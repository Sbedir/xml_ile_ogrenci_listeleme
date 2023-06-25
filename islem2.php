<?php  
include './baglan.php';
//öğrenci ekleme işlemi


if(isset($_POST['ogr_ekleme']))
{
    $target_file='';
   if($_FILES['resim']["tmp_name"]!==""){  ////// kullanıcı resmini klasöre atıp uzantısını $target_file olarak veriyoruz
        $target_dir = "images/";
        $target_file = $target_dir . time().usernameproduce(basename($_FILES["resim"]["name"]));
    
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        
    
        $check = getimagesize($_FILES['resim']["tmp_name"]);
        if($check !== false) {
            move_uploaded_file($_FILES['resim']["tmp_name"], $target_file);
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }
    }
    


    /////////////// XML KALASÖRÜNE VERİ EKLEME İŞLEMLERİ BURADA BAŞLAR
        $dosya_ogrler=ogr_xml_okuma(); ///// xml klasöründeki verileri okuyoruz

        header("content-type: application/xml;charset=utf-8");
        $xml = new DOMDocument('1.0', 'UTF-8');

        $ogrenciler = $xml->createElement('ogrenciler');

        /////burası xml dosyasındaki verileri okumak için kullanılıyor //////
        //Veri Kontrolü
        $id=0;
        foreach($dosya_ogrler as $dosya_ogr)
        {
            $id=$dosya_ogr['id'];
            $ogrenci=ogr_ekleme_xml($xml,$dosya_ogr); ////// posttan gelen degeri buradaki fonksiyona post değerlerini göndererek ekliyoruz

            $ogrenciler->appendChild($ogrenci);
        }

        $_POST['id']=$id+1;
        $_POST['resim']=$target_file;
        $_POST['ekleme_zamani']=date('Y-m-d H:i:s');
        $_POST['guncelleme_zamani']=date('Y-m-d H:i:s');
        $ogrenci=ogr_ekleme_xml($xml,$_POST); ////// posttan gelen degeri buradaki fonksiyona post değerlerini göndererek ekliyoruz

        $ogrenciler->appendChild($ogrenci);
        $xml->appendChild($ogrenciler);
        $xml->save('ogrenciler.xml');
        $xml->saveHTML();
    /////////////// XML KALASÖRÜNE VERİ EKLEME İŞLEMLERİ BURADA BİTER
    if ($xml) {
        //echo "kayıt başarılı";
        header("location:ogrenciler2.php?durum=ok&type=ekleme");
        exit;
    }
    else{
        //echo "kayıt başarısız";
        header("location:ogrenciler2.php?durum=no&type=ekleme");
        exit;
    }
}

//öğrenci güncelleme işlemi

