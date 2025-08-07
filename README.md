# 🏥 HỆ THỐNG QUẢN LÝ KHÁM CHỮA BỆNH VIỆN HERUKO

## 📋 Tổng quan

Hệ thống quản lý khám chữa bệnh là một ứng dụng web toàn diện được phát triển bằng **Laravel 12** để quản lý toàn bộ quy trình khám chữa bệnh tại bệnh viện. Hệ thống hỗ trợ 3 vai trò chính: **Admin**, **Bác sĩ** và **Bệnh nhân** với các chức năng quản lý đầy đủ và hiện đại.
<img width="1588" height="818" alt="image" src="https://github.com/user-attachments/assets/07fe1d2b-87cd-4cfc-a5f5-ba7d36034dbe" />


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

## 👤 Quy định tài khoản các quyền

### **Admin**
- Email: admin@gmail.com
- Password: password
  <img width="1511" height="855" alt="image" src="https://github.com/user-attachments/assets/558e9329-c88f-493b-888e-8fdb3041dcc2" />

### **Bác sĩ**
- Mỗi bác sĩ sẽ có 1 tài khoản riêng biệt nhưng có sẽ có email tổng quát : BS001_doctor@gmail.com ->BS00n_doctor@gmail.com
- Bác sĩ mới sẽ phải kích hoạt tài khoản và cài mật khẩu 
- Password: xxxxx (ít nhất 8 kí tự)
  <img width="1511" height="855" alt="image" src="https://github.com/user-attachments/assets/fde72590-f5c8-476f-a319-b1844ab670a7" />

### **Bệnh nhân**
# Đối với bệnh nhân đã có tài khoản :
<img width="1336" height="913" alt="image" src="https://github.com/user-attachments/assets/1687f243-ffb1-4b79-a47e-c85482aad288" />

- Email: x@gmail.com
- Password: xxxx
# Đối với bệnh nhân mới sẽ phải đăng kí :
<img width="1458" height="947" alt="image" src="https://github.com/user-attachments/assets/da16c577-9ab9-408d-9434-366ee63699af" />
- Cần nhập đủ thông tin để dữ liệu có thể đổ về thông báo , chi tiết bệnh nhân và lịch khám của admin
- Đăng kí xong có thể tiến hành đăng nhập 

## 🔐 Bảo mật

- **Authentication:** Laravel Breeze với multi-role support
- **Authorization:** Middleware phân quyền theo vai trò
- **Data Validation:** Form validation và sanitization
- **CSRF Protection:** Laravel CSRF tokens
- **Password Hashing:** Bcrypt hashing
  
## 🔄 QUY TRÌNH LÀM VIỆC CHI TIẾT

### 📝 QUY TRÌNH DÀNH CHO BỆNH NHÂN
<img width="1467" height="945" alt="image" src="https://github.com/user-attachments/assets/9a00d259-27d3-4366-90ee-47482fd58217" />

#### 1. **Đăng ký và Đăng nhập**
```
Bệnh nhân → Đăng ký tài khoản → Xác thực thông tin → Đăng nhập
```

**Chi tiết:**
- Bệnh nhân truy cập `/patient/register`
- Điền thông tin cá nhân (họ tên, email, số điện thoại, địa chỉ)
- Hệ thống tạo ID bệnh nhân tự động (format: BNxxxxx)
- Đăng nhập qua `/patient/login`

#### 2. **Đặt Lịch Hẹn Khám**
<img width="1487" height="926" alt="image" src="https://github.com/user-attachments/assets/411c6a6d-7b81-4cf4-9ae6-da5867a457c1" />

