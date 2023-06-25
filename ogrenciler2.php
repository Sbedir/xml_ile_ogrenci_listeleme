<?php
include './baglan.php';
$ogrencisor=ogr_xml_okuma();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Öğrenci Kayıt Sayfası</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script> <!-- javascriptte json çalıştırmak için bu olması gerekir-->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script><!-- bootstrap javascriptlerini kullanmak için  için bu olması gerekir-->
<style>
    .basarili{
        background: #048c17;
    color: #fff;
    text-align: center;
    padding: 7px 0px;
    }
    .basarisiz{
        background: red;
    color: #fff;
    text-align: center;
    padding: 7px 0px;
    }
</style>
</head>
<body>

<div class="container">
    <?php
    if(isset($_GET['durum']) && $_GET['durum']=='ok'){
        echo "<p class='basarili'>".ucwords($_GET['type'].' başarılı.').'</p>';
    }

    elseif(isset($_GET['durum'])&& $_GET['durum']=='no'){
        echo '<p class="basarisiz">'.ucwords($_GET['type'].' başarısız.').'</p>';
    }
    
    ?>
  <h2>KAYITLI ÖĞRENCİ LİSTESİ deneme</h2>
  <p>Bu sayfada aşagıdaki gibi daha önceden eklenen öğrenciler aşağıdaki gibi listelenmektedir.Listenin üst tarafında bulunan mavi ekle butonu ile öğrenci ekleme işlemi ,listenin içerisinde bulunan her öğrenciye karşılık gelen turuncu güncelle butonu ile güncelleme işlemi ve kırmızı sil butonu ile silme işlemi gerçekleştirilir.</p>            
  <a class='btn btn-primary btn-sm' onClick='ogr_ekle()'>Ekle</a>
  <a href ='./ogrenciler_excel.php' class='btn btn-success btn-sm'>Excel Export</a>
  <div class='table-responsive'>
  <table id='ogrTable' class="table table-striped table-bordered">
    <thead>
      <tr>
      <th>Öğrenci Resmi</th>
        <th>Ad</th>
        <th>Soyad</th>
        <th>Okul Numarası</th>
        <th>Okul Adı</th>
        <th>Fakülte</th>
        <th>Bölümü</th>
        <th>Adres</th>
        <th>Telefon</th>
        <th>Email</th>
        <th>Okula Başlangıç Tarihi</th>
        <th>Okul Bitiş Tarihi</th>
        <th>Güncelle</th>
        <th>Sil</th>
      </tr>
    </thead>
    <tbody><?php
    foreach ($ogrencisor as $ogrencicek) {?>
      <tr>
        <td><img src="<?=$ogrencicek['resim']!=''?$ogrencicek['resim']:'images/resim-yok.jpg';?>" style="width:100px"/></td>
        <td><?=$ogrencicek['ad'];?></td>
        <td><?=$ogrencicek['soyad'];?></td>
        <td><?=$ogrencicek['okul_numarasi'];?></td>
        <td><?=$ogrencicek['okul_adi'];?></td>
        <td><?=$ogrencicek['fakulte'];?></td>
        <td><?=$ogrencicek['bolum'];?></td>
        <td><?=$ogrencicek['adres'];?></td>
        <td><?=$ogrencicek['telefon'];?></td>
        <td><?=$ogrencicek['mail'];?></td>
        <td><?=$ogrencicek['okul_baslangic_tarihi'];?></td>
        <td><?=$ogrencicek['okul_bitis_tarihi'];?></td>
        <td>
         <!--modal güncelleme-->
<!-- Button trigger modal -->
<!-- json_encode phpde arrayı stringe cevirir-->
<button type="button" onClick='ogr_guncelle(<?=json_encode($ogrencicek)?>)' name='id' class="btn btn-warning" data-toggle="modal" data-target="#exampleModalCenter">
  güncelleme
</button>
          </td>
      <td>
          <a class='btn btn-danger btn-sm' onClick='ogr_sil(<?=json_encode($ogrencicek)?>)'>Sil</a>
      </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
  </div>
</div>

<!---- Ekleme Modal Başlangıcı ------>
<div class="modal" id='ekle_modal' tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
    <form action="./islem2.php" method="post" enctype="multipart/form-data"> <!-- Dosya gödermek için gerekli ---->
      <div class="modal-header">
        <h5 class="modal-title" >Öğrenci Ekleme</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="resim">Resim</label>
          <input type="file" class="form-control-file" id="resim" name='resim'>
        </div>
        <div class="form-group">
          <label for="ad">Adı</label>
          <input type="text" class="form-control" id="ad" name='ad'>
        </div>
        <div class="form-group">
          <label for="soyad">Soyadı</label>
          <input type="text" class="form-control" id="soyad" name='soyad'>
        </div>
        <div class="form-group">
          <label for="okul_numarasi">Okul Numarası</label>
          <input type="number" class="form-control" id="okul_numarasi" name='okul_numarasi'>
        </div>
        <div class="form-group">
          <label for="okul_adi">Okul Adı</label>
          <input type="text" class="form-control" id="okul_adi" name='okul_adi'>
        </div>
        <div class="form-group">
          <label for="fakulte">Fakülte</label>
          <input type="text" class="form-control" id="fakulte" name='fakulte'>
        </div>
        <div class="form-group">
          <label for="bolum">Bölüm</label>
          <input type="text" class="form-control" id="bolum" name='bolum'>
        </div>
        <div class="form-group">
          <label for="adres">Adres</label>
          <textarea  class="form-control" id="adres" name='adres'></textarea>
        </div>
        <div class="form-group">
          <label for="telefon">Telefon</label>
          <input type="number" class="form-control" id="telefon" name='telefon'>
        </div>
        <div class="form-group">
          <label for="mail">Mail</label>
          <input type="email" class="form-control" id="mail" name='mail'>
        </div>
        <div class="form-group">
          <label for="okul_baslangic_tarihi">Okula Başlangıç Tarihi</label>
          <input type="date" class="form-control" id="okul_baslangic_tarihi" name='okul_baslangic_tarihi'>
        </div>
        <div class="form-group">
          <label for="okul_bitis_tarihi">Okula Bitiş Tarihi</label>
          <input type="date" class="form-control" id="okul_bitis_tarihi" name='okul_bitis_tarihi'>
        </div>
      

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" name="ogr_ekleme" >Kaydet</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
      </div>
      </form>
    </div>
  </div>
</div>



<!-- Modal güncelleme-->
<div class="modal fade" id="guncelle_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
    
      <form action="./islem2.php" method="post" enctype="multipart/form-data"> <!-- Dosya gödermek için gerekli ---->
      <div class="modal-header">
        <h5 class="modal-title" >Öğrenci güncelleme</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" class="form-control" id="gid" name='id'>
        <input type="hidden"  class="form-control-file" id="gresimdel" name='gresimdel'>
        <div class="form-group">
          <label for="resim">Resim</label>
          <input type="file"  class="form-control-file" id="gresim" name='resim'>
        </div>
       
        <div class="form-group">
          <label for="ad">Adı</label>
          <input type="text" class="form-control" id="gad" name='ad'>
        </div>
        <div class="form-group">
          <label for="soyad">Soyadı</label>
          <input type="text" class="form-control" id="gsoyad" name='soyad'>
        </div>
        <div class="form-group">
          <label for="okul_numarasi">Okul Numarası</label>
          <input type="number" class="form-control" id="gokul_numarasi" name='okul_numarasi'>
        </div>
        <div class="form-group">
          <label for="okul_adi">Okul Adı</label>
          <input type="text" class="form-control" id="gokul_adi" name='okul_adi'>
        </div>
        <div class="form-group">
          <label for="fakulte">Fakülte</label>
          <input type="text" class="form-control" id="gfakulte" name='fakulte'>
        </div>
        <div class="form-group">
          <label for="bolum">Bölüm</label>
          <input type="text" class="form-control" id="gbolum" name='bolum'>
        </div>
        <div class="form-group">
          <label for="adres">Adres</label>
          <textarea  class="form-control" id="gadres" name='adres'></textarea>
        </div>
        <div class="form-group">
          <label for="telefon">Telefon</label>
          <input type="number" class="form-control" id="gtelefon" name='telefon'>
        </div>
        <div class="form-group">
          <label for="mail">Mail</label>
          <input type="email" class="form-control" id="gmail" name='mail'>
        </div>
        <div class="form-group">
          <label for="okul_baslangic_tarihi">Okula Başlangıç Tarihi</label>
          <input type="date" class="form-control" id="gokul_baslangic_tarihi" name='okul_baslangic_tarihi'>
        </div>
        <div class="form-group">
          <label for="okul_bitis_tarihi">Okula Bitiş Tarihi</label>
          <input type="date" class="form-control" id="gokul_bitis_tarihi" name='okul_bitis_tarihi'>
        </div>
      

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" name="ogr_guncelle" >Kaydet</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
      </div>
      </form>



    
     
    </div>
  </div>
</div>


<!-- Modal sil-->
<div class="modal fade" id="sil_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
    
      <form action="./islem2.php" method="post" enctype="multipart/form-data"> <!-- Dosya gödermek için gerekli ---->
      <div class="modal-header">
        <h5 class="modal-title" >Öğrenci sil</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        <input type="hidden" class="form-control" id="sid" name='id' >
        <input type="hidden" class="form-control" id="sresim" name='resim' >
       <p>Silmek İstediğinize Emin Misiniz?</p>

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" name="ogr_sil" >Sil</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
      </div>
      </form>



    
     
    </div>
  </div>
</div>

</body>
<script>
    function ogr_ekle()
    {
      $('#ekle_modal').modal('show');
    }

    function ogr_guncelle(obj)
    {
        console.log(obj);
        console.log(obj.ad[0]);
        $('#gid').val(obj.id[0]);
        $('#gad').val(obj.ad[0]);
        $('#gresimdel').val(obj.resim[0]);
        $('#gsoyad').val(obj.soyad[0]);
        $('#gokul_numarasi').val(obj.okul_numarasi[0]);
        $('#gokul_adi').val(obj.okul_adi[0]);
        $('#gfakulte').val(obj.fakulte[0]);
        $('#gbolum').val(obj.bolum[0]);
        $('#gadres').val(obj.adres[0]);
        $('#gtelefon').val(obj.telefon[0]);
        $('#gmail').val(obj.mail[0]);
        $('#gokul_baslangic_tarihi').val(obj.okul_baslangic_tarihi[0]);
        $('#gokul_bitis_tarihi').val(obj.okul_bitis_tarihi[0]);


      $('#guncelle_modal').modal('show');
    }
    function ogr_sil(obj)
    {
        $('#sid').val(obj.id[0]);
        $('#sresim').val(obj.resim[0]);
        $('#sil_modal').modal('show');
    }



</script>

</html>