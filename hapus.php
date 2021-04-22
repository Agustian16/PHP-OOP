<?php
session_start();

if( !isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

require 'functions.php';


function hapus($id) {
global $conn;
  mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");

  return mysqli_affected_rows($conn);

}

$id = $_GET['id'];

if ( hapus($id) > 0) {
    echo "<script> alert('Data berhasil dihapus');
            document.location.href = 'index.php';
            </script> ";
} else {
  echo "<script> alert('Data Gagal dihapus');
          document.location.href = 'index.php';
          </script> ";
}

 ?>
