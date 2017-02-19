<?php

include "../../../config/database.php";

// $CONFIG['default']['db_host'] = 'localhost';
// $CONFIG['default']['db_user'] = 'root';
// $CONFIG['default']['db_pass'] = 'root123root';
// $CONFIG['default']['db_name'] = 'simbada_2014';


$link = mysqli_connect($CONFIG['default']['db_host'],$CONFIG['default']['db_user'],$CONFIG['default']['db_pass'],$CONFIG['default']['db_name']) or die("Error " . mysqli_error($link)); 

$query = "SELECT aset_list FROM apl_userasetlist WHERE aset_action = 'XLSIMPB' LIMIT 1" or die("Error in the consult.." . mysqli_error($link));
$result = $link->query($query); 

while($row = mysqli_fetch_assoc($result)) {
  $asetlist = $row;
} 

$sql = "SELECT SUM(NilaiTotal) as sumnilai FROM tmp_mesin";
$sumall = $link->query($sql);
while($row = mysqli_fetch_assoc($sumall)) {
  $sum = $row;
} 

$cleardata = explode(",", $asetlist['aset_list']);

echo "Total Data Row : ".count($cleardata)."\n\n";

//start transaction
// echo "Start Transaction\n\n";
// $command = "SET autocommit=0;";
// $exec = $link->query($command);
// $command = "START TRANSACTION;";
// $exec = $link->query($command);

$counter = 0;
$totaldata = 0;
foreach ($cleardata as $key => $val) {
	$counter++;
	$tmp = explode("|", $val);

	$sql = "SELECT * FROM tmp_mesin WHERE tmp_Mesin_ID = '{$tmp[0]}'" or die("Error in the consult.." . mysqli_error($link));
	$result = $link->query($sql); 

	while($row = mysqli_fetch_assoc($result)) {
	  $datatmp = $row;
	}

	echo "ID Data di proses:".$tmp[0]."\n";
	echo "Jumlah Data:".$datatmp['Jumlah']."\n";
    
	$data['kodeSatker'] = $datatmp['kodeSatker'];
    $data['kodeRuangan'] = $datatmp['kodeRuangan'];
    $data['kodeKelompok'] = $datatmp['kodeKelompok'];
    $data['Merk'] = $datatmp['Merk'];
    $data['Model'] = $datatmp['Model'];
    $data['Ukuran'] = $datatmp['Ukuran'];
    $data['Pabrik'] = $datatmp['Pabrik'];
    $data['NoMesin'] = $datatmp['NoMesin'];
    $data['NoBPKB'] = $datatmp['NoBPKB'];
    $data['Material'] = $datatmp['Material'];
    $data['NoRangka'] = $datatmp['NoRangka'];
    $data['NoSeri'] = $datatmp['NoSeri'];
	$data['TglPerolehan'] = $datatmp['TglPerolehan'];
    $data['TglPembukuan'] = $datatmp['TglPembukuan'];
	$data['Alamat'] = $datatmp['Alamat'];
	$data['Kuantitas'] = $datatmp['Jumlah'];
	$data['Satuan'] = $datatmp['NilaiPerolehan'];
	$data['NilaiPerolehan'] = $datatmp['NilaiPerolehan'];
	$data['NilaiTotal'] = $datatmp['NilaiTotal'];
	$data['Info'] = "[importing-" .$sum['sumnilai']. "]" . $datatmp['Info'];
	$data['id'] = $argv[2];
	$data['noKontrak'] = $datatmp['noKontrak'];
	$data['kondisi'] = 1;
	$data['UserNm'] = $argv[1];
	$data['Tahun'] = $datatmp['Tahun'];
	$data['TipeAset'] = $datatmp['TipeAset'];
	$data['AsalUsul'] = $datatmp['AsalUsul'];
	$data['GUID'] = $datatmp['GUID'];
	$data['xls'] = 1;


	$totaldata = store_aset($data,$link,$totaldata);
	echo "=================== Row Finish:".$counter." ===================\n\n";

    // echo "Commit data\n";
    // $command = "COMMIT;";
    // $exec = $link->query($command);

}

echo "Updating log import\n";
$sql = "UPDATE log_import SET totalPerolehan = '{$sum['sumnilai']}', status = 1 WHERE noKontrak = '{$datatmp['noKontrak']}'";
$exec = $link->query($sql);

