<?php
include "../../config/config.php";

$PENGHAPUSAN = new RETRIEVE_PENGHAPUSAN;
$menu_id = 10;
            $SessionUser = $SESSION->get_session_user();
            ($SessionUser['ses_uid']!='') ? $Session = $SessionUser : $Session = $SESSION->get_session(array('title'=>'GuestMenu', 'ses_name'=>'menu_without_login')); 
            $USERAUTH->FrontEnd_check_akses_menu($menu_id, $Session);

// $get_data_filter = $RETRIEVE->retrieve_kontrak();
// ////pr($get_data_filter);
?>

<?php
	include"$path/meta.php";
	include"$path/header.php";
	include"$path/menu.php";
	
?>
	<!-- SQL Sementara -->
	<?php
	////pr($_POST);

	////pr($_SESSION['usulanIDTmp']);

	if(isset($_POST['usulanID'])){
		$id=$_POST['usulanID'];
	}else{
		$id="";
		if(isset($_SESSION['usulanIDTmp'])) {
			$id=$_SESSION['usulanIDTmp'];
		}
		
	}
	if ($_POST['submit']){
		// unset($_SESSION['ses_mutasi_filter']);
		// pr($_POST);
		$_SESSION['filterAsetUsulan'] = $_POST;
		
	}
	$data_post=$PENGHAPUSAN->apl_userasetlistHPS("RVWUSPMD");

		if($data_post){
			
		}else{
			
		}
	// if(isset($_POST['filterAsetUsulan']) && $_POST['filterAsetUsulan']==1){
	// 	$data = $PENGHAPUSAN->retrieve_usulan_penghapusan_pmd($_POST);
	// 	$_SESSION['filterAsetUsulanAdd']=$data;
	// 	$data=$_SESSION['filterAsetUsulanAdd'];
	// 	// ////pr($_SESSION['reviewAsetUsulan']);
	// 	$data_post=$PENGHAPUSAN->apl_userasetlistHPS("RVWUSPMD");

	// 	if($data_post){
	// 	$data_delete=$PENGHAPUSAN->apl_userasetlistHPS_del("RVWUSPMD");
	// 	}
	// }else{
	// 	$dataSESSION=$_SESSION['filterAsetUsulanAdd'];
	// 	$data_post=$PENGHAPUSAN->apl_userasetlistHPS("RVWUSPMD");
		
	// 	$POST=$PENGHAPUSAN->apl_userasetlistHPS_filter($data_post);

	// 	$POST['penghapusanfilter']=$POST;
	// 	if($POST){
	// 		// ////pr($_SESSION['reviewAsetUsulan']['penghapusanfilter']);
	// 		foreach ($dataSESSION as $keySESSION => $valueSESSION) {
	// 			// ////pr($valueSESSION['Aset_ID']);
	// 			if(!in_array($valueSESSION['Aset_ID'], $POST['penghapusanfilter'])){
	// 				// echo "stringnot";
	// 				$data[]=$valueSESSION;
	// 			}
	// 		}
		
	// 	}
	// 	// ////pr($data);
	$POST = $_SESSION['filterAsetUsulan'];
	
	$POST['page'] = intval($_GET['pid']);
	// pr($POST);
	$par_data_table="bup_tahun={$POST['bup_tahun']}&bup_nokontrak={$POST['bup_nokontrak']}&jenisaset={$POST['jenisaset'][0]}&kodeSatker={$POST['kodeSatker']}&page={$POST['page']}";

	// }
	// $data = $PENGHAPUSAN->retrieve_usulan_penghapusan_pmd($_POST);
	if(isset($_GET['flegAset'])){
		$flegAset=$_GET['flegAset'];
	}else{
		$flegAset=1;
	}
		 $sql = mysql_query("SELECT * FROM kontrak ORDER BY id ");
        while ($dataKontrak = mysql_fetch_assoc($sql)){
                $kontrak[] = $dataKontrak;
            }
	?>
	<!-- End Sql -->

	<script>
		function AreAnyCheckboxesChecked () 
		{
			setTimeout(function() {
		  if ($("#Form2 input:checkbox:checked").length > 0)
			{
			    $("#submit").removeAttr("disabled");
			    updDataCheckbox('RVWUSPMD');
			}
			else
			{
			   $('#submit').attr("disabled","disabled");
			    updDataCheckbox('RVWUSPMD');
			}}, 100);
		}
		jQuery(function($) {
      		AreAnyCheckboxesChecked();	
      	});
		</script>
	<section id="main">
		<ul class="breadcrumb">
			  <li><a href="#"><i class="fa fa-home fa-2x"></i>  Home</a> <span class="divider"><b>&raquo;</b></span></li>
			  <li><a href="#">Penghapusan</a><span class="divider"><b>&raquo;</b></span></li>
			  <li class="active">Daftar Aset Usulan Penghapusan Pemindahtanganan</li>
			  <?php SignInOut();?>
			</ul>
			<div class="breadcrumb">
				<div class="title">Usulan Penghapusan Pemindahtanganan</div>
				<div class="subtitle">Daftar Aset yang akan dibuat Usulan</div>
			</div>	

		<div class="grey-container shortcut-wrapper">
				<a class="shortcut-link active" href="<?=$url_rewrite?>/module/penghapusan/dftr_usulan_pmd.php">
					<span class="fa-stack fa-lg">
				      <i class="fa fa-circle fa-stack-2x"></i>
				      <i class="fa fa-inverse fa-stack-1x">1</i>
				    </span>
					<span class="text">Usulan Penghapusan</span>
				</a>
				<a class="shortcut-link" href="<?=$url_rewrite?>/module/penghapusan/dftr_penetapan_pmd.php">
					<span class="fa-stack fa-lg">
				      <i class="fa fa-circle fa-stack-2x"></i>
				      <i class="fa fa-inverse fa-stack-1x">2</i>
				    </span>
					<span class="text">Penetapan Penghapusan</span>
				</a>
				<a class="shortcut-link" href="<?=$url_rewrite?>/module/penghapusan/dftr_validasi_pmd.php">
					<span class="fa-stack fa-lg">
				      <i class="fa fa-circle fa-stack-2x"></i>
				      <i class="fa fa-inverse fa-stack-1x">3</i>
				    </span>
					<span class="text">Validasi Penghapusan</span>
				</a>
			</div>		

		<section class="formLegend">
			<script>
    $(document).ready(function() {
          $('#usulan_pmd_table').dataTable(
                   {
                    "aoColumnDefs": [
                         { "aTargets": [2] }
                    ],
                    "aoColumns":[
                         {"bSortable": false},
                         {"bSortable": false,"sClass": "checkbox-column" },
                         {"bSortable": true},
                         {"bSortable": true},
                         {"bSortable": true},
                         {"bSortable": true},
                         {"bSortable": true},
                         {"bSortable": true},
                         {"bSortable": true},
                         {"bSortable": true}],
                    "sPaginationType": "full_numbers",

                    "bProcessing": true,
                    "bServerSide": true,
                    "sAjaxSource": "<?=$url_rewrite?>/api_list/api_aset_tambahan_usulan_pmd.php?<?php echo $par_data_table?>"
               }
                  );
      });
    </script>
			
			<div id="demo">
			<form method="POST" ID="Form2" action="<?php echo"$url_rewrite"?>/module/penghapusan/dftr_review_aset_tambahan_usulan_pmd.php"> 
			<table cellpadding="0" cellspacing="0" border="0" class="display  table-checkable" id="usulan_pmd_table">
				<thead>
					<tr>
						<td colspan="7" align="left">
								<span><button type="submit" name="submit" class="btn btn-info " id="submit" disabled/><i class="icon-plus-sign icon-white"></i>&nbsp;&nbsp;Buat Usulan Penghapusan</button></span>
								<input type="hidden" name="usulanID" value="<?=$id?>"/>
								<input type="hidden" name="reviewAsetUsulan" value="<?=$flegAset?>" />
						<?php
							if($flegAset==0){
						?>
							<a href="<?php echo"$url_rewrite"?>/module/penghapusan/dftr_review_aset_tambahan_usulan_pmd.php" class="btn">Kembali ke Aset Usulan</a>
						<?php

							}
						?>
						</td>

						<td colspan="3" align="right">
							<a href="<?php echo"$url_rewrite"?>/module/penghapusan/filter_tambah_aset_usulan_pmd.php?usulanID=<?=$id?>" class="btn">Kembali Ke Pencarian</a>
			
						</td>
					</tr>
					<tr>
						<th>No</th>
						<th class="checkbox-column"><input type="checkbox" class="icheck-input" onchange="return AreAnyCheckboxesChecked();"></th>
						<th>No Register</th>
						<th>No Kontrak</th>
						<th>Kode / Uraian</th>
						<th>Satker</th>
						<th>Tanggal Perolehan</th>
						<th>Nilai Perolehan</th>
						<th>Status</th>
						<th>Merk / Type</th>
					</tr>
				</thead>
				<tbody>		
				 	<tr>
	                    <td colspan="10">Data Tidak di temukkan</td>
	               	</tr>
				</tbody>
				<tfoot>
					<tr>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
					</tr>
				</tfoot>
			</table>
			</form>
			</div>
			<div class="spacer"></div>
			    
		</section> 
		     
	</section>
	
<?php
	include"$path/footer.php";
?>