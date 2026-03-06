<?php
    $errors = [];
    $email = $_POST['email'] ?? '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $password = $_POST['password'] ?? '';

        // Lấy dữ liệu từ Cookie đã lưu ở trang Register
        $cookie_email = $_COOKIE['stored_email'] ?? '';
        $cookie_pass = $_COOKIE['stored_password'] ?? '';

        //Ktra đăng nhập
        if (empty($email) || empty($password)) {
            $errors['login'] = "Vui lòng nhập đầy đủ thông tin.";
        } elseif ($email === $cookie_email && $password === $cookie_pass) {
            //khớp -> Chuyển 
            header("Location: success.php");
            exit();
        } else {
            //Không khớp
            $errors['login'] = "Email hoặc mật khẩu không chính xác.";
        }
    }
    ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./reset.css" />
    <link rel="stylesheet" href="./style.css" />
    <title>Register Page</title>
  </head>
  <body>
    <?php
    $errors = []; // (2)
    $success_msg = "";
    $username = $_POST['username'] ?? ''; // (3)
    $email = $_POST['email'] ?? '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // (1: Chống XSS)
    $username = htmlspecialchars(trim($username));
    $email = htmlspecialchars(trim($email));
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['repeat-password'] ?? '';

    //*Kiểm Tra Lỗi
    // Email
    if (empty($email)) {
        $errors['email'] = "Vui lòng nhập email.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Email không đúng định dạng.";
    }

    // matkhau
    if (empty($password)) {
        $errors['password'] = "Vui lòng nhập mật khẩu.";
    } elseif (strlen($password) < 6) {
        $errors['password'] = "Mật khẩu phải có ít nhất 6 ký tự.";
    }

    // Xác nhận matkhau
    if ($password !== $repeat_password) {
        $errors['repeat-password'] = "Mật khẩu xác nhận không khớp.";
    } 

    // (4) Xóa trống (Yc4)
    if (empty($errors)) {
        $success_msg = "Chào mừng $username!";
        $username = $email = ""; 
    }
}
    ?>
    
    <div class="wrapper fade-in-down">
      <div id="form-content">
        <!-- Tabs Titles -->
        <a href="login.php">
                <h2 class="active">Đăng nhập</h2>
            </a>
            <a href="register.php">
                <h2 class="inactive underline-hover">Đăng ký</h2>
            </a>

        <!-- Icon -->
        <div class="fade-in first">
          <img src="./imgs/avatar.png" id="avatar" alt="User Icon" />
        </div>

        <!-- Login Form -->
        <?php if(isset($errors['login'])): ?>
            <p style="color: red; font-size: 0.8em;"><?php echo $errors['login']; ?></p>
        <?php endif; ?>

         <form method="POST" action="">
        <form>
          <input
            type="email"
            id="Email"
            class="fade-in second"
            name="email"
            placeholder="Email"
          />
          <input
            type="password"
            id="password"
            class="fade-in third"
            name="password"
            placeholder="Mật khẩu"
          />
          <input type="submit" class="fade-in five" value="Đăng Nhập" />
        </form>

        <!-- Remind Passowrd -->
        <div id="form-footer">
          <a class="underline-hover" href="#">Quên mật khẩu?</a>
        </div>
      </div>
    </div>
  </body>
</html>
