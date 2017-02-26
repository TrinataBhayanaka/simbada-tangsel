<?php

include "../../../config/database.php";
// $CONFIG['default']['db_host'] = 'localhost';
// $CONFIG['default']['db_user'] = 'root';
// $CONFIG['default']['db_pass'] = 'root123root';
// $CONFIG['default']['db_name'] = 'simbada_2014';

$link = mysqli_connect($CONFIG['default']['db_host'],$CONFIG['default']['db_user'],$CONFIG['default']['db_pass'],$CONFIG['default']['db_name']) or die("Error " . mysqli_error($link)); 

$query = "SELECT aset_list FROM apl_userasetlist WHERE aset_action = 'XLSIMPWJD' LIMIT 1" or die("Error in the consult.." . mysqli_error($link));
$result = $link->query($query); 
while($row = mysqli_fetch_assoc($result)) {
  $asetlist = $row;
} 

$sql = "SELECT SUM(NilaiTotal) as sumnilai FROM tmp_twujud";
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
$datatmp = array();
$datatmp = array();
foreach ($cleardata as $key => $val) {
	$counter++;
	$tmp = explode("|", $val);

	$sql = "SELECT * FROM tmp_twujud WHERE temp_twujud_ID = '{$tmp[0]}'" or die("Error in the consult.." . mysqli_error($link));
	$result = $link->query($sql); 

	while($row = mysqli_fetch_assoc($result)) {
	  $datatmp = $row;
	}

	echo "ID Data di proses:".$tmp[0]."\n";
	echo "Jumlah Data:".$datatmp['Jumlah']."\n";

	$data['kodeSatker'] = $datatmp['kodeSatker'];
	$data['kodeRuangan'] = $datatmp['kodeRuangan'];
    $data['kodeKelompok'] = $datatmp['kodeKelompok'];
    $data['kondisi'] = $datatmp['kondisi'];
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

$sql = "DELETE FROM apl_userasetlist WHERE aset_action = 'XLSIMPWJD'";
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
        // if(intval($tblAset['Tahun']) < 2008){
            // $tblAset['kodeKA'] = 1;
        // }else {
            /*if($data['TipeAset'] == 'B'){
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
            }*/
        // }
        $tblAset['kodeKA'] = 1;
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
            echo "Inserting to aset".$query."\n\n";
            $exec = $link->query($query);
            $tblKib['Aset_ID'] = mysqli_insert_id($link);
            if ($data['TipeAset']=="G") {
                $tabel = "aset";
                $logtabel = "log_aset";
            }

            if ($data['TipeAset']=="G") {
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
                $kib['Alamat'] = $data['Alamat'];
                $kib['Info'] = $data['Info'];
                $kib['AsalUsul'] = $data['AsalUsul'];
                $kib['kondisi'] = $data['kondisi'];
                $kib['GUID'] = $data['GUID'];

            }

            if(isset($data['xls'])){
   
                  $kib['TglPerubahan'] = $kib['TglPembukuan'];    
                  $kib['changeDate'] = date("Y-m-d");
                  $kib['action'] = 'posting';
                  $kib['operator'] = $data['UserNm'];
                  $kib['NilaiPerolehan_Awal'] = $kib['NilaiPerolehan'];
                  $kib['Kd_Riwayat'] = 0;    

                 		// echo "Inserting to log\n";	

                        unset($tmpField);
                        unset($tmpValue);
                        foreach ($kib as $key => $val) {
                          $tmpField[] = $key;
                          $tmpValue[] = "'".$val."'";
                        }
                         
                        $fileldImp = implode(',', $tmpField);
                        $dataImp = implode(',', $tmpValue);

                        $sql = "INSERT INTO {$logtabel} ({$fileldImp}) VALUES ({$dataImp})" or die("Error in the consult.." . mysqli_error($link));
                       	$exec = $link->query($sql);
                        echo "Inserting to log".$sql."\n\n";
                       	echo "Baris selesai : ".$xlsxount."\n";
                       	echo "Jumlah data yang masuk : ".$totaldata."\n";
            }

        }
        if(isset($data['xls'])) return $totaldata;
    }

	

?>
