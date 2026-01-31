---
title: [Template checklist bàn giao]
date: [YYYY-MM-DD]
tags: [checklist, delivery, testing]
type: [checklist, output-testing]
---

# 📋 WEBSITE OUTPUT TESTING CHECKLIST

**Website:** [Tên website]
**Client:** [Tên khách hàng]
**Date:** [YYYY-MM-DD]
**Status:** [PENDING | IN_PROGRESS | COMPLETED]

---

## ✅ KIỂM TRA CHI TIẾT

### 1. ⚠️ UPTIMEROBOT NOTIFICATION
- [ ] Đã thêm website vào UptimeRobot chưa?
- [ ] Email notification có cấu hình chưa?
- [ ] Test notification sent successfully?

### 2. 📧 BREVO EMAIL SERVICE
- [ ] Brevo account đã cấu hình SMTP chưa?
- [ ] Plugin SMTP có cài chưa? (WP Mail SMTP / SendGrid)
- [ ] SMTP configuration đã lưu chưa?

### 3. ⚡ LITESPEED CACHE PLUGIN
- [ ] Cài LiteSpeed Cache plugin chưa?
- [ ] Page cache/Object cache có cấu hình chưa?
- [ ] Purge cache sau khi cài xong?

**⚠️ LANDING PAGE: Không cài plugin này**

### 4. 🔒 SECURITY PLUGINS
- [ ] Cài Wordfence hoặc iThemes Security chưa?
- [ ] Firewall rules có cấu hình chưa?
- [ ] Login security (2FA) đã setup chưa?
- [ ] Backup schedule đã cấu hình chưa?

### 5. 🌐 GOOGLE INDEX CHECK
- [ ] Vào Dashboard WordPress
- [ ] Navigate to: Settings → Reading
- [ ] Tích vào **"Allow search engines to index this site"**
- [ ] Screenshot lại màn hình cho client xác nhận

### 6. 📊 ADDITIONAL VERIFICATIONS
- [ ] Test all contact forms
- [ ] Test newsletter subscription
- [ ] Check mobile responsiveness
- [ ] Verify all links work
- [ ] Test checkout process (nếu có)
- [ ] Check admin panel access

---

## 📸 REQUIRED SCREENSHOTS

1. UptimeRobot setup
2. Brevo SMTP configuration
3. Reading settings (Google Index)
4. Security plugin dashboard
5. Website loaded in browser

---

## ✍️ NOTES / REMARKS
[User can add custom notes here]

---

## ✅ VERIFICATION SIGNATURE

**Client Name:** ___________________
**Date:** ___________________
**Approved:** [✓] YES / [ ] NO

---

## 🔗 DOCUMENTATION

- UptimeRobot URL: ___________________
- Brevo Account: ___________________
- SMTP Details: ___________________
- Security Plugin Dashboard: ___________________
