<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="css/style.css">
<?php
$conn = mysqli_connect("localhost","root","","phpdasar");

function query($query){
  global $conn;
  $result = mysqli_query($conn, $query);
  $rows = [];
  while($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }
  return $rows;
}

// ---------- register --------

function registrasi($data) {
  global $conn;

  $username = strtolower (stripslashes ($data ["username"]));
  $password = mysqli_real_escape_string($conn, $data["password"]);
  $password2 = mysqli_real_escape_string($conn, $data["password2"]);

  // cek username sudah ada apa blm / tidak boleh sama

  $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");

  if(mysqli_fetch_assoc($result)){
    echo "<script>
            alert('username sudah ada')
    </script>";
    return false;
  }


  // cek Konfirmasi password

  if ($password !== $password2) {
    echo "<script>
        alert('Password tidak sesuai')
        </script>";
        return false;
  }


 // enkripsi password
  $password = password_hash($password, PASSWORD_DEFAULT);

  // TAMBAHKAN USER BARU KE DATABASE
  mysqli_query($conn, "INSERT INTO user VALUES ('','$username', '$password')");

  return mysqli_affected_rows($conn);
}

 ?>