$sql = "DELETE FROM apl_userasetlist WHERE aset_action = 'XLSIMPB'";
$result = $link->query($sql);

// echo "Commit data\n";
// $command = "COMMIT;";
// $exec = $link->query($command);



echo "=================== Process Complete. Thank you ===================\n\n";

function store_aset($data,$link,$totaldata)
    {
        $kodeSatker = explode(".",$data['kodeSatker']);
        $tblAset['kodeRuangan'] = $data['kodeRuangan'];
        $tblAset['kodeKelompok'] = $data['kodeKelompok'];
        $tblAset['kodeSatker'] = $data['kodeSatker'];
        $tahun = explode("-", $data['TglPerolehan']);
        $tblAset['Tahun'] = $tahun[0];
        $tblAset['kodeLokasi'] = "12.11.33.".$kodeSatker[0].".".$kodeSatker[1].".".substr($tahun[0],-2).".".$kodeSatker[2].".".$kodeSatker[3];
        $tblAset['noKontrak'] = $data['noKontrak'];
        $tblAset['TglPerolehan'] = $data['TglPerolehan'];
        $tblAset['TglPembukuan'] = $data['TglPembukuan'];
        $tblAset['NilaiPerolehan'] = $data['Satuan'];
        $tblAset['NilaiBuku'] = $data['Satuan'];
        $tblAset['kondisi'] = $data['kondisi'];
        $tblAset['Kuantitas'] = 1;
        $tblAset['Satuan'] = $data['Satuan'];
        $tblAset['Info'] = $data['Info'];
        $tblAset['Alamat'] = $data['Alamat'];
        $tblAset['UserNm'] = $data['UserNm'];
        $tblAset['TipeAset'] = $data['TipeAset'];
        $tblAset['GUID'] = $data['GUID'];

        //Penyusutan
        /*$kd_aset = explode('.', $tblAset['kodeKelompok']);
        if($kd_aset[0] == '02'){
            $tb = '2015';
            $ta = $tblAset['Tahun'];
            $na = $tblAset['NilaiPerolehan'];
            $sql = "SELECT masa_manfaat FROM ref_masamanfaat WHERE kd_aset1 = '{$kd_aset[0]}' AND kd_aset2 = '{$kd_aset[1]}' AND kd_aset3 = '{$kd_aset[2]}'";
            $result = $link->query($sql);
            while($row = mysqli_fetch_assoc($result)) {
              $mm = $row['masa_manfaat'];
            }

            $range = $tb - $ta;
            // $pp = $na/$mm;
            $pp = round($na/$mm);
			if($range >= $mm){
				$ap = $na;
				$nb = 0;
			}else{
				 $ap = $pp * $range;
				 $nb = $na - $ap;
			}
           
           

            $tblAset['MasaManfaat'] = $mm;
            $tblAset['AkumulasiPenyusutan'] = $ap;
            $tblAset['PenyusutanPertaun'] = $pp;
            $tblAset['NilaiBuku'] = $nb;
            $tblAset['UmurEkonomis'] = $mm - $range;
            $tblAset['TahunPenyusutan'] = '2014';
        }*/

        // if(intval($tblAset['Tahun']) < 2008){
        // $tblAset['kodeKA'] = 1;
        // }else {
            if($data['TipeAset'] == 'B'){
                if($tblAset['NilaiPerolehan'] < 1000000){
                    $tblAset['kodeKA'] = 0;
                } else {
                    $tblAset['kodeKA'] = 1;
                }
            } elseif ($data['TipeAset'] == 'C') {
                if($tblAset['NilaiPerolehan'] < 20000000){
                    $tblAset['kodeKA'] = 0;
                } else {
                    $tblAset['kodeKA'] = 1;
                }
            } else {
            	$tblAset['kodeKA'] = 1;
            }
    // }
        $tblAset['AsalUsul'] = $data['AsalUsul'];

        if(isset($data['xls'])) {
            $tblAset['TglPembukuan'] = $data['TglPembukuan'];
            $tblAset['StatusValidasi'] = 1;
            $tblAset['Status_Validasi_Barang'] = 1;

        }
        $startreg = 0;
        $query = "SELECT MAX(CAST(noRegister AS SIGNED)) AS noRegister FROM aset WHERE kodeKelompok = '{$data['kodeKelompok']}' AND kodeLokasi = '{$tblAset['kodeLokasi']}' LIMIT 1" or die("Error in the consult.." . mysqli_error($link));
        $result = $link->query($query);
        while($row = mysqli_fetch_assoc($result)) {
		  $startreg = $row['noRegister'];
		}

        if(!$startreg) $startreg = 0;

        $loops = $startreg+$data['Kuantitas'];
        $xlsxount = 0;
        if(isset($data['xls'])) {$nilaisisa = $data['NilaiTotal'];}
        for($startreg;$startreg<$loops;$startreg++)
        {
            $xlsxount++;
            $totaldata++;
            if(isset($data['xls'])){
                if($xlsxount == $data['Kuantitas']){
                    $tblAset['NilaiPerolehan'] = $nilaisisa;
                    $tblAset['Satuan'] = $nilaisisa;
                } else {
                    $nilaisisa = $nilaisisa - $tblAset['NilaiPerolehan'];
                }
            }

            $tblAset['noRegister'] = intval($startreg)+1;
            
            unset($tmpfield); unset($tmpvalue);
            foreach ($tblAset as $key => $val) {
                $tmpfield[] = $key;
                $tmpvalue[] = "'$val'";
            }

            // echo "Inserting to aset\n";

            $field = implode(',', $tmpfield);
            $value = implode(',', $tmpvalue);
            $query = "INSERT INTO aset ({$field}) VALUES ({$value})" or die("Error in the consult.." . mysqli_error($link));
            
            $exec = $link->query($query);
            $tblKib['Aset_ID'] = mysqli_insert_id($link);

            
            
            // if(!$exec){
            //   $command = "ROLLBACK;";
            //   $roll = $link->query($command);
            //   echo "Query error. Data di rollback!!\n";
            //   exit;
            // }

   //          $query_id = "SELECT Aset_ID FROM aset WHERE kodeKelompok = '{$tblAset['kodeKelompok']}' AND kodeLokasi='{$tblAset['kodeLokasi']}' AND noRegister = '{$tblAset['noRegister']}' LIMIT 1" or die("Error in the consult.." . mysqli_error($link));

   //          $result = $link->query($query_id);

	  //       while($row = mysqli_fetch_assoc($result)) {
			//   $tblKib['Aset_ID'] = $row['Aset_ID'];
			// }

            if($data['TipeAset']=="A"){
                $tblKib['HakTanah'] = $data['HakTanah'];
                $tblKib['LuasTotal'] = $data['LuasTotal'];
                $tblKib['NoSertifikat'] = $data['NoSertifikat'];
                $tblKib['TglSertifikat'] = $data['TglSertifikat'];
                $tblKib['Penggunaan'] = $data['Penggunaan'];
                $tabel = "tanah";
                $logtabel = "log_tanah";
                $idkey = "Tanah_ID";
            } elseif ($data['TipeAset']=="B") {
                $tblKib['Pabrik'] = $data['Pabrik'];
                $tblKib['Merk'] = $data['Merk'];
                $tblKib['Model'] = $data['Model'];
                $tblKib['Ukuran'] = $data['Ukuran'];
                $tblKib['NoMesin'] = $data['NoMesin'];
                $tblKib['NoSeri'] = $data['NoSeri'];
                $tblKib['NoBPKB'] = $data['NoBPKB'];
                $tblKib['Material'] = $data['Material'];
                $tblKib['NoRangka'] = $data['NoRangka'];
                $tabel = "mesin";
                $logtabel = "log_mesin";
                $idkey = "Mesin_ID";
            } elseif ($data['TipeAset']=="C") {
                $tblKib['JumlahLantai'] = $data['JumlahLantai'];
                $tblKib['LuasLantai'] = $data['LuasLantai'];
                $tblKib['Beton'] = $data['Beton'];
                $tblKib['NoSurat'] = $data['NoSurat'];
                $tblKib['tglSurat'] = $data['TglSurat'];
                $tabel = "bangunan";
                $logtabel = "log_bangunan";
                $idkey = "Bangunan_ID";
            } elseif ($data['TipeAset']=="D") {
                $tblKib['Panjang'] = $data['Panjang'];
                $tblKib['Lebar'] = $data['Lebar'];
                $tblKib['LuasJaringan'] = $data['LuasJaringan'];
                $tblKib['Konstruksi'] = $data['Konstruksi'];
                $tblKib['NoDokumen'] = $data['NoDokumen'];
                $tblKib['tglDokumen'] = $data['TglDokumen'];
                $tabel = "jaringan";
                $logtabel = "log_jaringan";
                $idkey = "Jaringan_ID";
            } elseif ($data['TipeAset']=="E") {
                $tblKib['Judul'] = $data['Judul'];
                $tblKib['Pengarang'] = $data['Pengarang'];
                $tblKib['Penerbit'] = $data['Penerbit'];
                $tblKib['Spesifikasi'] = $data['Spesifikasi'];
                $tblKib['AsalDaerah'] = $data['AsalDaerah'];
                $tblKib['Material'] = $data['Material'];
                $tblKib['Ukuran'] = $data['Ukuran'];
                $tabel = "asetlain";
                $logtabel = "log_asetlain";
                $idkey = "AsetLain_ID";
            } elseif ($data['TipeAset']=="F") {
                $tblKib['JumlahLantai'] = $data['JumlahLantai'];
                $tblKib['LuasLantai'] = $data['LuasLantai'];
                $tblKib['Beton'] = $data['Beton'];
                $tabel = "kdp";
                $logtabel = "log_kdp";
                $idkey = "KDP_ID";
            } elseif ($data['TipeAset']=="G") {
                $tabel = "aset";
                $logtabel = "log_aset";
                $idkey = "Aset_ID";
            } elseif ($data['TipeAset']=="H") {
                $tabel = "aset";
                $logtabel = "log_aset";
                $idkey = "Aset_ID";
            }

            $tblKib['kodeRuangan'] = $data['kodeRuangan'];
            $tblKib['kodeKelompok'] = $data['kodeKelompok'];
            $tblKib['kodeSatker'] = $data['kodeSatker'];
            $tblKib['kodeLokasi'] = $tblAset['kodeLokasi'];
            $tblKib['TglPerolehan'] = $data['TglPerolehan'];
            $tblKib['TglPembukuan'] = $data['TglPembukuan'];
            $tblKib['NilaiPerolehan'] = $tblAset['NilaiPerolehan'];
            $tblKib['NilaiBuku'] = $tblAset['NilaiPerolehan'];
        
            $tblKib['kondisi'] = $data['kondisi'];
            $tblKib['Info'] = $data['Info'];
            $tblKib['Alamat'] = $data['Alamat'];
            $tblKib['Tahun'] = $tblAset['Tahun'];
            $tblKib['kodeKA'] = $tblAset['kodeKA'];
            $tblKib['noRegister'] = $tblAset['noRegister'];
            $tblKib['AsalUsul'] = $data['AsalUsul'];
            if(isset($data['xls'])) {
                $tblKib['TglPembukuan'] = $data['TglPembukuan'];
                $tblKib['StatusValidasi'] = 1;
                $tblKib['Status_Validasi_Barang'] = 1;
                $tblKib['StatusTampil'] = 1;
                $tblKib['GUID'] = $data['GUID'];

                /*if($kd_aset[0] == '02'){
                    $tblKib['MasaManfaat'] = $mm;
                    $tblKib['AkumulasiPenyusutan'] = $ap;
                    $tblKib['PenyusutanPerTahun'] = $pp;
                    $tblKib['NilaiBuku'] = $nb;
                    $tblKib['UmurEkonomis'] = $mm - $range;
                    $tblKib['TahunPenyusutan'] = '2014';
                }*/

            }
            
            // echo "Inserting to KIB\n";

            unset($tmpfield2);
            unset($tmpvalue2);
            foreach ($tblKib as $key => $val) {
                $tmpfield2[] = $key;
                $tmpvalue2[] = "'$val'";
            }
            $field = implode(',', $tmpfield2);
            $value = implode(',', $tmpvalue2);
            $query = "INSERT INTO {$tabel} ({$field}) VALUES ({$value})" or die("Error in the consult.." . mysqli_error($link));
            
            if($tabel!="aset"){
                $exec = $link->query($query);
                $kib[$idkey] = mysqli_insert_id($link);
                // echo $kib[$idkey];exit;
             //    if(!$exec){
	            //   $command = "ROLLBACK;";
	            //   $roll = $link->query($command);
	            //   echo "Query error. Data di rollback!!\n";
             //  	  exit;
	            // }
            }

            if($data['TipeAset']=="H"){
                $kib['Aset_ID'] = $tblKib['Aset_ID'];
                $kib['kodeKelompok'] = $data['kodeKelompok'];
                $kib['kodeSatker'] = $data['kodeSatker'];
                $kib['kodeLokasi'] = $tblAset['kodeLokasi'];
                $kib['TglPerolehan'] = $data['TglPerolehan'];
                $kib['NilaiPerolehan'] = $tblAset['NilaiPerolehan'];
                $kib['noKontrak'] = $data['noKontrak'];
                $kib['kondisi'] = $data['kondisi'];
                $kib['Info'] = $data['Info'];
                $kib['Alamat'] = $data['Alamat'];
                $kib['Tahun'] = $tblAset['Tahun'];
                $kib['kodeKA'] = $tblAset['kodeKA'];
                $kib['noRegister'] = $tblAset['noRegister'];
                $kib['AsalUsul'] = $data['AsalUsul'];
                $kib['TglPembukuan'] = $data['TglPembukuan'];
                $kib['StatusValidasi'] = 1;
                $kib['Status_Validasi_Barang'] = 1;
                $kib['Kuantitas'] = 1;
                $kib['Satuan'] = $data['Satuan'];
                $kib['UserNm'] = $data['UserNm'];
                $kib['TipeAset'] = $data['TipeAset'];
                $kib['kodeRuangan'] = $data['kodeRuangan'];
            } elseif ($data['TipeAset']=="E") {
                $kib['Aset_ID'] = $tblKib['Aset_ID'];
                $kib['kodeKelompok'] = $data['kodeKelompok'];
                $kib['kodeSatker'] = $data['kodeSatker'];
                $kib['kodeLokasi'] = $tblAset['kodeLokasi'];
                $kib['noRegister'] = $tblAset['noRegister'];
                $kib['TglPerolehan'] = $data['TglPerolehan'];
                $kib['TglPembukuan'] = $data['TglPembukuan'];
                $kib['kodeKA'] = $tblAset['kodeKA'];
                $kib['kodeRuangan'] = $data['kodeRuangan'];
                $kib['StatusValidasi'] = 1;
                $kib['Status_Validasi_Barang'] = 1;
                $kib['Tahun'] = $tblAset['Tahun'];
                $kib['NilaiPerolehan'] = $tblAset['NilaiPerolehan'];
                $kib['NilaiBuku'] = $tblAset['NilaiPerolehan'];
                $kib['Alamat'] = $data['Alamat'];
                $kib['Info'] = $data['Info'];
                $kib['AsalUsul'] = $data['AsalUsul'];
                $kib['kondisi'] = $data['kondisi'];
                $kib['Judul'] = $data['Judul'];
                $kib['Pengarang'] = $data['Pengarang'];
                $kib['Penerbit'] = $data['Penerbit'];
                $kib['Spesifikasi'] = $data['Spesifikasi'];
                $kib['AsalDaerah'] = $data['AsalDaerah'];
                $kib['Material'] = $data['Material'];
                $kib['Ukuran'] = $data['Ukuran'];
                $kib['StatusTampil'] = 1;
                $kib['GUID'] = $data['GUID'];
            } elseif ($data['TipeAset']=="B") {
                $kib['Aset_ID'] = $tblKib['Aset_ID'];
                $kib['kodeKelompok'] = $data['kodeKelompok'];
                $kib['kodeSatker'] = $data['kodeSatker'];
                $kib['kodeLokasi'] = $tblAset['kodeLokasi'];
                $kib['noRegister'] = $tblAset['noRegister'];
                $kib['TglPerolehan'] = $data['TglPerolehan'];
                $kib['TglPembukuan'] = $data['TglPembukuan'];
                $kib['kodeKA'] = $tblAset['kodeKA'];
                $kib['kodeRuangan'] = $data['kodeRuangan'];
                $kib['StatusValidasi'] = 1;
                $kib['Status_Validasi_Barang'] = 1;
                $kib['Tahun'] = $tblAset['Tahun'];
                $kib['NilaiPerolehan'] = $tblAset['NilaiPerolehan'];
                $kib['NilaiBuku'] = $tblAset['NilaiPerolehan'];
                $kib['Alamat'] = $data['Alamat'];
                $kib['Info'] = $data['Info'];
                $kib['AsalUsul'] = $data['AsalUsul'];
                $kib['kondisi'] = $data['kondisi'];
                $kib['Merk'] = $data['Merk'];
                $kib['Model'] = $data['Model'];
                $kib['Ukuran'] = $data['Ukuran'];
                $kib['Pabrik'] = $data['Pabrik'];
                $kib['NoMesin'] = $data['NoMesin'];
                $kib['NoBPKB'] = $data['NoBPKB'];
                $kib['Material'] = $data['Material'];
                $kib['NoRangka'] = $data['NoRangka'];
                $kib['NoSeri'] = $data['NoSeri'];
                $kib['StatusTampil'] = 1;
                $kib['GUID'] = $data['GUID'];
            }

            if(isset($data['xls'])){
                //log
     //              $sqlkib = "SELECT * FROM {$tabel} WHERE Aset_ID = '{$tblKib['Aset_ID']}'" or die("Error in the consult.." . mysqli_error($link));

     //              $result = $link->query($sqlkib);

			  //     while($row = mysqli_fetch_assoc($result)) {
					// $kib = $row;
				 //  }
                      
                  $kib['TglPerubahan'] = $kib['TglPembukuan'];    
                  $kib['changeDate'] = date("Y-m-d");
                  $kib['action'] = 'posting';
                  $kib['operator'] = $data['UserNm'];
                  $kib['NilaiPerolehan_Awal'] = $kib['NilaiPerolehan'];
                  if($tabel == "kdp") $kib['Kd_Riwayat'] = 20; else $kib['Kd_Riwayat'] = 0;    

                 		// echo "Inserting to log\n";	

                        unset($tmpField);
                        unset($tmpValue);
                        foreach ($kib as $key => $val) {
                          $tmpField[] = $key;
                          $tmpValue[] = "'".$val."'";
                        }
                         
                        $fileldImp = implode(',', $tmpField);
                        $dataImp = implode(',', $tmpValue);

                        $sql = "INSERT INTO log_{$tabel} ({$fileldImp}) VALUES ({$dataImp})" or die("Error in the consult.." . mysqli_error($link));
                       	$exec = $link->query($sql);

                /*if($kd_aset[0] == '02'){
                    echo "Creating Log for penyusutan";
                    //First Log
                    $kib['MasaManfaat'] = 0;
                    $kib['AkumulasiPenyusutan'] = 0;
                    $kib['PenyusutanPerTahun'] = 0;
                    $kib['NilaiBuku'] = 0;
                    $kib['UmurEkonomis'] = $mm;
                    $kib['TahunPenyusutan'] = '2014';
                    $kib['Kd_Riwayat'] = 50;

                    unset($tmpField);
                    unset($tmpValue);
                    foreach ($kib as $key => $val) {
                      $tmpField[] = $key;
                      $tmpValue[] = "'".$val."'";
                    }
                     
                    $fileldImp = implode(',', $tmpField);
                    $dataImp = implode(',', $tmpValue);

                    $sql = "INSERT INTO log_{$tabel} ({$fileldImp}) VALUES ({$dataImp})" or die("Error in the consult.." . mysqli_error($link));
                    $exec = $link->query($sql); 

                    //Second Log
                    $kib['MasaManfaat'] = $mm;
                    $kib['AkumulasiPenyusutan'] = $ap;
                    $kib['PenyusutanPerTahun'] = $pp;
                    $kib['NilaiBuku'] = $nb;
                    $kib['UmurEkonomis'] = $mm - $range;
                    $kib['TahunPenyusutan'] = '2014';
                    $kib['Kd_Riwayat'] = 50;

                    unset($tmpField);
                    unset($tmpValue);
                    foreach ($kib as $key => $val) {
                      $tmpField[] = $key;
                      $tmpValue[] = "'".$val."'";
                    }
                     
                    $fileldImp = implode(',', $tmpField);
                    $dataImp = implode(',', $tmpValue);

                    $sql = "INSERT INTO log_{$tabel} ({$fileldImp}) VALUES ({$dataImp})" or die("Error in the consult.." . mysqli_error($link));
                    $exec = $link->query($sql);  
                }*/
                

                       	echo "Baris selesai : ".$xlsxount."\n";
                       	echo "Jumlah data yang masuk : ".$totaldata."\n";

		             //    if(!$exec){
			            //   $command = "ROLLBACK;";
			            //   $roll = $link->query($command);
			            //   echo "Query error. Data di rollback!!\n";
              	// 		  exit;
			            // }
            }

        }
        if(isset($data['xls'])) return $totaldata;
    }

	

?>
