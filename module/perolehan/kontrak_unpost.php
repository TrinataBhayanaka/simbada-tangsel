<?php
include "../../config/config.php";
$menu_id = 10;
            $SessionUser = $SESSION->get_session_user();
            ($SessionUser['ses_uid']!='') ? $Session = $SessionUser : $Session = $SESSION->get_session(array('title'=>'GuestMenu', 'ses_name'=>'menu_without_login')); 
            $USERAUTH->FrontEnd_check_akses_menu($menu_id, $Session);

$kontrakID = $_GET['id'];
$sql = mysql_query("SELECT * FROM kontrak WHERE id = '{$kontrakID}'");
while ($dataKontrak = mysql_fetch_assoc($sql)){
            $noKontrak = $dataKontrak;
        }

$updateKontrak = "UPDATE kontrak SET n_status = '0' WHERE id = '{$noKontrak['id']}'";
$execquery = mysql_query($updateKontrak);
    logFile($updateKontrak);
if(!$execquery){
  $DBVAR->rollback();
  echo "<script>alert('Data gagal masuk. Silahkan coba lagi');</script><meta http-equiv=\"Refresh\" content=\"0; url={$url_rewrite}/module/perolehan/kontrak_posting.php\">";
  exit;
}

$sql = mysql_query("SELECT SUM(nilai) as total FROM sp2d WHERE idKontrak='{$kontrakID}' AND type = '2'");
while ($dataSP2D = mysql_fetch_assoc($sql)){
    $sumsp2d = $dataSP2D;
  }

  $sql = mysql_query("SELECT * FROM aset WHERE noKontrak = '{$noKontrak[noKontrak]}' AND (StatusValidasi != 9 OR StatusValidasi IS NULL) AND (Status_Validasi_Barang != 9 OR Status_Validasi_Barang IS NULL)");
  while ($dataAset = mysql_fetch_assoc($sql)){
              $aset[] = $dataAset;
          }
//sum total 
  $sqlsum = mysql_query("SELECT SUM(NilaiPerolehan) as total FROM aset WHERE noKontrak = '{$noKontrak['noKontrak']}' AND (StatusValidasi != 9 OR StatusValidasi IS NULL) AND (Status_Validasi_Barang != 9 OR Status_Validasi_Barang IS NULL)");
  while ($sum = mysql_fetch_assoc($sqlsum)){
        $sumTotal = $sum;
      }
  
  $j = 0;
  $bopsisa = $sumsp2d['total'];    
  foreach($aset as $key => $data){
    $j++;
    if(count($aset) == $j){
      $bop = $bopsisa;
    } else{
      $bopsisa = $bopsisa - ceil($data['NilaiPerolehan']/$sumTotal['total']*$sumsp2d['total']);  
      $bop = ceil($data['NilaiPerolehan']/$sumTotal['total']*$sumsp2d['total']);
    }
    $satuan = $data['Satuan']-$bop;
    $total = $data['NilaiPerolehan']-$bop;

    $updateAset = "UPDATE aset SET NilaiPerolehan = '{$total}', Satuan = '{$satuan}' WHERE Aset_ID = '{$data['Aset_ID']}'";
    $execquery = mysql_query($updateAset);
    logFile($updateAset);
    if(!$execquery){
      $DBVAR->rollback();
      echo "<script>alert('Data gagal masuk. Silahkan coba lagi');</script><meta http-equiv=\"Refresh\" content=\"0; url={$url_rewrite}/module/perolehan/kontrak_posting.php\">";
      exit;
    }
    
    if($data['TipeAset']=="A"){
          $tabel = "tanah";
      } elseif ($data['TipeAset']=="B") {
          $tabel = "mesin";
      } elseif ($data['TipeAset']=="C") {
          $tabel = "bangunan";
      } elseif ($data['TipeAset']=="D") {
          $tabel = "jaringan";
      } elseif ($data['TipeAset']=="E") {
          $tabel = "asetlain";
      } elseif ($data['TipeAset']=="F") {
          $tabel = "kdp";
      } elseif ($data['TipeAset']=="G") {
          $tabel = "aset";
      }

      $sql = "UPDATE {$tabel} SET NilaiPerolehan = '{$satuan}', StatusTampil = NULL, StatusValidasi = NULL WHERE Aset_ID = '{$data['Aset_ID']}'";
      $execquery = mysql_query($sql);
      logFile($sql);
      if(!$execquery){
        $DBVAR->rollback();
        echo "<script>alert('Data gagal masuk. Silahkan coba lagi');</script><meta http-equiv=\"Refresh\" content=\"0; url={$url_rewrite}/module/perolehan/kontrak_posting.php\">";
        exit;
      }

      //log
      $sqlkib = "SELECT * FROM {$tabel} WHERE Aset_ID = '{$data['Aset_ID']}'";
      $sqlquery = mysql_query($sqlkib);
      while ($dataAset = mysql_fetch_assoc($sqlquery)){
              $kib = $dataAset;
          }
      $kib['changeDate'] = date("Y-m-d");
      $kib['action'] = 'unposting';
      $kib['operator'] = $_SESSION['ses_uoperatorid'];
      $kib['NilaiPerolehan_Awal'] = $data['NilaiPerolehan'];
      $kib['Kd_Riwayat'] = 77;    

     
            unset($tmpField);
            unset($tmpValue);
            foreach ($kib as $key => $val) {
              $tmpField[] = $key;
              $tmpValue[] = "'".$val."'";
            }
             
            $fileldImp = implode(',', $tmpField);
            $dataImp = implode(',', $tmpValue);

            $sql = "INSERT INTO log_{$tabel} ({$fileldImp}) VALUES ({$dataImp})";
            $execquery = mysql_query($sql);
              logFile($sql);
            if(!$execquery){
              $DBVAR->rollback();
              echo "<script>alert('Data gagal masuk. Silahkan coba lagi');</script><meta http-equiv=\"Refresh\" content=\"0; url={$url_rewrite}/module/perolehan/kontrak_posting.php\">";              
              exit;
            } 

  
  }
  // exit;
  $DBVAR->commit();

  echo "<meta http-equiv=\"Refresh\" content=\"0; url={$url_rewrite}/module/perolehan/kontrak_posting.php\">";
  exit;

?>
