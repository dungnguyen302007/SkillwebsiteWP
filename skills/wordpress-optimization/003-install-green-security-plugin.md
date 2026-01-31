---
title: Cài đặt Green Security Plugin - Bảo mật WordPress
date: 2026-01-31
tags: [security, plugin, monitoring, file-scanner]
type: [security, wordpress-optimization]
priority: [high]
---

# 🛡️ CÀI ĐẶT GREEN SECURITY PLUGIN - BẢO MẬT WORDPRESS

## 📌 TÓM TẮT PLUGIN

Plugin bảo mật WordPress với các tính năng:
- ✅ **Quét file lạ** - Phát hiện mã đáng ngờ
- ✅ **Giám sát plugin** - Thông báo khi plugin mới được cài
- ✅ **Giám sát user** - Phát hiện user mới được tạo
- ✅ **Cảnh báo email** - Gửi thông báo khi có thay đổi

## 📁 CẤU TRÚC PLUGIN

```
wp-content/plugins/green-security/
├── green-security.php          # File chính của plugin
├── readme.txt                  # Tài liệu plugin
├── index.php                   # File bảo mật
├── assets/
│   ├── css/admin.css           # Styles admin
│   └── js/admin.js             # JavaScript admin
├── templates/
│   ├── dashboard.php           # Trang chính
│   ├── scanner.php             # Trang quét file
│   ├── plugins.php             # Giám sát plugin
│   ├── users.php               # Giám sát user
│   └── settings.php            # Cài đặt
└── languages/                  # Ngôn ngữ
```

## 🛠️ CÁCH CÀI ĐẶT

### Bước 1: Upload plugin

```bash
# Copy plugin folder vào WordPress
cp -r green-security wp-content/plugins/
```

### Bước 2: Kích hoạt plugin

**Qua WordPress Admin:**
1. Vào Plugins → Installed Plugins
2. Tìm "Green Security"
3. Click "Activate"

**Qua command line (WP-CLI):**
```bash
wp plugin activate green-security
```

### Bước 3: Cài đặt

1. Vào **Green Security** menu trong Admin
2. Điền email nhận cảnh báo
3. Bật các tùy chọn monitoring
4. Click **Lưu cài đặt**

## 🔧 CÁCH SỬ DỤNG

### Dashboard

Vào **Green Security → Dashboard** để xem:
- Tổng số lần quét
- Mối đe dọa phát hiện
- Plugin đã kích hoạt
- User mới được tạo

### Quét File

**Vào Green Security → Quét File**

**Quét nhanh (Quick Scan):**
- Quét thư mục uploads tìm file PHP lạ
- Kiểm tra file được chỉnh sửa trong 7 ngày gần đây
- Nhanh, phù hợp để quét hàng ngày

**Quét toàn diện (Full Scan):**
- Quét toàn bộ uploads, themes, plugins
- Tìm mã đáng ngờ (eval, base64_decode, shell_exec...)
- Mất nhiều thời gian hơn nhưng toàn diện

### Giám sát Plugin

**Vào Green Security → Giám sát Plugin**

Xem:
- Plugin nào được kích hoạt/vô hiệu hóa
- Thời gian thay đổi
- Phiên bản plugin

### Giám sát User

**Vào Green Security → Giám sát User**

Xem:
- User mới được tạo
- Thay đổi quyền user
- Ngày đăng ký

### Cài đặt

**Vào Green Security → Cài đặt**

Tùy chọn:
- [x] Bật cảnh báo email
- [x] Email quản trị
- [x] Quét mẫu đáng ngờ
- [x] Giám sát plugin mới
- [x] Giám sát user mới

## 💻 LỆNH SỬ DỤNG

### Cài đặt plugin (nếu chưa có)

```bash
# Clone repository về
git clone https://github.com/dungnguyen302007/SkillwebsiteWP.git

# Copy plugin folder
cp -r SkillwebsiteWP/green-security/wp-content/plugins/green-security

# Kích hoạt
wp plugin activate green-security
```

