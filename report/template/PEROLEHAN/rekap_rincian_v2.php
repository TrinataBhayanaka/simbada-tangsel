<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
#This code provided by:
#Andreas Hadiyono (andre.hadiyono@gmail.com)
#Gunadarma University
ob_start();
require_once('../../../config/config.php');
define("_JPGRAPH_PATH", "$path/function/mpdf/jpgraph/src/"); // must define this before including mpdf.php file
$JpgUseSVGFormat = true;
define('_MPDF_URI',"$url_rewrite/function/mpdf/"); 	// must be  a relative or absolute URI - not a file system path
include "../../report_engine.php";
require ('../../../function/mpdf/mpdf.php');
$modul = $_GET['menuID'];
$mode = $_GET['mode'];
$tab = $_GET['tab'];
$tglawal = $_GET['tglawalperolehan'];
if($tglawal != ''){
	$tglawalperolehan = $tglawal;
}else{
	$tglawalperolehan = '0000-00-00';
}
$tglakhirperolehan = $_GET['tglakhirperolehan'];
$tglakhirperolehan = $_GET['tglakhirperolehan'];
$skpd_id = $_GET['skpd_id'];
$levelAset=$_GET['levelAset'];
$tipeAset=$_GET['tipeAset'];
$tipe=$_GET['tipe_file'];
// pr($_REQUEST);
// exit;
$ex = explode('-',$tglakhirperolehan);
$tahun_neraca = $ex[0];
$REPORT=new report_engine();
$data=array(
    "modul"=>$modul,
    "mode"=>$mode,
	"tglawalperolehan"=>$tglawalperolehan,
    "tglakhirperolehan"=>$tglakhirperolehan,
    "skpd_id"=>$skpd_id,
	"tab"=>$tab
);
$REPORT->set_data($data);
$nama_kab = $NAMA_KABUPATEN;
$nama_prov = $NAMA_PROVINSI;
$gambar = $FILE_GAMBAR_KABUPATEN;
if($tipe == 1){
	$gmbr = "<img style=\"width: 80px; height: 85px;\" src=\"$gambar\">";
}else{
	$gmbr ="";
}
$hit = 2;
$flag = '';
$TypeRprtr = 'intra';
$Info = '';
$exeTempTable = $REPORT->TempTable($hit,$flag,$TypeRprtr,$Info,$tglawalperolehan,$tglakhirperolehan,
$skpd_id);
// exit;
//begin 
//head satker
$detailSatker = $REPORT->get_satker($skpd_id);
// pr($detailSatker);
// exit;
$NoBidang = $detailSatker[0];
$NoUnitOrganisasi = $detailSatker[1];
$NoSubUnitOrganisasi = $detailSatker[2];
$NoUPB = $detailSatker[3];
if($NoBidang !=""){
	$paramKodeLokasi = $NoBidang;
}
if($NoBidang !="" && $NoUnitOrganisasi != ""){
	$paramKodeLokasi = $NoUnitOrganisasi;
}
if($NoBidang !="" && $NoUnitOrganisasi != "" && $NoSubUnitOrganisasi !=""){
	$paramKodeLokasi = $NoUnitOrganisasi.".".$NoSubUnitOrganisasi;
}
if($NoBidang !="" && $NoUnitOrganisasi != "" && $NoSubUnitOrganisasi !="" && $NoUPB !=""){
	$paramKodeLokasi = $NoUnitOrganisasi.".".$NoSubUnitOrganisasi.".".$NoUPB;
}
$Bidang = $detailSatker[4][0];
$UnitOrganisasi = $detailSatker[4][1];
$SubUnitOrganisasi = $detailSatker[4][2];
$UPB = $detailSatker[4][3];
   
$ex = explode('.',$skpd_id);
$hit = count($ex);
if($hit == 1){
	$header = "<tr>
          <td style=\"width: 200px; font-weight: bold; text-align: left;\">BIDANG</td>
          <td style=\"text-align: center; font-weight: bold; width: 10px;\">:</td>
          <td style=\"width: 873px; font-weight: bold;\">$Bidang</td>
        </tr>
		";
}elseif($hit == 2){
	$header = "<tr>
          <td style=\"width: 200px; font-weight: bold; text-align: left;\">BIDANG</td>
          <td style=\"text-align: center; font-weight: bold; width: 10px;\">:</td>
          <td style=\"width: 873px; font-weight: bold;\">$Bidang</td>
        </tr>
		<tr>
          <td style=\"width: 200px; font-weight: bold; text-align: left;\">UNIT ORGANISASI</td>
          <td style=\"text-align: center; font-weight: bold; width: 10px;\">:</td>
          <td style=\"width: 873px; font-weight: bold;\">$UnitOrganisasi</td>
        </tr>";
}elseif($hit == 3){
	$header = "<tr>
          <td style=\"width: 200px; font-weight: bold; text-align: left;\">BIDANG</td>
          <td style=\"text-align: center; font-weight: bold; width: 10px;\">:</td>
          <td style=\"width: 873px; font-weight: bold;\">$Bidang</td>
        </tr>
		<tr>
          <td style=\"width: 200px; font-weight: bold; text-align: left;\">UNIT ORGANISASI</td>
          <td style=\"text-align: center; font-weight: bold; width: 10px;\">:</td>
          <td style=\"width: 873px; font-weight: bold;\">$UnitOrganisasi</td>
        </tr>
		<tr>
          <td style=\"width: 200px; font-weight: bold; text-align: left;\">SUB UNIT ORGANISASI</td>
          <td style=\"text-align: center; font-weight: bold; width: 10px;\">:</td>
          <td style=\"width: 873px; font-weight: bold;\">$SubUnitOrganisasi</td>
        </tr>";
}elseif($hit == 4){
	$header = "<tr>
          <td style=\"width: 200px; font-weight: bold; text-align: left;\">BIDANG</td>
          <td style=\"text-align: center; font-weight: bold; width: 10px;\">:</td>
          <td style=\"width: 873px; font-weight: bold;\">$Bidang</td>
        </tr>
		<tr>
          <td style=\"width: 200px; font-weight: bold; text-align: left;\">UNIT ORGANISASI</td>
          <td style=\"text-align: center; font-weight: bold; width: 10px;\">:</td>
          <td style=\"width: 873px; font-weight: bold;\">$UnitOrganisasi</td>
        </tr>
		<tr>
          <td style=\"width: 200px; font-weight: bold; text-align: left;\">SUB UNIT ORGANISASI</td>
          <td style=\"text-align: center; font-weight: bold; width: 10px;\">:</td>
          <td style=\"width: 873px; font-weight: bold;\">$SubUnitOrganisasi</td>
        </tr>
		<tr>
          <td style=\"width: 200px; font-weight: bold; text-align: left;\">UPB</td>
          <td style=\"text-align: center; font-weight: bold; width: 10px;\">:</td>
          <td style=\"width: 873px; font-weight: bold;\">$UPB</td>
        </tr>";
}
// echo $head;
// exit;
//start
if($tipeAset == 'all'){
	$data = array('tanahView','mesin_ori','bangunan_ori','jaringan_ori','asetlain_ori','kdp_ori');
}elseif($tipeAset == 'tanah'){
	$data = array('tanahView');
}elseif($tipeAset == 'mesin'){
	$data = array('mesin_ori');
}elseif($tipeAset == 'bangunan'){
	$data = array('bangunan_ori');
}elseif($tipeAset == 'jaringan'){
	$data = array('jaringan_ori');
}elseif($tipeAset == 'asetlain'){
	$data = array('asetlain_ori');
}elseif($tipeAset == 'kdp'){
	$data = array('kdp_ori');
}
//$data = array('tanahView');

//print_r($data);
//exit();
$hit_loop = count($data);
$i = 0;
$head ="<head>
			  <meta content=\"text/html; charset=UTF-8\"http-equiv=\"content-type\">
			  <title></title>
			</head>
			<body>
			<table style=\"text-align: left; width: 100%;\" border=\"0\"
			 cellpadding=\"2\" cellspacing=\"2\">
			  <tbody>
				<tr>
				  <td style=\"width: 150px; text-align: LEFT;\">$gmbr</td>
				  <td style=\"width: 902px; text-align: center;\">
				  <h3>REKAPITULASI RINCIAN BARANG KE NERACA</h3>
				  <h3>TAHUN $tahun_neraca</h3>
				  </td>
				</tr>
			  </tbody>
			</table>
			<br>
			<table style=\"text-align: left; width: 100%;\" border=\"0\" cellpadding=\"2\" cellspacing=\"2\">
			  <tbody>
				<tr>
				  <td style=\"width: 200px; font-weight: bold; text-align: left;\">KABUPATEN / KOTA</td>
				  <td style=\"text-align: center; font-weight: bold; width: 10px;\">:</td>
				  <td style=\"width: 873px; font-weight: bold;\">$nama_kab </td>
				</tr>
				<tr>
				  <td style=\"width: 200px; font-weight: bold; text-align: left;\">PROVINSI</td>
				  <td style=\"text-align: center; font-weight: bold; width: 10px;\">:</td>
				  <td style=\"width: 873px; font-weight: bold;\">$nama_prov</td>
				</tr>
				$header
			  </tbody>
			</table>
				<br>";
