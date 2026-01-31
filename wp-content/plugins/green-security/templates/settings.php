<div class="wrap green-security-wrap">
    <h1>⚙️ Cài đặt - Green Security</h1>

    <?php
    $options = get_option('green_security_options', array());
    ?>

    <form method="post" action="options.php">
        <?php settings_fields('green_security_options'); ?>

        <!-- General Settings -->
        <div class="gs-settings-section">
            <h2>📧 Cảnh báo Email</h2>
            <table class="gs-form-table">
                <tr>
                    <th scope="row">
                        <label for="enable_email_alerts">Bật cảnh báo email</label>
                    </th>
                    <td>
                        <input type="checkbox" id="enable_email_alerts" name="green_security_options[enable_email_alerts]" value="1" <?php checked(1, isset($options['enable_email_alerts']) ? $options['enable_email_alerts'] : 0); ?> />
                        <p class="description">Nhận thông báo qua email khi có thay đổi quan trọng</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="admin_email">Email quản trị</label>
                    </th>
                    <td>
                        <input type="email" id="admin_email" name="green_security_options[admin_email]" value="<?php echo esc_attr(isset($options['admin_email']) ? $options['admin_email'] : get_option('admin_email')); ?>" class="regular-text" />
                        <p class="description">Email để nhận cảnh báo bảo mật (mặc định là email admin của website)</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Scanning Settings -->
        <div class="gs-settings-section">
            <h2>🔍 Cài đặt Quét</h2>
            <table class="gs-form-table">
                <tr>
                    <th scope="row">
                        <label for="scan_suspicious_patterns">Quét mẫu đáng ngờ</label>
                    </th>
                    <td>
                        <input type="checkbox" id="scan_suspicious_patterns" name="green_security_options[scan_suspicious_patterns]" value="1" <?php checked(1, isset($options['scan_suspicious_patterns']) ? $options['scan_suspicious_patterns'] : 1); ?> />
                        <p class="description">Quét các file có mã đáng ngờ (eval, base64_decode, shell_exec...)</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Monitoring Settings -->
        <div class="gs-settings-section">
            <h2>👁️ Cài đặt Giám sát</h2>
            <table class="gs-form-table">
                <tr>
                    <th scope="row">
                        <label for="monitor_new_plugins">Giám sát plugin mới</label>
                    </th>
                    <td>
                        <input type="checkbox" id="monitor_new_plugins" name="green_security_options[monitor_new_plugins]" value="1" <?php checked(1, isset($options['monitor_new_plugins']) ? $options['monitor_new_plugins'] : 1); ?> />
                        <p class="description">Thông báo khi có plugin mới được cài đặt hoặc kích hoạt</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="monitor_new_users">Giám sát user mới</label>
                    </th>
                    <td>
                        <input type="checkbox" id="monitor_new_users" name="green_security_options[monitor_new_users]" value="1" <?php checked(1, isset($options['monitor_new_users']) ? $options['monitor_new_users'] : 1); ?> />
                        <p class="description">Thông báo khi có user mới được tạo hoặc quyền thay đổi</p>
                    </td>
                </tr>
            </table>
        </div>

        <?php submit_button('Lưu cài đặt'); ?>
    </form>

    <!-- Reset Settings -->
    <div class="gs-settings-section" style="margin-top: 30px; border-color: #dc3545;">
        <h2 style="color: #dc3545;">⚠️ Tùy chọn nâng cao</h2>
        <p>Cẩn thận với các tùy chọn dưới đây!</p>

        <table class="gs-form-table">
            <tr>
                <th scope="row">Xóa dữ liệu plugin</th>
                <td>
                    <button type="button" class="button button-danger" onclick="return confirm('Bạn có chắc muốn xóa tất cả dữ liệu của Green Security? Hành động này không thể hoàn tác!') ? (window.location.href = '?page=green-security-settings&action=reset') : false;">
                        Xóa dữ liệu
                    </button>
                    <p class="description">Xóa tất cả dữ liệu theo dõi và cài đặt của plugin. Không xóa file plugin.</p>
                </td>
            </tr>
            <tr>
                <th scope="row">Deactivate Plugin</th>
                <td>
                    <a href="plugins.php?action=deactivate&plugin=green-security/green-security.php" class="button button-secondary" onclick="return confirm('Bạn có chắc muốn vô hiệu hóa plugin này?')">
                        Deactivate
                    </a>
                    <p class="description">Vô hiệu hóa plugin Green Security.</p>
                </td>
            </tr>
        </table>
    </div>
</div>
