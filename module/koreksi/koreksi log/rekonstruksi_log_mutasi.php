<?php
include "../../../config/database.php";
function pr($data,$exit=1){
	echo "<pre>";
	print_r($data);
	echo "</pre>";
	// if($exit == 1) exit;
}

$link = mysqli_connect($CONFIG['default']['db_host'],$CONFIG['default']['db_user'],$CONFIG['default']['db_pass'],$CONFIG['default']['db_name']) or die("Error " . mysqli_error($link)); 

// $sql_noReg_max = "SELECT max(noRegister)+1 as noReg from aset WHERE kodeKelompok = '08.01.03.01.01' and Tahun = '2015'";
// $exe_sql_noReg_max = $link->query($sql_noReg_max);
// $data = mysqli_fetch_assoc($exe_sql_noReg_max);
// $noReg = $data['noReg'];

$sql_1 ="SELECT * FROM `log_tanah` WHERE `Kd_Riwayat` = 3 and action like 'Data Mutasi sebelum diubah%' order by Aset_ID asc";
$sql_2 ="SELECT * FROM `log_mesin` WHERE `Kd_Riwayat` = 3 and action like 'Data Mutasi sebelum diubah%' order by Aset_ID asc";
$sql_3 ="SELECT * FROM `log_bangunan` WHERE `Kd_Riwayat` = 3 and action like 'Data Mutasi sebelum diubah%' order by Aset_ID asc";

echo "mulai---\n";
$no = 1;
$array_sql =array($sql_1,$sql_2,$sql_3);
// $array_sql =array($sql_3);
for ($i = 0; $i < count($array_sql); $i++){
	$exe_select_aset = $link->query($array_sql[$i]);
	$rowcount=mysqli_num_rows($exe_select_aset);
	echo "Result set has %d rows.\n".$rowcount;
	echo "<br/>";
	
	if($i == 0){
		$table = "log_tanah";
	}elseif($i == 1){
		$table = "log_mesin";
	}else{
		$table = "log_bangunan";
	}
	
	
    while($row = mysqli_fetch_assoc($exe_select_aset)) {
		// pr($row);
		$TglPerolehan = $row['TglPerolehan'];
		$asetlist = $row['Aset_ID'];
		$log_id = $row['log_id'];
        echo "$no  \n";
		echo "<br/>";
        echo "$asetlist  \n";
		// db($asetlist);
		
		$update_sql = "UPDATE {$table} SET TglPembukuan = '{$TglPerolehan}' WHERE 
					   Aset_ID = '{$asetlist}' and log_id ='{$log_id}' 
					   and `Kd_Riwayat` = 3 and action like 'Data Mutasi sebelum diubah%' ";
		// pr($update_sql);			   
		$exe_update_sql = $link->query($update_sql);
	  $no++;
	}
}			


echo "no = ".$no;
echo "============= DONE =============";
exit;

?>