$head.=" <table style=\"width: 100%; text-align: left; margin-left: auto; margin-right: auto; border-collapse:collapse\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\; \">
	<tr>
		<td rowspan='2' colspan='5' style=\" text-align: center; font-weight: bold; width: \">Kode</td>
		<td rowspan='2' style=\" text-align: center; font-weight: bold; width: \">Uraian</td>
		<td colspan='5' style=\" text-align: center; font-weight: bold; width: \">1 Januari $tahun_neraca</td>
                <td colspan='2' style=\" text-align: center; font-weight: bold; width: \">Nilai Perolehan</td>
                <td colspan='2' style=\" text-align: center; font-weight: bold; width: \">Akumulasi Penyusutan</td>
                <td rowspan='2' style=\" text-align: center; font-weight: bold; width: \">Beban Penyusutan Tahun Berjalan</td>
                <td colspan='5' style=\" text-align: center; font-weight: bold; width: \">31 Desember $tahun_neraca</td>
                
	</tr>
        <tr>
            <td  style=\" text-align: center; font-weight: bold; width: \">Jumlah</td>
            <td  style=\" text-align: center; font-weight: bold; width: \">Nilai Perolehan</td>
            <td  style=\" text-align: center; font-weight: bold; width: \">Penyusutan PerTahun</td>
            <td  style=\" text-align: center; font-weight: bold; width: \">Akumulasi Penyusutan</td>
            <td  style=\" text-align: center; font-weight: bold; width: \">Nilai Buku</td>
            
            <td  style=\" text-align: center; font-weight: bold; width: \">Berkurang</td>
            <td  style=\" text-align: center; font-weight: bold; width: \">Bertambah</td>
            <td  style=\" text-align: center; font-weight: bold; width: \">Berkurang</td>
            <td  style=\" text-align: center; font-weight: bold; width: \">Bertambah</td>
            
            <td  style=\" text-align: center; font-weight: bold; width: \">Jumlah</td>
            <td  style=\" text-align: center; font-weight: bold; width: \">Nilai Perolehan</td>
            <td  style=\" text-align: center; font-weight: bold; width: \">Penyusutan PerTahun</td>
            <td  style=\" text-align: center; font-weight: bold; width: \">Akumulasi Penyusutan</td>
            <td  style=\" text-align: center; font-weight: bold; width: \">Nilai Buku</td>
        </tr>
	<tr>
		   <td style=\" text-align: center; font-weight: bold; width: \">1</td>
		   <td style=\" text-align: center; font-weight: bold; width: \">2</td>
		   <td style=\" text-align: center; font-weight: bold; width: \">3</td>
		   <td style=\" text-align: center; font-weight: bold; width: \">4</td>
		   <td style=\" text-align: center; font-weight: bold; width: \">5</td>
		   <td style=\" text-align: center; font-weight: bold; width: \">6</td>
		   <td style=\" text-align: center; font-weight: bold; width: \">7</td>
		   <td style=\" text-align: center; font-weight: bold; width: \">8</td>
		   <td style=\" text-align: center; font-weight: bold; width: \">9</td>
		   <td style=\" text-align: center; font-weight: bold; width: \">10</td>
		   <td style=\" text-align: center; font-weight: bold; width: \">11</td>
                   <td style=\" text-align: center; font-weight: bold; width: \">12</td>
                   <td style=\" text-align: center; font-weight: bold; width: \">13</td>
                   <td style=\" text-align: center; font-weight: bold; width: \">14</td>
                   <td style=\" text-align: center; font-weight: bold; width: \">15</td>
                   <td style=\" text-align: center; font-weight: bold; width: \">16</td>
                   <td style=\" text-align: center; font-weight: bold; width: \">17</td>
                   <td style=\" text-align: center; font-weight: bold; width: \">18</td>
                   <td style=\" text-align: center; font-weight: bold; width: \">19</td>
                   <td style=\" text-align: center; font-weight: bold; width: \">20</td>
                   <td style=\" text-align: center; font-weight: bold; width: \">21</td>
                   
	</tr>";	
//foreach ($data as $gol) {
$param_satker = $skpd_id;
$splitKodeSatker = explode ('.',$param_satker);
	if(count($splitKodeSatker) == 4){	
		$paramSatker = "kodeSatker = '$param_satker'";
	}else{
		$paramSatker = "kodeSatker like '$param_satker%'";
	}