Bệnh nhân → Chọn khoa → Chọn bác sĩ → Chọn ngày giờ → Xác nhận lịch hẹn
```

**Chi tiết:**
- Truy cập `/patient/appointment/create`
- Chọn khoa khám bệnh
- Chọn bác sĩ (nếu có)
- Chọn ngày và giờ khám
- Mô tả triệu chứng
- Xác nhận đặt lịch
```
#### 3. **Đăng Ký Bảo Hiểm Y Tế (BHYT)**
<img width="859" height="802" alt="image" src="https://github.com/user-attachments/assets/54c28519-e4d5-484c-a9ea-b1ec0bcfec9b" />
<img width="852" height="745" alt="image" src="https://github.com/user-attachments/assets/e25c34a4-1f93-44ed-9d24-420b63edbe88" />

Bệnh nhân → Tạo hồ sơ BHYT → Upload giấy tờ → Chờ duyệt → Nhận thông báo
```

**Chi tiết:**
- Truy cập `/patient/insurance/create`
- Điền thông tin BHYT
- Upload giấy tờ chứng minh
- Hệ thống gửi thông báo cho Admin
- Admin duyệt/từ chối hồ sơ
- Bệnh nhân nhận thông báo kết quả
````
<img width="1054" height="929" alt="image" src="https://github.com/user-attachments/assets/ee6bc9f2-66c1-496b-94a9-7806bb8c3c13" />

#### 4. **Khám Bệnh và Nhận Đơn Thuốc**
```
Bệnh nhân → Đến khám theo lịch → Bác sĩ khám → Nhận đơn thuốc → Thanh toán
```

**Chi tiết:**
- Bệnh nhân đến khám theo lịch hẹn
- Bác sĩ khám và ghi hồ sơ y tế
- Bác sĩ kê đơn thuốc
- Hệ thống tạo hóa đơn tự động
- Bệnh nhân thanh toán qua `/patient/bills`
<img width="720" height="748" alt="image" src="https://github.com/user-attachments/assets/ca9a10ac-051e-4c61-8894-07081b1ae17a" />
<img width="889" height="757" alt="image" src="https://github.com/user-attachments/assets/0a76e120-150f-4511-8b5e-a42ec34cd31b" />

#### 5. **Xem Hồ Sơ Y Tế**
```
Bệnh nhân → Truy cập hồ sơ → Xem lịch sử khám → Xem đơn thuốc → Tải xuống
```

**Chi tiết:**
- Truy cập `/patient/medical-records`
- <img width="1237" height="807" alt="image" src="https://github.com/user-attachments/assets/8b4fc74e-5356-406d-abd3-eccc12b14aae" />

- Xem tất cả lịch sử khám bệnh
- Xem chi tiết từng lần khám
- Xem đơn thuốc tương ứng
- Tải xuống hồ sơ (nếu có)

#### 6. **Thanh Toán Hóa Đơn**
```
Bệnh nhân → Xem hóa đơn → Chọn phương thức thanh toán → Xác nhận thanh toán

