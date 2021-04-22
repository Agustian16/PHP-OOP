<?php
session_start();

if( !isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

require 'functions.php';
// cek apakah tombol submit sudah dtekan atau belum

function ubah($data) {
global $conn;
//ambil data dari tiap elemen dalam form


$nrp =htmlspecialchars ($data["nrp"]);
$nama = htmlspecialchars($data["nama"]);
$email = htmlentities($data["email"]);
$jurusan = htmlspecialchars($data["jurusan"]);
$gambar = htmlspecialchars($data["gambar"]);
$gambarLama  = htmlspecialchars($data["gambarLama"]);

// query insert Data
$query = "INSERT INTO mahasiswa
            VALUES
            ('','$nrp','$nama','$email','$jurusan','$gambar')";
mysqli_query($conn, $query);

  return mysqli_affected_rows($conn);
}

function update($data) {
global $conn;
//ambil data dari tiap elemen dalam form

$id = $data["id"];
$nrp =htmlspecialchars ($data["nrp"]);
$nama = htmlspecialchars($data["nama"]);
$email = htmlentities($data["email"]);
$jurusan = htmlspecialchars($data["jurusan"]);
$gambar = htmlspecialchars($data["gambar"]);

// cek apakah user pilih gambar baru / tidak
if ($_FILES['gambar'['error'] === 4]) {
    $gambar = $gambarLama;
} else {
  $gambar = upload();
}

// query insert Data
$query = "UPDATE mahasiswa SET
            nrp = $nrp',
            nama = '$nama',
            email = '$email',
            jurusan = '$jurusan',
            gambar = '$gambar'
            WHERE id = $id
            ";
mysqli_query($conn, $query);

  return mysqli_affected_rows($conn);
}



$id = $_GET["id"];
// query data mahasiswa berdasarkan id ocibindbyname
$mhs = query("SELECT * FROM mahasiswa WHERE id = $id")[0];





if (isset($_POST["submit"])) {

    // cek apakah data berhasil ditambahkan atau tidak
      if (ubah($_POST) > 0 ) {
        echo "<script> alert('Data berhasil diubah');
                document.location.href = 'index.php';
                </script> ";
      } else {
        echo "<script> alert('Data Gagal diubah');
                document.location.href = 'index.php';
                </script> ";
      }
}

 ?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Update Data Mahasiswa</title>
  </head>
  <body>
          <h1>Update data mahasiswa</h1>
    <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo $mhs["id"]; ?>">
      <input type="hidden" name="gambarLama" value="<?php echo $mhs["gambar"]; ?>">
      <ul>
        <li>
          <label  for="nrp">NRP :</label>
          <input type="text" name="nrp" id="nrp" required value="<?php echo $mhs ["nrp"]; ?>">
        </li>
        <li>
          <label  for="nrp">NAMA :</label>
          <input type="text" name="nama" id="nama" required value="<?php echo $mhs["nama"]; ?>">
        </li>
        <li>
          <label  for="nrp">email :</label>
          <input type="text" name="email" id="email" required value="<?php echo $mhs["email"]; ?>">
        </li>
        <li>
          <label  for="nrp">Jurusan :</label>
          <input type="text" name="jurusan" id="jurusan" required value= <?php echo $mhs["jurusan"]; ?>>
        </li>
        <li>
          <label  for="nrp">Gambar :</label> <br>
          <img src="img/<?php echo $mhs["gambar"]; ?>" width="40"> <br>
          <input type="file" name="gambar" id="gambar">
        </li>
        <li>
              <button type="submit" name="submit">Update Data!</button>
        </li>
      </ul>
    </form>

  </body>
</html>