$param_tgl = $tglakhirperolehan ;

        

		/*		$jml_total=0;
                $np_total=0;
                $pp_total=0;
                $ap_total=0;
                $nb_total=0;
                $bp_total=0;
                
                $mutasi_nilai_tambah=0;
                $mutasi_nilai_kurang=0;
                
                $mutasi_jml_tambah=0;
                $mutasi_jml_kurang=0;
                
                $mutasi_ap_tambah=0;
                $mutasi_ap_kurang=0;
                
                $mutasi_nb_tambah=0;
                $mutasi_nb_kurang=0;

                $jml_total_akhir=0;
                $np_total_akhir=0;
                $pp_total_akhir=0;
                $ap_total_akhir=0;
                $nb_total_akhir=0;*/

     foreach ($data as $gol) {
            $q_gol_final=$gol;
		$kode_golongan = $data_gol;
		$ps = $param_satker;
		$pt =$param_tgl;
		$paramLevelGol = $levelAset;
		//$data[$i]=$data_gol;
		/*if($paramLevelGol != 2){
			$data[$i]['Bidang'] = bidang($kode_golongan,$gol,$ps,$pt,$paramLevelGol);
		}*/
                $data_awal=  subsub_awal($kode_golongan, $q_gol_final, $ps, $pt);
                $data_akhir=  subsub($kode_golongan, $q_gol_final, $ps, "$tahun_neraca-12-31");
                $data_hilang=subsub_hapus($kode_golongan, $q_gol_final, $ps, "$tahun_neraca-12-31",$pt);
		//exit();
                $hasil=  group_data($data_awal, $data_akhir,$data_hilang);
               //echo "<pre>";
               //print_r($hasil);
              // exit();
                $data[$i]=$hasil;
                //head asal
				
                
		foreach($hasil as $gol)
		{	
	   
                    
                   if($gol[ap]==""||$gol[ap]==0)
						$gol[nb]=$gol[nilai];

					if($gol[ap_akhir]==""||$gol[ap_akhir]==0)
						$gol[nb_akhir]=$gol[nilai_akhir];
		    
                        $jml_total = $jml_total + $gol[jml];
			$np_total = $np_total + $gol[nilai];
			
                         $mutasi_nilai_tambah+=$gol[mutasi_nilai_tambah];
                         $mutasi_nilai_kurang+=$gol[mutasi_nilai_kurang];

                         $mutasi_jml_tambah+=$gol[mutasi_jml_tambah];
                         $mutasi_jml_kurang+=$gol[mutasi_jml_kurang];

                         $mutasi_ap_tambah+=$gol[mutasi_ap_tambah];
                         $mutasi_ap_kurang+=$gol[mutasi_ap_kurang];
                         
                         $bp=0;
                         //$bp=$gol[ap_akhir]-$gol[ap_awal]-$gol[mutasi_ap_tambah]+$gol[mutasi_ap_kurang];
                         $bp=$gol[bp];
                         $bp_total+=$bp;
                         
                         $mutasi_nb_tambah+=$gol[mutasi_nb_tambah];
                         $mutasi_nb_kurang+=$gol[mutasi_nb_kurang];
                        
                        
                        $pp_total = $pp_total + $gol[pp];
						$ap_total = $ap_total + $gol[ap];
						$nb_total = $nb_total + $gol[nb];

						$jml_total_akhir += $gol[jml_akhir];
						$np_total_akhir += $gol[nilai_akhir];
						
						$pp_total_akhir += $gol[pp_akhir];
						$ap_total_akhir += $gol[ap_akhir];
						$nb_total_akhir += $gol[nb_akhir];
		
		$body.="<tr>
					<td style=\"font-weight: bold;\">{$gol[Kelompok]}</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td style=\"font-weight: bold;\">{$gol[Uraian]}</td>
					<td style=\"text-align: center; font-weight: bold;\">{$gol[jml]}</td>
					<td style=\"font-weight: bold; text-align: right;\">".number_format($gol[nilai],2,",",".")."</td>
					<td style=\"font-weight: bold; text-align: right;\">".number_format($gol[pp],2,",",".")."</td>
					<td style=\"font-weight: bold; text-align: right;\">".number_format($gol[ap],2,",",".")."</td>
					<td style=\"font-weight: bold; text-align: right;\">".number_format($gol[nb],2,",",".")."</td> 
                                        
                                        <td style=\"text-align: center; font-weight: bold;\">".number_format($gol[mutasi_nilai_kurang],2,",",".")."</td>
					<td style=\"font-weight: bold; text-align: right;\">".number_format($gol[mutasi_nilai_tambah],2,",",".")."</td>
					<td style=\"font-weight: bold; text-align: right;\">".number_format($gol[mutasi_ap_kurang],2,",",".")."</td>
					<td style=\"font-weight: bold; text-align: right;\">".number_format($gol[mutasi_ap_tambah],2,",",".")."</td>
                                        
                                         <td style=\"font-weight: bold; text-align: right;\">".number_format($bp,2,",",".")."</td>
					
                                        <td style=\"text-align: center; font-weight: bold;\">{$gol[jml_akhir]}</td>
					<td style=\"font-weight: bold; text-align: right;\">".number_format($gol[nilai_akhir],2,",",".")."</td>
					<td style=\"font-weight: bold; text-align: right;\">".number_format($gol[pp_akhir],2,",",".")."</td>
					<td style=\"font-weight: bold; text-align: right;\">".number_format($gol[ap_akhir],2,",",".")."</td>
					<td style=\"font-weight: bold; text-align: right;\">".number_format($gol[nb_akhir],2,",",".")."</td> 
				</tr>";	
				
			foreach($gol['Bidang'] as $bidang)
			{	
			   if($bidang[ap]==""||$bidang[ap]==0)
					$bidang[nb]=$bidang[nilai];

                           $bp_bidang=0;
                          // $bp_bidang=$bidang[ap_akhir]-$bidang[ap_awal]-$bidang[mutasi_ap_tambah]+$bidang[mutasi_ap_kurang];
                            $bp_bidang=$bidang[bp];
                           
				if($bidang[ap_akhir]==""||$bidang[ap_akhir]==0)
					$bidang[nb_akhir]=$bidang[nilai_akhir];
					$body.="<tr>
								<td>&nbsp;</td>
								<td style=\"font-weight: bold;\">{$bidang[Kelompok]}</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td style=\"font-weight: bold;\">{$bidang[Uraian]}</td>
                                <td style=\"text-align: center; font-weight: bold;\">{$bidang[jml]}</td>
                                <td style=\"font-weight: bold; text-align: right;\">".number_format($bidang[nilai],2,",",".")."</td>
                                <td style=\"font-weight: bold; text-align: right;\">".number_format($bidang[pp],2,",",".")."</td>
                                <td style=\"font-weight: bold; text-align: right;\">".number_format($bidang[ap],2,",",".")."</td>
                                <td style=\"font-weight: bold; text-align: right;\">".number_format($bidang[nb],2,",",".")."</td>
                                    
                                <td style=\"text-align: center; font-weight: bold;\">".number_format($bidang[mutasi_nilai_kurang],2,",",".")."</td>
                                <td style=\"font-weight: bold; text-align: right;\">".number_format($bidang[mutasi_nilai_tambah],2,",",".")."</td>
				<td style=\"font-weight: bold; text-align: right;\">".number_format($bidang[mutasi_ap_kurang],2,",",".")."</td>
				<td style=\"font-weight: bold; text-align: right;\">".number_format($bidang[mutasi_ap_tambah],2,",",".")."</td>
				
                                <td style=\"text-align: center; font-weight: bold;\">".number_format($bp_bidang,2,",",".")."</td>
                                
                                <td style=\"text-align: center; font-weight: bold;\">{$bidang[jml_akhir]}</td>
				<td style=\"font-weight: bold; text-align: right;\">".number_format($bidang[nilai_akhir],2,",",".")."</td>
				<td style=\"font-weight: bold; text-align: right;\">".number_format($bidang[pp_akhir],2,",",".")."</td>
				<td style=\"font-weight: bold; text-align: right;\">".number_format($bidang[ap_akhir],2,",",".")."</td>
				<td style=\"font-weight: bold; text-align: right;\">".number_format($bidang[nb_akhir],2,",",".")."</td> 
							</tr>";	
				foreach($bidang['Kel'] as $Kelompok)
				{	
				   if($Kelompok[ap]==""||$Kelompok[ap]==0)
							$Kelompok[nb]=$Kelompok[nilai];

					if($Kelompok[ap_akhir]==""||$Kelompok[ap_akhir]==0)
							$Kelompok[nb_akhir]=$Kelompok[nilai_akhir];	

                                        $bp_kelompok=0;
                                        //$bp_kelompok=$Kelompok[ap_akhir]-$Kelompok[ap_awal]-$Kelompok[mutasi_ap_tambah]+$Kelompok[mutasi_ap_kurang];
                                        $bp_kelompok=$Kelompok[bp];
                                        
					$body.="<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>{$Kelompok[Kelompok]}</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>{$Kelompok[Uraian]}</td>
                                <td style=\"text-align: center;\">{$Kelompok[jml]}</td>
								<td style=\"text-align: right;\">".number_format($Kelompok[nilai],2,",",".")."</td>
								<td style=\"text-align: right;\">".number_format($Kelompok[pp],2,",",".")."</td>
								<td style=\"text-align: right;\">".number_format($Kelompok[ap],2,",",".")."</td>
								<td style=\"text-align: right;\">".number_format($Kelompok[nb],2,",",".")."</td>
		   	        <td style=\"text-align: center; font-weight: bold;\">".number_format($Kelompok[mutasi_nilai_kurang],2,",",".")."</td>
                                <td style=\"font-weight: bold; text-align: right;\">".number_format($Kelompok[mutasi_nilai_tambah],2,",",".")."</td>
				<td style=\"font-weight: bold; text-align: right;\">".number_format($Kelompok[mutasi_ap_kurang],2,",",".")."</td>
				<td style=\"font-weight: bold; text-align: right;\">".number_format($Kelompok[mutasi_ap_tambah],2,",",".")."</td>
					
                                <td style=\"text-align: center; font-weight: bold;\">".number_format($bp_kelompok,2,",",".")."</td>

                                <td style=\"text-align: center; font-weight: bold;\">{$Kelompok[jml_akhir]}</td>
				<td style=\"font-weight: bold; text-align: right;\">".number_format($Kelompok[nilai_akhir],2,",",".")."</td>
				<td style=\"font-weight: bold; text-align: right;\">".number_format($Kelompok[pp_akhir],2,",",".")."</td>
				<td style=\"font-weight: bold; text-align: right;\">".number_format($Kelompok[ap_akhir],2,",",".")."</td>
				<td style=\"font-weight: bold; text-align: right;\">".number_format($Kelompok[nb_akhir],2,",",".")."</td> 
						
                                        </tr>";
					foreach($Kelompok['Sub'] as $Sub)
					{	
						if($Sub[ap]==""||$Sub[ap]==0)
							$Sub[nb]=$Sub[nilai];

						if($Sub[ap_akhir]==""||$Sub[ap_akhir]==0)
							$Sub[nb_akhir]=$Sub[nilai_akhir];

                                                $bp_sub=0;
                                                //$bp_sub=$Sub[ap_akhir]-$Sub[ap_awal]-$Sub[mutasi_ap_tambah]+$Sub[mutasi_ap_kurang];
                                                $bp_sub=$Sub[bp];
                                                
							$body.="<tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>{$Sub[Kelompok]}</td>
										<td>&nbsp;</td>
										<td>{$Sub[Uraian]}</td>
										<td style=\"text-align: center;\">{$Sub[jml]}</td>
										<td style=\"text-align: right;\">".number_format($Sub[nilai],2,",",".")."</td>
										<td style=\"text-align: right;\">".number_format($Sub[pp],2,",",".")."</td>
										<td style=\"text-align: right;\">".number_format($Sub[ap],2,",",".")."</td>
										<td style=\"text-align: right;\">".number_format($Sub[nb],2,",",".")."</td>
                                                                                    
                                <td style=\"text-align: center; font-weight: bold;\">".number_format($Sub[mutasi_nilai_kurang],2,",",".")."</td>
                                <td style=\"font-weight: bold; text-align: right;\">".number_format($Sub[mutasi_nilai_tambah],2,",",".")."</td>
				<td style=\"font-weight: bold; text-align: right;\">".number_format($Sub[mutasi_ap_kurang],2,",",".")."</td>
				<td style=\"font-weight: bold; text-align: right;\">".number_format($Sub[mutasi_ap_tambah],2,",",".")."</td>
				
                                <td style=\"text-align: center; font-weight: bold;\">".number_format($bp_sub,2,",",".")."</td>
                                    
                                <td style=\"text-align: center; font-weight: bold;\">{$Sub[jml_akhir]}</td>
				<td style=\"font-weight: bold; text-align: right;\">".number_format($Sub[nilai_akhir],2,",",".")."</td>
				<td style=\"font-weight: bold; text-align: right;\">".number_format($Sub[pp_akhir],2,",",".")."</td>
				<td style=\"font-weight: bold; text-align: right;\">".number_format($Sub[ap_akhir],2,",",".")."</td>
				<td style=\"font-weight: bold; text-align: right;\">".number_format($Sub[nb_akhir],2,",",".")."</td> 

									</tr>";
						foreach($Sub['SubSub'] as $SubSub)
						{	 
							if($SubSub[ap]==""||$SubSub[ap]==0)
								$SubSub[nb]=$SubSub[nilai];

							if($SubSub[ap_akhir]==""||$SubSub[ap_akhir]==0)
								$SubSub[nb_akhir]=$SubSub[nilai_akhir];
                                                        
                                                        $bp_subsub=0;
                                                        //$bp_subsub=$SubSub[ap_akhir]-$SubSub[ap_awal]-$SubSub[mutasi_ap_tambah]+$SubSub[mutasi_ap_kurang];
                                                       $bp_subsub=$SubSub[bp];
                                                        //$SubSub[mutasi_ap_tambah]-$SubSub[mutasi_ap_kurang];
                                                        
								$body.="<tr>
											<td>&nbsp;</td>
											<td>&nbsp;</td>
											<td>&nbsp;</td>
											<td>&nbsp;</td>
											<td>{$SubSub[Kelompok]}</td>
											<td>{$SubSub[Uraian]}</td>
                                            <td style=\"text-align: center;\">{$SubSub[jml]}</td>
											<td style=\"text-align: right;\">".number_format($SubSub[nilai],2,",",".")."</td>
											<td style=\"text-align: right;\">".number_format($SubSub[pp],2,",",".")."</td>
											<td style=\"text-align: right;\">".number_format($SubSub[ap],2,",",".")."</td>
											<td style=\"text-align: right;\">".number_format($SubSub[nb],2,",",".")."</td>
                                                                                            
<td style=\"text-align: center; font-weight: bold;\">".number_format($SubSub[mutasi_nilai_kurang],2,",",".")."</td>
                                <td style=\"font-weight: bold; text-align: right;\">".number_format($SubSub[mutasi_nilai_tambah],2,",",".")."</td>
				<td style=\"font-weight: bold; text-align: right;\">".number_format($SubSub[mutasi_ap_kurang],2,",",".")."</td>
				<td style=\"font-weight: bold; text-align: right;\">".number_format($SubSub[mutasi_ap_tambah],2,",",".")."</td>
				
                                <td style=\"font-weight: bold; text-align: right;\">".number_format($bp_subsub,2,",",".")."</td>
    

                                <td style=\"text-align: center; font-weight: bold;\">{$SubSub[jml_akhir]}</td>
				<td style=\"font-weight: bold; text-align: right;\">".number_format($SubSub[nilai_akhir],2,",",".")."</td>
				<td style=\"font-weight: bold; text-align: right;\">".number_format($SubSub[pp_akhir],2,",",".")."</td>
				<td style=\"font-weight: bold; text-align: right;\">".number_format($SubSub[ap_akhir],2,",",".")."</td>
				<td style=\"font-weight: bold; text-align: right;\">".number_format($SubSub[nb_akhir],2,",",".")."</td> 

										</tr>";
						}
					}
				}
			
			}
		}
                $i++;
	
	}
	
	
	if($i == $hit_loop){
		$foot="<tr>
				<td colspan = \"6\" style=\"text-align: center; font-weight: bold;\">Total</td>
				<td style=\"text-align: center; font-weight: bold;\">".number_format($jml_total,0,",",".")."</td>
				<td style=\"text-align: right; font-weight: bold;\">".number_format($np_total,2,",",".")."</td>
				<td style=\"text-align: right; font-weight: bold;\">".number_format($pp_total,2,",",".")."</td>
				<td style=\"text-align: right; font-weight: bold;\">".number_format($ap_total,2,",",".")."</td>
				<td style=\"text-align: right; font-weight: bold;\">".number_format($nb_total,2,",",".")."</td>

				<td style=\"text-align: center; font-weight: bold;\">".number_format($mutasi_nilai_kurang,2,",",".")."</td>
				<td style=\"text-align: right; font-weight: bold;\">".number_format($mutasi_nilai_tambah,2,",",".")."</td>
				<td style=\"text-align: right; font-weight: bold;\">".number_format($mutasi_ap_kurang,2,",",".")."</td>
				<td style=\"text-align: right; font-weight: bold;\">".number_format($mutasi_ap_tambah,2,",",".")."</td>

                                <td style=\"text-align: center; font-weight: bold;\">".number_format($bp_total,2,",",".")."</td>
    
				<td style=\"text-align: center; font-weight: bold;\">".number_format($jml_total_akhir,0,",",".")."</td>
				<td style=\"text-align: right; font-weight: bold;\">".number_format($np_total_akhir,2,",",".")."</td>
				<td style=\"text-align: right; font-weight: bold;\">".number_format($pp_total_akhir,2,",",".")."</td>
				<td style=\"text-align: right; font-weight: bold;\">".number_format($ap_total_akhir,2,",",".")."</td>
				<td style=\"text-align: right; font-weight: bold;\">".number_format($nb_total_akhir,2,",",".")."</td>
			</tr>
		</table>";
	}else{
		$foot= '';
	}
	$html =$head.$body.$foot;
	
  
//}

