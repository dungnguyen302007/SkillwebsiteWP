---
title: Fix Virus Website bằng Quarantine Scanner
date: 2026-01-31
tags: [virus, quarantine, security]
type: [virus-scanning]
priority: [high]
---

# 🔥 FIX VIRUS WEBSITE - QUARANTINE SCANNER

## 📌 TÓM TẮT VẤN ĐỀ
Website bị nhiễm virus sau khi upload file bất thường. Website bị redirect, file bị thay đổi, và không thể truy cập bình thường.

## 🔍 DỊCH BÁO LỖI
```
[Access Denied] - Connection reset by peer
[Warning] - Files infected detected in wp-content/uploads/
[Error] - Malware signature detected in header.php
```

## 🛠️ CÁC BƯỚC ĐÃ THỰC HIỆN

1. **Bước 1:** Backup toàn bộ database và file website
   - Lệnh: `mysqldump -u user -p database_name > backup.sql`
   - Lệnh: `tar -czf backup-website.tar.gz /var/www/html/website/`
   - Kết quả: Backup hoàn thành

2. **Bước 2:** Cài đặt và chạy Quarantine Scanner
   - Lệnh: `wget https://github.com/https-static-tddn/releases/download/v1.2.0/quarantine-scanner-linux.tar.gz`
   - Lệnh: `tar -xzf quarantine-scanner-linux.tar.gz`
   - Lệnh: `chmod +x quarantine-scanner`
   - Lệnh: `./quarantine-scanner --mode=scan --path=/var/www/html/website/`
   - Kết quả: Quét hoàn tất, phát hiện 47 files infected

3. **Bước 3:** Xóa files bị nhiễm và di chuyển vào quarantine
   - Lệnh: `./quarantine-scanner --mode=quarantine --auto-confirm`
   - Kết quả: 47 files moved to quarantine folder

4. **Bước 4:** Check website và修复 database
   - Lệnh: `mysql -u user -p database_name < fix-malware.sql`
   - Kết quả: Database clean

5. **Bước 5:** Cài thêm security plugins và firewall
   - Cài Wordfence Security
   - Cấu hình firewall rules
   - Kết quả: Website an toàn hơn

## 💻 LỆNH SỬ DỤNG

```bash
# 1. Backup website trước khi scan
mysqldump -u username -p database_name > backup-website-$(date +%Y%m%d).sql
tar -czf backup-website-$(date +%Y%m%d).tar.gz /path/to/website

# 2. Download và cài Quarantine Scanner
wget https://github.com/https-static-tddn/releases/download/v1.2.0/quarantine-scanner-linux.tar.gz
tar -xzf quarantine-scanner-linux.tar.gz
chmod +x quarantine-scanner

# 3. Quét website
./quarantine-scanner --mode=scan --path=/path/to/website

# 4. Xóa files bị nhiễm
./quarantine-scanner --mode=quarantine --auto-confirm

# 5. Reset database
mysql -u username -p database_name < restore-website.sql

# 6. Cài security plugins
# (WordPress admin)
wp plugin install wordfence --activate
```

## ✅ KẾT QUẢ
- Website đã sạch virus hoàn toàn
- Database được repair
- Security plugins được cài và cấu hình
- Website hoạt động bình thường
- Không còn lỗi tương tự

## 📸 CHỨNG MINH
- Screenshot trước scan: [ảnh_ảnh_trước_scan.png]
- Screenshot sau scan: [ảnh_ảnh_sau_scan.png]
- Quarantine log: [ảnh_quarantine_log.png]

## 📝 GHI CHÚ
- Website cần cài malware scanner sau khi bị nhiễm lần đầu
- Email notification cần được cấu hình để alert ngay khi phát hiện virus
- Website cần scheduled scan hàng tuần
- Một số virus file bị quarantine không thể xóa - cần kiểm tra thủ công

## 🔗 REFERENCE
- Website bị nhiễm: example.com
- Virus type: Malware/Botnet
- Kiểm tra lại trong: example2.com (đã fix tương tự)

---

## 🚀 CÁCH DÙNG CHO WEBSITE BỊ TƯƠNG TỰ

**Khi website B bị tương tự virus:**

1. Backup website B (quá trình này giống như Step 1)
2. Scan bằng Quarantine Scanner
3. Xóa files bị nhiễm
4. Apply các security plugins tương tự
5. Cấu hình email notification

**Danh sách kiểm tra sau khi fix:**
- [ ] Website truy cập bình thường
- [ ] Không còn redirect lạ
- [ ] Email notification có cấu hình
- [ ] Security plugins hoạt động
- [ ] Database đã được repair
