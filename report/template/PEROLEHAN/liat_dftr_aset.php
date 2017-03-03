<?php
include "../../../config/config.php";
include "../../report_engine.php";

//pr($_GET);
//exit;
$tahun = $_GET['tahun'];
$jns_aset = $_GET['jenisaset'];
$Satker_ID = $_GET['kodeSatker'];
$kodeKelompok = $_GET['kodeKelompok'];
$status = $_GET['statusaset'];
$tipe=$_REQUEST['tipe_file'];
// pr($_REQUEST);
$paramater_url="tahun=$tahun&jns_aset=$jns_aset&Satker_ID=$Satker_ID&kodeKelompok=$kodeKelompok&status=$status&tipe=$tipe";
// echo $paramater_url;
// exit;
$REPORT=new report_engine();
$url = "report_perolehanaset_cetak_liat_daftar_aset.php?$paramater_url";
$REPORT->show_pilih_download_cstm($url);  




?>
 