function subsub_awal($kode,$gol,$ps,$pt) {
$param_satker = $ps;
$splitKodeSatker = explode ('.',$param_satker);
if(count($splitKodeSatker) == 4){	
	$paramSatker = "kodeSatker = '$param_satker'";
}else{
	$paramSatker = "kodeSatker like '$param_satker%'";
}
$param_tgl = $pt;   
if($gol == 'mesin_ori'){
	$param_where = "Status_Validasi_barang=1 and StatusTampil = 1 and kondisi != '3'  and 
				( (TglPerolehan < '2008-01-01' and TglPembukuan <= '$param_tgl' and kodeLokasi like '12%' and kodeKa=1) or 
				  (TglPerolehan >= '2008-01-01' and TglPembukuan <= '$param_tgl'  and kodeLokasi like '12%' and (NilaiPerolehan >=1000000 or kodeKa=1)))
				 and $paramSatker";
 
      $sql = "select  kodeKelompok as kelompok,Aset_ID,
               NilaiPerolehan as nilai,Status_Validasi_barang as jml,
               PenyusutanPerTahun as PP,Tahun as Tahun, noRegister as noRegister,
               AkumulasiPenyusutan as AP, NilaiBuku as NB,
               (select Uraian from kelompok 
               where kode= kodeKelompok 
               ) as Uraian,
               Status_Validasi_barang,kodeSatker from $gol m
                where kodeKelompok like '$kode_sub%' and
                 $param_where    
               order by kelompok asc";
}elseif($gol == 'bangunan_ori'){
	$param_where = "Status_Validasi_barang=1 and StatusTampil = 1 and kondisi != '3'  and 
				( (TglPerolehan < '2008-01-01' and TglPembukuan <= '$param_tgl' and kodeLokasi like '12%' and kodeKa=1) or 
				  (TglPerolehan >= '2008-01-01' and TglPembukuan <= '$param_tgl' and kodeLokasi like '12%' and (NilaiPerolehan >=20000000  or kodeKa=1)))
				 and $paramSatker";
	 
	$sql = "select  kodeKelompok as kelompok,Aset_ID,
               NilaiPerolehan as nilai,Status_Validasi_barang as jml,
               PenyusutanPerTahun as PP,Tahun as Tahun, noRegister as noRegister,
               AkumulasiPenyusutan as AP, NilaiBuku as NB,
               (select Uraian from kelompok 
               where kode= kodeKelompok 
               ) as Uraian,
               Status_Validasi_barang,kodeSatker from $gol m
                where kodeKelompok like '$kode_sub%' and
                 $param_where    
               order by kelompok asc";
}else{
	if($gol!="tanahView")
		  $param_where = "Status_Validasi_barang=1 and StatusTampil = 1  
					 and TglPerolehan <= '$param_tgl' 
					 and TglPembukuan <='$param_tgl' 
					 and kodeLokasi like '12%' 
					 and kondisi != '3'					 
					 and $paramSatker";
		else
		    $param_where = "Status_Validasi_barang=1 and StatusTampil = 1  
					 and TglPerolehan <= '$param_tgl' 
					 and TglPembukuan <='$param_tgl' 
					 and kodeLokasi like '12%' 
					 and $paramSatker";
	 
	 if($gol == 'jaringan_ori'){
		$sql = "select  kodeKelompok as kelompok,Aset_ID,
               NilaiPerolehan as nilai,Status_Validasi_barang as jml,
               PenyusutanPerTahun as PP,Tahun as Tahun, noRegister as noRegister,
               AkumulasiPenyusutan as AP, NilaiBuku as NB,
               (select Uraian from kelompok 
               where kode= kodeKelompok 
               ) as Uraian,
               Status_Validasi_barang,kodeSatker from $gol m
                where kodeKelompok like '$kode_sub%' and
                 $param_where    
               order by kelompok asc";
	 }else{
		$sql = "select  kodeKelompok as kelompok,Tahun as Tahun, noRegister as noRegister,Aset_ID,
               NilaiPerolehan as nilai,Status_Validasi_barang as jml,
              (select Uraian from kelompok 
               where kode= kodeKelompok 
               ) as Uraian,
               Status_Validasi_barang,kodeSatker from $gol m
                where kodeKelompok like '$kode_sub%' and
                 $param_where    
               order by kelompok asc";
	 }
}
	 //echo "$gol == $sql";
     $resultparentSubSub = mysql_query($sql) or die(mysql_error());
     $data = array();
     while ($data_subsub = mysql_fetch_array($resultparentSubSub,MYSQL_ASSOC)) {
          $data[] = $data_subsub;
     }
     return $data;
}


function subsub($kode,$gol,$ps,$pt) {
$param_satker = $ps;
$splitKodeSatker = explode ('.',$param_satker);
if(count($splitKodeSatker) == 4){	
	$paramSatker = "kodeSatker = '$param_satker'";
}else{
	$paramSatker = "kodeSatker like '$param_satker%'";
}
$param_tgl = $pt;   
if($gol == 'mesin_ori'){
    $gol="mesin";
	$param_where = "Status_Validasi_barang=1 and StatusTampil = 1 and kondisi != '3'  and 
				( (TglPerolehan < '2008-01-01' and TglPembukuan <= '$param_tgl' and kodeLokasi like '12%' and kodeKa=1) or 
				  (TglPerolehan >= '2008-01-01' and TglPembukuan <= '$param_tgl'  and kodeLokasi like '12%' and (NilaiPerolehan >=1000000 or kodeKa=1)))
				 and $paramSatker";
 
      $sql = "select  kodeKelompok as kelompok,Aset_ID,TahunPenyusutan,
               NilaiPerolehan as nilai,Status_Validasi_barang as jml,
               PenyusutanPerTahun as PP,Tahun as Tahun, noRegister as noRegister,
               AkumulasiPenyusutan as AP, NilaiBuku as NB,
               (select Uraian from kelompok 
               where kode= kodeKelompok 
               ) as Uraian,
               Status_Validasi_barang,kodeSatker from $gol m
                where kodeKelompok like '$kode_sub%' and
                 $param_where    
               order by kelompok asc";
}elseif($gol == 'bangunan_ori'){
    $gol="bangunan";
	$param_where = "Status_Validasi_barang=1 and StatusTampil = 1 and kondisi != '3'  and 
				( (TglPerolehan < '2008-01-01' and TglPembukuan <= '$param_tgl' and kodeLokasi like '12%' and kodeKa=1) or 
				  (TglPerolehan >= '2008-01-01' and TglPembukuan <= '$param_tgl' and kodeLokasi like '12%' and (NilaiPerolehan >=20000000  or kodeKa=1)))
				 and $paramSatker";
	 
	$sql = "select  kodeKelompok as kelompok,Aset_ID,TahunPenyusutan,
               NilaiPerolehan as nilai,Status_Validasi_barang as jml,
               PenyusutanPerTahun as PP,Tahun as Tahun, noRegister as noRegister,
               AkumulasiPenyusutan as AP, NilaiBuku as NB,
               (select Uraian from kelompok 
               where kode= kodeKelompok 
               ) as Uraian,
               Status_Validasi_barang,kodeSatker from $gol m
                where kodeKelompok like '$kode_sub%' and
                 $param_where    
               order by kelompok asc";
}else{
	if($gol!="tanahView")
		  $param_where = "Status_Validasi_barang=1 and StatusTampil = 1  
					 and TglPerolehan <= '$param_tgl' 
					 and TglPembukuan <='$param_tgl' 
					 and kodeLokasi like '12%' 
					 and kondisi != '3'					 
					 and $paramSatker";
		else
		    $param_where = "Status_Validasi_barang=1 and StatusTampil = 1  
					 and TglPerolehan <= '$param_tgl' 
					 and TglPembukuan <='$param_tgl' 
					 and kodeLokasi like '12%' 
					  and kondisi != '3'	
					 and $paramSatker";
	 
	 if($gol == 'jaringan_ori'){
             $gol="jaringan";
		$sql = "select  kodeKelompok as kelompok,Aset_ID,TahunPenyusutan,
               NilaiPerolehan as nilai,Status_Validasi_barang as jml,
               PenyusutanPerTahun as PP,Tahun as Tahun, noRegister as noRegister,
               AkumulasiPenyusutan as AP, NilaiBuku as NB,
               (select Uraian from kelompok 
               where kode= kodeKelompok 
               ) as Uraian,
               Status_Validasi_barang,kodeSatker from $gol m
                where kodeKelompok like '$kode_sub%' and
                 $param_where    
               order by kelompok asc";
	 }else{
             if($gol=="kdp_ori")
                 $gol="kdp";
             else if($gol=="tanahView")
                 $gol="tanah";
             else  $gol="asetlain";
             
		$sql = "select  kodeKelompok as kelompok,Tahun as Tahun, noRegister as noRegister,Aset_ID,
               NilaiPerolehan as nilai,Status_Validasi_barang as jml,
                (select Uraian from kelompok 
               where kode= kodeKelompok 
               ) as Uraian,
               Status_Validasi_barang,kodeSatker from $gol m
                where kodeKelompok like '$kode_sub%' and
                 $param_where    
               order by kelompok asc";
	 }
}
	 
//echo "$gol == $sql";
     $resultparentSubSub = mysql_query($sql) or die(mysql_error());
     $data = array();
     while ($data_subsub = mysql_fetch_array($resultparentSubSub,MYSQL_ASSOC)) {
          $data[] = $data_subsub;
     }
     return $data;
}


