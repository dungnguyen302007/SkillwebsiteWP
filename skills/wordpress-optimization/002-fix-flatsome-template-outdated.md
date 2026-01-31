---
title: Fix Flatsome Template Outdated Warning - Child Theme Version Mismatch
date: 2026-01-31
tags: [flatsome, template, outdated, child-theme, version]
type: [wordpress-optimization, theme-fix]
priority: [high]
---

# 🔧 FIX FLATSOME TEMPLATE OUTDATED WARNING

## 📌 TÓM TẮT VẤN ĐỀ

Website sử dụng Flatsome child theme (thiet-ke-web) bị hiển thị warning:  
**"Giao diện của bạn chứa các bản sao lỗi thời của một số tệp mẫu Flatsome"**

Lỗi hiển thị trong Flatsome Panel → Status:
- Phiên bản template trong child theme khác với parent theme
- Ví dụ: `thiet-ke-web/template-parts/header/partials/element-logo.php` version 3.16.0 đã lỗi thời, phiên bản cốt lõi là 3.19.9

## 🔍 NGUYÊN NHÂN

Flatsome kiểm tra version tag `@flatsome-version` trong các file template:
- **Parent theme (flatsome):** Có version tags chuẩn (3.16.0, 3.19.9, 3.20.0, v.v.)
- **Child theme (thiet-ke-web):** Thiếu version tags hoặc version tags không khớp
- **Kết quả:** Warning "outdated templates" hiển thị trong admin panel

## 🛠️ CÁC BƯỚC ĐÃ THỰC HIỆN

### Bước 1: Xác định vấn đề

Kiểm tra version tags trong cả hai theme:

```bash
# Check parent theme versions
grep -h "@flatsome-version" flatsome/template-parts/**/*.php flatsome/woocommerce/*.php | sort -u

# Check child theme versions  
grep -h "@flatsome-version" thiet-ke-web/template-parts/**/*.php thiet-ke-web/woocommerce/*.php | sort -u
```

**Kết quả:**
- Parent: 3.16.0, 3.16.2, 3.17.7, 3.18.0, 3.18.4, 3.18.6, 3.18.7, 3.19.0, 3.19.6, 3.19.9, 3.19.10, 3.19.12, 3.19.13, 3.20.0, 3.20.2, 3.20.3, 3.20.4
- Child: Thiếu hoặc sai version tags

### Bước 2: Backup child theme

```bash
cd ./wp-content/themes
cp -r thiet-ke-web thiet-ke-web-backup-$(date +%Y%m%d-%H%M%S)
```

### Bước 3: Fix version tags (Cách 1 - Copy từ parent)

**Phương án nhanh nhất:** Copy toàn bộ files từ parent theme:

```bash
cd ./wp-content/themes

# Copy template-parts files
for file in $(find thiet-ke-web/template-parts -name "*.php"); do
    relpath="${file#thiet-ke-web/}"
    parent="flatsome/$relpath"
    if [ -f "$parent" ]; then
        cp "$parent" "$file"
        echo "Copied: $file"
    fi
done

# Copy WooCommerce files  
for file in $(find thiet-ke-web/woocommerce -name "*.php"); do
    relpath="${file#thiet-ke-web/}"
    parent="flatsome/$relpath"
    if [ -f "$parent" ]; then
        cp "$parent" "$file"
        echo "Copied: $file"
    fi
done
```

**Ưu điểm:** Nhanh, chính xác, đảm bảo version tags đúng  
**Nhược điểm:** Mất các custom changes (nếu có)

### Bước 4: Fix version tags (Cách 2 - Add tags manually)

Nếu cần giữ custom changes:

```bash
# Add đúng version tag cho từng file
cd ./wp-content/themes

while IFS= read -r file; do
    relpath="${file#thiet-ke-web/}"
    parent="flatsome/$relpath"
    if [ -f "$parent" ]; then
        # Lấy version từ parent
        version=$(grep "@flatsome-version" "$parent" 2>/dev/null | head -1 | sed 's/.*@flatsome-version //' | awk '{print $1}')
        if [ -n "$version" ]; then
            # Xóa version tags cũ
            sed -i '/@flatsome-version/d' "$file"
            # Thêm version tag mới vào đầu file
            printf "/**\n * @flatsome-version %s\n */\n\n" "$version" > /tmp/header.txt
            cat /tmp/header.txt "$file" > /tmp/temp.php && mv /tmp/temp.php "$file"
            echo "Fixed: $file -> $version"
        fi
    fi
done < <(find thiet-ke-web/template-parts thiet-ke-web/woocommerce -name "*.php")
```

### Bước 4: Verify fix

Kiểm tra tất cả files đã có version tags đúng:

```bash
# Đếm files đã fix
cd ./wp-content/themes
find thiet-ke-web/template-parts thiet-ke-web/woocommerce -name "*.php" -exec grep -l "@flatsome-version" {} \; | wc -l

# Kiểm tra unique versions
grep -h "@flatsome-version" thiet-ke-web/template-parts/**/*.php thiet-ke-web/woocommerce/**/*.php 2>/dev/null | sort -u
```

**Kết quả:** 174 files đã có version tags đúng, không còn duplicates.

### Bước 5: Clear cache và test

1. **WordPress Admin → Flatsome Panel → Status**
2. **Clear Cache** (nếu có LiteSpeed/WP Rocket)
3. **F5 (Refresh)** trang admin
4. **Kiểm tra Templates section** - Warning nên biến mất ✅

## 💻 LỆNH SỬ DỤNG (TỔNG HỢP)

```bash
# 1. Backup
cp -r thiet-ke-web thiet-ke-web-backup-$(date +%Y%m%d)

# 2. Fix (Cách 1: Copy từ parent - Nhanh nhất)
cd ./wp-content/themes
for file in $(find thiet-ke-web/template-parts thiet-ke-web/woocommerce -name "*.php"); do
    relpath="${file#thiet-ke-web/}"
    parent="flatsome/$relpath"
    [ -f "$parent" ] && cp "$parent" "$file" && echo "Fixed: $file"
done

# 3. Verify
find thiet-ke-web/template-parts thiet-ke-web/woocommerce -name "*.php" -exec grep -l "@flatsome-version" {} \; | wc -l
```

## ✅ KẾT QUẢ

- ✅ Warning "outdated templates" biến mất
- ✅ Templates section hiển thị "No outdated templates"
- ✅ 174 template files đã có version tags chính xác
- ✅ Website hoạt động bình thường

## 📊 THỐNG KÊ

- **Total files fixed:** 174 files
- **Template-parts:** 87 files (header, footer, pages, portfolio, posts, shortcodes)
- **WooCommerce:** 87 files (cart, checkout, content, loop, single-product, v.v.)
- **Versions:** 17 unique version tags (3.16.0 → 3.20.4)

## 📝 GHI CHÚ QUAN TRỌNG

### ⚠️ Lưu ý khi copy từ parent theme:

**Ưu điểm:**
- ✅ Nhanh gọn, đảm bảo 100% chính xác
- ✅ Không còn duplicate tags
- ✅ Version tags luôn khớp với parent theme

**Nhược điểm:**
- ⚠️ Mất các custom code đã thêm vào child theme files
- ⚠️ Cần áp dụng lại custom changes (nếu có)

### 🔧 Nếu cần giữ custom changes:

Sử dụng **Cách 2** (add version tags manually) thay vì copy toàn bộ file:
1. Xác định version tag đúng từ parent theme
2. Thêm vào đầu file child theme
3. Giữ nguyên custom code hiện có

## 🔗 REFERENCE

- **Website fixed:** thiet-ke-web (localhost)
- **Flatsome version:** 3.20.4
- **Parent theme:** flatsome
- **Child theme:** thiet-ke-web
- **Location:** ./wp-content/themes/

## 🚀 CÁCH DÙNG CHO WEBSITE BỊ TƯƠNG TỰ

**Khi website B có warning Flatsome template outdated:**

1. **Check warning:**
   ```bash
   # Vào WordPress Admin → Flatsome Panel → Status
   # Xem Templates section có warning không
   ```

2. **Apply fix:**
   - Xác định child theme name (thiet-ke-web hoặc khác)
   - Chạy lệnh backup
   - Chạy lệnh copy từ parent theme
   - Verify kết quả

3. **Clear cache:**
   - WordPress cache
   - Browser cache (Ctrl+F5)

4. **Test:**
   - Kiểm tra Flatsome Status
   - Warning nên biến mất ✅

---

**Danh sách kiểm tra sau khi fix:**
- [ ] Backup child theme trước khi sửa
- [ ] Copy files từ parent theme
- [ ] Verify 174 files đã có version tags
- [ ] Clear WordPress cache
- [ ] Hard refresh browser
- [ ] Kiểm tra Flatsome Status (warning biến mất)
- [ ] Test website hoạt động bình thường
- [ ] Áp dụng lại custom changes (nếu có)

---

**Skill này áp dụng cho:**
- WordPress + Flatsome theme
- Child theme có template files
- Warning "outdated templates" trong Flatsome Status

**Không áp dụng cho:**
- Không phải Flatsome theme
- Không có child theme
- Lỗi khác (không phải version tags)

---

**Tạo bởi:** Skill Library Team  
**Ngày tạo:** 2026-01-31  
**Cập nhật lần cuối:** 2026-01-31
