# 👥 WORKFLOW NHÂN VIÊN SKILL LIBRARY

## 📋 QUY TRÌNH LÀM VIỆC TIÊU CHUẨN

### 1. KHỞI TẠO GITHUB REPOSITORY

**Bước 1:** Clone repository về máy
```bash
git clone https://github.com/dungnguyen302007/SkillwebsiteWP.git
cd SkillwebsiteWP
```

**Bước 2:** Cấu hình Git user
```bash
git config user.name "[Tên nhân viên]"
git config user.email "[email nhân viên]"
```

**Bước 3:** Pull updates từ remote
```bash
git pull origin main
```

---

### 2. KHI CẦN FIX WEBSITE

#### Tình huống 1: Xem có fix tương tự chưa?

**Workflow:**
1. Kiểm tra thư mục `skills/`
2. Tìm folder phù hợp (virus-scanning, wordpress-optimization, v.v.)
3. Xem các skill file đã từng fix lỗi tương tự
4. Apply fix tương tự vào website hiện tại

**Lưu ý:**
- ✅ Nếu có skill tương tự: Apply ngay và test
- ⚠️ Nếu skill tương tự nhưng có chút khác biệt: Custom lại
- ❌ Nếu không có skill: Cần tạo skill mới

---

#### Tình huống 2: Cần tạo skill mới

**Workflow:**

**Bước 1:** Mở file template
```bash
# Copy template
cp templates/skill-template.md skills/[folder-issue]/[000]-[issue-name].md
```

**Bước 2:** Điền thông tin vào skill file
- **Title:** Tên issue ngắn gọn
- **Date:** Ngày tạo skill
- **Tags:** Thẻ ngắn (ví dụ: virus, scan, security)
- **Type:** Loại skill (virus-scanning, wordpress-optimization, v.v.)
- **Priority:** Priority (high, medium, low)

**Bước 3:** Điền nội dung
- **Tóm tắt vấn đề:** Giải thích rõ ràng lỗi website A gặp phải
- **Dịch báo lỗi:** Copy error log hoặc warning message
- **Các bước đã thực hiện:**
  - Bước 1: [Mô tả + lệnh]
  - Bước 2: [Mô tả + lệnh]
  - Bước 3: [Mô tả + lệnh]
- **Lệnh sử dụng:** Chứa tất cả lệnh đã dùng
- **Kết quả:** ✅ Báo cáo hoàn thành
- **Ghi chú:** Lưu ý về biến thể, biến thể của lỗi này

**Bước 4:** Commit và push lên GitHub
```bash
git add skills/[folder-issue]/[000]-[issue-name].md
git commit -m "Add new skill: [issue-name]"
git push origin main
```

---

### 3. KHI BÀN GIAO WEBSITE

**Workflow:**

**Bước 1:** Mở checklist output testing
```bash
# Lấy checklist
skills/website-output-testing/checklist-template.md
```

**Bước 2:** Thiết lập các thông số
- Update thông tin: Website, Client, Date
- Check checklist items (từ UptimeRobot đến Google Index)

**Bước 3:** Thiết lập service
- [ ] UptimeRobot notification
- [ ] Brevo SMTP configuration
- [ ] SMTP Plugin setup
- [ ] LiteSpeed Cache (nếu không landing page)
- [ ] Security Plugins (Wordfence/iThemes)
- [ ] Google Index enable
- [ ] Test all features

**Bước 4:** Lấy client signature
- Client review checklist
- Client sign verification form
- Employee confirm completed items

**Bước 5:** Lưu documentation
- Screenshot các mục quan trọng
- Backup credentials
- Provide admin access

---

### 4. QUẢN LÝ SKILL FILES

#### Cấu trúc thư mục skills/
```
skills/
├── virus-scanning/              # Virus và security
├── wordpress-optimization/       # Tối ưu WordPress
├── server-management/           # Quản lý server
├── backup-solutions/            # Giải pháp backup
├── website-output-testing/      # Checklist bàn giao
└── [other categories...]
```

#### Naming Convention:
- **Folder naming:** Dùng tên ngắn gọn, được biết đến rộng (ví dụ: virus-scanning)
- **File naming:** `[00X]-[short-name].md` (00X = số thứ tự, short-name = tên ngắn)
- **Example:** `001-fix-virus-infection.md`, `002-optimize-database.md`

#### Version Control:
- ✅ Luôn commit khi tạo hoặc update skill
- ✅ Sử dụng clear commit messages
- ✅ Update tags khi có skill tương tự mới

---

### 5. UPDATE SKILL EXISTING

**Khi fix lỗi tương tự:**

**Bước 1:** Tìm skill tương tự
- Scan skills/[folder-issue]/
- Check tags và descriptions

**Bước 2:** Update skill file
- Nếu có nhiều website bị lỗi tương tự:
  - Update phần "Link reference"
  - Add website mới vào danh sách
- Nếu website khác biệt nhiều:
  - Thêm phần "Ghi chú" hoặc "Lưu ý"
  - Update tags nếu cần

**Bước 3:** Commit và push
```bash
git add skills/[folder-issue]/[file-name].md
git commit -m "Update [file-name]: add website B"
git push origin main
```

---

### 6. TEAM COLLABORATION

#### Cách team làm việc:

**Daily:**
- Pull updates: `git pull origin main`
- Check skills/ để xem có skill mới không
- Apply skill mới nếu cần

**Weekly:**
- Review skills/
- Suggest improvement cho skills
- Update outdated information

**Monthly:**
- Organize skills/
- Merge similar skills
- Archive completed skills

---

## 📊 CHECKLIST HÀNG NGÀY

**Buổi sáng:**
- [ ] Pull updates từ GitHub
- [ ] Check skills/ để xem skill mới
- [ ] Scan skills/ để tìm lỗi tương tự

**Trong ngày:**
- [ ] Khi fix lỗi → Kiểm tra skills/
- [ ] Nếu có fix mới → Tạo skill mới
- [ ] Khi bàn giao → Check output testing checklist

**Buổi tối:**
- [ ] Update skills/ nếu cần
- [ ] Commit và push lên GitHub
- [ ] Update checklist bàn giao nếu cần

---

## 🎯 SUMMARY

**Quy trình cơ bản:**

```
1. Pull updates từ GitHub
2. Khi thấy lỗi lặp lại:
   - Kiểm tra skills/ → Nếu có: Apply fix
   - Nếu không: Tạo skill mới
3. Tạo skill mới:
   - Copy template
   - Điền thông tin
   - Commit & push
4. Khi bàn giao:
   - Check checklist output testing
   - Thiết lập các thông số
   - Lấy client signature
   - Lưu documentation
```

**Best Practices:**
- ✅ Pull updates hàng ngày
- ✅ Tạo skill ngay khi fix lỗi
- ✅ Commit ngay sau khi update
- ✅ Test kỹ trước khi commit
- ✅ Đầy đủ thông tin trong skill
- ✅ Sử dụng naming convention
- ✅ Get client signature cho checklist
- ✅ Backup trước khi fix anything

---

## 🔗 TÀI LIỆU THAM KHẢO

- Skill templates: `templates/skill-template.md`
- Checklist template: `skills/website-output-testing/checklist-template.md`
- Cấu trúc skills: Check folder skills/
- GitHub repository: https://github.com/dungnguyen302007/SkillwebsiteWP

---

**Last Updated:** 2026-01-31
**Author:** Skill Library Team
**Repository:** SkillwebsiteWP