function subsub_hapus($kode,$gol,$ps,$pt,$tgl_pem) {
$param_satker = $ps;
$splitKodeSatker = explode ('.',$param_satker);
if(count($splitKodeSatker) == 4){	
	$paramSatker = "m.kodeSatker = '$param_satker'";
}else{
	$paramSatker = "m.kodeSatker like '$param_satker%'";
}
$param_tgl = $pt;   
if($gol == 'mesin_ori'){
    $gol="mesin";
    //cek kapitalisasi
    $kapitalisasi_kondisi=" and m.Aset_ID not in(select Aset_ID from log_$gol where  `action` LIKE 'Sukses kapitalisasi Mutasi%') ";

    $param_where = "m.Status_Validasi_barang!=1 and m.StatusTampil != 1 and m.kondisi != '3'  and 
				( (m.TglPerolehan < '2008-01-01' and m.TglPembukuan <= '$param_tgl' and m.TglPembukuan > '$tgl_pem' and m.kodeLokasi like '12%' and m.kodeKa=1) or 
				  (m.TglPerolehan >= '2008-01-01' and m.TglPembukuan <= '$param_tgl'  and m.TglPembukuan > '$tgl_pem' and m.kodeLokasi like '12%' and (m.NilaiPerolehan >=1000000 or m.kodeKa=1)))
				 and $paramSatker";
        
     
        
        
      $sql = "select  m.kodeKelompok as kelompok,m.Aset_ID,m.TahunPenyusutan,
               l.NilaiPerolehan as nilai,m.Status_Validasi_barang as jml,
               m.PenyusutanPerTahun as PP,m.Tahun as Tahun, m.noRegister as noRegister,
               m.AkumulasiPenyusutan as AP, m.NilaiBuku as NB,
               (select Uraian from kelompok 
               where kode= m.kodeKelompok 
               ) as Uraian,
               m.Status_Validasi_barang,m.kodeSatker from $gol m 
                   inner join log_$gol as l on  l.Aset_ID=m.Aset_ID and l.TglPerubahan > '$tgl_pem' and l.kd_riwayat=3 and `action` like 'Sukses Mutasi%' 
                where m.kodeKelompok like '$kode_sub%' and
                 $param_where $kapitalisasi_kondisi   
               order by kelompok asc";
}elseif($gol == 'bangunan_ori'){
    $gol="bangunan";
     //cek kapitalisasi
    $kapitalisasi_kondisi=" and m.Aset_ID not in(select Aset_ID from log_$gol where  `action` LIKE 'Sukses kapitalisasi Mutasi%') ";

	$param_where = "m.Status_Validasi_barang!=1 and m.StatusTampil != 1 and m.kondisi != '3'  and 
				( (m.TglPerolehan < '2008-01-01' and m.TglPembukuan <= '$param_tgl' and m.TglPembukuan > '$tgl_pem' and m.kodeLokasi like '12%' and m.kodeKa=1) or 
				  (m.TglPerolehan >= '2008-01-01' and m.TglPembukuan <= '$param_tgl' and m.TglPembukuan > '$tgl_pem' and m.kodeLokasi like '12%' and (m.NilaiPerolehan >=20000000  or m.kodeKa=1)))
				 and $paramSatker";
	 
	$sql = "select  m.kodeKelompok as kelompok,m.Aset_ID,m.TahunPenyusutan,
               l.NilaiPerolehan as nilai,m.Status_Validasi_barang as jml,
               m.PenyusutanPerTahun as PP,m.Tahun as Tahun, m.noRegister as noRegister,
               m.AkumulasiPenyusutan as AP, m.NilaiBuku as NB,
               (select Uraian from kelompok 
               where kode= m.kodeKelompok 
               ) as Uraian,
               m.Status_Validasi_barang,m.kodeSatker from $gol m 
                    inner join log_$gol as l on  l.Aset_ID=m.Aset_ID and l.TglPerubahan > '$tgl_pem' and l.kd_riwayat=3 and `action` like 'Sukses Mutasi%' 
                where m.kodeKelompok like '$kode_sub%' and
                 $param_where   $kapitalisasi_kondisi 
               order by kelompok asc";
}else{
	if($gol!="tanahView")
		  $param_where = "m.Status_Validasi_barang!=1 and m.StatusTampil != 1  
					 and m.TglPerolehan <= '$param_tgl' and m.TglPembukuan > '$tgl_pem' and l.kd_riwayat=3 and `action` like 'Sukses Mutasi%' 
					 and m.TglPembukuan <='$param_tgl' 
					 and m.kodeLokasi like '12%' 
					 and m.kondisi != '3'					 
					 and $paramSatker";
		else
		    $param_where = "m.Status_Validasi_barang!=1 and m.StatusTampil != 1  
					 and m.TglPerolehan <= '$param_tgl' and m.TglPembukuan > '$tgl_pem' and l.kd_riwayat=3 and `action` like 'Sukses Mutasi%' 
					 and m.TglPembukuan <='$param_tgl' 
					 and m.kodeLokasi like '12%' 
					 and $paramSatker";
	 
	 if($gol == 'jaringan_ori'){
             
             $gol="jaringan";
              //cek kapitalisasi
    $kapitalisasi_kondisi=" and m.Aset_ID not in(select Aset_ID from log_$gol where  `action` LIKE 'Sukses kapitalisasi Mutasi%') ";

		$sql = "select  m.kodeKelompok as kelompok,m.Aset_ID,m.TahunPenyusutan,
               l.NilaiPerolehan as nilai,m.Status_Validasi_barang as jml,
               m.PenyusutanPerTahun as PP,m.Tahun as Tahun, m.noRegister as noRegister,
               m.AkumulasiPenyusutan as AP, m.NilaiBuku as NB,
               (select Uraian from kelompok 
               where kode= m.kodeKelompok 
               ) as Uraian,
               m.Status_Validasi_barang,m.kodeSatker from $gol m 
                    inner join log_$gol as l on  l.Aset_ID=m.Aset_ID and l.TglPerubahan > '$tgl_pem' and l.kd_riwayat=3  and `action` like 'Sukses Mutasi%' 
                where m.kodeKelompok like '$kode_sub%' and
                 $param_where    $kapitalisasi_kondisi
               order by kelompok asc";
	 }else{
             if($gol=="kdp_ori")
                 $gol="kdp";
             else if($gol=="tanahView")
                 $gol="tanah";
             else  $gol="asetlain";
             
                 //cek kapitalisasi
    $kapitalisasi_kondisi=" and m.Aset_ID not in(select Aset_ID from log_$gol where  `action` LIKE 'Sukses kapitalisasi Mutasi%') ";

		$sql = "select  m.kodeKelompok as kelompok,m.Tahun as Tahun, m.noRegister as noRegister,
                    m.Aset_ID,
               m.NilaiPerolehan as nilai,m.Status_Validasi_barang as jml,
                (select Uraian from kelompok 
               where kode= m.kodeKelompok 
               ) as Uraian,
               m.Status_Validasi_barang,m.kodeSatker from $gol m 
                   inner join log_$gol as l on  l.Aset_ID=m.Aset_ID and l.TglPerubahan > '$tgl_pem' and l.kd_riwayat=3  and `action` like 'Sukses Mutasi%' 
                where m.kodeKelompok like '$kode_sub%' and
                 $param_where    $kapitalisasi_kondisi
               order by kelompok asc";
	 }
}
	 
//echo "$gol == $sql";
     $resultparentSubSub = mysql_query($sql) or die(mysql_error());
     $data = array();
     while ($data_subsub = mysql_fetch_array($resultparentSubSub,MYSQL_ASSOC)) {
          $data[] = $data_subsub;
     }
     return $data;
}

// exit;
if($tipe=="3"){
	echo $serviceJson;
	exit;
}elseif($tipe!="2"){
$REPORT->show_status_download_kib();
$mpdf=new mPDF('','','','',15,15,16,16,9,9,'L');
$mpdf->AddPage('L','','','','',15,15,16,16,9,9);
$mpdf->setFooter('{PAGENO}') ;
$mpdf->progbar_heading = '';
$mpdf->StartProgressBarOutput(2);
$mpdf->useGraphs = true;
$mpdf->list_number_suffix = ')';
$mpdf->hyphenate = true;
//$mpdf->debug = true;
//print output pdf
$mpdf->WriteHTML($html);
$count = count($html);
	for ($i = 0; $i < $count; $i++) {
		 if($i==0)
			  $mpdf->WriteHTML($html[$i]);
		 else
		 {
			   $mpdf->AddPage('L','','','','',15,15,16,16,9,9);
			   $mpdf->WriteHTML($html[$i]);
			   
		 }
	}
$waktu=date("d-m-y_h-i-s");
$namafile="$path/report/output/Rekapitulasi-Detail-Rincian-Mutasi-Barang-Ke-Neraca_$skpd_id-$tahun_neraca-$waktu.pdf";
$mpdf->Output("$namafile",'F');
$namafile_web="$url_rewrite/report/output/Rekapitulasi-Rincian-Mutasi-Barang-Ke-Neraca_$skpd_id-$tahun_neraca$waktu.pdf";
echo "<script>window.location.href='$namafile_web';</script>";
exit;
}
else
{
	$waktu=date("d-m-y_h:i:s");
	$filename ="Rekapitulasi-Detail-Rincian-Mutasi-Barang-Ke-Neraca_$skpd_id-$tahun_neraca-$waktu.xls";
	header('Content-type: application/ms-excel');
	header('Content-Disposition: attachment; filename='.$filename);
	echo $html; 
}