if(isset($_POST['ogr_guncelle']))
{
    // print_r($_FILES);
   // print_r($_POST);
    //exit; 
    //sol tarafdakiler mysq
    //file_exists dosya varmı kontrolu yapar
    //unlink dosyanın icine yüklenen resmi siler
  


      $target_file='';

      //////////// BU KISIMDA POSTTAN GÖNDERİLEN RESİM VARSA ESKİ RESİM SİLİNİR YENİ RESMİN KALASÖRE EKLENİM TARGET_FILE A DOSYA YOLU EKLENİR
      if($_FILES['resim']["tmp_name"]!==""){
        if (file_exists($_POST['gresimdel'])) {
            unlink($_POST['gresimdel']);
            $uploadOk = 0;
          }

      $target_dir = "images/";
      $target_file = $target_dir . time(). basename($_FILES["resim"]["name"]);
     
      $uploadOk = 1;
      $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
      // Check if image file is a actual image or fake image
      
     
      $check = getimagesize($_FILES["resim"]["tmp_name"]);
      if($check !== false) {
          move_uploaded_file($_FILES["resim"]["tmp_name"], $target_file);
          $uploadOk = 1;
      } else {
          $uploadOk = 0;
      }
    }
    else{
        $target_file=$_POST['gresimdel'];
    }

    /////////////// XML KALASÖRÜNE VERİ GÜNCELLEME İŞLEMLERİ BURADA BAŞLAR
    $dosya_ogrler=ogr_xml_okuma(); ///// xml klasöründeki verileri okuyoruz

    foreach($dosya_ogrler as $dosya_ogr)
    {
        if($dosya_ogr['id']==$_POST['id'])
        {
            $_POST['resim']=$target_file;
            $_POST['guncelleme_zamani']=date('Y-m-d H:i:s');
            $_POST['ekleme_zamani']=$dosya_ogr['ekleme_zamani'];
            print_r($_POST);
        }
        else {
            print_r($dosya_ogr);
        }
       
    }
    
    header("content-type: application/xml;charset=utf-8");
    $xml = new DOMDocument('1.0', 'UTF-8');

    $ogrenciler = $xml->createElement('ogrenciler');

    /////burası xml dosyasındaki verileri okumak için kullanılıyor //////
    //Veri Kontrolü
    foreach($dosya_ogrler as $dosya_ogr)
    {
        if($dosya_ogr['id']==$_POST['id'])
        {
            $_POST['resim']=$target_file;
            $_POST['guncelleme_zamani']=date('Y-m-d H:i:s');
            $ogrenci=ogr_ekleme_xml($xml,$_POST); ////// posttan gelen degeri buradaki fonksiyona post değerlerini göndererek ekliyoruz

            $ogrenciler->appendChild($ogrenci);
        }
        else {
            $ogrenci=ogr_ekleme_xml($xml,$dosya_ogr); ////// posttan gelen degeri buradaki fonksiyona post değerlerini göndererek ekliyoruz

            $ogrenciler->appendChild($ogrenci);
        }
       
    }

    $xml->appendChild($ogrenciler);
    $xml->save('ogrenciler.xml');
    $xml->saveHTML();
/////////////// XML KALASÖRÜNE VERİ GÜNCELLEME İŞLEMLERİ BURADA BİTER
    


    if ($xml) {
        //echo "güncelleme başarılı";
        header("location:ogrenciler2.php?durum=ok&type=güncelleme");
        exit;
    }
    else{
        //echo "güncelleme başarısız";
        header("location:ogrenciler2.php?durum=no&type=güncelleme");
        exit;
    }
}


//öğrenci silme işlemi

if(isset($_POST['ogr_sil']))
{
    // print_r($_FILES);
   // print_r($_POST);
    //exit; 
    //sol tarafdakiler mysq
    if (file_exists($_POST['resim'])) {
        unlink($_POST['resim']);
        $uploadOk = 0;
      }

      /////////////// XML KALASÖRÜNE VERİ GÜNCELLEME İŞLEMLERİ BURADA BAŞLAR
    $dosya_ogrler=ogr_xml_okuma(); ///// xml klasöründeki verileri okuyoruz
    
    header("content-type: application/xml;charset=utf-8");
    $xml = new DOMDocument('1.0', 'UTF-8');

    $ogrenciler = $xml->createElement('ogrenciler');

    /////burası xml dosyasındaki verileri okumak için kullanılıyor //////
    //Veri Kontrolü
    foreach($dosya_ogrler as $dosya_ogr)
    {
        if($dosya_ogr['id']==$_POST['id'])
        {
           ///// burada bulunan id klasöre yazdırılmaz boş geçilir
        }
        else{
            $ogrenci=ogr_ekleme_xml($xml,$dosya_ogr); ////// posttan gelen degeri buradaki fonksiyona post değerlerini göndererek ekliyoruz
            $ogrenciler->appendChild($ogrenci);
        }
       
    }

    $xml->appendChild($ogrenciler);
    $xml->save('ogrenciler.xml');
    $xml->saveHTML();
/////////////// XML KALASÖRÜNE VERİ GÜNCELLEME İŞLEMLERİ BURADA BİTER


    if ($xml) {
        //echo "silme başarılı";
        header("location:ogrenciler2.php?durum=ok&type=silme");
        exit;
    }
    else{
        //echo "silme başarısız";
        header("location:ogrenciler2.php?durum=no&type=silme");
        exit;
    }
}
?>