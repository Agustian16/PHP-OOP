<?php

require 'functions.php';
if( isset($_POST["register"])) {

  if (registrasi($_POST) > 0 ) {
    echo "<script>
        alert('user baru berhasil ditambahkan')
        </script>";
  } else {
    echo mysqli_error($conn);
  }
}

 ?>



<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Halamaan Registrasi</title>
    <style media="screen">
      label{
        display: block;
      }
    </style>
  </head>
  <body>

    <h1>Halaman Registrasi</h1>
    <form  action="" method="post">
      <ul>
        <li>
              <label for="username">username</label>
              <input type="text" name="username" >
        </li>
        <li>
              <label for="username">password</label>
              <input type="password" name="password" >
        </li>
        <li>
              <label for="username">Konfirmasi Password</label>
              <input type="password" name="password2">
        </li>
        <li>
              <button type="submit" name="register">Register</button>
        </li>
      </ul>
    </form>

  </body>
</html>
