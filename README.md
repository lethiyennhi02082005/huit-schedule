# HUIT Schedule Hub — Hệ thống Quản lý & Phân lịch Giảng dạy Đa cơ sở Thông minh

> **Đồ án thực hành:** Web App "HUIT Schedule Hub"  
> **Sinh viên thực hiện:** Lê Thị Yến Nhi — MSSV: 2001230614  
> **Giấy phép:** MIT License  

---

## 📖 Giới thiệu Dự án
Trong môi trường giáo dục đại học, giảng viên thường phải di chuyển giảng dạy giữa nhiều cơ sở (Cơ sở chính Tân Phú, các phòng máy thí nghiệm hoặc cơ sở liên kết). **HUIT Schedule Hub** là giải pháp web ứng dụng hỗ trợ Phòng Đào tạo:
- Phân lịch giảng dạy thông minh theo các tiết trống.
- Tự động phát hiện và cảnh báo tránh tình trạng trùng lịch, trùng phòng học.
- Gợi ý giảng viên có chuyên môn phù hợp, tối ưu hóa thời gian di chuyển giữa các cơ sở và hạn chế khoảng trống chết (dead gap).
- Cung cấp cổng thông tin riêng biệt cho Giảng viên tra cứu lịch dạy cá nhân trực tuyến.
- Báo cáo và biểu đồ thống kê phân bổ ca dạy theo từng cơ sở trực quan.

---

## 🛠 Công nghệ sử dụng
- **Backend:** PHP 8.3+, Laravel 11/12
- **Thư viện mở Packagist:**
  - `vlucas/phpdotenv`: Quản lý an toàn biến môi trường và kết nối CSDL.
  - `fakerphp/faker`: Giả lập dữ liệu mẫu tiếng Việt (giảng viên, lịch dạy, môn học).
  - `laravel/breeze`: Hệ thống xác thực và phân quyền tài khoản (Admin / Giảng viên).
- **Database:** MySQL 8.x / HeidiSQL (`huit_db`)
- **Frontend:** Blade Template, Tailwind CSS, Font Awesome 6, Chart.js
- **CI/CD:** GitHub Actions (tự động chạy lint `php -l` kiểm tra lỗi cú pháp khi push code).

---

## ⚙️ Hướng dẫn Cài đặt & Khởi chạy (Laragon / Môi trường Cục bộ)

### 1. Chuẩn bị môi trường
- Đã cài đặt **Laragon** (bao gồm PHP 8.3+, Apache/Nginx, MySQL).
- Đã cài đặt **Composer** và **Node.js** (npm).

### 2. Cài đặt các gói thư viện phụ thuộc
Mở terminal tại thư mục dự án và chạy các lệnh sau:

```bash
# Cài đặt các thư viện PHP qua Composer
composer install

# Cài đặt các thư viện JavaScript và biên dịch giao diện
npm install
npm run build
```

### 3. Cấu hình biến môi trường (`.env`)
Tạo file `.env` từ file mẫu `.env.example`:

```bash
# Trên Windows PowerShell hoặc CMD:
copy .env.example .env

# Tạo mã khóa bí mật cho ứng dụng
php artisan key:generate
```

Mở file `.env` và kiểm tra các thông số kết nối Database MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=huit_db
DB_USERNAME=root
DB_PASSWORD=
```

---

## 🗄 Hướng dẫn Import Cơ sở dữ liệu mẫu (`huit_db.sql`)

Dự án đã đính kèm sẵn file dữ liệu hoàn chỉnh `huit_db.sql` tại thư mục gốc. Bạn có thể import theo 1 trong 2 cách sau:

### Cách 1: Sử dụng HeidiSQL hoặc phpMyAdmin (Khuyên dùng trên Laragon)
1. Mở **HeidiSQL** (hoặc truy cập `http://localhost/phpmyadmin`).
2. Tạo mới một cơ sở dữ liệu có tên: `huit_db` với bảng mã `utf8mb4_unicode_ci`.
3. Nhấp chọn cơ sở dữ liệu `huit_db`.
4. Vào menu **Tập tin (File)** ➔ **Nạp tập tin SQL... (Load SQL file...)** ➔ Chọn file `huit_db.sql` tại thư mục dự án.
5. Nhấn **F9** (Execute / Chạy) để nạp toàn bộ cấu trúc bảng và dữ liệu mẫu.

### Cách 2: Sử dụng Dòng lệnh (MySQL CLI)
Mở terminal và thực thi lệnh sau:

```bash
# 1. Tạo Database
mysql -u root -e "CREATE DATABASE IF NOT EXISTS huit_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 2. Import dữ liệu từ file huit_db.sql
mysql -u root huit_db < huit_db.sql
```

*(Ghi chú: Nếu muốn tự sinh lại toàn bộ cơ sở dữ liệu và dữ liệu mẫu Faker tiếng Việt thông qua Seeder của Laravel, bạn có thể chạy: `php artisan migrate:fresh --seed`)*

---

## 🚀 Khởi chạy Ứng dụng

### Cách 1: Sử dụng Virtual Host của Laragon
- Tên miền ảo tự động: `http://huit-schedule.test`  
- Hoặc truy cập đường dẫn: `http://localhost/LeThiYenNhi_2001230614_CC/huit-schedule/public`

### Cách 2: Sử dụng máy chủ phát triển tích hợp của Laravel
```bash
php artisan serve
```
Truy cập tại: `http://127.0.0.1:8000`

---

## 👥 Tài khoản Thử nghiệm Hệ thống

Hệ thống được thiết kế phân quyền rõ rệt theo 2 vai trò:

| Vai trò | Email đăng nhập | Mật khẩu | Quyền hạn và Chức năng |
| :--- | :--- | :--- | :--- |
| **Phòng Đào Tạo** *(Admin)* | `admin@huit.edu.vn` | `12345678` | - Toàn quyền quản trị lịch dạy (Thêm, Xóa, Lọc).<br>- Gợi ý GV rảnh tự động, tối ưu di chuyển, tránh khoảng trống chết.<br>- Xem biểu đồ tỷ trọng phân bổ lịch theo cơ sở. |
| **Giảng viên** *(Teacher)* | `gv1@huit.edu.vn`<br>*(hoặc từ gv1 đến gv8)* | `12345678` | - Cổng thông tin cá nhân dành riêng cho giảng viên.<br>- Chỉ xem được lịch dạy của chính bản thân.<br>- Nắm bắt chính xác phòng học và cơ sở cần đến dạy. |

---

## 🔄 Tự động hóa CI/CD (GitHub Actions)

Dự án thiết lập quy trình CI tự động qua file `.github/workflows/php-lint.yml`:
- Tự động kích hoạt mỗi khi có lệnh `git push` hoặc tạo `Pull Request`.
- Khởi tạo môi trường PHP 8.3 trên Ubuntu Runner.
- Chạy lệnh `php -l` quét cú pháp toàn bộ mã nguồn PHP để ngăn chặn lỗi cú pháp trước khi triển khai.

---

## 📄 Bản quyền (License)
Dự án được phân phối dưới giấy phép [MIT License](LICENSE).  
Copyright (c) 2026 Lê Thị Yến Nhi.
