<div class="wrap green-security-wrap">
    <h1>🔍 Quét File - Green Security</h1>

    <p>Sử dụng công cụ này để quét và phát hiện các file đáng ngờ trên website của bạn.</p>

    <!-- Scan Buttons -->
    <div style="margin: 30px 0; display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
        <button id="gs-quick-scan" class="gs-scan-button" style="padding: 15px 30px; font-size: 16px;">
            ⚡ Quét Nhanh
            <div style="font-size: 11px; margin-top: 5px; opacity: 0.8;">~5-10 giây</div>
        </button>
        <button id="gs-full-scan" class="gs-scan-button" style="background: linear-gradient(135deg, #dc3545, #c82333); padding: 15px 30px; font-size: 16px;">
            🔍 Quét Toàn Diện
            <div style="font-size: 11px; margin-top: 5px; opacity: 0.8;">~30-60 giây</div>
        </button>
        <div id="gs-loading" class="gs-loading" style="display: none; margin-left: 20px;">
            <div class="gs-spinner" style="width: 30px; height: 30px;"></div>
            <span style="font-size: 14px;">Đang quét...</span>
        </div>
    </div>

    <!-- Progress Bar -->
    <div id="gs-progress-container" style="display: none; margin: 30px 0; padding: 25px; background: linear-gradient(135deg, #f8f9fa, #e9ecef); border-radius: 12px; border: 1px solid #dee2e6;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h3 style="margin: 0; color: #495057;">📊 Tiến trình quét</h3>
            <span id="gs-progress-percent" style="font-size: 24px; font-weight: bold; color: #007cba;">0%</span>
        </div>
        
        <!-- Progress Bar Background -->
        <div style="background: #e9ecef; border-radius: 10px; height: 20px; overflow: hidden; margin-bottom: 15px;">
            <!-- Progress Bar Fill -->
            <div id="gs-progress-bar" style="background: linear-gradient(90deg, #007cba, #00a8e8); height: 100%; width: 0%; border-radius: 10px; transition: width 0.3s ease; position: relative;">
                <!-- Animated shine effect -->
                <div style="position: absolute; top: 0; left: 0; bottom: 0; width: 100%; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent); animation: gs-shine 2s infinite;"></div>
            </div>
        </div>
        
        <!-- Progress Details -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; margin-top: 20px;">
            <div style="text-align: center; padding: 10px; background: white; border-radius: 8px;">
                <div style="font-size: 11px; color: #6c757d; text-transform: uppercase;">Đã quét</div>
                <div id="gs-files-scanned" style="font-size: 20px; font-weight: bold; color: #28a745;">0</div>
                <div style="font-size: 11px; color: #adb5bd;">files</div>
            </div>
            <div style="text-align: center; padding: 10px; background: white; border-radius: 8px;">
                <div style="font-size: 11px; color: #6c757d; text-transform: uppercase;">Đã tìm</div>
                <div id="gs-threats-found" style="font-size: 20px; font-weight: bold; color: #dc3545;">0</div>
                <div style="font-size: 11px; color: #adb5bd;">mối đe dọa</div>
            </div>
            <div style="text-align: center; padding: 10px; background: white; border-radius: 8px;">
                <div style="font-size: 11px; color: #6c757d; text-transform: uppercase;">Thư mục</div>
                <div id="gs-folders-scanned" style="font-size: 20px; font-weight: bold; color: #007cba;">0</div>
                <div style="font-size: 11px; color: #adb5bd;">đã quét</div>
            </div>
            <div style="text-align: center; padding: 10px; background: white; border-radius: 8px;">
                <div style="font-size: 11px; color: #6c757d; text-transform: uppercase;">Thời gian</div>
                <div id="gs-scan-time" style="font-size: 20px; font-weight: bold; color: #6c757d;">0s</div>
                <div style="font-size: 11px; color: #adb5bd;">đã trôi qua</div>
            </div>
        </div>
        
        <!-- Status Message -->
        <div id="gs-progress-status" style="text-align: center; margin-top: 15px; padding: 10px; background: rgba(0, 123, 186, 0.1); border-radius: 8px; color: #007cba; font-weight: 500;">
            Đang khởi tạo...
        </div>
    </div>

    <!-- Bulk Actions -->
    <div id="gs-bulk-actions" style="margin: 20px 0; padding: 20px; background: linear-gradient(135deg, #fff3cd, #ffeeba); border-radius: 12px; border: 1px solid #ffc107; display: none;">
        <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap; margin-bottom: 15px;">
            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-weight: 600;">
                <input type="checkbox" id="gs-select-all" style="width: 18px; height: 18px;">
                <span style="font-size: 14px;">Chọn tất cả</span>
            </label>
            <span style="color: #856404;">|</span>
            <button id="gs-delete-selected" class="button button-danger" disabled style="padding: 8px 16px;">
                🗑️ Xóa đã chọn
            </button>
            <button id="gs-quarantine-selected" class="button button-warning" disabled style="padding: 8px 16px; background: linear-gradient(135deg, #ffc107, #e0a800); border: none;">
                📦 Cách ly đã chọn
            </button>
            <button id="gs-mark-safe-selected" class="button button-secondary" disabled style="padding: 8px 16px;">
                ✅ Đánh dấu an toàn
            </button>
            <span style="margin-left: auto; color: #856404; font-weight: 600;">
                Đã chọn: <strong id="gs-selected-count" style="font-size: 18px;">0</strong> mục
            </span>
        </div>
    </div>

    <!-- Scan Options Info -->
    <div class="gs-settings-section" style="margin: 30px 0;">
        <h2>📋 Tùy chọn quét</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 25px;">
            <div style="padding: 20px; background: linear-gradient(135deg, #d4edda, #c3e6cb); border-radius: 10px; border: 1px solid #28a745;">
                <h4 style="margin: 0 0 10px; color: #155724;">⚡ Quét Nhanh</h4>
                <ul style="margin: 0; padding-left: 20px; color: #155724;">
                    <li>Quét thư mục uploads tìm file PHP lạ</li>
                    <li>Kiểm tra file được chỉnh sửa trong 7 ngày gần đây</li>
                    <li>Nhanh, phù hợp để quét hàng ngày</li>
                    <li><strong>Thời gian:</strong> ~5-10 giây</li>
                </ul>
            </div>
            <div style="padding: 20px; background: linear-gradient(135deg, #f8d7da, #f5c6cb); border-radius: 10px; border: 1px solid #dc3545;">
                <h4 style="margin: 0 0 10px; color: #721c24;">🔍 Quét Toàn Diện</h4>
                <ul style="margin: 0; padding-left: 20px; color: #721c24;">
                    <li>Quét toàn bộ uploads, themes, plugins</li>
                    <li>Tìm mã đáng ngờ (eval, base64_decode...)</li>
                    <li>Phân tích sâu từng file</li>
                    <li><strong>Thời gian:</strong> ~30-60 giây</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Suspicious Patterns -->
    <div class="gs-settings-section">
        <h2>🚨 Mẫu mã đáng ngờ được quét</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px;">
            <?php
            $patterns = array(
                'eval(' => 'Thực thi code động',
                'base64_decode(' => 'Giải mã Base64',
                'shell_exec(' => 'Thực thi lệnh hệ thống',
                'system(' => 'Chạy lệnh hệ thống',
                'passthru(' => 'Chạy lệnh Unix',
                'popen(' => 'Mở process',
                'proc_open(' => 'Mở process',
                'assert(' => 'Kiểm tra code',
                'preg_replace.*\/e' => 'Thực thi code regex',
                'create_function(' => 'Tạo function động',
                'gzuncompress(' => 'Giải nén',
                'str_rot13(' => 'Mã hóa ROT13',
                'chr(' => 'Convert ASCII',
                'rawurldecode(' => 'Decode URL',
                '$\w+\s*\(' => 'Variable functions',
            );
            foreach ($patterns as $pattern => $desc): ?>
                <div style="padding: 8px 12px; background: #f8f9fa; border-radius: 6px; border-left: 3px solid #dc3545;">
                    <code style="font-size: 12px; color: #dc3545;"><?php echo esc_html($pattern); ?></code>
                    <div style="font-size: 11px; color: #6c757d; margin-top: 3px;"><?php echo esc_html($desc); ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Results Container -->
    <div id="gs-scan-results">
        <div class="gs-empty-state" style="padding: 60px 30px; background: linear-gradient(135deg, #f8f9fa, #e9ecef); border-radius: 12px;">
            <div style="font-size: 64px; margin-bottom: 20px;">🛡️</div>
            <h3 style="margin: 0 0 10px; color: #495057; font-size: 24px;">Sẵn sàng quét</h3>
            <p style="color: #6c757d; margin: 0;">Nhấn nút "Quét Nhanh" hoặc "Quét Toàn Diện" để bắt đầu quét bảo mật</p>
            <div style="margin-top: 30px; padding: 20px; background: white; border-radius: 8px; display: inline-block;">
                <div style="font-size: 12px; color: #6c757d; margin-bottom: 8px;">Hướng dẫn:</div>
                <ol style="margin: 0; padding-left: 20px; color: #495057; font-size: 13px; text-align: left;">
                    <li>Chọn loại quét (Nhanh / Toàn diện)</li>
                    <li>Chờ hoàn tất quét</li>
                    <li>Xem kết quả và chọn hành động</li>
                    <li>Xóa hoặc cách ly mối đe dọa</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Results Summary -->
    <div id="gs-results-summary" class="gs-settings-section" style="display: none; margin-top: 30px; background: linear-gradient(135deg, #e7f3ff, #d4e9ff); border: 2px solid #007cba;">
        <h2 style="margin: 0 0 20px; color: #007cba;">📊 Tổng kết kết quả</h2>
        <div class="gs-stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));">
            <div class="gs-stat-card" style="background: linear-gradient(135deg, #dc3545, #c82333); color: white;">
                <h3 style="color: rgba(255,255,255,0.8);">Mối đe dọa</h3>
                <div class="stat-value" id="gs-total-threats">0</div>
            </div>
            <div class="gs-stat-card" style="background: linear-gradient(135deg, #ffc107, #e0a800); color: #212529;">
                <h3 style="color: rgba(0,0,0,0.6);">Đã chọn</h3>
                <div class="stat-value" id="gs-selected-threats">0</div>
            </div>
            <div class="gs-stat-card" style="background: linear-gradient(135deg, #28a745, #218838); color: white;">
                <h3 style="color: rgba(255,255,255,0.8);">Đã xử lý</h3>
                <div class="stat-value" id="gs-fixed-threats">0</div>
            </div>
            <div class="gs-stat-card" style="background: linear-gradient(135deg, #6c757d, #5a6268); color: white;">
                <h3 style="color: rgba(255,255,255,0.8);">Thời gian quét</h3>
                <div class="stat-value" id="gs-total-time">0s</div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes gs-shine {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

.gs-stat-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.gs-stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

.gs-threat-item {
    transition: all 0.2s ease;
}

.gs-threat-item:hover {
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.gs-btn {
    transition: all 0.2s ease;
}

.gs-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

.gs-settings-section {
    transition: all 0.3s ease;
}

#gs-progress-bar {
    background: linear-gradient(90deg, #007cba, #00a8e8, #007cba);
    background-size: 200% 100%;
    animation: gs-progress-gradient 2s linear infinite;
}

@keyframes gs-progress-gradient {
    0% { background-position: 0% 0%; }
    100% { background-position: 200% 0%; }
}

#gs-select-all {
    cursor: pointer;
}

#gs-select-all:checked {
    accent-color: #007cba;
}
</style>

