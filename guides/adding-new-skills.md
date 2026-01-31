# ➕ CÁCH TẠO SKILL MỚI - HƯỚNG DẪN CHI TIẾT

## 📋 TỔNG QUAN

Khi bạn gặp lỗi website và fix xong, bạn cần tạo skill file để lưu lại kinh nghiệm này. Skill này sẽ giúp team sau này fix lỗi tương tự nhanh hơn.

---

## 🎯 KHI NÀO CẦN TẠO SKILL?

**Condition:** Bạn nên tạo skill khi:
- ✅ Fix được lỗi lặp lại trong nhiều website
- ✅ Lỗi phức tạp và cần nhiều bước
- ✅ Fix cần các lệnh hoặc plugin cụ thể
- ✅ Lỗi có thể xảy ra lại trong tương lai
- ✅ Fix cần thêm tài liệu hay steps rõ ràng

**Condition:** Bạn KHÔNG cần tạo skill nếu:
- ❌ Fix đơn giản và nhanh
- ❌ Lỗi đã có sẵn trong skills/
- ❌ Fix chỉ áp dụng cho một website duy nhất
- ❌ Fix không có nhiều biến thể

---

## 📝 CẤU TRÚC SKILL FILE

### Folder structure:
```
skills/
├── virus-scanning/              # Skill về virus
├── wordpress-optimization/       # Skill về optimization
├── server-management/           # Skill về server
├── backup-solutions/            # Skill về backup
└── website-output-testing/      # Checklist bàn giao
```

### Naming convention:
- **Folder:** Dùng tên ngắn gọn, được hiểu chung (ví dụ: virus-scanning, wordpress-optimization)
- **File:** `[00X]-[short-name].md` (00X = số thứ tự, short-name = tên ngắn)
- **Example:** `001-fix-virus-infection.md`, `002-optimize-database.md`

---

## 🚀 BƯỚC 1: CHỌN FOLDER

Dựa trên loại lỗi:

| Loại lỗi | Folder |
|----------|--------|
| Virus, malware, security | `virus-scanning/` |
| WordPress speed, database, optimization | `wordpress-optimization/` |
| Server firewall, nginx, configuration | `server-management/` |
| Database backup, restore, migration | `backup-solutions/` |
| Checklist bàn giao, output testing | `website-output-testing/` |
| SEO, keyword, on-page | `seo-optimization/` |
| Caching, CDN, performance | `performance-tuning/` |

**Lưu ý:** Nếu không có folder phù hợp, tạo mới với tên ngắn gọn (ví dụ: `php-fixer` cho PHP errors)

---

## 🚀 BƯỚC 2: TẠO FILE SKILL

**Method 1: Copy template**
```bash
cp templates/skill-template.md skills/[folder-issue]/[00X]-[issue-name].md
```

**Method 2: Manual creation**
- Tạo file mới với tên `[00X]-[issue-name].md`
- Copy content từ `templates/skill-template.md`

---

## 🚀 BƯỚC 3: ĐIỀN THÔNG TIN VÀO SKILL

### 3.1. Frontmatter (Header)

```markdown
---
title: [Tên issue ngắn gọn]
date: [YYYY-MM-DD]
tags: [tag1, tag2, tag3]
type: [folder-type]
priority: [high, medium, low]
---
```

**Example:**
```markdown
---
title: Fix Virus Website bằng Quarantine Scanner
date: 2026-01-31
tags: [virus, scan, security]
type: [virus-scanning]
priority: [high]
---
```

**Guide:**
- **title:** Tên issue ngắn gọn (3-5 từ)
- **date:** Ngày tạo skill (format: YYYY-MM-DD)
- **tags:** Thẻ ngắn (2-3 từ, comma-separated)
- **type:** Tên folder tương ứng
- **priority:** high (đắt hàng, cần fix gấp), medium (không gấp), low (ít gặp)

### 3.2. NỘI DUNG CHÍNH

#### Tóm tắt vấn đề
```markdown
## 📌 TÓM TẮT VẤN ĐỀ
Website bị nhiễm virus sau khi upload file bất thường. Website bị redirect, file bị thay đổi, và không thể truy cập bình thường.
```

**Guide:**
- Giải thích rõ ràng lỗi
- 1-2 câu mô tả
- Không quá dài

#### Dịch báo lỗi
```markdown
## 🔍 DỊCH BÁO LỖI
```
```
[Access Denied] - Connection reset by peer
[Warning] - Files infected detected in wp-content/uploads/
[Error] - Malware signature detected in header.php
```
```

**Guide:**
- Copy error log hoặc warning message
- Format code block
- Include timestamp nếu có

#### Các bước đã thực hiện
```markdown
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
```

**Guide:**
- Liệt kê 3-5 bước chính
- Mỗi bước: Mô tả + lệnh + kết quả
- Format code block cho lệnh
- Kết quả rõ ràng (✅/✗)

#### Lệnh sử dụng
```markdown
## 💻 LỆNH SỬ DỤNG