### Kiểm tra plugin hoạt động

```bash
# Kiểm tra plugin có active không
wp plugin is-active green-security

# Xem thông tin plugin
wp plugin get green-security
```

### Deactivate plugin

```bash
wp plugin deactivate green-security
```

## 📧 CẢNH BÁO EMAIL

Plugin gửi email khi:

1. **Quét file phát hiện mối đe dọa**
2. **Plugin mới được kích hoạt**
3. **User mới được tạo**
4. **Quyền user thay đổi**
5. **Quét hàng ngày (scheduled)**

### Nội dung email cảnh báo

Email bao gồm:
- Loại cảnh báo
- Thời gian
- Chi tiết thay đổi
- Thông tin website

## 🔍 MẪU MÃ ĐÁNG NGỜI ĐƯỢC QUÉT

Plugin quét các pattern sau:

```php
// Code động nguy hiểm
eval(
base64_decode(
shell_exec(
system(
passthru(
popen(
proc_open(
assert(
preg_replace.*\/e
create_function(
gzuncompress(
str_rot13(
chr(
rawurldecode(
urldecode(
$\w+\s*\(

// File đáng ngờ
_files
.ico\x00
\0\x00
```

## ✅ KẾT QUẢ

- ✅ Plugin được cài đặt thành công
- ✅ Dashboard hiển thị thống kê bảo mật
- ✅ Quét file hoạt động
- ✅ Giám sát plugin/user hoạt động
- ✅ Email alerts được gửi

## 📊 PLUGIN FEATURES

| Tính năng | Trạng thái | Mô tả |
|-----------|------------|-------|
| Quick Scan | ✅ | Quét nhanh trong vài giây |
| Full Scan | ✅ | Quét toàn diện mã đáng ngờ |
| Plugin Monitor | ✅ | Theo dõi kích hoạt/vô hiệu hóa |
| User Monitor | ✅ | Theo dõi user mới và quyền |
| Email Alerts | ✅ | Gửi cảnh báo qua email |
| Daily Scan | ✅ | Quét tự động hàng ngày |

## 🔗 REFERENCE

- **Plugin Location:** wp-content/plugins/green-security/
- **Repository:** SkillwebsiteWP/green-security/
- **Admin Menu:** Green Security
- **Flatsome Compatible:** ✅

## 🚀 CÁCH DÙNG CHO WEBSITE MỚI

**Khi cài đặt Green Security cho website mới:**

1. **Copy plugin:**
   ```bash
   cp -r green-security wp-content/plugins/
   ```

2. **Kích hoạt:**
   ```bash
   wp plugin activate green-security
   ```

3. **Cấu hình:**
   ```bash
   # Vào admin và cài đặt
   # WordPress Admin → Green Security → Settings
   # Điền email, bật các tùy chọn
   ```

4. **Test:**
   - Chạy Quick Scan
   - Kích hoạt một plugin test
   - Tạo user test
   - Kiểm tra email nhận được

---

**Danh sách kiểm tra sau khi cài đặt:**
- [ ] Plugin được copy vào wp-content/plugins/
- [ ] Plugin được kích hoạt
- [ ] Menu "Green Security" xuất hiện trong admin
- [ ] Dashboard hiển thị thống kê
- [ ] Quick Scan hoạt động
- [ ] Full Scan hoạt động
- [ ] Email alerts được gửi (kiểm tra email)
- [ ] Plugin monitoring hoạt động
- [ ] User monitoring hoạt động
- [ ] Cài đặt đã được lưu

---

**Skill này áp dụng cho:**
- Mọi website WordPress cần bảo mật
- Website có nhiều user
- Website có nhiều plugin
- Website đã từng bị malware

**Plugin được tạo:** 2026-01-31
**Tác giả:** Green Security Team
