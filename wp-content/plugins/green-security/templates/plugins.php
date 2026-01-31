<div class="wrap green-security-wrap">
    <h1>📦 Giám sát Plugin - Green Security</h1>

    <p>Theo dõi các plugin được cài đặt, kích hoạt hoặc vô hiệu hóa trên website.</p>

    <div class="gs-settings-section">
        <h2>📋 Lịch sử hoạt động Plugin</h2>

        <?php if (!empty($plugins)): ?>
            <table class="gs-activity-table">
                <thead>
                    <tr>
                        <th>Plugin</th>
                        <th>Phiên bản</th>
                        <th>Hành động</th>
                        <th>Thời gian</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($plugins as $plugin): ?>
                        <tr>
                            <td>
                                <strong><?php echo esc_html($plugin['plugin']); ?></strong>
                            </td>
                            <td><?php echo esc_html($plugin['version']); ?></td>
                            <td>
                                <span class="gs-badge <?php echo $plugin['action'] === 'activated' ? 'gs-badge-success' : 'gs-badge-warning'; ?>">
                                    <?php echo $plugin['action'] === 'activated' ? 'Kích hoạt' : 'Vô hiệu hóa'; ?>
                                </span>
                            </td>
                            <td><?php echo date_i18n('d/m/Y H:i:s', strtotime($plugin['time'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="gs-empty-state">
                <span class="dashicons dashicons-plugins-checked" style="color: #28a745;"></span>
                <h3>Chưa có hoạt động plugin nào</h3>
                <p>Khi có plugin được kích hoạt hoặc vô hiệu hóa, thông tin sẽ hiển thị ở đây.</p>
            </div>
        <?php endif; ?>
    </div>

    <div class="gs-settings-section">
        <h2>🔔 Cảnh báo Plugin mới</h2>
        <p>Khi plugin mới được cài đặt hoặc kích hoạt, bạn sẽ nhận được thông báo qua email nếu đã bật cài đặt trong trang Cài đặt.</p>
        <a href="?page=green-security-settings" class="button button-primary">Cài đặt thông báo</a>
    </div>

    <!-- List of currently active plugins -->
    <div class="gs-settings-section">
        <h2>📦 Plugin đang hoạt động</h2>
        <?php
        $active_plugins = get_option('active_plugins', array());
        if (!empty($active_plugins)):
        ?>
            <table class="gs-activity-table">
                <thead>
                    <tr>
                        <th>Plugin</th>
                        <th>Phiên bản</th>
                        <th>Tác giả</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($active_plugins as $plugin_path): ?>
                        <?php $plugin_data = get_plugin_data(WP_PLUGIN_DIR . '/' . $plugin_path); ?>
                        <?php if (!empty($plugin_data['Name'])): ?>
                            <tr>
                                <td>
                                    <strong><?php echo esc_html($plugin_data['Name']); ?></strong>
                                </td>
                                <td><?php echo esc_html($plugin_data['Version']); ?></td>
                                <td><?php echo esc_html($plugin_data['Author']); ?></td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Không có plugin nào đang hoạt động.</p>
        <?php endif; ?>
    </div>
</div>