```bash
# Các lệnh chính đã sử dụng
command1
command2
command3
```
```

**Guide:**
- Include tất cả lệnh chính
- Format code block
- Add comments nếu cần

#### Kết quả
```markdown
## ✅ KẾT QUẢ
- Website đã sạch virus hoàn toàn
- Database được repair
- Security plugins được cài và cấu hình
- Website hoạt động bình thường
- Không còn lỗi tương tự
```

**Guide:**
- Liệt kê 3-5 điểm kết quả chính
- Format bulleted list

#### Ghi chú
```markdown
## 📝 GHI CHÚ
- Lưu ý về biến thể của lỗi này
- Lưu ý về các website khác có thể gặp lỗi tương tự
```

**Guide:**
- Lưu ý quan trọng
- Những điều cần nhớ
- Biến thể của lỗi

#### Link reference
```markdown
## 🔗 REFERENCE
- URL website đã fix: [Link]
- Lỗi tương tự trong website khác: [Link nếu có]
```

**Guide:**
- Link website đã fix
- Link website khác có lỗi tương tự

---

## 🚀 BƯỚC 4: LƯU VÀ COMMIT

```bash
# Check file có được tạo không
ls -la skills/[folder-issue]/

# Add file
git add skills/[folder-issue]/[00X]-[issue-name].md

# Commit với message rõ ràng
git commit -m "Add new skill: fix virus infection using quarantine scanner"

# Push lên GitHub
git push origin main
```

**Guide:**
- Commit message ngắn gọn và rõ ràng
- Include type skill (ví dụ: "fix virus", "optimize database")
- Push lên main branch

---

## 🎯 CHECKLIST TRƯỚC KHI SUBMIT

Trước khi commit và push skill:

- [ ] File đã được tạo trong skills/[folder-issue]/
- [ ] Frontmatter đã được điền đầy đủ
- [ ] Title ngắn gọn và rõ ràng
- [ ] Date đúng format YYYY-MM-DD
- [ ] Tags phù hợp (2-3 thẻ)
- [ ] Type tương ứng với folder
- [ ] Priority đúng (high/medium/low)
- [ ] Tóm tắt vấn đề rõ ràng
- [ ] Dịch báo lỗi được copy đúng
- [ ] Các bước đã thực hiện được liệt kê
- [ ] Lệnh sử dụng được format code block
- [ ] Kết quả được ghi rõ ràng
- [ ] Ghi chú được liệt kê
- [ ] Link reference được cung cấp
- [ ] File đã được commit
- [ ] File đã được push lên GitHub
- [ ] File đã được pull lại để verify

---

## 📝 EXAMPLES

### Example 1: Optimize Database

**File:** `001-optimize-wordpress-database.md`

```markdown
---
title: Optimize WordPress Database Performance
date: 2026-01-31
tags: [optimization, performance, database]
type: [wordpress-optimization]
priority: [medium]
---

## 📌 TÓM TẮT VẤN ĐỀ
Website đang load chậm, database quá nặng sau nhiều năm hoạt động.

## 🔍 DỊCH BÁO LỖI
```
[Slow query]: SELECT * FROM wp_options WHERE option_name = 'siteurl'
[Memory usage]: PHP memory limit exceeded
[Response time]: Page load time > 5 seconds
```

## 🛠️ CÁC BƯỚC ĐÃ THỰC HIỆN

1. **Bước 1:** Backup database
   - Lệnh: `mysqldump -u user -p database_name > backup.sql`
   - Kết quả: Backup thành công

2. **Bước 2:** Optimize tables
   - Lệnh: `mysql -u user -p database_name -e "OPTIMIZE TABLE wp_options, wp_postmeta"`
   - Kết quả: Database optimized

3. **Bước 3:** Remove revisions
   - Lệnh: `mysql -u user -p database_name -e "DELETE FROM wp_posts WHERE post_type='revision'"`
   - Kết quả: Removed 12,500 revisions

## 💻 LỆNH SỬ DỤNG

```bash
mysqldump -u username -p database_name > backup.sql
mysql -u username -p database_name -e "OPTIMIZE TABLE wp_options, wp_postmeta"
```

## ✅ KẾT QUẢ
- Database size giảm 50%
- Page load time giảm từ 5s xuống 1.2s

## 📝 GHI CHÚ
- Cần schedule optimize hàng tháng

## 🔗 REFERENCE
- Website: example.com
- Website2: example2.com (similar issue)
```

---

## 🚀 SUMMARY

**Quick Reference:**

```
Khi gặp lỗi lặp lại:
1. Kiểm tra skills/[folder]/
2. Nếu có: Apply fix
3. Nếu không: Tạo skill mới
4. Copy template
5. Điền thông tin
6. Commit & push
7. Get client signature
```

**Best Practices:**
- ✅ Tạo skill ngay khi fix
- ✅ Điền đầy đủ thông tin
- ✅ Format code block cho lệnh
- ✅ Include kết quả rõ ràng
- ✅ Naming convention
- ✅ Commit rõ ràng
- ✅ Get client signature

---

**Last Updated:** 2026-01-31
**Repository:** SkillwebsiteWP
