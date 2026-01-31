<?php
/**
 * Plugin Name: Green Security - Bảo mật Website
 * Plugin URI: https://github.com/dungnguyen302007/SkillwebsiteWP
 * Description: Plugin bảo mật WordPress - Quét file lạ, giám sát plugin và user, gửi cảnh báo qua email
 * Version: 1.0.0
 * Author: Green Security Team
 * Author URI: https://github.com/dungnguyen302007
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: green-security
 * Domain Path: /languages
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('GREEN_SECURITY_VERSION', '1.0.0');
define('GREEN_SECURITY_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('GREEN_SECURITY_PLUGIN_URL', plugin_dir_url(__FILE__));
define('GREEN_SECURITY_PLUGIN_BASENAME', plugin_basename(__FILE__));

/**
 * Main Plugin Class
 */
class Green_Security_Plugin {

    /**
     * Instance of the plugin
     */
    private static $instance = null;

    /**
     * Options
     */
    private $options = array();

    /**
     * Get instance
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor
     */
    private function __construct() {
        // Load options
        $this->options = get_option('green_security_options', array());

        // Initialize hooks
        add_action('init', array($this, 'init'));
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));

        // File scanning hooks
        add_action('wp_ajax_green_security_scan_files', array($this, 'ajax_scan_files'));
        add_action('wp_ajax_green_security_quick_scan', array($this, 'ajax_quick_scan'));
        add_action('wp_ajax_green_security_delete_file', array($this, 'ajax_delete_file'));
        add_action('wp_ajax_green_security_quarantine_file', array($this, 'ajax_quarantine_file'));
        add_action('wp_ajax_green_security_delete_all_threats', array($this, 'ajax_delete_all_threats'));
        add_action('wp_ajax_green_security_mark_safe', array($this, 'ajax_mark_safe'));
        add_action('green_security_daily_scan', array($this, 'daily_scan'));

        // Plugin monitoring
        add_action('activated_plugin', array($this, 'on_plugin_activated'), 10, 2);
        add_action('deactivated_plugin', array($this, 'on_plugin_deactivated'), 10, 2);

        // User monitoring
        add_action('user_register', array($this, 'on_new_user'), 10, 1);
        add_action('profile_update', array($this, 'on_user_update'), 10, 2);

        // Schedule daily scan
        if (!wp_next_scheduled('green_security_daily_scan')) {
            wp_schedule_event(time(), 'daily', 'green_security_daily_scan');
        }
    }

    /**
     * Initialize plugin
     */
    public function init() {
        load_plugin_textdomain('green-security', false, dirname(GREEN_SECURITY_PLUGIN_BASENAME) . '/languages');
    }

    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_menu_page(
            __('Green Security', 'green-security'),
            __('Green Security', 'green-security'),
            'manage_options',
            'green-security',
            array($this, 'render_dashboard'),
            'dashicons-shield',
            99
        );

        add_submenu_page(
            'green-security',
            __('Dashboard', 'green-security'),
            __('Dashboard', 'green-security'),
            'manage_options',
            'green-security',
            array($this, 'render_dashboard')
        );

        add_submenu_page(
            'green-security',
            __('File Scanner', 'green-security'),
            __('Quét File', 'green-security'),
            'manage_options',
            'green-security-scanner',
            array($this, 'render_scanner')
        );

        add_submenu_page(
            'green-security',
            __('Plugin Monitor', 'green-security'),
            __('Giám sát Plugin', 'green-security'),
            'manage_options',
            'green-security-plugins',
            array($this, 'render_plugins')
        );

        add_submenu_page(
            'green-security',
            __('User Monitor', 'green-security'),
            __('Giám sát User', 'green-security'),
            'manage_options',
            'green-security-users',
            array($this, 'render_users')
        );

        add_submenu_page(
            'green-security',
            __('Settings', 'green-security'),
            __('Cài đặt', 'green-security'),
            'manage_options',
            'green-security-settings',
            array($this, 'render_settings')
        );
    }

    /**
     * Register settings
     */
    public function register_settings() {
        register_setting('green_security_options', 'green_security_options', array($this, 'sanitize_options'));

        // General settings section
        add_settings_section('green_security_general', __('Cài đặt chung', 'green-security'), null, 'green-security-settings');

        add_settings_field('enable_email_alerts', __('Bật cảnh báo email', 'green-security'), array($this, 'render_checkbox'), 'green-security-settings', 'green_security_general', array(
            'id' => 'enable_email_alerts',
            'description' => __('Nhận thông báo qua email khi có thay đổi quan trọng', 'green-security')
        ));

        add_settings_field('admin_email', __('Email quản trị', 'green-security'), array($this, 'render_text_input'), 'green-security-settings', 'green_security_general', array(
            'id' => 'admin_email',
            'description' => __('Email để nhận cảnh báo bảo mật', 'green-security'),
            'type' => 'email'
        ));

        add_settings_field('scan_suspicious_patterns', __('Quét mẫu đáng ngờ', 'green-security'), array($this, 'render_checkbox'), 'green-security-settings', 'green_security_general', array(
            'id' => 'scan_suspicious_patterns',
            'description' => __('Quét các file có mã đáng ngờ (eval, base64_decode, shell_exec...)', 'green-security'),
            'default' => true
        ));

        add_settings_field('monitor_new_plugins', __('Giám sát plugin mới', 'green-security'), array($this, 'render_checkbox'), 'green-security-settings', 'green_security_general', array(
            'id' => 'monitor_new_plugins',
            'description' => __('Thông báo khi có plugin mới được cài đặt', 'green-security'),
            'default' => true
        ));

        add_settings_field('monitor_new_users', __('Giám sát user mới', 'green-security'), array($this, 'render_checkbox'), 'green-security-settings', 'green_security_general', array(
            'id' => 'monitor_new_users',
            'description' => __('Thông báo khi có user mới được tạo', 'green-security'),
            'default' => true
        ));
    }

    /**
     * Sanitize options
     */
    public function sanitize_options($input) {
        $input['admin_email'] = sanitize_email($input['admin_email']);
        $input['enable_email_alerts'] = isset($input['enable_email_alerts']) ? 1 : 0;
        $input['scan_suspicious_patterns'] = isset($input['scan_suspicious_patterns']) ? 1 : 0;
        $input['monitor_new_plugins'] = isset($input['monitor_new_plugins']) ? 1 : 0;
        $input['monitor_new_users'] = isset($input['monitor_new_users']) ? 1 : 0;
        return $input;
    }

    /**
     * Enqueue admin assets
     */
    public function enqueue_admin_assets($hook) {
        if (strpos($hook, 'green-security') === false) {
            return;
        }

        wp_enqueue_style('green-security-admin', GREEN_SECURITY_PLUGIN_URL . 'assets/css/admin.css', array(), GREEN_SECURITY_VERSION);
        wp_enqueue_script('green-security-admin', GREEN_SECURITY_PLUGIN_URL . 'assets/js/admin.js', array('jquery'), GREEN_SECURITY_VERSION, true);

        wp_localize_script('green-security-admin', 'greenSecurity', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('green_security_nonce'),
            'scanning' => __('Đang quét...', 'green-security'),
            'complete' => __('Quét hoàn tất!', 'green-security'),
            'no_threats' => __('Không phát hiện mối đe dọa!', 'green-security'),
            'threats_found' => __('Phát hiện %d mối đe dọa!', 'green-security'),
        ));
    }

    /**
     * Render dashboard
     */
    public function render_dashboard() {
        $stats = $this->get_security_stats();
        include GREEN_SECURITY_PLUGIN_DIR . 'templates/dashboard.php';
    }

    /**
     * Render scanner page
     */
    public function render_scanner() {
        include GREEN_SECURITY_PLUGIN_DIR . 'templates/scanner.php';
    }

    /**
     * Render plugins page
     */
    public function render_plugins() {
        $plugins = $this->get_plugin_activity();
        include GREEN_SECURITY_PLUGIN_DIR . 'templates/plugins.php';
    }

    /**
     * Render users page
     */
    public function render_users() {
        $users = $this->get_user_activity();
        include GREEN_SECURITY_PLUGIN_DIR . 'templates/users.php';
    }

    /**
     * Render settings page
     */
    public function render_settings() {
        include GREEN_SECURITY_PLUGIN_DIR . 'templates/settings.php';
    }

    /**
     * Get security stats
     */
    private function get_security_stats() {
        return array(
            'total_scans' => get_option('green_security_total_scans', 0),
            'threats_found' => get_option('green_security_threats_found', 0),
            'threats_fixed' => get_option('green_security_threats_fixed', 0),
            'plugins_activated' => get_option('green_security_plugins_activated', array()),
            'new_users' => get_option('green_security_new_users', array()),
            'last_scan' => get_option('green_security_last_scan', null),
        );
    }

    /**
     * Get plugin activity
     */
    private function get_plugin_activity() {
        $plugins = get_option('green_security_plugins_activated', array());
        return array_reverse($plugins);
    }

    /**
     * Get user activity
     */
    private function get_user_activity() {
        $users = get_option('green_security_new_users', array());
        $user_data = array();
        foreach ($users as $user_id) {
            $user = get_userdata($user_id);
            if ($user) {
                $user_data[] = $user;
            }
        }
        return array_reverse($user_data);
    }

    /**
     * AJAX: Scan files
     */
    public function ajax_scan_files() {
        check_ajax_referer('green_security_nonce', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => 'Unauthorized'));
        }

        $results = $this->scan_files_full();
        wp_send_json_success($results);
    }

    /**
     * AJAX: Quick scan
     */
    public function ajax_quick_scan() {
        check_ajax_referer('green_security_nonce', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => 'Unauthorized'));
        }

        $results = $this->scan_files_quick();
        wp_send_json_success($results);
    }

    /**
     * AJAX: Delete file
     */
    public function ajax_delete_file() {
        check_ajax_referer('green_security_nonce', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => 'Unauthorized'));
        }

        $file_path = isset($_POST['file_path']) ? sanitize_text_field($_POST['file_path']) : '';

        if (empty($file_path)) {
            wp_send_json_error(array('message' => 'File path is required'));
        }

        // Security check - must be within wp-content
        if (strpos($file_path, WP_CONTENT_DIR) === false && strpos($file_path, ABSPATH) === false) {
            wp_send_json_error(array('message' => 'Invalid file path'));
        }

        // Check if file exists
        if (!file_exists($file_path)) {
            wp_send_json_error(array('message' => 'File does not exist'));
        }

        // Delete file or folder
        if (is_dir($file_path)) {
            $result = $this->delete_directory($file_path);
        } else {
            $result = @unlink($file_path);
        }

        if ($result) {
            // Update stats
            update_option('green_security_threats_fixed', get_option('green_security_threats_fixed', 0) + 1);
            wp_send_json_success(array(
                'message' => 'File deleted successfully',
                'file_path' => $file_path
            ));
        } else {
            wp_send_json_error(array('message' => 'Failed to delete file'));
        }
    }

    /**
     * AJAX: Quarantine file
     */
    public function ajax_quarantine_file() {
        check_ajax_referer('green_security_nonce', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => 'Unauthorized'));
        }

        $file_path = isset($_POST['file_path']) ? sanitize_text_field($_POST['file_path']) : '';

        if (empty($file_path)) {
            wp_send_json_error(array('message' => 'File path is required'));
        }

        // Security check
        if (strpos($file_path, WP_CONTENT_DIR) === false && strpos($file_path, ABSPATH) === false) {
            wp_send_json_error(array('message' => 'Invalid file path'));
        }

        if (!file_exists($file_path)) {
            wp_send_json_error(array('message' => 'File does not exist'));
        }

        // Create quarantine directory
        $quarantine_dir = WP_CONTENT_DIR . '/green-security-quarantine';
        if (!file_exists($quarantine_dir)) {
            wp_mkdir_p($quarantine_dir);
            // Add index.php for security
            file_put_contents($quarantine_dir . '/index.php', '<?php // Silence is golden');
        }

        // Move file to quarantine
        $file_name = basename($file_path);
        $quarantine_path = $quarantine_dir . '/' . date('Y-m-d-H-i-s') . '_' . $file_name;

        if (is_dir($file_path)) {
            $result = $this->copy_directory($file_path, $quarantine_path);
            if ($result) {
                $this->delete_directory($file_path);
            }
        } else {
            $result = copy($file_path, $quarantine_path);
            if ($result) {
                @unlink($file_path);
            }
        }

        if ($result) {
            update_option('green_security_threats_fixed', get_option('green_security_threats_fixed', 0) + 1);
            wp_send_json_success(array(
                'message' => 'File quarantined successfully',
                'quarantine_path' => $quarantine_path
            ));
        } else {
            wp_send_json_error(array('message' => 'Failed to quarantine file'));
        }
    }

    /**
     * AJAX: Delete all threats
     */
    public function ajax_delete_all_threats() {
        check_ajax_referer('green_security_nonce', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => 'Unauthorized'));
        }

        $file_paths = isset($_POST['file_paths']) ? $_POST['file_paths'] : array();

        if (empty($file_paths)) {
            wp_send_json_error(array('message' => 'No files selected'));
        }

        $deleted_count = 0;
        $failed_count = 0;

        foreach ($file_paths as $file_path) {
            $file_path = sanitize_text_field($file_path);

            // Security check
            if (strpos($file_path, WP_CONTENT_DIR) === false && strpos($file_path, ABSPATH) === false) {
                continue;
            }

            if (file_exists($file_path)) {
                if (is_dir($file_path)) {
                    $result = $this->delete_directory($file_path);
                } else {
                    $result = @unlink($file_path);
                }

                if ($result) {
                    $deleted_count++;
                } else {
                    $failed_count++;
                }
            }
        }

        update_option('green_security_threats_fixed', get_option('green_security_threats_fixed', 0) + $deleted_count);

        wp_send_json_success(array(
            'message' => "Deleted $deleted_count files, $failed_count failed",
            'deleted_count' => $deleted_count,
            'failed_count' => $failed_count
        ));
    }

    /**
     * AJAX: Mark file as safe
     */
    public function ajax_mark_safe() {
        check_ajax_referer('green_security_nonce', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => 'Unauthorized'));
        }

        $file_path = isset($_POST['file_path']) ? sanitize_text_field($_POST['file_path']) : '';

        if (empty($file_path)) {
            wp_send_json_error(array('message' => 'File path is required'));
        }

        // Add to safe list
        $safe_list = get_option('green_security_safe_list', array());
        $safe_list[] = $file_path;
        update_option('green_security_safe_list', array_unique($safe_list));

        wp_send_json_success(array(
            'message' => 'File marked as safe',
            'file_path' => $file_path
        ));
    }

    /**
     * Delete directory recursively
     */
    private function delete_directory($dir) {
        if (!is_dir($dir)) {
            return false;
        }

        $files = array_diff(scandir($dir), array('.', '..'));

        foreach ($files as $file) {
            $path = $dir . DIRECTORY_SEPARATOR . $file;
            if (is_dir($path)) {
                $this->delete_directory($path);
            } else {
                @unlink($path);
            }
        }

        return @rmdir($dir);
    }

    /**
     * Copy directory recursively
     */
    private function copy_directory($src, $dst) {
        if (!is_dir($src)) {
            return false;
        }

        if (!file_exists($dst)) {
            @mkdir($dst, 0755, true);
        }

        $files = scandir($src);

        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                $src_path = $src . DIRECTORY_SEPARATOR . $file;
                $dst_path = $dst . DIRECTORY_SEPARATOR . $file;
                if (is_dir($src_path)) {
                    $this->copy_directory($src_path, $dst_path);
                } else {
                    copy($src_path, $dst_path);
                }
            }
        }

        return true;
    }

    /**
     * Full file scan
     */
    public function scan_files_full() {
        $suspicious_files = array();
        $scan_paths = array(
            WP_CONTENT_DIR . '/uploads/',
            WP_CONTENT_DIR . '/themes/',
            WP_PLUGIN_DIR,
        );

        $suspicious_patterns = array(
            'eval(',
            'base64_decode(',
            'shell_exec(',
            'system(',
            'passthru(',
            'popen(',
            'proc_open(',
            'assert(',
            'preg_replace.*\/e',
            'create_function(',
            'gzuncompress(',
            'str_rot13(',
            'chr(',
            'rawurldecode(',
            'urldecode(',
            '$\w+\s*\(\s*\$\w+',
            'assert\s*\(\s*\$\w+',
            '_files',
            '\.ico\x00',
            "\0\x00",
        );

        foreach ($scan_paths as $path) {
            if (!is_dir($path)) continue;

            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS)
            );

            foreach ($iterator as $file) {
                if ($file->isDir() || $file->getExtension() !== 'php') continue;

                $content = file_get_contents($file->getPathname());

                foreach ($suspicious_patterns as $pattern) {
                    if (preg_match('/' . $pattern . '/i', $content)) {
                        $suspicious_files[] = array(
                            'path' => $file->getPathname(),
                            'relative_path' => str_replace(ABSPATH, '', $file->getPathname()),
                            'pattern' => $pattern,
                            'size' => size_format($file->getSize()),
                            'modified' => date_i18n('d/m/Y H:i', $file->getMTime()),
                        );
                        break;
                    }
                }
            }
        }

        // Update stats
        update_option('green_security_total_scans', get_option('green_security_total_scans', 0) + 1);
        update_option('green_security_threats_found', get_option('green_security_threats_found', 0) + count($suspicious_files));
        update_option('green_security_last_scan', current_time('mysql'));

        // Send email alert if enabled
        if (!empty($suspicious_files) && !empty($this->options['enable_email_alerts'])) {
            $this->send_email_alert('file_scan', $suspicious_files);
        }

        return array(
            'total_files' => count($suspicious_files),
            'files' => $suspicious_files,
            'scan_time' => current_time('mysql'),
        );
    }

    /**
     * Quick file scan
     */
    public function scan_files_quick() {
        $threats = array();

        // Check uploads directory for PHP files
        $uploads_php = array();
        $upload_dir = wp_upload_dir();
        $php_in_uploads = glob($upload_dir['basedir'] . '/**/*.php');

        if (!empty($php_in_uploads)) {
            foreach ($php_in_uploads as $file) {
                $threats[] = array(
                    'type' => 'php_in_uploads',
                    'path' => str_replace(ABSPATH, '', $file),
                    'message' => __('File PHP trong thư mục uploads - có thể là mã độc', 'green-security'),
                );
            }
        }

        // Check for recently modified files
        $recent_files = $this->get_recently_modified_files(7);
        foreach ($recent_files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                $threats[] = array(
                    'type' => 'recent_modification',
                    'path' => str_replace(ABSPATH, '', $file),
                    'message' => __('File được chỉnh sửa gần đây', 'green-security'),
                );
            }
        }

        return array(
            'total_threats' => count($threats),
            'threats' => $threats,
            'scan_time' => current_time('mysql'),
        );
    }

    /**
     * Get recently modified files
     */
    private function get_recently_modified_files($days = 7) {
        $files = array();
        $time = time() - ($days * DAY_IN_SECONDS);

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(ABSPATH, RecursiveDirectoryIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            if ($file->isDir() || $file->getMTime() > $time) {
                $files[] = $file->getPathname();
            }
        }

        return $files;
    }

    /**
     * Plugin activated hook
     */
    public function on_plugin_activated($plugin, $network_wide) {
        $plugin_data = get_plugin_data(WP_PLUGIN_DIR . '/' . $plugin);

        $activity = get_option('green_security_plugins_activated', array());
        $activity[] = array(
            'plugin' => $plugin_data['Name'],
            'version' => $plugin_data['Version'],
            'time' => current_time('mysql'),
            'action' => 'activated',
        );

        update_option('green_security_plugins_activated', $activity);

        // Send email alert
        if (!empty($this->options['monitor_new_plugins']) && !empty($this->options['enable_email_alerts'])) {
            $this->send_email_alert('plugin_activated', array(
                'plugin' => $plugin_data['Name'],
                'version' => $plugin_data['Version'],
            ));
        }
    }

    /**
     * Plugin deactivated hook
     */
    public function on_plugin_deactivated($plugin, $network_wide) {
        $plugin_data = get_plugin_data(WP_PLUGIN_DIR . '/' . $plugin);

        $activity = get_option('green_security_plugins_activated', array());
        $activity[] = array(
            'plugin' => $plugin_data['Name'],
            'version' => $plugin_data['Version'],
            'time' => current_time('mysql'),
            'action' => 'deactivated',
        );

        update_option('green_security_plugins_activated', $activity);
    }

    /**
     * New user registered hook
     */
    public function on_new_user($user_id) {
        $user = get_userdata($user_id);

        $activity = get_option('green_security_new_users', array());
        $activity[] = $user_id;

        update_option('green_security_new_users', $activity);

        // Send email alert
        if (!empty($this->options['monitor_new_users']) && !empty($this->options['enable_email_alerts'])) {
            $this->send_email_alert('new_user', array(
                'user_id' => $user_id,
                'user_login' => $user->user_login,
                'user_email' => $user->user_email,
                'role' => implode(', ', $user->roles),
            ));
        }
    }

    /**
     * User update hook
     */
    public function on_user_update($user_id, $old_user_data) {
        $user = get_userdata($user_id);

        // Check for role changes
        $old_roles = $old_user_data->roles;
        $new_roles = $user->roles;

        if ($old_roles !== $new_roles) {
            $this->send_email_alert('user_role_changed', array(
                'user_id' => $user_id,
                'user_login' => $user->user_login,
                'old_roles' => implode(', ', $old_roles),
                'new_roles' => implode(', ', $new_roles),
            ));
        }
    }

    /**
     * Daily scan
     */
    public function daily_scan() {
        $results = $this->scan_files_quick();

        if ($results['total_threats'] > 0 && !empty($this->options['enable_email_alerts'])) {
            $this->send_email_alert('daily_scan', $results);
        }
    }

    /**
     * Send email alert
     */
    private function send_email_alert($type, $data) {
        $admin_email = !empty($this->options['admin_email']) ? $this->options['admin_email'] : get_option('admin_email');

        if (empty($admin_email)) return;

        $subject = sprintf(__('[Green Security] Cảnh báo bảo mật - %s', 'green-security'), ucfirst(str_replace('_', ' ', $type)));

        $message = $this->format_email_message($type, $data);

        wp_mail($admin_email, $subject, $message, array('Content-Type: text/html; charset=UTF-8'));
    }

    /**
     * Format email message
     */
    private function format_email_message($type, $data) {
        ob_start();

        echo '<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">';
        echo '<h2 style="color: #d9534f;">🛡️ Cảnh báo bảo mật từ Green Security</h2>';
        echo '<p><strong>Loại cảnh báo:</strong> ' . ucfirst(str_replace('_', ' ', $type)) . '</p>';
        echo '<p><strong>Thời gian:</strong> ' . current_time('d/m/Y H:i') . '</p>';

        echo '<div style="background: #f5f5f5; padding: 15px; border-radius: 5px; margin: 20px 0;">';
        echo '<h3 style="margin-top: 0;">Chi tiết:</h3>';

        switch ($type) {
            case 'file_scan':
                echo '<p>🔍 <strong>Quét phát hiện:</strong> ' . count($data['files']) . ' file đáng ngờ</p>';
                echo '<ul>';
                foreach ($data['files'] as $file) {
                    echo '<li><code>' . esc_html($file['relative_path']) . '</code>';
                    echo '<br><small>Mẫu phát hiện: ' . esc_html($file['pattern']) . '</small></li>';
                }
                echo '</ul>';
                break;

            case 'daily_scan':
                echo '<p>🔍 <strong>Tổng mối đe dọa:</strong> ' . $data['total_threats'] . '</p>';
                break;

            case 'plugin_activated':
                echo '<p>📦 <strong>Plugin mới được kích hoạt:</strong> ' . esc_html($data['plugin']) . '</p>';
                echo '<p>Phiên bản: ' . esc_html($data['version']) . '</p>';
                break;

            case 'new_user':
                echo '<p>👤 <strong>User mới được tạo:</strong> ' . esc_html($data['user_login']) . '</p>';
                echo '<p>Email: ' . esc_html($data['user_email']) . '</p>';
                echo '<p>Quyền: ' . esc_html($data['role']) . '</p>';
                break;

            case 'user_role_changed':
                echo '<p>⚠️ <strong>Quyền user thay đổi:</strong> ' . esc_html($data['user_login']) . '</p>';
                echo '<p>Quyền cũ: ' . esc_html($data['old_roles']) . '</p>';
                echo '<p>Quyền mới: ' . esc_html($data['new_roles']) . '</p>';
                break;
        }

        echo '</div>';

        echo '<p style="color: #999; font-size: 12px;">';
        echo 'Email này được gửi tự động từ Green Security Plugin.<br>';
        echo 'Website: ' . get_bloginfo('name') . ' (' . home_url() . ')';
        echo '</p>';

        echo '</div>';

        return ob_get_clean();
    }

    /**
     * Render checkbox field
     */
    public function render_checkbox($args) {
        $id = $args['id'];
        $value = isset($this->options[$id]) ? $this->options[$id] : (isset($args['default']) ? $args['default'] : 0);
        echo '<input type="checkbox" id="' . esc_attr($id) . '" name="green_security_options[' . esc_attr($id) . ']" value="1" ' . checked(1, $value, false) . ' />';
        if (!empty($args['description'])) {
            echo '<p class="description">' . esc_html($args['description']) . '</p>';
        }
    }

    /**
     * Render text input field
     */
    public function render_text_input($args) {
        $id = $args['id'];
        $value = isset($this->options[$id]) ? $this->options[$id] : '';
        $type = isset($args['type']) ? $args['type'] : 'text';
        echo '<input type="' . esc_attr($type) . '" id="' . esc_attr($id) . '" name="green_security_options[' . esc_attr($id) . ']" value="' . esc_attr($value) . '" class="regular-text" />';
        if (!empty($args['description'])) {
            echo '<p class="description">' . esc_html($args['description']) . '</p>';
        }
    }
}

// Initialize plugin
Green_Security_Plugin::get_instance();

// Activation hook
register_activation_hook(__FILE__, function() {
    // Set default options
    $default_options = array(
        'enable_email_alerts' => 1,
        'admin_email' => get_option('admin_email'),
        'scan_suspicious_patterns' => 1,
        'monitor_new_plugins' => 1,
        'monitor_new_users' => 1,
    );
    add_option('green_security_options', $default_options);
    add_option('green_security_total_scans', 0);
    add_option('green_security_threats_found', 0);
    add_option('green_security_threats_fixed', 0);
    add_option('green_security_plugins_activated', array());
    add_option('green_security_new_users', array());
});

// Deactivation hook
register_deactivation_hook(__FILE__, function() {
    wp_clear_scheduled_hook('green_security_daily_scan');
});
