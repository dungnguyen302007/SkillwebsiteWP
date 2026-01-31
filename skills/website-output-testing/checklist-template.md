---
title: Standard Website Output Checklist
date: 2026-01-31
tags: [checklist, delivery, testing, output]
type: [checklist, output-testing]
priority: [high]
---

# 📋 WEBSITE OUTPUT TESTING CHECKLIST - STANDARD

**Website:** [Tên website]
**Client:** [Tên khách hàng]
**Date:** [YYYY-MM-DD]
**Status:** [PENDING | IN_PROGRESS | COMPLETED]

---

## ✅ CHECKLIST CHI TIẾT

### 1. ⚠️ UPTIMEROBOT NOTIFICATION
- [ ] Website được thêm vào UptimeRobot: https://uptimerobot.com
- [ ] Email notification có cấu hình cho team chưa?
- [ ] Test notification gửi thành công?

### 2. 📧 BREVO EMAIL SERVICE
- [ ] Brevo account đã cấu hình SMTP chưa?
- [ ] Plugin SMTP đã cài chưa? (WP Mail SMTP / SendGrid)
- [ ] SMTP configuration đã lưu chưa? (Host, Port, Username, Password)
- [ ] Test gửi email từ contact form thành công?

### 3. ⚡ LITESPEED CACHE PLUGIN
- [ ] Cài LiteSpeed Cache plugin chưa?
- [ ] Page cache/Object cache có cấu hình chưa?
- [ ] Purge cache sau khi cài xong chưa?
- [ ] Test website loading speed?

**⚠️ LANDING PAGE: Không cài plugin này**

### 4. 🔒 SECURITY PLUGINS
- [ ] Cài Wordfence hoặc iThemes Security chưa?
- [ ] Firewall rules có cấu hình chưa?
- [ ] Login security (2FA) đã setup chưa?
- [ ] Backup schedule đã cấu hình chưa?
- [ ] Scan malware trước khi deliver?

### 5. 🌐 GOOGLE INDEX CHECK
- [ ] Vào Dashboard WordPress
- [ ] Navigate to: **Settings → Reading**
- [ ] Tích vào **"Allow search engines to index this site"** chưa?
- [ ] Screenshot lại màn hình cho client xác nhận

### 6. 📊 ADDITIONAL VERIFICATIONS
- [ ] Test all contact forms
- [ ] Test newsletter subscription
- [ ] Check mobile responsiveness
- [ ] Verify all links work
- [ ] Test checkout process (nếu có)
- [ ] Check admin panel access
- [ ] Verify SSL certificate (HTTPS) working?

---

## 📸 REQUIRED SCREENSHOTS

1. **UptimeRobot setup:**
   - [ ] Screenshot màn hình UptimeRobot
   - [ ] Include notification settings

2. **Brevo SMTP configuration:**
   - [ ] Screenshot Brevo dashboard
   - [ ] Include SMTP credentials backup

3. **Google Index settings:**
   - [ ] Screenshot WordPress Reading settings
   - [ ] Include checkbox marked "Allow search engines to index this site"

4. **Security plugin dashboard:**
   - [ ] Screenshot Wordfence/iThemes dashboard
   - [ ] Include firewall status

5. **Website loaded in browser:**
   - [ ] Screenshot website with HTTPS
   - [ ] Include mobile view screenshot

---

## ✍️ NOTES / REMARKS

[User can add custom notes here]

**Các thông tin quan trọng cần lưu:**
- UptimeRobot URL: ___________________
- Brevo Account: ___________________
- SMTP Details: ___________________
- Security Plugin Dashboard: ___________________
- Google Index Status: [✓] YES / [ ] NO

---

## ✅ VERIFICATION SIGNATURE

**Client Name:** ___________________
**Date:** ___________________
**Approved:** [✓] YES / [ ] NO

**Employee Note:** [Thực hiện checklist] - [Date completed]
**Client Confirmed:** [✓] YES / [ ] NO
**Client Signature:** ___________________

---

## 🔗 DOCUMENTATION

### Backup Links:
- UptimeRobot URL: ___________________
- Brevo Account: ___________________
- SMTP Settings: ___________________
- Security Plugin: ___________________

### Test Results:
- Contact Form Test: [✓] PASSED / [✗] FAILED
- Email Notification Test: [✓] PASSED / [✗] FAILED
- Google Index Test: [✓] PASSED / [✗] FAILED
- Mobile Responsiveness: [✓] PASSED / [✗] FAILED
- SSL Certificate: [✓] VALID / [✗] INVALID

---

## 📝 PROCEDURE CHECKLIST

### Pre-Delivery Checklist:
- [ ] All plugins updated to latest version
- [ ] SSL certificate valid and working
- [ ] Database optimized
- [ ] Cache cleared and tested
- [ ] Security plugins configured
- [ ] All contact forms tested
- [ ] Mobile responsiveness tested
- [ ] Website speed test completed
- [ ] Documentation provided to client

### Delivery Checklist:
- [ ] Present checklist to client
- [ ] Client reviews and confirms each item
- [ ] Take screenshots of confirmed items
- [ ] Provide backup credentials to client
- [ ] Provide admin access instructions
- [ ] Client signs verification form
- [ ] Final backup completed
- [ ] Website handed over

---

## 🎯 QUICK SUMMARY

**Website Status:** [ ]
**Client Contact Info:** [ ]
**Total Checklist Items:** 18 items
**Items Completed:** [ ] out of 18
**Percentage:** [ ]%

**Quick Checklist Copy-Paste:**

```
## ✅ OUTPUT TESTING
- [ ] UptimeRobot notification có config chưa?
- [ ] Brevo SMTP đã cấu hình chưa?
- [ ] SMTP Plugin cài config xong chưa?
- [ ] LiteSpeed Cache: [ ] Có / [ ] Skip (landing page)
- [ ] Security Plugins: [ ] Cài / [ ] Config xong
- [ ] Google Index: [ ] Bật "Allow search engines to index this site"
- [ ] All contact forms tested
- [ ] Mobile responsiveness verified
```

---

## 🔗 REFERENCE

- Website URL: ___________________
- Database Name: ___________________
- Admin URL: ___________________
- Previous Fixes: [Link nếu có]

---

## 📝 WEB A LIKE THIS (REFERENCE)
[Copy this reference for future use]

Web A - BẮT ĐẦU CHO WEB A:
- **Website:** [screenshot từ Web A]
- **Output Status:** [✓] PASS / [✗] FAIL
- **Fix Applied:** [Link nếu có]

---

## 🚀 CÁCH DÙNG CHO WEB B (TƯƠNG TỰ)

**Khi website B cần output testing:**

1. Clone checklist này
2. Update thông tin website B
3. Thiết lập UptimeRobot notification
4. Configure Brevo SMTP
5. Install và config SMTP Plugin
6. Config LiteSpeed Cache (nếu không landing page)
7. Install Security Plugins
8. Enable Google Index
9. Test tất cả contact forms
10. Verify mobile responsiveness
11. Test SSL certificate
12. Get client signature
13. Screenshot tất cả checklist items
14. Final delivery

**Danh sách kiểm tra sau khi fix:**
- [ ] Checklist đã được hoàn thành
- [ ] Client đã xác nhận từng item
- [ ] Screenshots đã được chụp
- [ ] Backup credentials đã được cung cấp
- [ ] Client đã ký verification form
- [ ] Final backup completed
- [ ] Website được bàn giao thành công

---

**Generated:** 2026-01-31
**Last Updated:** 2026-01-31
**Repository:** SkillwebsiteWP
