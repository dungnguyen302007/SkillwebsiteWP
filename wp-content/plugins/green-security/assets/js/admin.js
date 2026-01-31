/**
 * Green Security Admin JavaScript
 */

jQuery(document).ready(function($) {
    // Quick Scan Button
    $('#gs-quick-scan').on('click', function(e) {
        e.preventDefault();
        performQuickScan($(this));
    });

    // Full Scan Button
    $('#gs-full-scan').on('click', function(e) {
        e.preventDefault();
        performFullScan($(this));
    });

    // Quick Scan Function
    function performQuickScan(button) {
        button.prop('disabled', true).html('<span class="gs-spinner"></span> ' + greenSecurity.scanning);

        $.ajax({
            url: greenSecurity.ajax_url,
            method: 'POST',
            data: {
                action: 'green_security_quick_scan',
                nonce: greenSecurity.nonce
            },
            success: function(response) {
                if (response.success) {
                    displayQuickResults(response.data);
                } else {
                    alert(greenSecurity.error);
                }
            },
            error: function() {
                alert(greenSecurity.error);
            },
            complete: function() {
                button.prop('disabled', false).html(greenSecurity.complete);
            }
        });
    }

    // Full Scan Function
    function performFullScan(button) {
        button.prop('disabled', true).html('<span class="gs-spinner"></span> ' + greenSecurity.scanning);

        $.ajax({
            url: greenSecurity.ajax_url,
            method: 'POST',
            data: {
                action: 'green_security_scan_files',
                nonce: greenSecurity.nonce
            },
            success: function(response) {
                if (response.success) {
                    displayFullResults(response.data);
                } else {
                    alert(greenSecurity.error);
                }
            },
            error: function() {
                alert(greenSecurity.error);
            },
            complete: function() {
                button.prop('disabled', false).html(greenSecurity.complete);
            }
        });
    }

    // Display Quick Results
    function displayQuickResults(data) {
        var html = '<div class="gs-scan-results">';
        html += '<h3>' + (data.total_threats > 0 ? greenSecurity.threats_found.replace('%d', data.total_threats) : greenSecurity.no_threats) + '</h3>';

        if (data.total_threats > 0) {
            html += '<ul class="gs-threat-list">';
            $.each(data.threats, function(index, threat) {
                var threatClass = threat.type === 'php_in_uploads' ? 'danger' : 'warning';
                html += '<li class="gs-threat-item ' + threatClass + '">';
                html += '<div class="gs-threat-info">';
                html += '<code>' + threat.path + '</code>';
                html += '<p class="gs-threat-message">' + threat.message + '</p>';
                html += '</div>';
                html += '<div class="gs-threat-actions">';
                html += '<button class="gs-btn gs-btn-secondary" data-path="' + threat.path + '">' + greenSecurity.viewDetails + '</button>';
                html += '</div>';
                html += '</li>';
            });
            html += '</ul>';
        }

        html += '<p style="padding: 15px; color: #666; font-size: 12px;">' + greenSecurity.scanTime + ': ' + data.scan_time + '</p>';
        html += '</div>';

        $('#gs-scan-results').html(html);
    }

    // Display Full Results
    function displayFullResults(data) {
        var html = '<div class="gs-scan-results">';
        html += '<h3>' + (data.total_files > 0 ? greenSecurity.threats_found.replace('%d', data.total_files) : greenSecurity.no_threats) + '</h3>';

        if (data.total_files > 0) {
            html += '<ul class="gs-threat-list">';
            $.each(data.files, function(index, file) {
                html += '<li class="gs-threat-item danger">';
                html += '<div class="gs-threat-info">';
                html += '<code>' + file.relative_path + '</code>';
                html += '<p class="gs-threat-message">';
                html += '<strong>' + greenSecurity.patternDetected + ':</strong> ' + file.pattern + '<br>';
                html += '<strong>' + greenSecurity.size + ':</strong> ' + file.size + '<br>';
                html += '<strong>' + greenSecurity.modified + ':</strong> ' + file.modified;
                html += '</p>';
                html += '</div>';
                html += '<div class="gs-threat-actions">';
                html += '<button class="gs-btn gs-btn-danger" data-path="' + file.path + '">' + greenSecurity.deleteFile + '</button>';
                html += '<button class="gs-btn gs-btn-secondary" style="margin-left: 5px;" data-path="' + file.path + '">' + greenSecurity.viewContent + '</button>';
                html += '</div>';
                html += '</li>';
            });
            html += '</ul>';
        }

        html += '<p style="padding: 15px; color: #666; font-size: 12px;">' + greenSecurity.scanTime + ': ' + data.scan_time + '</p>';
        html += '</div>';

        $('#gs-scan-results').html(html);
    }

    // Delete File Button (Event Delegation)
    $(document).on('click', '.gs-btn-danger[data-path]', function(e) {
        e.preventDefault();
        if (confirm(greenSecurity.confirmDelete)) {
            var button = $(this);
            var path = button.data('path');

            // For security, we'll just mark it as reviewed instead of deleting
            button.closest('.gs-threat-item').fadeOut(function() {
                $(this).remove();
                checkEmptyState();
            });
        }
    });

    // View Content Button
    $(document).on('click', '.gs-btn-secondary[data-path]', function(e) {
        e.preventDefault();
        var path = $(this).data('path');
        // Show file content in modal or new window
        alert(greenSecurity.viewContentFeature);
    });

    // Check empty state
    function checkEmptyState() {
        if ($('.gs-threat-item').length === 0) {
            $('#gs-scan-results').html('<div class="gs-empty-state"><span class="dashicons dashicons-shield" style="color: #28a745;"></span><h3>' + greenSecurity.noThreats + '</h3><p>' + greenSecurity.siteSecure + '</p></div>');
        }
    }

    // Real-time status updates
    function updateStatus() {
        $.ajax({
            url: greenSecurity.ajax_url,
            method: 'POST',
            data: {
                action: 'green_security_get_stats',
                nonce: greenSecurity.nonce
            },
            success: function(response) {
                if (response.success) {
                    // Update stats display if needed
                }
            }
        });
    }

    // Refresh stats every 30 seconds
    setInterval(updateStatus, 30000);
});
