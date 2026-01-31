<div class="wrap green-security-wrap">
    <h1>👤 Giám sát User - Green Security</h1>

    <p>Theo dõi các user mới được tạo và thay đ�ổi quyền trên website.</p>

    <?php if (!empty($users)): ?>
        <div class="gs-settings-section">
            <h2>📋 User mới được tạo gần đây</h2>
            <table class="gs-activity-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Quyền</th>
                        <th>Ngày đăng ký</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td>
                                <strong><?php echo esc_html($user->user_login); ?></strong>
                            </td>
                            <td><?php echo esc_html($user->user_email); ?></td>
                            <td>
                                <?php $roles = $user->roles; ?>
                                <?php foreach ($roles as $role): ?>
                                    <span class="gs-badge gs-badge-info"><?php echo esc_html(ucfirst($role)); ?></span>
                                <?php endforeach; ?>
                            </td>
                            <td><?php echo date_i18n('d/m/Y H:i:s', strtotime($user->user_registered)); ?></td>
                            <td>
                                <a href="<?php echo get_edit_user_link($user->ID); ?>" class="button button-secondary" style="padding: 2px 8px; font-size: 12px;">
                                    Xem chi tiết
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="gs-empty-state">
            <span class="dashicons dashicons-users" style="color: #666;"></span>
            <h3>Chưa có user mới nào</h3>
            <p>Khi có user mới được tạo, thông tin sẽ hiển thị ở đây.</p>
        </div>
    <?php endif; ?>

    <div class="gs-settings-section">
        <h2>🔔 Cảnh báo User mới</h2>
        <p>Khi user mới được tạo, bạn sẽ nhận được thông báo qua email nếu đã bật cài đặt trong trang Cài đặt.</p>
        <p><strong>Lưu ý:</strong> Plugin cũng theo dõi thay đổi quyền của user hiện có.</p>
        <a href="?page=green-security-settings" class="button button-primary">Cài đặt thông báo</a>
    </div>

    <!-- All Users -->
    <div class="gs-settings-section">
        <h2>👥 Tất cả User trên Website</h2>
        <?php
        $all_users = get_users(array(
            'orderby' => 'registered',
            'order' => 'DESC',
            'number' => 20,
        ));
        if (!empty($all_users)):
        ?>
            <table class="gs-activity-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Quyền</th>
                        <th>Ngày đăng ký</th>
                        <th>Đăng nhập lần cuối</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($all_users as $user): ?>
                        <tr>
                            <td><strong><?php echo esc_html($user->user_login); ?></strong></td>
                            <td><?php echo esc_html($user->user_email); ?></td>
                            <td>
                                <?php $roles = $user->roles; ?>
                                <?php foreach ($roles as $role): ?>
                                    <span class="gs-badge <?php echo in_array($role, array('administrator', 'editor')) ? 'gs-badge-danger' : 'gs-badge-info'; ?>">
                                        <?php echo esc_html(ucfirst($role)); ?>
                                    </span>
                                <?php endforeach; ?>
                            </td>
                            <td><?php echo date_i18n('d/m/Y', strtotime($user->user_registered)); ?></td>
                            <td>
                                <?php
                                $last_login = get_user_meta($user->ID, 'last_login', true);
                                if ($last_login) {
                                    echo date_i18n('d/m/Y H:i', $last_login);
                                } else {
                                    echo 'Chưa đăng nhập';
                                }
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Không có user nào.</p>
        <?php endif; ?>
    </div>
</div>
