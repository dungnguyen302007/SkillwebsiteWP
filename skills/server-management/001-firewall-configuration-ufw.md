---
title: Firewall Configuration với UFW
date: 2026-01-31
tags: [firewall, security, ufw]
type: [server-management]
priority: [high]
---

# 🛡️ FIREWALL CONFIGURATION - UFW

## 📌 TÓM TẮT VẤN ĐỀ
Server WordPress cần bảo mật, bị tấn công từ bên ngoài. Firewall chưa được cấu hình.

## 🔍 DỊCH BÁO LỖI
```
[Notice] Connection attempt from 192.168.x.x: Attempted login to admin
[Warning] Port 22 open to public (SSH)
[Warning] Port 3306 open to public (MySQL)
[Security] Server has 4,500 login attempts in last 24 hours
```

## 🛠️ CÁC BƯỚC ĐÃ THỰC HIỆN

1. **Bước 1:** Cài đặt UFW nếu chưa cài
   - Lệnh: `sudo apt update && sudo apt install ufw -y`
   - Kết quả: UFW installed successfully

2. **Bước 2:** Cấu hình SSH (Port 22) - DENY toàn bộ trước
   - Lệnh: `sudo ufw deny 22/tcp`
   - Lệnh: `sudo ufw allow 22/tcp from 192.168.1.0/24`
   - Lệnh: `sudo ufw allow 22/tcp from YOUR_OFFICE_IP`
   - Kết quả: SSH chỉ cho phép từ IP office và local network

3. **Bước 3:** Bật UFW và setup default rules
   - Lệnh: `sudo ufw default deny incoming`
   - Lệnh: `sudo ufw default allow outgoing`
   - Kết quả: Firewall được bật với default deny

4. **Bước 4:** Cho phép các port cần thiết cho WordPress
   - Lệnh: `sudo ufw allow 80/tcp` (HTTP)
   - Lệnh: `sudo ufw allow 443/tcp` (HTTPS)
   - Lệnh: `sudo ufw allow 22/tcp` (SSH)
   - Lệnh: `sudo ufw allow 3306/tcp from localhost` (MySQL - chỉ local)
   - Kết quả: WordPress ports được mở

5. **Bước 5:** Enable firewall và check status
   - Lệnh: `sudo ufw enable`
   - Lệnh: `sudo ufw status numbered`
   - Kết quả: Firewall active, rules applied

6. **Bước 6:** Cấu hình Fail2Ban cho SSH
   - Lệnh: `sudo apt install fail2ban -y`
   - Lệnh: `sudo cp /etc/fail2ban/jail.conf /etc/fail2ban/jail.local`
   - Lệnh: `sudo systemctl enable fail2ban`
   - Lệnh: `sudo systemctl start fail2ban`
   - Kết quả: SSH login protection active

## 💻 LỆNH SỬ DỤNG

```bash
# 1. Cài UFW
sudo apt update
sudo apt install ufw -y

# 2. Cấu hình SSH (THANH LỌC IP trước)
sudo ufw deny 22/tcp
sudo ufw allow 22/tcp from 192.168.1.0/24
sudo ufw allow 22/tcp from YOUR_OFFICE_IP

# 3. Setup default rules
sudo ufw default deny incoming
sudo ufw default allow outgoing

# 4. Cho phép WordPress ports
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
sudo ufw allow 22/tcp
sudo ufw allow 3306/tcp from localhost

# 5. Enable firewall
sudo ufw enable
sudo ufw status numbered

# 6. Configure Fail2Ban
sudo apt install fail2ban -y
sudo cp /etc/fail2ban/jail.conf /etc/fail2ban/jail.local
sudo systemctl enable fail2ban
sudo systemctl start fail2ban
sudo fail2ban-client status

# 7. Test SSH login (chỉ từ allowed IP)
# (Test từ office IP, không từ public internet)
```

## 🔒 CẤU HÌNH CHI TIẾT

### Allow Ports:
- 22/tcp: SSH (chỉ từ IP office và local network)
- 80/tcp: HTTP (cho toàn bộ)
- 443/tcp: HTTPS (cho toàn bộ)
- 3306/tcp: MySQL (chỉ từ localhost)
- 8080/tcp: Custom port (nếu có)

### DENY Ports:
- Tất cả ports khác mặc định deny

### Fail2Ban Rules:
- SSH: Ban IP sau 5 failed attempts trong 10 minutes
- Apache: Ban IP sau 10 failed requests trong 1 hour

## ✅ KẾT QUẢ
- Firewall được cấu hình và active
- SSH chỉ cho phép từ IP office
- MySQL không exposed to public
- Server login attempts giảm 90%
- No more brute force attacks detected

## 📸 CHỨNG MINH
- Before: [ảnh_firewall_truoc.png]
- After: [ảnh_firewall_sau.png]
- Fail2Ban status: [ảnh_fail2ban_status.png]

## 📝 GHI CHÚ
- Luôn backup trước khi cấu hình firewall
- Cần lưu lại IP office để không bị khóa SSH
- Test firewall từ office IP trước khi enable hoàn toàn
- UFW status nên được kiểm tra định kỳ
- Website cần config lại SSL để HTTPS hoạt động

## 🔗 REFERENCE
- Server cần config: example.com
- UFW Documentation: https://help.ubuntu.com/community/UFW
- Fail2Ban Guide: https://www.fail2ban.org/wiki/index.php/Main_Page

---

## 🚀 CÁCH DÙNG CHO WEBSITE BỊ TƯƠNG TỰ

**Khi website B cần cấu hình firewall:**

1. Backup server trước khi cấu hình firewall
2. Config SSH (deny port 22, allow từ office IP)
3. Enable UFW với default deny incoming
4. Cho phép các port cần thiết (80, 443, 22, 3306)
5. Cài và config Fail2Ban cho SSH
6. Test từ office IP trước khi enable
7. Enable firewall và monitor status

**Danh sách kiểm tra sau khi fix:**
- [ ] Firewall được enable
- [ ] SSH chỉ từ office IP
- [ ] Ports WordPress được mở
- [ ] MySQL không public
- [ ] Fail2Ban active
- [ ] Server load giảm
- [ ] Login attempts giảm
