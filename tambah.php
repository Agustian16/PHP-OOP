<?php
session_start();

if( !isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}
require 'functions.php';
// cek apakah tombol submit sudah dtekan atau belum

function tambah($data) {
global $conn;
//ambil data dari tiap elemen dalam form


$nrp =htmlspecialchars ($data["nrp"]);
$nama = htmlspecialchars($data["nama"]);
$email = htmlentities($data["email"]);
$jurusan = htmlspecialchars($data["jurusan"]);

// upload gambar
$gambar = upload();
if( !$gambar) {
  return false;
}

// query insert Data
$query = "INSERT INTO mahasiswa
            VALUES
            ('','$nrp','$nama','$email','$jurusan','$gambar')";
mysqli_query($conn, $query);

  return mysqli_affected_rows($conn);
}


function upload(){
  $namaFile = $_FILES ['gambar']['name'];
  $ukuranFile = $_FILES['gambar']['size'];
  $error = $_FILES['gambar']['error'];
  $tmpName = $_FILES['gambar']['tmp_name'];

  //cek apakah ada gambar yang diupload
  if ( $error === 4) {
    echo "<script>
            alert('pilih gambar terlebih dahulu !');
            </script>";
            return false;
  }

  // cek apakah yang diupload adalah gambar atau bukan
  // cek ekstensi gambar yg valid
  $ekstensiGambarValid = ['jpg','jpeg','png'];
  $ekstensiGambar = explode ('.', $namaFile);
  $ekstensiGambar = strtolower (end($ekstensiGambar));

  if ( !in_array($ekstensiGambar, $ekstensiGambarValid)) {
    echo "<script>
            alert('anda tidak mengupload gambar yang sesuai !');
            </script>";
            return false;
  }

  // cek jika ukuran file terlalu besar
  if( $ukuranFile > 1000000) {
    echo "<script>
            alert('Ukuran file terlalu besar !');
            </script>";
            return false;
  }

  // lolos pengecekan Gambar
  // generate nama gambar baru agar tidak ditimpa jika sama nama gambarnya
  $namaFileBaru = uniqid();
  $namaFileBaru .= '.';
  $namaFileBaru .= $ekstensiGambar;

  move_uploaded_file($tmpName, 'img/' . $namaFileBaru);
  return $namaFileBaru;
}









if (isset($_POST["submit"])) {



    // cek apakah data berhasil ditambahkan atau tidak
      if (tambah($_POST) > 0 ) {
        echo "<script> alert('Data berhasil ditambahkan');
                document.location.href = 'index.php';
                </script> ";
      } else {
        echo "<script> alert('Data Gagal ditambahkan');
                document.location.href = 'index.php';
                </script> ";
      }
}

 ?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Tambah Data Mahasiswa</title>
  </head>
  <body>
          <h1>Tambah data mahasiswa</h1>
    <form action="" method="post" enctype="multipart/form-data">
      <ul>
        <li>
          <label  for="nrp">NRP :</label>
          <input type="text" name="nrp" id="nrp" required>
        </li>
        <li>
          <label  for="nrp">NAMA :</label>
          <input type="text" name="nama" id="nama" required>
        </li>
        <li>
          <label  for="nrp">email :</label>
          <input type="text" name="email" id="email" required>
        </li>
        <li>
          <label  for="nrp">Jurusan :</label>
          <input type="text" name="jurusan" id="jurusan" required>
        </li>
        <li>
          <label  for="nrp">Gambar :</label>
          <input type="file" name="gambar" id="gambar">
        </li>
        <li>
              <button type="submit" name="submit">Tambah Data!</button>
        </li>
      </ul>
    </form>

  </body>
</html>
