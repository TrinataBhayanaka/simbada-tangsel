<?php

ob_start();
require_once('../../../config/config.php');
include ('../../../function/tanggal/tanggal.php');

define("_JPGRAPH_PATH", "$path/function/mpdf/jpgraph/src/"); // must define this before including mpdf.php file
$JpgUseSVGFormat = true;
define('_MPDF_URI',"$url_rewrite/function/mpdf/"); 	// must be  a relative or absolute URI - not a file system path

include "../../report_engine.php";
require_once('../../../function/mpdf/mpdf.php');
// pr($_GET);
/*$no_kontrak = $_GET['no_kontrak]'];
$tahun = $_GET['tahun'];
$Satker_ID = $_GET['Satker_ID'];
$status = $_GET['status'];
$jns_aset = $_GET['jns_aset'];
$tipe=$_GET['tipe'];*/

$REPORT=new report_engine();

$gambar = $FILE_GAMBAR_KABUPATEN;

/*if($no_kontrak !=''){
	$query_noKontrak = "noKontrak='{$no_kontrak}' AND";
}else{
	$query_noKontrak="";
}

if($tahun!=''){
	$query_tahun = "tahun='{$tahun}' AND";
}else{ 
	$query_tahun="";
}

if($Satker_ID != ""){
	$query_satker="kodeSatker = '{$Satker_ID}' AND";
}else{
	$query_satker="";
}

if($status != ''){
	if($status == 0){
		$query_status="(Status_Validasi_Barang IS NULL OR Status_Validasi_Barang = '{$status}') AND";
	}elseif($status == 1){
		$query_status="Status_Validasi_Barang = '{$status}' AND StatusValidasi = '{$status}' AND";
	}
}else{
	$query_status="";
}

$expld = explode(',',$jns_aset);
$count = count($expld);
$add ='0';

for ($i = 0; $i < $count; $i++){
	
	if($jns_aset != ''){
		$query_kodekelompok= "kodeKelompok  like '".$add.$expld[$i]."%' ";
	}else{
		$query_kodekelompok= "";
	}
	
	$query = "SELECT noKontrak,noRegister,kodeKelompok,kodeSatker,Info,TglPerolehan,TglPembukuan,Tahun,NilaiPerolehan,Status_Validasi_Barang 
			  from aset where {$query_noKontrak} {$query_tahun} {$query_satker} {$query_status} {$query_kodekelompok} order by kodeKelompok,noRegister asc";

	$exe = mysql_query($query);
	while ($data = mysql_fetch_object($exe))
	{
		$dataArr[] = $data;
	}
		
}*/
$tahun = $_GET['tahun'];
$jenisaset = $_GET['jns_aset'];
$kodeSatker = $_GET['Satker_ID'];
$kodeKelompok = $_GET['kodeKelompok'];
$statusaset = $_GET['status'];
$tipe=$_GET['tipe'];
//pr($_GET);
$param = '';
//param tahun
if ($tahun != "") {
  $param.=" AND Tahun ='$tahun' ";
}

//param kodekelompok
if ($kodeKelompok != "") {
  $param.=" AND kodeKelompok ='$kodeKelompok' ";
}

if($statusaset!=""){
  switch ($statusaset) {
    case "1":
      //masuk neraca  StatusValidasi=1 dan Status_Validasi_Barang=1
     // tahun berjalan dan tgl
      $aset_status= " StatusValidasi=1 AND Status_Validasi_Barang=1";
      break;
    case "0":
      //baru masuk kontrak atau inventarisasi  StatusValidasi=1 dan Status_Validasi_Barang=0
      $aset_status= " (StatusValidasi=1 AND (Status_Validasi_Barang=0 or Status_Validasi_Barang is null))";
      break; 
   } 
}

$sWhere = "WHERE $aset_status AND kodeSatker='$kodeSatker' AND TipeAset='$jenisaset' {$param}";
//pr($sWhere);
$query = "SELECT noKontrak,noRegister,kodeKelompok,kodeSatker,Info,TglPerolehan,TglPembukuan,Tahun,
				 NilaiPerolehan,StatusValidasi,Status_Validasi_Barang 
	  	  from aset {$sWhere} order by kodeKelompok,noRegister asc";
//r($query);
$exe = mysql_query($query);
while ($data = mysql_fetch_object($exe)){
	$dataArr[] = $data;
}
//pr($dataArr);
//exit;
//mendeklarasikan report_engine. FILE utama untuk reporting
// pr($gambar);
$html=$REPORT->retrieve_html_liat_dftr_aset($dataArr,$Satker_ID,$gambar,$tipe);

$count = count($html);
/*for ($i = 0; $i < $count; $i++) {
		 echo $html[$i];     
	}
exit;*/
if($tipe==1){
$REPORT->show_status_download_kib();
$mpdf=new mPDF('','','','',15,15,16,16,9,9,'L');
$mpdf->AddPage('L','','','','',15,15,16,16,9,9);
$mpdf->setFooter('{PAGENO}') ;
$mpdf->progbar_heading = '';
$mpdf->StartProgressBarOutput(2);
$mpdf->useGraphs = true;
$mpdf->list_number_suffix = ')';
$mpdf->hyphenate = true;

$count = count($html);

	for ($i = 0; $i < $count; $i++) {
		 if($i==0)
			{ 
			$mpdf->WriteHTML($html[$i]);
			}
		 else
		 {
			   $mpdf->AddPage('L','','','','',15,15,16,16,9,9);
			   $mpdf->WriteHTML($html[$i]);
			   
		 }
	}

$waktu=date("d-m-y_h-i-s");
$namafile="$path/report/output/Daftar_Aset_$waktu.pdf";
$mpdf->Output("$namafile",'F');
$namafile_web="$url_rewrite/report/output/Daftar_Aset_$waktu.pdf";
echo "<script>window.location.href='$namafile_web';</script>";
exit;	
}
else
{
	
	$waktu=date("d-m-y_h:i:s");
	$filename ="Daftar_Aset_$waktu.xls";
	header('Content-type: application/ms-excel');
	header('Content-Disposition: attachment; filename='.$filename);
	$count = count($html);
	for ($i = 0; $i < $count; $i++) {
           echo "$html[$i]";
           
     }
	
}

?>