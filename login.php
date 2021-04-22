<?php
session_start();
require 'functions.php';

  // Cek cookie
  if(isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    // ambil username bedasarkan id
    $result = mysqli_query($conn,"SELECT username FROM user WHERE id = $id");
    $row = mysqli_fetch_assoc($result);

    // cek cookie dan username
    if($key === hash('sha256', $row['username'])) {
      $_SESSION['login'] = true;
    }
  }

if (isset($_SESSION["login"])) {
  header("Location: index.php");
  exit;
}


if(isset($_POST["login"])) {

  $username = $_POST["username"];
  $password = $_POST["password"];

  $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

  //cek Username
  if(mysqli_num_rows($result) === 1) {

    //cek PASSWORD
    $row = mysqli_fetch_assoc($result);
     if (password_verify($password, $row["password"])) {
       // set session
       // kl berhasil
       $_SESSION["login"] = true;

       // cek remember me
       if(isset($_POST['remember'])) {
          // membuat cookie
          setcookie('id', $row['id'], time()+30);

          // enskripsi cookie
          setcookie('key', hash('sha256', $row['username']), time()+30);
         //setcookie('login', 'true', time()+30);
       }

        header("Location: index.php");
        exit;
     }
  }
  $error = true;
}


 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Login Form</title>
  </head>
  <body>
    <h1>Login Form</h1>

    <?php if(isset($error)) : ?>
      <p style="color: red; font-style: italic;">username/password salah</p>
<?php endif; ?>
    <form  action="" method="post">
        <div class="form-group mx-sm-3 mb-2">
              <label for="username">Username :</label>
             <input type="text" name="username" autofocus required>
        </div>

        <div class="form-group mx-sm-3 mb-2">
          <label for="password">Password :</label>
             <input  type="password" name="password" required>
        </div>
        <div>
                <input class="mx-sm-3 mb-2" type="checkbox" name="remember" id="remember">
                <label for="remember"class="form-check-label "> Remember Me!</label>
        </div>
        <div>
              <button type="submit" name="login" class="btn btn-primary mx-sm-5 mb-2">Login</button>
        </div>
    </form>



  </body>
</html>
