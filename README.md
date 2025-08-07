# 🏥 HỆ THỐNG QUẢN LÝ KHÁM CHỮA BỆNH VIỆN HERUKO

## 📋 Tổng quan

Hệ thống quản lý khám chữa bệnh là một ứng dụng web toàn diện được phát triển bằng **Laravel 12** để quản lý toàn bộ quy trình khám chữa bệnh tại bệnh viện. Hệ thống hỗ trợ 3 vai trò chính: **Admin**, **Bác sĩ** và **Bệnh nhân** với các chức năng quản lý đầy đủ và hiện đại.


## 🎯 Tính năng chính

### 👥 Quản lý Người dùng

#### **Bệnh nhân**
- ✅ Đăng ký tài khoản với ID tự động (BNxxxxx)
- ✅ Phân loại bệnh nhân (nội trú/ngoại trú)
- ✅ Quản lý thông tin cá nhân và liên hệ
- ✅ Đăng nhập riêng với hệ thống xác thực
- ✅ Quản lý thông tin người thân
- ✅ Xem lịch sử khám bệnh và đơn thuốc

#### **Bác sĩ**
- ✅ Quản lý thông tin bác sĩ theo khoa chuyên môn
- ✅ Hệ thống xác thực riêng biệt
- ✅ Dashboard chuyên môn với các chức năng khám chữa bệnh
- ✅ Quản lý lịch hẹn và kê đơn thuốc
- ✅ Xem danh sách bệnh nhân được phân công

#### **Admin**
- ✅ Quản lý toàn bộ hệ thống
- ✅ Dashboard tổng quan với thống kê
- ✅ Phân quyền và quản lý người dùng
- ✅ Xử lý đơn xin bảo hiểm y tế

### 🏥 Quản lý Khám chữa bệnh

#### **Lịch hẹn khám**
- ✅ Đặt lịch hẹn khám với bác sĩ chuyên khoa
- ✅ Phân công bác sĩ và khoa phù hợp
- ✅ Hệ thống thông báo real-time
- ✅ Theo dõi trạng thái lịch hẹn (pending, confirmed, completed)
- ✅ Lịch sử lịch hẹn chi tiết

#### **Sổ khám bệnh**
- ✅ Tạo và quản lý sổ khám bệnh
- ✅ Ghi chép triệu chứng và chẩn đoán
- ✅ Lưu trữ lịch sử khám bệnh chi tiết
- ✅ Theo dõi tiến trình điều trị

#### **Đơn thuốc**
- ✅ Kê đơn thuốc với chi tiết thuốc
- ✅ Quản lý liều lượng và hướng dẫn sử dụng
- ✅ Danh mục thuốc trong kho
- ✅ Lịch sử đơn thuốc của bệnh nhân

#### **Nhập/Xuất viện**
- ✅ Quản lý quá trình nhập viện
- ✅ Phân công phòng và giường bệnh
- ✅ Quản lý xuất viện và hướng dẫn
- ✅ Theo dõi thời gian nằm viện

### 💰 Quản lý Tài chính

#### **Hóa đơn viện phí**
- ✅ Tạo hóa đơn tự động
- ✅ Tính toán chi phí theo loại bệnh nhân
- ✅ Quản lý thanh toán
- ✅ Lịch sử hóa đơn

#### **Bảo hiểm y tế**
- ✅ Quản lý thông tin bảo hiểm
- ✅ Xử lý đơn xin bảo hiểm
- ✅ Tính toán mức chi trả
- ✅ Theo dõi trạng thái đơn

### 📊 Dashboard & Báo cáo

#### **Admin Dashboard**
- ✅ Thống kê tổng quan (bệnh nhân, bác sĩ, đơn thuốc)
- ✅ Biểu đồ nhập/xuất viện theo tháng
- ✅ Thông báo real-time cho lịch hẹn mới
- ✅ Quản lý đơn xin bảo hiểm

#### **Bác sĩ Dashboard**
- ✅ Danh sách bệnh nhân được phân công
- ✅ Lịch hẹn trong ngày
- ✅ Quản lý đơn thuốc và sổ khám bệnh

## 🛠️ Công nghệ sử dụng

### **Backend**
- **Framework:** Laravel 12
- **PHP:** 8.2+
- **Database:** MySQL
- **ORM:** Eloquent
- **Authentication:** Laravel Breeze

