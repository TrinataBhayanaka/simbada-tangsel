<?php
include "../../config/config.php";


$PENGHAPUSAN = new RETRIEVE_PENGHAPUSAN;

        $menu_id = 38;
        ($SessionUser['ses_uid']!='') ? $Session = $SessionUser : $Session = $SESSION->get_session(array('title'=>'GuestMenu', 'ses_name'=>'menu_without_login')); 
        $SessionUser = $SESSION->get_session_user();
        $USERAUTH->FrontEnd_check_akses_menu($menu_id, $SessionUser);

        // $nmaset=$_POST['penghapusan_nama_aset'];
        $UserNm=$_SESSION['ses_uoperatorid'];// usernm akan diganti jika session di implementasikan
        $usulan_id=get_auto_increment("Usulan");
        $date=date('Y-m-d');
        $ses_uid=$_SESSION['ses_uid'];
		// //pr($nmaset);
		// echo "jml=".$nmaset;
        // exit;
        // $data = $STORE->store_usulan_penghapusan(
                // $UserNm,
                // $nmaset,
                // $usulan_id,
                // $date,
                // $ses_uid
                // );
		// //pr($_POST);

        $data_post=$PENGHAPUSAN->apl_userasetlistHPS("USPMD");
        $POST=$_POST;
        // //pr($POST);
        $POST_data=$PENGHAPUSAN->apl_userasetlistHPS_filter($data_post);
        // $POST['penghapusan_nama_aset']=$POST_data;
        // pr($POST);

        // pr($_POST);
        // // exit;
		$data = $PENGHAPUSAN->store_usulan_penghapusan_pmdx($POST,2);
        pr($data);
        $data_postRVW=$PENGHAPUSAN->apl_userasetlistHPS("RVWUSPMD");
        if($data_postRVW){
         $data_delete=$PENGHAPUSAN->apl_userasetlistHPS_del("RVWUSPMD");
        }
        if($data_post){
         $data_delete=$PENGHAPUSAN->apl_userasetlistHPS_del("USPMD");
        }
       
      if ($data){
            print json_encode(array('status'=>true, 'data'=>$data));
        }else{
            print json_encode(array('status'=>false));
        }
        
        exit;

?>
