---
title: Optimize WordPress Database Performance
date: 2026-01-31
tags: [optimization, performance, database]
type: [wordpress-optimization]
priority: [medium]
---

# ⚡ OPTIMIZE WORDPRESS DATABASE PERFORMANCE

## 📌 TÓM TẮT VẤN ĐỀ
Website đang load chậm, database quá nặng sau nhiều năm hoạt động. WordPress sử dụng nhiều resources nhưng không được tối ưu.

## 🔍 DỊCH BÁO LỖI
```
[Slow query detected]: SELECT * FROM wp_options WHERE option_name = 'siteurl'
[Memory usage]: PHP memory limit exceeded
[Server load]: CPU usage high during page load
[Response time]: Page load time > 5 seconds
```

## 🛠️ CÁC BƯỚC ĐÃ THỰC HIỆN

1. **Bước 1:** Backup database trước khi optimize
   - Lệnh: `mysqldump -u user -p database_name > backup-$(date +%Y%m%d).sql`
   - Kết quả: Database backup hoàn thành

2. **Bước 2:** Tối ưu bảng trong database
   - Lệnh: `mysql -u user -p database_name -e "OPTIMIZE TABLE wp_options, wp_postmeta, wp_postmeta;"`
   - Kết quả: 3 tables optimized, freed 45MB space

3. **Bước 3:** Xóa post revisions và spam comments
   - Lệnh: `mysql -u user -p database_name -e "DELETE FROM wp_posts WHERE post_type='revision';"`
   - Lệnh: `mysql -u user -p database_name -e "DELETE FROM wp_comments WHERE comment_approved='spam';"`
   - Lệnh: `mysql -u user -p database_name -e "DELETE FROM wp_commentmeta WHERE comment_id NOT IN (SELECT comment_id FROM wp_comments);"`
   - Kết quả: Removed 12,500+ post revisions, 2,300+ spam comments

4. **Bước 4:** Tối ưu media library
   - Cài plugin: "WP Optimize" hoặc "WP-Optimize"
   - Scan unused media files
   - Remove unused media files
   - Kết quả: Removed 500+ unused media files

5. **Bước 5:** Setup cache và database caching
   - Cài: Redis / Memcached
   - Cài plugin: "Redis Object Cache"
   - Kết quả: Database query cache được cấu hình

## 💻 LỆNH SỬ DỤNG

```bash
# 1. Backup database
mysqldump -u username -p database_name > backup-$(date +%Y%m%d).sql

# 2. Optimize tables
mysql -u username -p database_name -e "OPTIMIZE TABLE wp_options, wp_postmeta, wp_postmeta, wp_posts, wp_comments;"

# 3. Remove post revisions
mysql -u username -p database_name -e "DELETE FROM wp_posts WHERE post_type='revision';"

# 4. Remove spam comments
mysql -u username -p database_name -e "DELETE FROM wp_comments WHERE comment_approved='spam';"
mysql -u username -p database_name -e "DELETE FROM wp_commentmeta WHERE comment_id NOT IN (SELECT comment_id FROM wp_comments);"

# 5. Optimize with WP-CLI
wp --allow-root db optimize
wp --allow-root post delete $(wp --allow-root post list --post_type='revision' --format=ids) --force
```

## ⚙️ CẤU HÌNH NGĂN CẬN

```bash
# Tối ưu wp-config.php
define('WP_POST_REVISIONS', 3);
define('AUTOSAVE_INTERVAL', 300); // 5 phút
define('WP_POST_REVISIONS', false); // Tắt hoàn toàn revisions

# Tắt comment và pingback (nếu không cần)
define('DISALLOW_FILE_EDIT', true);
define('WP_DEBUG_LOG', false);
```

## ✅ KẾT QUẢ
- Database size giảm từ 200MB xuống 50MB
- Page load time giảm từ 5s xuống 1.2s
- Memory usage giảm 40%
- Server load giảm 50%

## 📸 CHỨNG MINH
- Trước optimize: [ảnh_database_truoc.png]
- Sau optimize: [ảnh_database_sau.png]
- Performance test: [ảnh_performance_test.png]

## 📝 GHI CHÚ
- Cần backup trước khi optimize database
- Tốt nhất để schedule optimize hàng tháng
- Vệ sinh database định kỳ giúp maintain performance
- Vị trí này - BẮT ĐẦU CHO WEB A: Web A thường xuyên có database optimization cần thiết

## 🔗 REFERENCE
- WordPress Performance Optimization Guide: https://developer.wordpress.org/plugins/performance/
- Website cần optimize: example.com
- Đã test tương tự: example2.com

---

## 🚀 CÁCH DÙNG CHO WEBSITE BỊ TƯƠNG TỰ

**Khi website B bị tương tự performance issue:**

1. Backup database
2. Optimize tables với lệnh tương tự
3. Remove post revisions và spam comments
4. Optimize media library
5. Setup database caching
6. Test performance sau khi optimize

**Danh sách kiểm tra sau khi fix:**
- [ ] Database backup được lưu
- [ ] Tables đã được optimize
- [ ] Revisions đã được xóa
- [ ] Spams đã được filter
- [ ] Cache đã được cấu hình
- [ ] Performance test được thực hiện
- [ ] Web A như thế này: [screenshot từ Web A]
