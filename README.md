# websiteBanTrangSuc
Thiết kế giao diện: sử dụng HTML kết hợp với các gói hỗ trợ (Bootstrap, Html,
Css,JavaScript,PHP,MySQL ...).Tách các file giao diện vào thư mục include.
# Trang người dùng
## Trang chủ: Hiển thị tổng quan về các sản phẩm
Cho dù bạn đến đây để mua sắm, tìm hiểu hay khám phá, giao diện dễ dùng và tiện ích bao gồm thanh trang chủ, danh mục sản phẩm, giới thiệu, tin tức, liên hệ, tìm kiếm sản phẩm, thêm sản phẩm vào giỏ hàng
- Thanh tìm kiếm nhanh cho khách hàng
- Xem giỏ hàng đã thêm
- Xem danh sách các sản phẩm theo danh mục
- Xem chi tiết sản phẩm và thêm sản phẩm vào giỏ hàng
- Xem tất cả sản phẩm có trong cửa hàng
- Sắp xếp và phân trang sản phẩm để thực hiện mua hàng tiện hơn
Khi người dùng đăng nhập bằng tài khoản người dùng đăng kí thì mới được đặt hàng và thêm sản phẩm vào giỏ hàng, tìm kiếm sản phẩm
## Đăng ký / Đăng nhập: Cho phép người dùng đăng ký hoặc đăng nhập.
- Khi người dùng mua hàng phải đăng nhập vào trang mua sắm mới có thể thực hiện các chức năng trong trang chủ
- Khi người dùng chưa có tài khoản phải thực hiện tạo tại khoản để thực hiện đăng nhập vào trang nếu muốn mua hàng
## Trang chi tiết sản phẩm
- Hình ảnh chất lượng cao
- Mô tả sản phẩm chi tiết
- Thông số kỹ thuật
- Giá cả
- Lợi ích sản phẩm
## Giỏ hàng 
Khi khách hàng duyệt qua các sản phẩm trên trang web, họ có thể nhấp vào nút "Thêm vào giỏ hàng" để thêm sản phẩm vào giỏ hàng của họ.
- Khách hàng có thể nhấp vào biểu tượng giỏ hàng để xem danh sách các sản phẩm họ đã thêm vào giỏ hàng. Tại đây, họ có thể xem thông tin chi tiết về mỗi sản phẩm, số lượng sản phẩm đã chọn, giá cả và tổng số tiền thanh toán.
- Khách hàng có thể thay đổi số lượng sản phẩm trong giỏ hàng, xóa sản phẩm khỏi giỏ hàng
- Khi khách hàng đã hài lòng với các sản phẩm trong giỏ hàng, họ có thể nhấp vào nút "Đặt hàng" để tiến hành thanh toán.
# Trang người quản trị 
- Thêm, sửa, xóa tài khoản người dùng: Quản trị viên có thể tạo tài khoản mới cho người dùng, cập nhật thông tin tài khoản hiện có hoặc xóa tài khoản không còn sử dụng.
- Quản lý hồ sơ người dùng: Quản trị viên có thể xem và cập nhật thông tin hồ sơ của người dùng, chẳng hạn như tên, địa chỉ email, số điện thoại
- Khôi phục mật khẩu: Quản trị viên có thể giúp người dùng khôi phục mật khẩu đã quên
## Trang quản lý sản phẩm 
- Thêm sản phẩm mới: Cho phép người dùng tạo sản phẩm mới bằng cách nhập thông tin chi tiết về sản phẩm, chẳng hạn như tên sản phẩm, mô tả, giá cả, hình ảnh,
- Quản lý sản phẩm hiện có: Cho phép người dùng cập nhật thông tin chi tiết về sản phẩm hiện có.
- Xóa sản phẩm
## Trang quản lý danh mục sản phẩm
- Cho phép người dùng tạo sản phẩm mới bằng cách nhập thông tin chi tiết về sản phẩm, chẳng hạn như tên sản phẩm, mô tả, giá cả, hình ảnh,
- Phân loại sản phẩm theo danh mục và nhóm sản phẩm.
- Cho phép quản lý cập nhật thông tin chi tiết về sản phẩm hiện có
- Xóa danh mục sản phẩm khỏi danh mục sản phẩm
## Trang quản lý đơn hàng
- Cho phép người quản lý xem những đơn hàng đã đặt của khách hàng
- Lưu trữ thông tin khách hàng như tên, địa chỉ, email, số điện thoại, lịch sử mua hàng, vv
## Back-end code bằng PHP thuần túy
## Truy cập : http://minhtamphan.byethost14.com/