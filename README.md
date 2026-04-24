# Student Manager Plugin

## 1. Yêu cầu chức năng
Plugin **Student Manager** cung cấp giải pháp quản lý sinh viên trong WordPress. 
- **Backend:** Đăng ký Custom Post Type "Sinh viên" với các trường thuộc tính tiêu chuẩn (Họ tên, Ghi chú) và Custom Meta Boxes để nhập Mã số sinh viên, Chuyên ngành, Ngày sinh.
- **Frontend:** Cung cấp shortcode `[danh_sach_sinh_vien]` để hiển thị danh sách sinh viên theo dạng bảng HTML.

## 2. Cấu trúc plugin
```
wp-content/plugins/student-manager/
├── student-manager.php
├── includes/
│   ├── class-student-manager-cpt.php
│   └── class-student-manager-shortcode.php
├── assets/
│   └── css/
│       └── style.css
└── README.md
```

## 3. Hướng dẫn sử dụng
1. Upload folder `student-manager` vào thư mục `wp-content/plugins/` hoặc cài đặt qua file `.zip`.
2. Kích hoạt (Activate) plugin trong trang quản trị WordPress.
3. Vào menu **Sinh viên** ở sidebar để thêm mới các sinh viên, điền các thông tin MSSV, Lớp/Chuyên ngành, và Ngày sinh.
4. Ở trang giao diện (Page/Post), chèn shortcode `[danh_sach_sinh_vien]` để hiển thị danh sách sinh viên ra ngoài Frontend.

## 4. Kết quả (Screenshots)
*(Ảnh chụp kết quả sẽ được sinh viên đính kèm tại đây, bao gồm giao diện admin thêm sinh viên và bảng hiển thị frontend sau khi test)*