```

**Chi tiết:**
- Truy cập `/patient/bills`
- Xem danh sách hóa đơn chưa thanh toán
- Chọn hóa đơn cần thanh toán
- Chọn phương thức thanh toán
- Xác nhận và hoàn tất thanh toán
- Tùy theo giấy tờ của bệnh nhân (bhyt, sổ cận nghèo, (sổ nghèo, có công với cách mạng)) sẽ được miễn giảm lần lượt theo : 80%,95%,100%
<img width="1224" height="804" alt="image" src="https://github.com/user-attachments/assets/294b2a9e-764b-4f33-8a23-a31d3ba0d476" />

#### 7. **Quản Lý Thông Tin Cá Nhân**
```
Bệnh nhân → Cập nhật thông tin → Đổi mật khẩu → Quản lý thân nhân
```

**Chi tiết:**
- Truy cập `/patient/account`
- Cập nhật thông tin cá nhân
- Đổi mật khẩu
- Quản lý danh sách thân nhân
- Xem lịch sử hoạt động
<img width="438" height="698" alt="image" src="https://github.com/user-attachments/assets/325b10e0-79a1-4484-9e80-9cec88745d04" />

### 👨‍⚕️ QUY TRÌNH DÀNH CHO BÁC SĨ

#### 1. **Đăng Nhập và Dashboard**
```
Bác sĩ → Đăng nhập → Xem dashboard → Kiểm tra lịch khám hôm nay
```
<img width="1914" height="943" alt="image" src="https://github.com/user-attachments/assets/1d01b961-1fa0-4d69-b9ba-b9e35658865d" />

**Chi tiết:**
- Truy cập `/doctor/login`
- Đăng nhập với email và mật khẩu
- Xem dashboard với thống kê cá nhân
- <img width="1611" height="813" alt="image" src="https://github.com/user-attachments/assets/1a412e08-64c5-4985-9e6a-46cffbc4a881" />
- Kiểm tra lịch khám trong ngày

#### 2. **Quản Lý Lịch Khám**
```
Bác sĩ → Xem lịch khám → Sắp xếp thứ tự → Cập nhật trạng thái
```

**Chi tiết:**
- Truy cập `/doctors/appointments`( phải chờ admin duyệt thì mới unlock khám bệnh )
- <img width="1901" height="803" alt="image" src="https://github.com/user-attachments/assets/06ebc945-5d91-41f4-8f93-6ee8982c19ce" />
- Xem danh sách lịch hẹn
- Sắp xếp theo thứ tự ưu tiên
- Cập nhật trạng thái lịch hẹn
- Ghi chú cho từng lịch hẹn

#### 3. **Khám Bệnh và Ghi Hồ Sơ**
```
Bác sĩ → Chọn bệnh nhân → Khám bệnh → Ghi hồ sơ y tế → Lưu thông tin
```

**Chi tiết:**
- Truy cập `/doctors/exam/create/{appointmentId}`
- Chọn bệnh nhân từ lịch hẹn
- Khám bệnh và ghi chẩn đoán
- Ghi triệu chứng và phương pháp điều trị
- Lưu hồ sơ y tế

#### 4. **Kê Đơn Thuốc**
```
Bác sĩ → Tạo đơn thuốc → Chọn thuốc → Điều chỉnh liều lượng → Lưu đơn
```

**Chi tiết:**
- Truy cập `/doctors/prescription/create/{medicalRecordId}`
- Chọn thuốc từ danh sách
- Điều chỉnh liều lượng và cách dùng
- Thêm hướng dẫn sử dụng
- Lưu đơn thuốc

#### 5. **Quản Lý Hồ Sơ Y Tế**
```
Bác sĩ → Xem hồ sơ bệnh nhân → Cập nhật thông tin → Theo dõi tiến trình
```

**Chi tiết:**
- Truy cập `/doctors/medical-records`
- Xem danh sách hồ sơ y tế
- Xem chi tiết từng hồ sơ
- Cập nhật thông tin khám bệnh
- Theo dõi tiến trình điều trị

#### 6. **Quản Lý Nhập/Xuất Viện**
```
Bác sĩ → Đánh giá tình trạng → Quyết định nhập viện → Theo dõi → Xuất viện
```

**Chi tiết:**
- Truy cập `/doctors/hospitalized`
- Đánh giá tình trạng bệnh nhân
- Quyết định nhập viện nếu cần
- Phân phòng và giường
- Theo dõi quá trình điều trị
- Quyết định xuất viện khi đủ điều kiện

#### 7. **Thống Kê và Báo Cáo**
```
Bác sĩ → Xem thống kê cá nhân → Phân tích hiệu suất → Báo cáo định kỳ
```
<img width="1681" height="935" alt="image" src="https://github.com/user-attachments/assets/e9277c93-e6fa-4ab6-b278-507d3a0c0e8e" />

**Chi tiết:**
- Truy cập `/doctors/statistics`
- Xem số lượng bệnh nhân khám
- Thống kê đơn thuốc đã kê
- Phân tích hiệu suất làm việc
- Tạo báo cáo định kỳ

### 🔧 QUY TRÌNH DÀNH CHO ADMIN

#### 1. **Đăng Nhập và Dashboard**
```
Admin → Đăng nhập → Xem tổng quan hệ thống → Kiểm tra thông báo
```
<img width="1878" height="720" alt="image" src="https://github.com/user-attachments/assets/fabd542f-b833-4790-aee8-161eac4f6ecf" />



**Chi tiết:**
- Truy cập `/admin/login`
- Đăng nhập với quyền admin
- Xem dashboard với thống kê tổng quan
- Kiểm tra thông báo mới

#### 2. **Quản Lý Bệnh Nhân**
```
Admin → Xem danh sách bệnh nhân → Thêm/Sửa/Xóa → Quản lý thông tin
```

**Chi tiết:**
- Truy cập `/admin/patients`
 <img width="1919" height="948" alt="image" src="https://github.com/user-attachments/assets/f76f5fe9-c2dd-4d8a-ae78-9af01e40e13d" />

- Xem danh sách tất cả bệnh nhân
- Thêm bệnh nhân mới
- Cập nhật thông tin bệnh nhân
- Quản lý loại bệnh nhân

#### 3. **Quản Lý Bác Sĩ**
```
Admin → Xem danh sách bác sĩ → Phân công khoa → Quản lý lịch làm việc
```

**Chi tiết:**
- Truy cập `/admin/doctors`
<img width="1919" height="834" alt="image" src="https://github.com/user-attachments/assets/cf903d8e-f5dc-4f0b-97a8-8be8a6a78ca8" />

- Xem/xóadanh sách bác sĩ
- Thêm bác sĩ mới
- Phân công khoa cho bác sĩ
- Quản lý trạng thái hoạt động

#### 4. **Quản Lý Khoa**
```
Admin → Xem danh sách khoa → Thêm khoa mới → Phân công bác sĩ
```
<img width="1919" height="931" alt="image" src="https://github.com/user-attachments/assets/8524c677-6bb7-4074-984d-2d8d838d25dd" />

**Chi tiết:**
- Truy cập `/admin/departments`
- Xem danh sách các khoa
- Thêm khoa mới
- Cập nhật thông tin khoa
- Phân công bác sĩ cho khoa

#### 5. **Quản Lý Thuốc**
```
Admin → Xem danh sách thuốc → Thêm thuốc mới → Cập nhật giá → Quản lý tồn kho
```
<img width="1855" height="934" alt="image" src="https://github.com/user-attachments/assets/a2347136-c6dd-4261-b988-ab7f942af362" />

**Chi tiết:**
- Truy cập `/admin/medicines`
- Xem danh sách thuốc
- Thêm thuốc mới
- Cập nhật giá thuốc
- Quản lý tồn kho

#### 6. **Duyệt Hồ Sơ BHYT**
```
Admin → Xem hồ sơ đăng ký → Kiểm tra giấy tờ → Duyệt/Từ chối → Thông báo kết quả
```
<img width="1054" height="929" alt="image" src="https://github.com/user-attachments/assets/ee6bc9f2-66c1-496b-94a9-7806bb8c3c13" />
**Chi tiết:**
- Truy cập `/admin/insurance-applications`
- Xem danh sách hồ sơ đăng ký BHYT
- Kiểm tra giấy tờ đính kèm
- Duyệt hoặc từ chối hồ sơ
- Gửi thông báo cho bệnh nhân

#### 7. **Quản Lý Hóa Đơn**
```
Admin → Xem danh sách hóa đơn → Kiểm tra thanh toán → Xử lý khiếu nại
```
<img width="1919" height="845" alt="image" src="https://github.com/user-attachments/assets/0dcf4749-5319-450b-8443-80abaa1fbfcb" />

**Chi tiết:**
- Truy cập `/admin/bills`
- Xem danh sách hóa đơn
- Kiểm tra trạng thái thanh toán
- Xử lý khiếu nại từ bệnh nhân
- Tạo báo cáo tài chính

#### 8. **Quản Lý Nhập/Xuất Viện**
```
Admin → Xem danh sách nhập viện → Phân phòng → Quản lý xuất viện → Thống kê
```
<img width="1919" height="819" alt="image" src="https://github.com/user-attachments/assets/3a913be8-dd05-49c4-8c40-190b750767a3" />
<img width="1919" height="822" alt="image" src="https://github.com/user-attachments/assets/9b55ce52-9af2-4686-a23e-5ff2ba31f5a8" />


**Chi tiết:**
- Truy cập `/admin/hospitalized`
- Xem danh sách bệnh nhân nhập viện
- Phân phòng và giường
- Quản lý xuất viện
- Thống kê tỷ lệ lưu viện
- 
#### 9. **Duyệt lịch hẹn cho bệnh nhân và bác sĩ**
- Vào trang admin/appointments để đổi trạng thái Đang chờ sang Đã xác nhận còn trạng thái hoàn thành sẽ được thực hiện khi bác sĩ chuẩn đoán/kê đơn cho bệnh nhân
- <img width="1901" height="753" alt="image" src="https://github.com/user-attachments/assets/e2e5550a-308b-4823-a72c-eaea972afb54" />
- Duyệt xong sẽ được khám bệnh ko được duyệt sẽ ko đươc khám phòng trường hợp bệnh kê khai linh tinh.
- 
#### 10. **Thống Kê và Báo Cáo**
```
Admin → Xem thống kê tổng quan → Tạo báo cáo → Phân tích xu hướng
```
<img width="1878" height="720" alt="image" src="https://github.com/user-attachments/assets/fa577f2a-a20e-46e6-8ac1-65ce626a4e2e" />

**Chi tiết:**
- Truy cập dashboard admin
- Xem thống kê tổng quan
- Tạo báo cáo định kỳ
- Phân tích xu hướng bệnh nhân
- Đưa ra quyết định quản lý

---

## 🔗 CÁC MỐI QUAN HỆ TRONG HỆ THỐNG

### 📊 Mối Quan Hệ Giữa Các Bảng Dữ Liệu

```
PATIENTS (Bệnh nhân)
├── APPOINTMENTS (Lịch hẹn)
├── MEDICAL_RECORDS (Hồ sơ y tế)
├── PRESCRIPTIONS (Đơn thuốc)
├── BILLS (Hóa đơn)
├── HOSPITALIZED (Nhập viện)
├── DISCHARGES (Xuất viện)
├── RELATIVES (Thân nhân)
└── INSURANCE_APPLICATIONS (Đăng ký BHYT)

