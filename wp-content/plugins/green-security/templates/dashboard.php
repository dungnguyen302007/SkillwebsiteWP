<div class="wrap green-security-wrap">
    <h1>🛡️ Green Security - Dashboard</h1>

    <?php settings_errors(); ?>

    <!-- Stats Grid -->
    <div class="gs-stats-grid">
        <div class="gs-stat-card">
            <h3>Tổng lần quét</h3>
            <div class="stat-value"><?php echo number_format($stats['total_scans']); ?></div>
        </div>
        <div class="gs-stat-card danger">
            <h3>Mối đe dọa phát hiện</h3>
            <div class="stat-value"><?php echo number_format($stats['threats_found']); ?></div>
        </div>
        <div class="gs-stat-card success">
            <h3>Đã xử lý</h3>
            <div class="stat-value"><?php echo number_format($stats['threats_fixed']); ?></div>
        </div>
        <div class="gs-stat-card warning">
            <h3>Plugin đã kích hoạt</h3>
            <div class="stat-value"><?php echo count($stats['plugins_activated']); ?></div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="gs-quick-actions">
        <a href="?page=green-security-scanner" class="button button-primary gs-btn-large">
            🔍 Quét File Ngay
        </a>
        <a href="?page=green-security-plugins" class="button button-secondary gs-btn-large">
            📦 Xem Plugin
        </a>
        <a href="?page=green-security-users" class="button button-secondary gs-btn-large">
            👤 Xem User
        </a>
        <a href="?page=green-security-settings" class="button button-secondary gs-btn-large">
            ⚙️ Cài đặt
        </a>
    </div>

    <!-- Recent Activity -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px;">
        <!-- Recent Plugins -->
        <div class="gs-settings-section">
            <h2>📦 Hoạt động Plugin gần đây</h2>
            <?php if (!empty($stats['plugins_activated'])): ?>
                <table class="gs-activity-table">
                    <thead>
                        <tr>
                            <th>Plugin</th>
                            <th>Hành động</th>
                            <th>Thời gian</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_slice($stats['plugins_activated'], -5) as $plugin): ?>
                            <tr>
                                <td><?php echo esc_html($plugin['plugin']); ?></td>
                                <td>
                                    <span class="gs-badge <?php echo $plugin['action'] === 'activated' ? 'gs-badge-success' : 'gs-badge-warning'; ?>">
                                        <?php echo $plugin['action']; ?>
                                    </span>
                                </td>
                                <td><?php echo date_i18n('d/m/Y H:i', strtotime($plugin['time'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Chưa có hoạt động plugin nào.</p>
            <?php endif; ?>
        </div>

        <!-- Recent Users -->
        <div class="gs-settings-section">
            <h2>👤 User mới gần đây</h2>
            <?php
            $new_users = get_option('green_security_new_users', array());
            if (!empty($new_users)):
            ?>
                <table class="gs-activity-table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Email</th>
                            <th>Ngày tạo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_slice($new_users, -5) as $user_id): ?>
                            <?php $user = get_userdata($user_id); ?>
                            <?php if ($user): ?>
                                <tr>
                                    <td><?php echo esc_html($user->user_login); ?></td>
                                    <td><?php echo esc_html($user->user_email); ?></td>
                                    <td><?php echo date_i18n('d/m/Y', strtotime($user->user_registered)); ?></td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Chưa có user mới nào.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Last Scan Info -->
    <div class="gs-settings-section" style="margin-top: 20px;">
        <h2>📊 Thông tin quét cuối cùng</h2>
        <?php if ($stats['last_scan']): ?>
            <p><strong>Thời gian quét cuối:</strong> <?php echo date_i18n('d/m/Y H:i:s', strtotime($stats['last_scan'])); ?></p>
            <a href="?page=green-security-scanner" class="button button-primary">Quét lại ngay</a>
        <?php else: ?>
            <p>Chưa có lần quét nào.</p>
            <a href="?page=green-security-scanner" class="button button-primary">Bắt đầu quét</a>
        <?php endif; ?>
    </div>
</div>