function group_data($data_awal_perolehan,$data_akhir_perolehan,$data_hapus_awal){
    
    //tes
 $data_awal = array();

foreach($data_awal_perolehan as $arg)
{
    $data_awal[$arg['kelompok'].'.'.$arg['Tahun'].'-'.$arg['noRegister'].'-'.$arg['Aset_ID']]['Kelompok']= $arg['kelompok'];
    
    $data_awal[$arg['kelompok'].'.'.$arg['Tahun'].'-'.$arg['noRegister'].'-'.$arg['Aset_ID']]['TahunPenyusutan']= $arg['TahunPenyusutan'];
    $data_awal[$arg['kelompok'].'.'.$arg['Tahun'].'-'.$arg['noRegister'].'-'.$arg['Aset_ID']]['Aset_ID']= $arg['Aset_ID'];
    $data_awal[$arg['kelompok'].'.'.$arg['Tahun'].'-'.$arg['noRegister'].'-'.$arg['Aset_ID']]['Tahun']= $arg['Tahun'];
    
    $data_awal[$arg['kelompok'].'.'.$arg['Tahun'].'-'.$arg['noRegister'].'-'.$arg['Aset_ID']]['Uraian']= $arg['Uraian'];
    $data_awal[$arg['kelompok'].'.'.$arg['Tahun'].'-'.$arg['noRegister'].'-'.$arg['Aset_ID']]['nilai']+= $arg['nilai'];
    $data_awal[$arg['kelompok'].'.'.$arg['Tahun'].'-'.$arg['noRegister'].'-'.$arg['Aset_ID']]['PP']+= $arg['PP'];
    $data_awal[$arg['kelompok'].'.'.$arg['Tahun'].'-'.$arg['noRegister'].'-'.$arg['Aset_ID']]['AP']+= $arg['AP'];
    $data_awal[$arg['kelompok'].'.'.$arg['Tahun'].'-'.$arg['noRegister'].'-'.$arg['Aset_ID']]['NB']+= $arg['NB'];
    $data_awal[$arg['kelompok'].'.'.$arg['Tahun'].'-'.$arg['noRegister'].'-'.$arg['Aset_ID']]['jml']+= 1;
}

 $data_akhir = array();

foreach($data_akhir_perolehan as $arg)
{
    $data_akhir[$arg['kelompok'].'.'.$arg['Tahun'].'-'.$arg['noRegister'].'-'.$arg['Aset_ID']]['Kelompok']+= $arg['kelompok'];
    
    $data_akhir[$arg['kelompok'].'.'.$arg['Tahun'].'-'.$arg['noRegister'].'-'.$arg['Aset_ID']]['TahunPenyusutan']= $arg['TahunPenyusutan'];
    $data_akhir[$arg['kelompok'].'.'.$arg['Tahun'].'-'.$arg['noRegister'].'-'.$arg['Aset_ID']]['Aset_ID']= $arg['Aset_ID'];
    $data_akhir[$arg['kelompok'].'.'.$arg['Tahun'].'-'.$arg['noRegister'].'-'.$arg['Aset_ID']]['Tahun']= $arg['Tahun'];
    
    $data_akhir[$arg['kelompok'].'.'.$arg['Tahun'].'-'.$arg['noRegister'].'-'.$arg['Aset_ID']]['Uraian']= $arg['Uraian'];
    $data_akhir[$arg['kelompok'].'.'.$arg['Tahun'].'-'.$arg['noRegister'].'-'.$arg['Aset_ID']]['nilai']+= $arg['nilai'];
    $data_akhir[$arg['kelompok'].'.'.$arg['Tahun'].'-'.$arg['noRegister'].'-'.$arg['Aset_ID']]['PP']+= $arg['PP'];
    $data_akhir[$arg['kelompok'].'.'.$arg['Tahun'].'-'.$arg['noRegister'].'-'.$arg['Aset_ID']]['AP']+= $arg['AP'];
    $data_akhir[$arg['kelompok'].'.'.$arg['Tahun'].'-'.$arg['noRegister'].'-'.$arg['Aset_ID']]['NB']+= $arg['NB'];
    $data_akhir[$arg['kelompok'].'.'.$arg['Tahun'].'-'.$arg['noRegister'].'-'.$arg['Aset_ID']]['jml']+= 1;
}

$data_hapus_tmp = array();

foreach($data_hapus_awal as $arg)
{
     $data_hapus_tmp[$arg['kelompok'].'.'.$arg['Tahun'].'-'.$arg['noRegister'].'-'.$arg['Aset_ID']]['Kelompok']+= $arg['kelompok'];
    $data_hapus_tmp[$arg['kelompok'].'.'.$arg['Tahun'].'-'.$arg['noRegister'].'-'.$arg['Aset_ID']]['Uraian']+= $arg['Uraian'];
    $data_hapus_tmp[$arg['kelompok'].'.'.$arg['Tahun'].'-'.$arg['noRegister'].'-'.$arg['Aset_ID']]['nilai']+= $arg['nilai'];
    $data_hapus_tmp[$arg['kelompok'].'.'.$arg['Tahun'].'-'.$arg['noRegister'].'-'.$arg['Aset_ID']]['PP']+= $arg['PP'];
    $data_hapus_tmp[$arg['kelompok'].'.'.$arg['Tahun'].'-'.$arg['noRegister'].'-'.$arg['Aset_ID']]['AP']+= $arg['AP'];
    $data_hapus_tmp[$arg['kelompok'].'.'.$arg['Tahun'].'-'.$arg['noRegister'].'-'.$arg['Aset_ID']]['NB']+= $arg['NB'];
    $data_hapus_tmp[$arg['kelompok'].'.'.$arg['Tahun'].'-'.$arg['noRegister'].'-'.$arg['Aset_ID']]['jml']+= 1;
}
   
    
 $result=array_intersect($data_awal,$data_akhir);
//memasukan nilai selisih
$data_gabungan=array();
foreach ($result as $key =>$value){
    $tipe=  $key;
    $selisih_nilai=$data_akhir[$tipe]['nilai']-$data_awal[$tipe]['nilai'];
    $selisih_jml=$data_akhir[$tipe]['jml']-$data_awal[$tipe]['jml'];
    $selisih_ap=$data_akhir[$tipe]['AP']-$data_awal[$tipe]['AP'];
    $selisih_pp=$data_akhir[$tipe]['PP']-$data_awal[$tipe]['PP'];
    $selisih_nb=$data_akhir[$tipe]['NB']-$data_awal[$tipe]['NB'];
    
    
    
    
    
    $selisih_nilai_tambah=0;
    $selisih_nilai_kurang=0;
    $selisih_jml_tambah=0;
    $selisih_jml_kurang=0;
    $selisih_ap_tambah=0;
    $selisih_ap_kurang=0;
    $selisih_nb_tambah=0;
    $selisih_nb_kurang=0;
    $selisih_pp_tambah=0;
    $selisih_pp_kurang=0;
    
    
    
    if($selisih_nilai<0)
        $selisih_nilai_kurang=abs($selisih_nilai);
    else $selisih_nilai_tambah=$selisih_nilai;
    
    if($selisih_jml<0)
        $selisih_jml_kurang=abs($selisih_jml);
    else $selisih_jml_tambah=$selisih_jml;
    
    
    if($data_akhir[$tipe]['nilai']!=0 && $data_awal[$tipe]['nilai']!=0 && $selisih_nilai!=0){
        if($selisih_ap<0)
           $selisih_ap_kurang=abs($selisih_ap);
       else $selisih_ap_tambah=$selisih_ap;
    }
    
    if($data_akhir[$tipe]['AP']==""||$data_akhir[$tipe]['AP']==0)
       $selisih_ap_kurang=abs($selisih_ap);
   else if($data_awal[$tipe]['AP']==""||$data_awal[$tipe]['AP']==0)
       $selisih_ap_tambah=$selisih_ap;
   
    $data_gabungan[$tipe]['bp']=$selisih_ap-$selisih_ap_tambah+$selisih_ap_kurang;
    
    if($selisih_nb<0)
        $selisih_nb_kurang=abs($selisih_nb);
    else
        $selisih_nb_tambah=$selisih_nb;
    
    if($selisih_pp<0)
        $selisih_pp_kurang=$selisih_pp;
    else
        $selisih_pp_tambah=$selisih_pp;
    
    $data_gabungan[$tipe]['Kelompok']=$tipe;
    $data_gabungan[$tipe]['Uraian']=$data_awal[$tipe]['Uraian'];
    $data_gabungan[$tipe]['nilai']=$data_awal[$tipe]['nilai'];
    $data_gabungan[$tipe]['jml']=$data_awal[$tipe]['jml'];
    $data_gabungan[$tipe]['ap']=$data_awal[$tipe]['AP'];
    $data_gabungan[$tipe]['pp']=$data_awal[$tipe]['PP'];
    $data_gabungan[$tipe]['nb']=$data_awal[$tipe]['NB'];
    $data_gabungan[$tipe]['mutasi_jml_tambah']=$selisih_jml_tambah;
    $data_gabungan[$tipe]['mutasi_jml_kurang']=$selisih_jml_kurang;
    
    $data_gabungan[$tipe]['mutasi_ap_tambah']=$selisih_ap_tambah;
     $data_gabungan[$tipe]['mutasi_ap_kurang']=$selisih_ap_kurang;
     
    $data_gabungan[$tipe]['mutasi_pp_tambah']=$selisih_pp_tambah;
    $data_gabungan[$tipe]['mutasi_pp_kurang']=$selisih_pp_kurang;
    
    $data_gabungan[$tipe]['mutasi_nb_tambah']=$selisih_nb_tambah;
    $data_gabungan[$tipe]['mutasi_nb_kurang']=$selisih_nb_kurang;
    
    $data_gabungan[$tipe]['mutasi_nilai_tambah']=$selisih_nilai_tambah;
    $data_gabungan[$tipe]['mutasi_nilai_kurang']=$selisih_nilai_kurang;
    
    $data_gabungan[$tipe]['nilai_akhir']=$data_akhir[$tipe]['nilai'];
    $data_gabungan[$tipe]['jml_akhir']=$data_akhir[$tipe]['jml'];
    $data_gabungan[$tipe]['ap_akhir']=$data_akhir[$tipe]['AP'];
    $data_gabungan[$tipe]['pp_akhir']=$data_akhir[$tipe]['PP'];
    $data_gabungan[$tipe]['nb_akhir']=$data_akhir[$tipe]['NB'];

    
    
}
//echo "array gabungan:<br/><pre>";
//print_r($result);

//hitung yang tidak masuk dalam intersection
$data_awal_alone=array_diff_assoc($data_awal,$data_gabungan);
//echo "array awal sendiri:<br/><pre>";
//print_r($data_awal_alone);

$data_awal=array();
foreach ($data_awal_alone as $tipe => $value) {
    $data_awal[$tipe]['Kelompok']=$tipe;
    $data_awal[$tipe]['Uraian']=$value['Uraian'];
    $data_awal[$tipe]['nilai']=$value['nilai'];
    $data_awal[$tipe]['jml']=$value['jml'];
    $data_awal[$tipe]['ap']=$value['AP'];
    $data_awal[$tipe]['pp']=$value['PP'];
    $data_awal[$tipe]['nb']=$value['NB'];
    $data_awal[$tipe]['mutasi_nilai_tambah']=0;
    $data_awal[$tipe]['mutasi_jml_tambah']=0;
    $data_awal[$tipe]['mutasi_ap_tambah']=0;
    $data_awal[$tipe]['mutasi_pp_tambah']=0;
    $data_awal[$tipe]['mutasi_nb_tambah']=0;
   /* 
    $data_awal[$tipe]['mutasi_nilai_kurang']=0;
    $data_awal[$tipe]['mutasi_jml_kurang']=0;
    $data_awal[$tipe]['mutasi_ap_kurang']=0;
    $data_awal[$tipe]['mutasi_pp_kurang']=0;
    $data_awal[$tipe]['mutasi_nb_kurang']=0;
    
    $data_awal[$tipe]['nilai_akhir']=$value['nilai'];
    $data_awal[$tipe]['jml_akhir']=$value['jml'];
    $data_awal[$tipe]['ap_akhir']=$value['AP'];
    $data_awal[$tipe]['pp_akhir']=$value['PP'];
    $data_awal[$tipe]['nb_akhir']=$value['NB'];*/
    
    $data_awal[$tipe]['mutasi_nilai_kurang']=$value['nilai'];
    $data_awal[$tipe]['mutasi_jml_kurang']=$value['jml'];
    $data_awal[$tipe]['mutasi_ap_kurang']=$value['AP'];
    $data_awal[$tipe]['mutasi_pp_kurang']=$value['PP'];
    $data_awal[$tipe]['mutasi_nb_kurang']=$value['NB'];
    
    $data_awal[$tipe]['bp']=0;
     
    $data_awal[$tipe]['nilai_akhir']=0;
    $data_awal[$tipe]['jml_akhir']=0;
    $data_awal[$tipe]['ap_akhir']=0;
    $data_awal[$tipe]['pp_akhir']=0;
    $data_awal[$tipe]['nb_akhir']=0;
    
    
}




$data_akhir_alone=array_diff_assoc($data_akhir,$data_gabungan);
//echo "array akhir sendiri:<br/><pre>";
//print_r($data_akhir_alone);

$data_akhir=array();
foreach ($data_akhir_alone as $tipe => $value) {
    
    $Aset_ID=$value['Aset_ID'];
    $TahunPenyusutan=$value['TahunPenyusutan'];
    $kelompok=$value['Kelompok'];
    $Tahun=$value['Tahun'];
    $akumulasi_sblm=get_akumulasi_sblm($Aset_ID, $TahunPenyusutan, $kelompok);
    
    if($Tahun==$TahunPenyusutan){
        //pengadaan di tahun berjalan
        $akumulasi_sblm=0;
        $bp=$value['AP'];
    }
    else{
        //transfer dari tempat lain
        if($akumulasi_sblm==0){
            //barang inventarisasi
             $bp=$value['AP'];
             $akumulasi_sblm=0;
        }
        $bp=$value['AP']-$akumulasi_sblm;
        //bila tidak penyusutan lagi
        if($bp==$value['AP'])
        {
            $bp=0;
            $akumulasi_sblm=$value['AP'];
        } 
    }
       
    $data_akhir[$tipe]['Kelompok']=$tipe;
    $data_akhir[$tipe]['Uraian']=$value['Uraian'];
    
    $data_akhir[$tipe]['nilai']=0;
    $data_akhir[$tipe]['jml']=0;
    $data_akhir[$tipe]['ap']=0;
    $data_akhir[$tipe]['pp']=0;
    $data_akhir[$tipe]['nb']=0;
    $data_akhir[$tipe]['mutasi_jml_tambah']=$value['jml'];
    $data_akhir[$tipe]['mutasi_nilai_tambah']=$value['nilai'];
    $data_akhir[$tipe]['mutasi_ap_tambah']=$bp;//$akumulasi_sblm;//$value['AP'];
    $data_akhir[$tipe]['mutasi_pp_tambah']=$value['PP'];
    $data_akhir[$tipe]['mutasi_nb_tambah']=$value['NB'];
    
    $data_akhir[$tipe]['mutasi_nilai_kurang']=0;
    $data_akhir[$tipe]['mutasi_jml_kurang']=0;
    $data_akhir[$tipe]['mutasi_ap_kurang']=0;
    $data_akhir[$tipe]['mutasi_pp_kurang']=0;
    $data_akhir[$tipe]['mutasi_nb_kurang']=0;
    
    $data_akhir[$tipe]['bp']=0;//$bp;//$value['AP'];
    
    $data_akhir[$tipe]['nilai_akhir']=$value['nilai'];
    $data_akhir[$tipe]['jml_akhir']=$value['jml'];
    $data_akhir[$tipe]['ap_akhir']=$value['AP'];
    $data_akhir[$tipe]['pp_akhir']=$value['PP'];
    $data_akhir[$tipe]['nb_akhir']=$value['NB'];
    
    
}

$data_hapus=array();
foreach ($data_hapus_tmp as $tipe => $value) {
     $data_hapus[$tipe]['Kelompok']=$tipe;
    $data_hapus[$tipe]['Uraian']=$value['Uraian'];
    
    $data_hapus[$tipe]['nilai']=0;
    $data_hapus[$tipe]['jml']=0;
    $data_hapus[$tipe]['ap']=0;
    $data_hapus[$tipe]['pp']=0;
    $data_hapus[$tipe]['nb']=0;
    $data_hapus[$tipe]['mutasi_jml_tambah']=$value['jml'];
    $data_hapus[$tipe]['mutasi_nilai_tambah']=$value['nilai'];
    $data_hapus[$tipe]['mutasi_ap_tambah']=$value['AP'];
    $data_hapus[$tipe]['mutasi_pp_tambah']=$value['PP'];
    $data_hapus[$tipe]['mutasi_nb_tambah']=$value['NB'];
    
    $data_hapus[$tipe]['mutasi_jml_kurang']=$value['jml'];
    $data_hapus[$tipe]['mutasi_nilai_kurang']=$value['nilai'];
    $data_hapus[$tipe]['mutasi_ap_kurang']=$value['AP'];
    $data_hapus[$tipe]['mutasi_pp_kurang']=$value['PP'];
    $data_hapus[$tipe]['mutasi_nb_kurang']=$value['NB'];
    
    $data_hapus[$tipe]['bp']=0;//$value['AP'];
    
    $data_hapus[$tipe]['nilai_akhir']=0;
    $data_hapus[$tipe]['jml_akhir']=0;
    $data_hapus[$tipe]['ap_akhir']=0;
    $data_hapus[$tipe]['pp_akhir']=0;
    $data_hapus[$tipe]['nb_akhir']=0;
    
    
}



/*echo "array akhir:<br/><pre>";
print_r($data_akhir);//data-sub-sub
exit;*/
$data_gabungan=  array_merge($data_awal,$data_gabungan,$data_akhir,$data_hapus);

//echo "array gabungan:<br/><pre>";
//print_r($data_gabungan);//data-sub-sub
//
$data_level5=array();
foreach ($data_gabungan as $key => $value) {
    $tmp=  explode(".", $key);
    $key_baru="{$tmp[0]}.{$tmp[1]}.{$tmp[2]}.{$tmp[3]}.{$tmp[4]}";
    $URAIAN=  get_uraian($key_baru,5);

    $data_level5[$key_baru]['Uraian']=$URAIAN;
    $data_level5[$key_baru]['Kelompok']=$key_baru;
    $data_level5[$key_baru]['nilai']+=$data_gabungan[$key]['nilai'];
    $data_level5[$key_baru]['jml']+=$data_gabungan[$key]['jml'];
    $data_level5[$key_baru]['ap']+=$data_gabungan[$key]['ap'];
    $data_level5[$key_baru]['pp']+=$data_gabungan[$key]['pp'];
    $data_level5[$key_baru]['nb']+=$data_gabungan[$key]['nb'];
    $data_level5[$key_baru]['mutasi_jml_tambah']+=$data_gabungan[$key]['mutasi_jml_tambah'];
    $data_level5[$key_baru]['mutasi_nilai_tambah']+=$data_gabungan[$key]['mutasi_nilai_tambah'];
    $data_level5[$key_baru]['mutasi_ap_tambah']+=$data_gabungan[$key]['mutasi_ap_tambah'];
    $data_level5[$key_baru]['mutasi_pp_tambah']+=$data_gabungan[$key]['mutasi_pp_tambah'];
    $data_level5[$key_baru]['mutasi_nb_tambah']+=$data_gabungan[$key]['mutasi_nb_tambah'];
    
    $data_level5[$key_baru]['bp']+=$data_gabungan[$key]['bp'];
    
    $data_level5[$key_baru]['mutasi_jml_kurang']+=$data_gabungan[$key]['mutasi_jml_kurang'];
    $data_level5[$key_baru]['mutasi_nilai_kurang']+=$data_gabungan[$key]['mutasi_nilai_kurang'];
    $data_level5[$key_baru]['mutasi_ap_kurang']+=$data_gabungan[$key]['mutasi_ap_kurang'];
    $data_level5[$key_baru]['mutasi_pp_kurang']+=$data_gabungan[$key]['mutasi_pp_kurang'];
    $data_level5[$key_baru]['mutasi_nb_kurang']+=$data_gabungan[$key]['mutasi_nb_kurang'];
    
    $data_level5[$key_baru]['nilai_akhir']+=$data_gabungan[$key]['nilai_akhir'];
    $data_level5[$key_baru]['jml_akhir']+=$data_gabungan[$key]['jml_akhir'];
    $data_level5[$key_baru]['ap_akhir']+=$data_gabungan[$key]['ap_akhir'];
    $data_level5[$key_baru]['pp_akhir']+=$data_gabungan[$key]['pp_akhir'];
    $data_level5[$key_baru]['nb_akhir']+=$data_gabungan[$key]['nb_akhir'];
    
    
}
//$data_level5=$data_gabungan;
$data_level4=array();
//Buat array gabungan --> level 4
foreach ($data_level5 as $key => $value) {
    $tmp=  explode(".", $key);
    $key_baru="{$tmp[0]}.{$tmp[1]}.{$tmp[2]}.{$tmp[3]}";
    $URAIAN=  get_uraian($key_baru,4);

    $data_level4[$key_baru]['Uraian']=$URAIAN;
    $data_level4[$key_baru]['Kelompok']=$key_baru;
    $data_level4[$key_baru]['nilai']+=$data_level5[$key]['nilai'];
    $data_level4[$key_baru]['jml']+=$data_level5[$key]['jml'];
    $data_level4[$key_baru]['ap']+=$data_level5[$key]['ap'];
    $data_level4[$key_baru]['pp']+=$data_level5[$key]['pp'];
    $data_level4[$key_baru]['nb']+=$data_level5[$key]['nb'];
    $data_level4[$key_baru]['mutasi_jml_tambah']+=$data_level5[$key]['mutasi_jml_tambah'];
    $data_level4[$key_baru]['mutasi_nilai_tambah']+=$data_level5[$key]['mutasi_nilai_tambah'];
    $data_level4[$key_baru]['mutasi_ap_tambah']+=$data_level5[$key]['mutasi_ap_tambah'];
    $data_level4[$key_baru]['mutasi_pp_tambah']+=$data_level5[$key]['mutasi_pp_tambah'];
    $data_level4[$key_baru]['mutasi_nb_tambah']+=$data_level5[$key]['mutasi_nb_tambah'];
    
    $data_level4[$key_baru]['bp']+=$data_level5[$key]['bp'];
    
    $data_level4[$key_baru]['mutasi_jml_kurang']+=$data_level5[$key]['mutasi_jml_kurang'];
    $data_level4[$key_baru]['mutasi_nilai_kurang']+=$data_level5[$key]['mutasi_nilai_kurang'];
    $data_level4[$key_baru]['mutasi_ap_kurang']+=$data_level5[$key]['mutasi_ap_kurang'];
    $data_level4[$key_baru]['mutasi_pp_kurang']+=$data_level5[$key]['mutasi_pp_kurang'];
    $data_level4[$key_baru]['mutasi_nb_kurang']+=$data_level5[$key]['mutasi_nb_kurang'];
    
    $data_level4[$key_baru]['nilai_akhir']+=$data_level5[$key]['nilai_akhir'];
    $data_level4[$key_baru]['jml_akhir']+=$data_level5[$key]['jml_akhir'];
    $data_level4[$key_baru]['ap_akhir']+=$data_level5[$key]['ap_akhir'];
    $data_level4[$key_baru]['pp_akhir']+=$data_level5[$key]['pp_akhir'];
    $data_level4[$key_baru]['nb_akhir']+=$data_level5[$key]['nb_akhir'];
    $data_level4[$key_baru]['SubSub'][$key]=$data_level5[$key];
    
}

//echo "array level 4:<br/><pre>";
//print_r($data_level4);//data-sub


$data_level3=array();
//Buat array gabungan --> level 3
foreach ($data_level4 as $key => $value) {
    $tmp=  explode(".", $key);
    $key_baru="{$tmp[0]}.{$tmp[1]}.{$tmp[2]}";
     $URAIAN=  get_uraian($key_baru,3);

    $data_level3[$key_baru]['Uraian']=$URAIAN;
    $data_level3[$key_baru]['Kelompok']=$key_baru;
    $data_level3[$key_baru]['nilai']+=$data_level4[$key]['nilai'];
    $data_level3[$key_baru]['jml']+=$data_level4[$key]['jml'];
    $data_level3[$key_baru]['ap']+=$data_level4[$key]['ap'];
    $data_level3[$key_baru]['pp']+=$data_level4[$key]['pp'];
    $data_level3[$key_baru]['nb']+=$data_level4[$key]['nb'];
    
    $data_level3[$key_baru]['mutasi_jml_tambah']+=$data_level4[$key]['mutasi_jml_tambah'];
    $data_level3[$key_baru]['mutasi_nilai_tambah']+=$data_level4[$key]['mutasi_nilai_tambah'];
    $data_level3[$key_baru]['mutasi_ap_tambah']+=$data_level4[$key]['mutasi_ap_tambah'];
    $data_level3[$key_baru]['mutasi_pp_tambah']+=$data_level4[$key]['mutasi_pp_tambah'];
    $data_level3[$key_baru]['mutasi_nb_tambah']+=$data_level4[$key]['mutasi_nb_tambah'];
    
    $data_level3[$key_baru]['bp']+=$data_level4[$key]['bp'];
    
    $data_level3[$key_baru]['mutasi_jml_kurang']+=$data_level4[$key]['mutasi_jml_kurang'];
    $data_level3[$key_baru]['mutasi_nilai_kurang']+=$data_level4[$key]['mutasi_nilai_kurang'];
    $data_level3[$key_baru]['mutasi_ap_kurang']+=$data_level4[$key]['mutasi_ap_kurang'];
    $data_level3[$key_baru]['mutasi_pp_kurang']+=$data_level4[$key]['mutasi_pp_kurang'];
    $data_level3[$key_baru]['mutasi_nb_kurang']+=$data_level4[$key]['mutasi_nb_kurang'];
    
    
    
    $data_level3[$key_baru]['nilai_akhir']+=$data_level4[$key]['nilai_akhir'];
    $data_level3[$key_baru]['jml_akhir']+=$data_level4[$key]['jml_akhir'];
    $data_level3[$key_baru]['ap_akhir']+=$data_level4[$key]['ap_akhir'];
    $data_level3[$key_baru]['pp_akhir']+=$data_level4[$key]['pp_akhir'];
    $data_level3[$key_baru]['nb_akhir']+=$data_level4[$key]['nb_akhir'];
    $data_level3[$key_baru]['Sub'][$key]=$data_level4[$key];
    
}

//echo "array level 3:<br/><pre>";
//print_r($data_level3);//data-sub-sub


$data_level2=array();
//Buat array gabungan --> level 2
foreach ($data_level3 as $key => $value) {
    $tmp=  explode(".", $key);
    $key_baru="{$tmp[0]}.{$tmp[1]}";
     $URAIAN=  get_uraian($key_baru,2);
     
    $data_level2[$key_baru]['Uraian']=$URAIAN;
    $data_level2[$key_baru]['Kelompok']=$key_baru;
    $data_level2[$key_baru]['nilai']+=$data_level3[$key]['nilai'];
    $data_level2[$key_baru]['jml']+=$data_level3[$key]['jml'];
    $data_level2[$key_baru]['ap']+=$data_level3[$key]['ap'];
    $data_level2[$key_baru]['pp']+=$data_level3[$key]['pp'];
    $data_level2[$key_baru]['nb']+=$data_level3[$key]['nb'];
    
    $data_level2[$key_baru]['mutasi_jml_tambah']+=$data_level3[$key]['mutasi_jml_tambah'];
    $data_level2[$key_baru]['mutasi_nilai_tambah']+=$data_level3[$key]['mutasi_nilai_tambah'];
    $data_level2[$key_baru]['mutasi_ap_tambah']+=$data_level3[$key]['mutasi_ap_tambah'];
    $data_level2[$key_baru]['mutasi_pp_tambah']+=$data_level3[$key]['mutasi_pp_tambah'];
    $data_level2[$key_baru]['mutasi_nb_tambah']+=$data_level3[$key]['mutasi_nb_tambah'];
    
    $data_level2[$key_baru]['bp']+=$data_level3[$key]['bp'];
    
    $data_level2[$key_baru]['mutasi_jml_kurang']+=$data_level3[$key]['mutasi_jml_kurang'];
    $data_level2[$key_baru]['mutasi_nilai_kurang']+=$data_level3[$key]['mutasi_nilai_kurang'];
    $data_level2[$key_baru]['mutasi_ap_kurang']+=$data_level3[$key]['mutasi_ap_kurang'];
    $data_level2[$key_baru]['mutasi_pp_kurang']+=$data_level3[$key]['mutasi_pp_kurang'];
    $data_level2[$key_baru]['mutasi_nb_kurang']+=$data_level3[$key]['mutasi_nb_kurang'];
    
    $data_level2[$key_baru]['nilai_akhir']+=$data_level3[$key]['nilai_akhir'];
    $data_level2[$key_baru]['jml_akhir']+=$data_level3[$key]['jml_akhir'];
    $data_level2[$key_baru]['ap_akhir']+=$data_level3[$key]['ap_akhir'];
    $data_level2[$key_baru]['pp_akhir']+=$data_level3[$key]['pp_akhir'];
    $data_level2[$key_baru]['nb_akhir']+=$data_level3[$key]['nb_akhir'];
    $data_level2[$key_baru]['Kel'][$key]=$data_level3[$key];
   // echo "<pre>";print_r($data_level3[$key]);
}

//echo "array level 2:<br/><pre>";
//print_r($data_level2);//data-sub-sub


$data_level=array();
//Buat array gabungan --> level 1
foreach ($data_level2 as $key => $value) {
    $tmp=  explode(".", $key);
    $key_baru="{$tmp[0]}";
     $URAIAN=  get_uraian($key_baru,1);
     
    $data_level[$key_baru]['Uraian']=$URAIAN;
    $data_level[$key_baru]['Kelompok']=$key_baru;
    $data_level[$key_baru]['nilai']+=$data_level2[$key]['nilai'];
    $data_level[$key_baru]['jml']+=$data_level2[$key]['jml'];
    $data_level[$key_baru]['ap']+=$data_level2[$key]['ap'];
    $data_level[$key_baru]['pp']+=$data_level2[$key]['pp'];
    $data_level[$key_baru]['nb']+=$data_level2[$key]['nb'];
    
    $data_level[$key_baru]['mutasi_jml_tambah']+=$data_level2[$key]['mutasi_jml_tambah'];
    $data_level[$key_baru]['mutasi_nilai_tambah']+=$data_level2[$key]['mutasi_nilai_tambah'];
    $data_level[$key_baru]['mutasi_ap_tambah']+=$data_level2[$key]['mutasi_ap_tambah'];
    $data_level[$key_baru]['mutasi_pp_tambah']+=$data_level2[$key]['mutasi_pp_tambah'];
    $data_level[$key_baru]['mutasi_nb_tambah']+=$data_level2[$key]['mutasi_nb_tambah'];
    
    $data_level[$key_baru]['bp']+=$data_level2[$key]['bp'];
    
    $data_level[$key_baru]['mutasi_jml_kurang']+=$data_level2[$key]['mutasi_jml_kurang'];
    $data_level[$key_baru]['mutasi_nilai_kurang']+=$data_level2[$key]['mutasi_nilai_kurang'];
    $data_level[$key_baru]['mutasi_ap_kurang']+=$data_level2[$key]['mutasi_ap_kurang'];
    $data_level[$key_baru]['mutasi_pp_kurang']+=$data_level2[$key]['mutasi_pp_kurang'];
    $data_level[$key_baru]['mutasi_nb_kurang']+=$data_level2[$key]['mutasi_nb_kurang'];
    
    $data_level[$key_baru]['nilai_akhir']+=$data_level2[$key]['nilai_akhir'];
    $data_level[$key_baru]['jml_akhir']+=$data_level2[$key]['jml_akhir'];
    $data_level[$key_baru]['ap_akhir']+=$data_level2[$key]['ap_akhir'];
    $data_level[$key_baru]['pp_akhir']+=$data_level2[$key]['pp_akhir'];
    $data_level[$key_baru]['nb_akhir']+=$data_level2[$key]['nb_akhir'];
    $data_level[$key_baru]['Bidang'][$key]=$data_level2[$key];
    
}

//echo "array level :<br/><pre>";
//print_r($data_level);//data-sub-sub

return $data_level;
}