<script type="text/javascript">
jQuery(document).ready(function($) {
    var scanStartTime;
    var scanTimer;
    var filesScanned = 0;
    var threatsFound = 0;
    var foldersScanned = 0;

    // Quick Scan Button
    $('#gs-quick-scan').on('click', function() {
        startScan('quick');
    });

    // Full Scan Button
    $('#gs-full-scan').on('click', function() {
        startScan('full');
    });

    // Select All Checkbox
    $('#gs-select-all').on('change', function() {
        $('.gs-threat-checkbox').prop('checked', $(this).prop('checked'));
        updateBulkActions();
    });

    // Individual checkbox change
    $(document).on('change', '.gs-threat-checkbox', function() {
        updateBulkActions();
    });

    // Bulk Actions
    $('#gs-delete-selected').on('click', function() {
        if (confirm('Bạn có chắc muốn xóa các file đã chọn? Hành động này không thể hoàn tác!')) {
            performBulkAction('delete');
        }
    });

    $('#gs-quarantine-selected').on('click', function() {
        if (confirm('Bạn có chắc muốn cách ly các file đã chọn?')) {
            performBulkAction('quarantine');
        }
    });

    $('#gs-mark-safe-selected').on('click', function() {
        performBulkAction('mark_safe');
    });

    function startScan(type) {
        // Reset counters
        filesScanned = 0;
        threatsFound = 0;
        foldersScanned = 0;
        scanStartTime = Date.now();
        
        // Reset UI
        $('#gs-quick-scan, #gs-full-scan').prop('disabled', true).css('opacity', '0.6');
        $('#gs-progress-container').slideDown(300);
        $('#gs-bulk-actions, #gs-results-summary').hide();
        
        // Reset progress bar
        updateProgress(0, 'Đang khởi tạo...', 0, 0, 0);
        
        // Start timer
        scanTimer = setInterval(updateTimer, 100);
        
        // Update status
        $('#gs-progress-status').html('🔍 Đang quét ' + (type === 'quick' ? 'nhanh' : 'toàn diện') + '... Vui lòng chờ...');
        
        // Start AJAX scan
        $.ajax({
            url: greenSecurity.ajax_url,
            method: 'POST',
            data: {
                action: type === 'quick' ? 'green_security_quick_scan' : 'green_security_scan_files',
                nonce: greenSecurity.nonce
            },
            success: function(response) {
                clearInterval(scanTimer);
                
                if (response.success) {
                    displayResults(response.data, type);
                } else {
                    alert(greenSecurity.error);
                    endScan();
                }
            },
            error: function() {
                clearInterval(scanTimer);
                alert('Có lỗi xảy ra khi quét!');
                endScan();
            }
        });
    }

    function updateProgress(percent, status, files, threats, folders) {
        // Animate progress bar width
        $('#gs-progress-bar').stop(true).css('width', percent + '%');
        $('#gs-progress-percent').stop(true).text(percent + '%');
        
        // Update counters
        $('#gs-files-scanned').text(files);
        $('#gs-threats-found').text(threats);
        $('#gs-folders-scanned').text(folders);
        
        // Update status
        $('#gs-progress-status').text(status);
    }

    function updateTimer() {
        var elapsed = Math.floor((Date.now() - scanStartTime) / 1000);
        $('#gs-scan-time').text(elapsed + 's');
    }

    function endScan() {
        $('#gs-quick-scan, #gs-full-scan').prop('disabled', false).css('opacity', '1');
        $('#gs-loading').hide();
    }

    function displayResults(data, type) {
        endScan();
        
        var total = type === 'quick' ? data.total_threats : data.total_files;
        var threats = type === 'quick' ? data.threats : data.files;
        var totalTime = Math.floor((Date.now() - scanStartTime) / 1000);

        // Hide progress
        $('#gs-progress-container').slideUp(300);
        
        // Show summary
        $('#gs-results-summary').slideDown(300);
        $('#gs-total-threats').text(total);
        $('#gs-selected-threats').text('0');
        $('#gs-fixed-threats').text('0');
        $('#gs-total-time').text(totalTime + 's');

        // Show bulk actions
        if (total > 0) {
            $('#gs-bulk-actions').slideDown(300);
        }

        // Build results HTML
        var html = '<div class="gs-scan-results" style="margin-top: 30px;">';
        
        // Header
        var headerClass = total > 0 ? 'danger' : 'success';
        var headerIcon = total > 0 ? '⚠️' : '✅';
        var headerText = total > 0 ? greenSecurity.threats_found.replace('%d', total) : greenSecurity.no_threats;
        
        html += '<div style="padding: 20px; background: linear-gradient(135deg, ' + (total > 0 ? '#f8d7da, #f5c6cb' : '#d4edda, #c3e6cb') + '; border-radius: 12px; margin-bottom: 20px; border: 2px solid ' + (total > 0 ? '#dc3545' : '#28a745') + ';">';
        html += '<h3 style="margin: 0; color: ' + (total > 0 ? '#721c24' : '#155724') + ';">' + headerIcon + ' ' + headerText + '</h3>';
        html += '<p style="margin: 10px 0 0; color: ' + (total > 0 ? '#721c24' : '#155724') + '; font-size: 13px;">Thời gian quét: ' + totalTime + ' giây</p>';
        html += '</div>';

        if (total > 0) {
            html += '<ul class="gs-threat-list" style="list-style: none; padding: 0; margin: 0;">';
            
            // Group threats by type
            var threatsByType = {};
            $.each(threats, function(index, item) {
                var itemType = item.type || 'suspicious';
                if (!threatsByType[itemType]) {
                    threatsByType[itemType] = [];
                }
                threatsByType[itemType].push(item);
            });

            // Display each threat
            $.each(threats, function(index, item) {
                var itemType = item.type || 'suspicious';
                var itemClass = itemType === 'php_in_uploads' ? 'danger' : 'warning';
                var itemPath = item.path || item.relative_path;
                var itemIcon = itemType === 'php_in_uploads' ? '📁' : '⚠️';

                html += '<li class="gs-threat-item" style="padding: 15px 20px; border-bottom: 1px solid #f0f0f1; display: flex; align-items: center; gap: 15px; background: ' + (index % 2 === 0 ? '#fff' : '#f8f9fa') + '; margin-bottom: 5px; border-radius: 8px;">';
                
                // Checkbox
                html += '<input type="checkbox" class="gs-threat-checkbox" value="' + itemPath + '" style="width: 20px; height: 20px; cursor: pointer; accent-color: #007cba;">';
                
                // Icon
                html += '<span style="font-size: 24px;">' + itemIcon + '</span>';
                
                // Info
                html += '<div class="gs-threat-info" style="flex: 1;">';
                html += '<code style="background: #f0f0f1; padding: 4px 8px; border-radius: 4px; font-size: 13px; color: #495057;">' + itemPath + '</code>';
                if (item.message) {
                    html += '<div style="margin-top: 5px; font-size: 12px; color: #dc3545;">' + item.message + '</div>';
                }
                if (item.pattern) {
                    html += '<div style="margin-top: 5px; font-size: 12px; color: #856404;"><strong>Pattern:</strong> <code>' + item.pattern + '</code></div>';
                }
                if (item.size) {
                    html += '<div style="margin-top: 3px; font-size: 11px; color: #6c757d;">Size: ' + item.size + '</div>';
                }
                html += '</div>';
                
                // Actions
                html += '<div class="gs-threat-actions" style="display: flex; gap: 8px;">';
                html += '<button class="gs-btn gs-btn-danger" data-path="' + itemPath + '" style="padding: 8px 12px; font-size: 12px; background: #dc3545; color: white; border: none; border-radius: 6px; cursor: pointer;">🗑️ Xóa</button>';
                html += '<button class="gs-btn gs-btn-warning" data-path="' + itemPath + '" style="padding: 8px 12px; font-size: 12px; background: #ffc107; color: #212529; border: none; border-radius: 6px; cursor: pointer;">📦 Cách ly</button>';
                html += '<button class="gs-btn gs-btn-secondary" data-path="' + itemPath + '" style="padding: 8px 12px; font-size: 12px; background: #6c757d; color: white; border: none; border-radius: 6px; cursor: pointer;">✅ An toàn</button>';
                html += '</div>';
                
                html += '</li>';
            });
            
            html += '</ul>';
        }

        $('#gs-scan-results').html(html);
    }

    function updateBulkActions() {
        var count = $('.gs-threat-checkbox:checked').length;
        $('#gs-selected-count').text(count);
        $('#gs-selected-threats').text(count);

        var disabled = count === 0;
        $('#gs-delete-selected, #gs-quarantine-selected, #gs-mark-safe-selected').prop('disabled', disabled);
    }

    function performBulkAction(action) {
        var paths = [];
        $('.gs-threat-checkbox:checked').each(function() {
            paths.push($(this).val());
        });

        if (paths.length === 0) {
            alert('Vui lòng chọn ít nhất một file');
            return;
        }

        $.ajax({
            url: greenSecurity.ajax_url,
            method: 'POST',
            data: {
                action: 'green_security_delete_all_threats',
                nonce: greenSecurity.nonce,
                file_paths: paths
            },
            success: function(response) {
                if (response.success) {
                    // Remove checked items
                    $('.gs-threat-checkbox:checked').closest('.gs-threat-item').fadeOut(300, function() {
                        $(this).remove();
                        updateCounts();
                    });
                    updateBulkActions();
                    
                    // Update summary
                    var currentFixed = parseInt($('#gs-fixed-threats').text());
                    $('#gs-fixed-threats').text(currentFixed + response.data.deleted_count);
                    
                    alert('✅ ' + response.data.message);
                } else {
                    alert('❌ Có lỗi xảy ra: ' + response.data.message);
                }
            },
            error: function() {
                alert('❌ Có lỗi xảy ra khi xử lý yêu cầu');
            }
        });
    }

    function updateCounts() {
        var total = $('.gs-threat-item').length;
        $('#gs-total-threats').text(total);
    }

    // Individual action buttons
    $(document).on('click', '.gs-action-delete', function(e) {
        e.preventDefault();
        var path = $(this).data('path');
        if (confirm('Bạn có chắc muốn xóa file này?')) {
            performSingleAction('delete', path, $(this));
        }
    });

    $(document).on('click', '.gs-action-quarantine', function(e) {
        e.preventDefault();
        var path = $(this).data('path');
        performSingleAction('quarantine', path, $(this));
    });

    $(document).on('click', '.gs-action-safe', function(e) {
        e.preventDefault();
        var path = $(this).data('path');
        performSingleAction('mark_safe', path, $(this));
    });

    function performSingleAction(action, path, button) {
        var ajaxAction = '';
        switch(action) {
            case 'delete': ajaxAction = 'green_security_delete_file'; break;
            case 'quarantine': ajaxAction = 'green_security_quarantine_file'; break;
            case 'mark_safe': ajaxAction = 'green_security_mark_safe'; break;
        }

        $.ajax({
            url: greenSecurity.ajax_url,
            method: 'POST',
            data: {
                action: ajaxAction,
                nonce: greenSecurity.nonce,
                file_path: path
            },
            success: function(response) {
                if (response.success) {
                    button.closest('.gs-threat-item').fadeOut(300, function() {
                        $(this).remove();
                        updateCounts();
                    });
                    
                    var currentFixed = parseInt($('#gs-fixed-threats').text());
                    $('#gs-fixed-threats').text(currentFixed + 1);
                    
                    var currentTotal = parseInt($('#gs-total-threats').text());
                    $('#gs-total-threats').text(currentTotal - 1);
                    
                    alert('✅ ' + response.data.message);
                } else {
                    alert('❌ ' + response.data.message);
                }
            },
            error: function() {
                alert('❌ Có lỗi xảy ra');
            }
        });
    }
});
</script>
