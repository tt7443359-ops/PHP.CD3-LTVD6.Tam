<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./reset.css" />
    <link rel="stylesheet" href="./style.css" />
    <title>Register Page</title>
    <style>
        .error-msg { color: red; font-size: 0.8em; margin-bottom: 10px; display: block; }
        .success-msg { color: green; font-weight: bold; margin-bottom: 20px; }
    </style>
</head>
<body>
    <?php
    $errors = [];
    $success_msg = "";
    $username = "";
    $email = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // (1: Chống XSS)
        $username = htmlspecialchars(trim($_POST['username'] ?? ''));
        $email = htmlspecialchars(trim($_POST['email'] ?? ''));
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['repeat-password'] ?? '';

        // 1. Kiểm tra Họ tên
        if (empty($username)) {
            $errors['username'] = "Vui lòng nhập họ tên.";
        }

        // 2. Kiểm tra Email
        if (empty($email)) {
            $errors['email'] = "Vui lòng nhập email.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Email không đúng định dạng.";
        }

        // 3. Kiểm tra Mật khẩu
        if (empty($password)) {
            $errors['password'] = "Vui lòng nhập mật khẩu.";
        } elseif (strlen($password) < 6) {
            $errors['password'] = "Mật khẩu phải có ít nhất 6 ký tự.";
        }

        // 4. Xác nhận mật khẩu 
        if ($password !== $confirm) {
            $errors['repeat-password'] = "Mật khẩu xác nhận không khớp.";
        }

        //Không lỗi -> Thành công
        if (empty($errors)) {
            // 1. Lưu thông tin vào Cookie (hạn 1 giờ)
            setcookie("stored_username", $username, time() + 3600, "/");
            setcookie("stored_email", $email, time() + 3600, "/");
            setcookie("stored_password", $_POST['password'], time() + 3600, "/");

            // 2. Chuyển hướng 
            header("Location: login.php");
            exit(); 
        }
    }
    ?>

    <div class="wrapper fade-in-down">
        <div id="form-content">
            <a href="login.php">
                <h2 class="inactive underline-hover">Đăng nhập</h2>
            </a>
            <a href="register.php">
                <h2 class="active">Đăng ký</h2>
            </a>

            <div class="fade-in first">
                <img src="./imgs/avatar.png" id="avatar" alt="User Icon" />
            </div>

            <?php if ($success_msg): ?>
                <p class="success-msg"><?php echo $success_msg; ?></p>
            <?php endif; ?>

            <form action="" method="POST">
                <input
                    type="text"
                    id="username"
                    class="fade-in first"
                    name="username"
                    placeholder="Họ tên"
                    value="<?php echo $username; ?>" 
                />
                <?php if(isset($errors['username'])): ?> <span class="error-msg"><?php echo $errors['username']; ?></span> <?php endif; ?>

                <input
                    type="text" 
                    id="Email"
                    class="fade-in second"
                    name="email"
                    placeholder="Email"
                    value="<?php echo $email; ?>"
                />
                <?php if(isset($errors['email'])): ?> <span class="error-msg"><?php echo $errors['email']; ?></span> <?php endif; ?>

                <input
                    type="password"
                    id="password"
                    class="fade-in third"
                    name="password"
                    placeholder="Mật khẩu"
                />
                <?php if(isset($errors['password'])): ?> <span class="error-msg"><?php echo $errors['password']; ?></span> <?php endif; ?>

                <input
                    type="password"
                    id="repeat-password"
                    class="fade-in fourth"
                    name="repeat-password"
                    placeholder="Xác nhận mật khẩu"
                />
                <?php if(isset($errors['repeat-password'])): ?> <span class="error-msg"><?php echo $errors['repeat-password']; ?></span> <?php endif; ?>

                <input type="submit" class="fade-in five" value="Đăng ký" />
            </form>

            <div id="form-footer">
                <a class="underline-hover" href="#">Quên mật khẩu?</a>
            </div>
        </div>
    </div>
</body>
</html>