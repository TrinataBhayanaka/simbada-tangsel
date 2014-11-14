<?php
ob_start();
require_once('../../../config/config.php');
//include ('../../../function/tanggal/tanggal.php');
include "../../report_engine.php";
require_once('../../../function/mpdf/mpdf.php');


$modul = $_REQUEST['menuID'];
$mode = $_REQUEST['mode'];
$tab = $_REQUEST['tab'];
$skpd_id = $_REQUEST['skpd_id'];

$kib = $_REQUEST['kib'];
$tahun = $_REQUEST['tahun'];
//$kelompok=$_REQUEST['kelompok'];
$kelompok = $_REQUEST['bidang'];

$data=array(
    "modul"=>$modul,
    "mode"=>$mode,
    "kib"=>$kib,
    "tahun"=>$tahun,
    "skpd_id"=>$skpd_id,
    "kelompok"=>$kelompok,
    "tab"=>$tab
);

//mendeklarasikan report_engine. FILE utama untuk reporting
$REPORT=new report_engine();

//menggunakan api untuk query berdasarkan variable yg telah dimasukan
$REPORT->set_data($data);

//mendapatkan jenis query yang digunakan
$query=$REPORT->list_query($data);
//echo $query;
//exit;

//kib-e
//============================
/*$query="select A.Aset_ID, A.LastSatker_ID,A.Lokasi_ID, A.NamaAset, A.AsalUsul, A.NilaiPerolehan, A.Info,A.NomorReg,A.TglPerolehan,A.Kuantitas,   
B.Judul, B.Spesifikasi, B.AsalDaerah, B.Pengarang, B.Material, B.Ukuran, B.TahunTerbit, 
C.KodeSatker,  C.Satker_ID, C.KodeUnit,C.NamaSatker,
D.Kode, D.Uraian, D.Satuan 
from  Aset A
left outer join AsetLain B on A.Aset_ID=B.Aset_ID
left outer join Satker C on A.LastSatker_ID=C.Satker_ID
left outer join Kelompok D on A.Kelompok_ID=D.Kelompok_ID
where A.TipeAset='E'
order by C.KodeSatker, C.KodeUnit, D.Kode, A.NomorReg limit 20";*/


//mengenerate query
$result_query=$REPORT->retrieve_query($query);

//set gambar untuk laporan
$gambar=$REPORT->getLogo('bireun', $url_rewrite);

//retrieve html

$html=$REPORT->retrieve_html_kib_e($result_query, $gambar);


$count = count($html);
//echo "$query ";


for ($i = 0; $i < $count; $i++) {
     
    // echo $html[$i];     
}


//list($nip,$nama_jabatan)=$REPORT->get_jabatan('474',"3");
									
//cetak reporting
//$mpdf=new mPDF(); 


$mpdf=new mPDF('','','','',15,15,16,16,9,9,'L');
$mpdf->AddPage('L','','','','',15,15,16,16,9,9);
$mpdf->setFooter('{PAGENO}') ;
$count = count($html);
for ($i = 0; $i < $count; $i++) {
     if($i==0)
          $mpdf->WriteHTML($html[$i]);
     else
     {
           $mpdf->AddPage('L','','','','',15,15,16,16,9,9);
           //$mpdf->AddPage();
           $mpdf->WriteHTML($html[$i]);
           
     }
}

$waktu=date("dymhis");
$namafile="$path/report/output/Kartu Inventaris E_$waktu.pdf";

$mpdf->Output("$namafile",'F');
$REPORT->show_status_download();
$namafile_web="$url_rewrite/report/output/Kartu Inventaris E_$waktu.pdf";
echo "<script>window.location.href='$namafile_web';</script>";
exit;

?>
