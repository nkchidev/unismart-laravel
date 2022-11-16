################## CHECK LIST XÂY DỰNG MODULE ##########3
1. Phân tích module
2. Thiết kế database
3. Ghép giao diện cho các tác vụ cần thực thi
4. Vadidate dữ liệu (nếu có)
5. Thực thi hoàn tất từng tác vụ
6. Testing
7. Tối ưu

# Thực hiện thao tác trên nhiều bảng ghi
    B1: Lấy ra danh sách được chọn
    B2: Kiểm tra danh sách có tồn tại hay không 
        -- Nếu tồn tại:
            - Duyệt tất cả các danh sách được chọn để kiểm tra xem có phần tử nào trùng với id đang đăng nhập hay không. Nếu có thì unset phần tử đó đi
            - Sau đó kiểm tra danh sách có còn khác rỗng hay không. Nếu khác thì kiểm tra action
             + Nếu action = delete thì xóa danh sách đi và sau đó chuyển hướng đến trang list kèm với section xóa thành công
             + Nếu action = restore thì khôi phục lại danh sách và sau đó chuyển hướng đến trang list với section khôi phục thành công
            - Nếu danh sách rỗng: chuyển hướng đến trang list với section không thể thao tác trên tài khoản của bạn
        -- Nếu không tồn tại: chuyển hướng đến trang list với section cần phải chọn phần tử cần thực thi 
# Xóa vĩnh viễn bảng ghi ra khỏi hệ thống
    B1: Tạo dữ liệu để hiển thị trên select box
    B2: Kiểm tra nếu act = forceDelete thì thực hiện xóa vĩnh viễn


################## PAGE ###############
# Route
# Controller
# Database 
    -id 
    -title
    -content
    -softDelete