DOCTORS (Bác sĩ)
├── APPOINTMENTS (Lịch hẹn)
├── PRESCRIPTIONS (Đơn thuốc)
└── DEPARTMENTS (Khoa)

DEPARTMENTS (Khoa)
├── DOCTORS (Bác sĩ)
└── APPOINTMENTS (Lịch hẹn)

MEDICINES (Thuốc)
└── DETAIL_PRESCRIPTIONS (Chi tiết đơn thuốc)
```

---

## 🚀 CÁCH THỨC HOẠT ĐỘNG

### 1. **Luồng Đặt Lịch Hẹn**
```
Bệnh nhân → Chọn khoa → Chọn bác sĩ → Chọn ngày → Xác nhận → Admin nhận thông báo -> Thao tác trạng thái/hành động 
```

### 2. **Luồng Khám Bệnh**
```
Bệnh nhân đến → Bác sĩ khám → Ghi hồ sơ → Kê đơn → Tạo hóa đơn → Bệnh nhân thanh toán
```

### 3. **Luồng Nhập Viện**
```
Bác sĩ đánh giá → Quyết định nhập viện → Phân phòng → Theo dõi → Quyết định xuất viện
```

### 4. **Luồng BHYT**
```
Bệnh nhân đăng ký → Upload giấy tờ → Admin duyệt → Cập nhật trạng thái → Thông báo kết quả
```

---
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

