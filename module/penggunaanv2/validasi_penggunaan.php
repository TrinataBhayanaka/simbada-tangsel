<?php

include "../../config/config.php"; 

$PENGHAPUSAN = new RETRIEVE_PENGHAPUSAN;
//exit;
$menu_id = 76;
($SessionUser['ses_uid']!='') ? $Session = $SessionUser : $Session = $SESSION->get_session(array('title'=>'GuestMenu', 'ses_name'=>'menu_without_login')); 
$SessionUser = $SESSION->get_session_user();
$USERAUTH->FrontEnd_check_akses_menu($menu_id, $SessionUser);

//pr($_GET);
//exit;

/*start background process
ket : param
id = id usulan penghapusan pmd
*/
$id = $_GET['id'];
$log = "validasi_penggunaan_".$id;
//pr($id);
//exit;	
$status=exec("php validasi_penggunaan_helper.php $id  > ../../log/$log.txt 2>&1 &");
echo "<meta http-equiv=\"Refresh\" content=\"0; url={$url_rewrite}/module/penggunaanv2/dftr_penetapan_validasi_penggunaan.php\">";  
    exit;

?>
