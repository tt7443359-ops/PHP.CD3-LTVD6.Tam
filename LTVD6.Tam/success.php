<?php
// Lấy tên từ cookie để chào hỏi cho thân thiện
$name = $_COOKIE['stored_username'] ?? 'Khách';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thành công</title>
    <style>body { font-family: sans-serif; text-align: center; padding-top: 50px; }</style>
</head>
<body>
    <h1>🎉 Đăng nhập thành công!</h1>
    <p>Chào mừng <strong><?php echo htmlspecialchars($name); ?></strong> đã quay trở lại.</p>
    <br>
    <img src="imgs/images.jpg" alt="">
    <a href="login.php">Quay lại trang đăng nhập</a>
</body>
</html>