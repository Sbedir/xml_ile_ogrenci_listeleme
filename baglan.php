<?php
function usernameproduce($name)
{

    $bul=$name;

    $bulunacak = array('ç','Ç','ı','İ','ğ','Ğ','ü','ö','Ş','ş','Ö','Ü',',',' ','(',')','[',']','.');
    $degistir  = array('c','C','i','I','g','G','u','o','S','s','O','U','','','','','','','');

    $name=str_replace($bulunacak, $degistir, $bul);
    // $name=strtolower($name);
    // $name=ucfirst($this->sef_link($name));
    return $name;
}

function ogr_ekleme_xml($xml,$ogr)
{
    $ogrenci = $xml->createElement('ogrenci');
    $id = $xml->createElement('id', $ogr['id']);
    $ad = $xml->createElement('ad', usernameproduce($ogr['ad']));
    $soyad = $xml->createElement('soyad', usernameproduce($ogr['soyad']));
    $okul_numarasi = $xml->createElement('okul_numarasi', $ogr['okul_numarasi']);
    $okul_adi = $xml->createElement('okul_adi', usernameproduce($ogr['okul_adi']));
    $fakulte = $xml->createElement('fakulte', usernameproduce($ogr['fakulte']));
    $bolum = $xml->createElement('bolum', usernameproduce($ogr['bolum']));
    $resim = $xml->createElement('resim',  $ogr['resim']);
    $address = $xml->createElement('address', usernameproduce($ogr['adres']));
    $telefon = $xml->createElement('telefon', $ogr['telefon']);
    $mail = $xml->createElement('mail', usernameproduce($ogr['mail']));
    $okul_baslangic_tarihi = $xml->createElement('okul_baslangic_tarihi', $ogr['okul_baslangic_tarihi']);
    $okul_bitis_tarihi = $xml->createElement('okul_bitis_tarihi', $ogr['okul_bitis_tarihi']);
    $ekleme_zamani = $xml->createElement('ekleme_zamani', $ogr['ekleme_zamani']);
    $guncelleme_zamani = $xml->createElement('guncelleme_zamani',$ogr['guncelleme_zamani']);

    $ogrenci->appendChild($id);
    $ogrenci->appendChild($ad);
    $ogrenci->appendChild($soyad);
    $ogrenci->appendChild($okul_numarasi);
    $ogrenci->appendChild($okul_adi);
    $ogrenci->appendChild($fakulte);
    $ogrenci->appendChild($bolum);
    $ogrenci->appendChild($resim);
    $ogrenci->appendChild($address);
    $ogrenci->appendChild($telefon);
    $ogrenci->appendChild($mail);
    $ogrenci->appendChild($okul_baslangic_tarihi);
    $ogrenci->appendChild($okul_bitis_tarihi);
    $ogrenci->appendChild($ekleme_zamani);
    $ogrenci->appendChild($guncelleme_zamani);
    return  $ogrenci;
}


function ogr_xml_okuma()
{
    $dosya_ogrler=[];
    header("Content-Type: text/html; charset=utf8");
if (file_exists("ogrenciler.xml")) { //// ogrenciler.xml klasörüm varmı kontrolü yapılıyor
	//Veri Çekiliyor
	$veri = simplexml_load_file("ogrenciler.xml");
	//Veri Yazdırılıyor
	foreach ($veri->ogrenci as $ogrenci) {
       
        array_push($dosya_ogrler,[
            'id'=>$ogrenci->id,
            'ad'=>$ogrenci->ad,
            'soyad'=>$ogrenci->soyad,
            'okul_numarasi'=>$ogrenci->okul_numarasi,
            'okul_adi'=>$ogrenci->okul_adi,
            'fakulte'=>$ogrenci->fakulte,
            'bolum'=>$ogrenci->bolum,
            'resim'=>$ogrenci->resim,
            'adres'=>$ogrenci->address,
            'telefon'=>$ogrenci->telefon,
            'mail'=>$ogrenci->mail,
            'okul_baslangic_tarihi'=>$ogrenci->okul_baslangic_tarihi,
            'okul_bitis_tarihi'=>$ogrenci->okul_bitis_tarihi,
            'ekleme_zamani'=>$ogrenci->ekleme_zamani,
            'guncelleme_zamani'=>$ogrenci->guncelleme_zamani
        ]);
	}
	
} else {
	//Veri Açılmadı Hatası
    echo ('ogrenciler.xml açılamadı.');
}
    return $dosya_ogrler;
}


?>