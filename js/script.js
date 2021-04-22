// ambil elemen yg d butuhkan
var keyword = document.getElementById('keyword');
var tombolCari = document.getElementById('tombol-cari');
var container = document.getElementById('container');

// tambahkan EVent atau aksi pada input cari
keyword.addEventListener('keyup', function() {

  // buat object Ajax
  var xhr = new XMLHttpRequest();

  // cek kesiapan data ajax
  xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && xhr.status == 200) {
          container.innerHTML = xhr.responseText;
    }
  }
      // eksekusi Ajax
      xhr.open('GET', 'ajax/mahasiswa.php?keyword=' + keyword.value, true);
      xhr.send();
});

// jQuery

$(document).ready(function(){
    //event ketika keyword ditulis
    $('#keyword').on('keyup', function() {
      $('#container').load('ajax/mahasiswa.php?keyword='+ $('#keyword').val());
    });
});
