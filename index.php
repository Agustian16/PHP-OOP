<?php
// KOMEKSI KE DATABASE
session_start();

if( !isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}
require 'functions.php';

    // Pagination = meentukan jumlah data pada beberapa Halaman
    // konfigurasi

$jumlahDataPerHalaman = 2;
$jumlahData = count(query("SELECT * FROM mahasiswa"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($GET["halaman"])) ? $_GET["halaman"] : 1;
$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

$mahasiswa = query("SELECT * FROM mahasiswa LIMIT $awalData, $jumlahDataPerHalaman");

// logic cari ---

function cari($keyword) {
  $query = "SELECT * FROM mahasiswa WHERE
            nama LIKE '%$keyword%' OR
            nrp LIKE '%$keyword%' OR
            email LIKE '%$keyword%' OR
            jurusan LIKE '%$keyword%' OR
            gender LIKE '%$keyword%' OR
            class LIKE '%$keyword%' OR
            phone LIKE '%$keyword%' OR
            address LIKE '%$keyword%'
            ";
  return query($query);
}

if (isset($_POST["cari"])) {
  $mahasiswa = cari($_POST["keyword"]);
}
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Halaman Admin</title>
  </head>
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <body>

    <a href="logout.php">Logout</a>

    <h1>Daftar Mahasiswa</h1>

    <a href="tambah.php">Tambah Data Mahasiswa</a>
    <br><br>

    <form action="" method="post">
      <input type="text" name="keyword" size="40"
            autofocus placeholder="masukan keyword pencarian.."
            autocomplete="off" id="keyword" >
      <button type="submit" name="cari" id="tombol-cari">Cari</button>

    </form>
    <br>

<!--Navigasi Pagination -->
<?php if($halamanAktif > 1) : ?>
<a href="?halaman=<?php echo $halamanAktif - 1 ?>">&laquo</a>
<?php endif;?>

<?php for( $i = 1; $i <= $jumlahHalaman; $i++ ) : ?>
  <?php if ($i == $halamanAktif) :?>
    <a href="?halaman=<?php echo $i; ?>" style="font-weight: bold; color:red;"><?php echo $i; ?></a>
  <?php else :?>
      <a href="?halaman=<?php echo $i; ?>"><?php echo $i; ?></a>
<?php endif; ?>
<?php endfor; ?>

<?php if($halamanAktif < $jumlahHalaman) : ?>
<a href="?halaman=<?php echo $halamanAktif + 1 ?>">&raquo</a>
<?php endif;?>

    <br>
  <div id="container">

    <table border="1" cellpadding="10" cellspacing="0">
      <tr>
        <th>No.</th>
        <th>Actions</th>
        <th>Pictures</th>
        <th>NIS</th>
        <th>Name</th>
        <th>Birth Date</th>
        <th>Gender</th>
        <th>Class</th>
        <th>Phone</th>
        <th>Address</th>
        
      </tr>

<?php $i = 1; ?>
<?php foreach ($mahasiswa as $row) :?>
    <tr>
      <td><?= $i; ?></td>
      <td>
            <a href="ubah.php?id=<?= $row["id"]; ?>">ubah</a>
            <a href="hapus.php?id=<?= $row["id"]; ?>"onclick="return confirm('Yakin?')">hapus</a>
      </td>
      <td>
            <img src="img/<?= $row["gambar"]; ?>" width="50">
      </td>
      <td><?= $row["nrp"]; ?></td>
      <td><?= $row["nama"]; ?></td>
      <td><?= $row["email"]; ?></td>
      <td><?= $row["jurusan"]; ?></td>
      <td><?= $row["class"]; ?></td>
      <td><?= $row["phone"]; ?></td>
      <td><?= $row["address"]; ?></td>
      
    </tr>
    <?php $i++; ?>
  <?php endforeach; ?>
    </table>
    </div>
    <script src="js/jquery.js"></script>
    <script src="js/script.js">

    </script>
  </body>
</html>
