<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
#This code provided by:
#Andreas Hadiyono (andre.hadiyono@gmail.com)
#Gunadarma University

//error_reporting(0);
include "../../config/config.php";

$tgl_proses = date("Y-m-d H:i:s");
$id_regrouping=$argv[1];
$time_start = microtime_float();
 
  echo "Start: $tgl_proses  \n ";
$query = "select * from regrouping where id_regrouping='$id_regrouping' limit 1";
$result = $DBVAR->query($query)or die($DBVAR->error());
$row = $DBVAR->fetch_object($result);
$status_regrouping = $row->status_proses;
$satker_lama = $row->satker_lama;
$satker_baru = $row->satker_baru;
$nama_satker_lama = $row->nama_satker_lama;
$nama_satker_baru = $row->nama_satker_baru;

   //update aset
$query="update aset set kodeSatker='$satker_baru' where kodeSatker='$satker_lama' ";

echo "$query \n";
$result= $DBVAR->query($query)or die($DBVAR->error());

//update tanah
$query="update tanah set kodeSatker='$satker_baru' where kodeSatker='$satker_lama' ";
echo "$query \n";
$result= $DBVAR->query($query)or die($DBVAR->error());
$query="update log_tanah set kodeSatker='$satker_baru' where kodeSatker='$satker_lama' ";

//update mesin
$query="update mesin set kodeSatker='$satker_baru' where kodeSatker='$satker_lama' ";
echo "$query \n";
$result= $DBVAR->query($query)or die($DBVAR->error());

$query="update log_mesin set kodeSatker='$satker_baru' where kodeSatker='$satker_lama' ";
echo "$query \n";
$result= $DBVAR->query($query)or die($DBVAR->error());

//update bangunan
$query="update bangunan set kodeSatker='$satker_baru' where kodeSatker='$satker_lama' ";
echo "$query \n";
$result= $DBVAR->query($query)or die($DBVAR->error());

$query="update log_bangunan set kodeSatker='$satker_baru' where kodeSatker='$satker_lama' ";
echo "$query \n";
$result= $DBVAR->query($query)or die($DBVAR->error());

//update bangunan
$query="update jaringan set kodeSatker='$satker_baru' where kodeSatker='$satker_lama' ";
echo "$query \n";
$result= $DBVAR->query($query)or die($DBVAR->error());

$query="update log_jaringan set kodeSatker='$satker_baru' where kodeSatker='$satker_lama' ";
echo "$query \n";
$result= $DBVAR->query($query)or die($DBVAR->error());

//update bangunan
$query="update kdp set kodeSatker='$satker_baru' where kodeSatker='$satker_lama' ";
echo "$query \n";
$result= $DBVAR->query($query)or die($DBVAR->error());

$query="update log_kdp set kodeSatker='$satker_baru' where kodeSatker='$satker_lama' ";
echo "$query \n";
$result= $DBVAR->query($query)or die($DBVAR->error());

//mutasi aset
$query="update mutasiaset set SatkerAwal='$satker_baru' where SatkerAwal='$satker_lama' ";
echo "$query \n";
$result= $DBVAR->query($query)or die($DBVAR->error());

$query="update mutasiaset set SatkerTujuan='$satker_baru' where SatkerTujuan='$satker_lama' ";
echo "$query \n";
$result= $DBVAR->query($query)or die($DBVAR->error());
//penggunaan aset
$query="update penggunaanaset set kodeSatker='$satker_baru' where kodeSatker='$satker_lama' ";

//distribusi
$query="update transfer set fromSatker='$satker_baru' where fromSatker='$satker_lama' ";
echo "$query \n";
$result= $DBVAR->query($query)or die($DBVAR->error());

$query="update transfer set toSatker='$satker_baru' where toSatker='$satker_lama' ";
echo "$query \n";
$result= $DBVAR->query($query)or die($DBVAR->error());
//satker

$temp=explode(".", $satker_baru);
$KodeSektor=$temp[0];
$KodeSatker=$temp[0].".".$temp[1];
$KodeUnit=$temp[2];
$Gudang=$temp[3];


$query="update satker  set kode='$satker_baru' , NamaSatker='$nama_satker_baru',"
        . "KodeSektor='$KodeSektor', KodeSatker='$KodeSatker',KodeUnit='$KodeUnit', Gudang='$Gudang' "
        . " where kode='$satker_lama'";echo "$query \n";
        echo "$query \n";
$result= $DBVAR->query($query)or die($DBVAR->error());


$query="delete from satker where  kode='$satker_lama'";
echo "$query \n";
$result= $DBVAR->query($query)or die($DBVAR->error());

$time_end = microtime_float();
$tgl_proses = date("Y-m-d H:i:s");
    echo "Akhir: $tgl_proses\n";

    $time = $time_end - $time_start;
    echo "Waktu proses: $time seconds ";
    
    
    $query = "update  regrouping  set status_proses=2 where id_regrouping=$id_regrouping";
          $DBVAR->query($query) or die($DBVAR->error());
          
          
     function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}
?>