### **Frontend**
- **CSS Framework:** Tailwind CSS
- **JavaScript:** Alpine.js
- **Build Tool:** Vite
- **Icons:** Phosphor Icons

### **Development Tools**
- **Testing:** PHPUnit
- **Code Quality:** Laravel Pint
- **Development Environment:** Laravel Sail
- **Package Manager:** Composer, NPM

## 📁 Cấu trúc dự án

```
manager_hospital/
├── app/
│   ├── Http/Controllers/     # 20+ Controllers
│   ├── Models/              # 15+ Models
│   ├── Services/            # Business Logic
│   ├── Helpers/             # Helper Functions
│   └── Providers/           # Service Providers
├── database/
│   ├── migrations/          # 30+ Migration files
│   └── seeders/            # Database Seeders
├── resources/
│   ├── views/              # 50+ Blade templates
│   └── css/               # Tailwind CSS
├── routes/
│   ├── web.php            # 100+ Routes
│   └── auth.php           # Authentication routes
└── tests/                 # Unit tests
```

## 🗄️ Database Schema

### **Core Tables**
- `patients` - Thông tin bệnh nhân
- `doctors` - Thông tin bác sĩ
- `departments` - Khoa chuyên môn
- `appointments` - Lịch hẹn khám
- `medical_records` - Sổ khám bệnh
- `prescriptions` - Đơn thuốc
- `medicines` - Danh mục thuốc
- `bills` - Hóa đơn viện phí
- `health_insurance` - Bảo hiểm y tế

### **Relationship Tables**
- `detail_medical_records` - Chi tiết sổ khám
- `detail_prescriptions` - Chi tiết đơn thuốc
- `hospitalized` - Thông tin nhập viện
- `discharges` - Thông tin xuất viện
- `relatives` - Người thân bệnh nhân

## 🚀 Cài đặt và chạy dự án

### **Yêu cầu hệ thống**
- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL 8.0+

### **Bước 1: Clone dự án**
```bash
git clone https://github.com/otisbrother/manager_hospital.git
cd manager_hospital
```

### **Bước 2: Cài đặt dependencies**
```bash
composer install
npm install
```

### **Bước 3: Cấu hình môi trường**
```bash
cp .env.example .env
php artisan key:generate
```

### **Bước 4: Cấu hình database**
```bash
# Chỉnh sửa .env file với thông tin database
php artisan migrate
php artisan db:seed
```

### **Bước 5: Chạy dự án**
```bash
# Terminal 1: Laravel server
php artisan serve

# Terminal 2: Vite development server
npm run dev
```

## 👤 Tài khoản mặc định

### **Admin**
- Email: admin@hospital.com
- Password: password

### **Bác sĩ**
- Email: doctor@hospital.com
- Password: password

### **Bệnh nhân**
- ID: BN00001
- Password: password

## 🔐 Bảo mật

- **Authentication:** Laravel Breeze với multi-role support
- **Authorization:** Middleware phân quyền theo vai trò
- **Data Validation:** Form validation và sanitization
- **CSRF Protection:** Laravel CSRF tokens
- **Password Hashing:** Bcrypt hashing

## 📱 Responsive Design

- **Mobile-first approach** với Tailwind CSS
- **Progressive Web App** features
- **Cross-browser compatibility**
- **Accessibility** standards

## 🧪 Testing

```bash
# Chạy tất cả tests
php artisan test

# Chạy tests với coverage
php artisan test --coverage
```

## 📈 Performance

- **Database Optimization:** Indexed queries, eager loading
- **Caching:** Laravel cache system
- **Asset Optimization:** Vite bundling
- **Image Optimization:** Responsive images

## 🔄 API Endpoints

### **Authentication**
- `POST /login` - Đăng nhập
- `POST /logout` - Đăng xuất
- `GET /profile` - Thông tin cá nhân

### **Appointments**
- `GET /appointments` - Danh sách lịch hẹn
- `POST /appointments` - Tạo lịch hẹn mới
- `PUT /appointments/{id}` - Cập nhật lịch hẹn

### **Medical Records**
- `GET /medical-records` - Danh sách sổ khám
- `POST /medical-records` - Tạo sổ khám mới
- `GET /medical-records/{id}` - Chi tiết sổ khám

## 🤝 Contributing

1. Fork dự án
2. Tạo feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Tạo Pull Request