function get_uraian($kode,$level){
    switch ($level) {
         case 5:
              $where="";
            break;
        case 4:
            $where=" and SubSub is null";
            break;
         case 3:
            $where=" and sub is null and SubSub is null";
            break;
         case 2:
            $where=" and kelompok is null and sub is null and SubSub is null";
            break;
         case 1:
              $where=" and bidang is null and kelompok is null and sub is null and SubSub is null";
            break;

        default:
            break;
    }
    $query="select Uraian from kelompok where Kode like '$kode%' $where limit 1";
    $result=  mysql_query($query) or die(mysql_error());
    while($row=  mysql_fetch_array($result)){
        $Uraian=$row[Uraian];
    }
    return $Uraian;
}

function get_akumulasi_sblm($Aset_ID,$TahunPenyusutan,$kelompok){
    $gol=  explode(".", $kelompok);
    //echo "$kelompok<pre>";
    //print_r($gol);
    //exit();
    switch ($gol[0]) {
        case "1":
            $nama_log="log_tanah";
            break;
        case "2":
            $nama_log="log_mesin";
            break;
        case "3":
            $nama_log="log_bangunan";
            break;
        case "4":
            $nama_log="log_jaringan";
            break;
        case "5":
            $nama_log="log_asetlain";
            break;
        case "6":
            $nama_log="log_kdp";
            break;

        default:
            break;
    }
    if($gol[0]=="2"||$gol[0]=="3"||$gol[0]=="4"){
        $Tahun=$TahunPenyusutan-1;
        $query="select AkumulasiPenyusutan from $nama_log where "
                . "kd_riwayat in(50,51,52) and TahunPenyusutan='$Tahun' "
                . " and Aset_ID='$Aset_ID' ";
        //echo "$query";
        //exit();
        $result=  mysql_query($query) or die(mysql_error());
        $AkumulasiPenyusutan=0;
        while($row=  mysql_fetch_array($result)){
            $AkumulasiPenyusutan=$row[AkumulasiPenyusutan];
        }
        
    } else{
        $AkumulasiPenyusutan=0;
    }
   
    
    return $AkumulasiPenyusutan;
}
?>