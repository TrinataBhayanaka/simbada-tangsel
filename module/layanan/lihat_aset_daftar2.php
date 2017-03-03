<?php
include "../../config/config.php";

//include "/config/config.php";
$menu_id = 1;
$SessionUser = $SESSION->get_session_user();
($SessionUser['ses_uid']!='') ? $Session = $SessionUser : $Session = $SESSION->get_session(array('title'=>'GuestMenu', 'ses_name'=>'menu_without_login')); 
$USERAUTH->FrontEnd_check_akses_menu($menu_id, $Session);
//pr($_POST);
if(isset($_POST)){
	$bup_tahun 		= $_POST['bup_tahun'];
	$statusaset     = $_POST['statusaset'];
	$jenisaset 		= $_POST['jenisaset'];
	$kodeSatker 	= $_POST['kodeSatker'];
	$kodepemilik 	= $_POST['kodepemilik'];
	$kodeKelompok 	= $_POST['kodeKelompok'];
}
pr($_POST);
//exit;
include"$path/meta.php";
include"$path/header.php";
include"$path/menu.php";

	$par_data_table ="tahun={$bup_tahun}&jenisaset={$jenisaset}&kodeSatker={$kodeSatker}&kodepemilik={$kodepemilik}&kodeKelompok={$kodeKelompok}&statusaset={$statusaset}";
	$param=$par_data_table;

	?>
	<script type="text/javascript">
	$(document).ready(function() {
		AreAnyCheckboxesChecked();
	} );

	function AreAnyCheckboxesChecked () 
		{
			setTimeout(function() {
		  if ($("#Form2 input:checkbox:checked").length > 0)
			{
			    $("#submit").removeAttr("disabled");
			    updDataCheckbox('LYNAN');
			}
			else
			{
			   $('#submit').attr("disabled","disabled");
			    updDataCheckbox('LYNAN');
			}}, 100);
		}

    function checkBefore(){

    	var txt;
		var r = confirm("Hapus Data Aset?");
		if (r == true) {
		    
		} else {
		    return false;
		}
    }

    </script>
	<section id="main">
		<ul class="breadcrumb">
			  <li><a href="#"><i class="fa fa-home fa-2x"></i>  Home</a> <span class="divider"><b>&raquo;</b></span></li>
			  <li><a href="#">Layanan</a><span class="divider"><b>&raquo;</b></span></li>
			  <li class="active">Log Aset Simbada</li>
			  <?php SignInOut();?>
		</ul>
		<div class="breadcrumb">
			<div class="title">Daftar Aset</div>
			<div class="subtitle">Daftar Aset hasil penelusuran</div>
		</div>	

		<section class="formLegend">
			<script>
			    $(document).ready(function() {
			          $('#layanan').dataTable(
	                    {
	                    "aoColumnDefs": [
	                         { "aTargets": [2] }
	                    ],
	                    "aoColumns":[
	                         {"bSortable": true},	
	                         {"bSortable": false,"sClass": "checkbox-column"},
	                         {"bSortable": true},
	                         {"bSortable": true},
	                         {"bSortable": true},
	                         {"bSortable": true},
	                         {"bSortable": true},
	                         {"bSortable": true},
	                         {"bSortable": true},
	                         //{"bSortable": true},
	                         {"bSortable": true}],
	                    "sPaginationType": "full_numbers",

	                    "bprocessing": true,
	                    "bServerSide": true,
	                    "sAjaxSource": "<?=$url_rewrite?>/api_list/api_layanan2.php?<?php echo $par_data_table?>"
		               	}
                    );
			      });
    		</script>

    	<form name="myform" id="Form2" method="POST" action="<?php echo "$url_rewrite/module/layanan/"; ?>hapus_aset.php" onsubmit="return checkBefore()">
			<?php 
			// pr($_SESSION);
			if ($_SESSION['ses_ujabatan']==1):
			?>
			<?php if($statusaset=="1"||$statusaset=="0"){ $data=array("Belum Terdistribusi","Terdistribusi");
										echo "<h4> Status Aset = {$data[$statusaset]}</h1>";?>
				<input type="submit" name="submit2" class="btn btn-danger" value="Hapus Aset" id="submit" disabled/>
				<input type ="hidden" name="kodeSatker" value="<?=$kodeSatker?>">
				<input type ="hidden" name="jenisaset" value="<?=$jenisaset?>">
			<?php } endif;?>
			<a href="<?php echo "$url_rewrite/report/template/PEROLEHAN/liat_dftr_aset.php?$param"; ?>" target="blank">
			   <input type="button" name="cetak" class="btn btn-info" value="Cetak Aset" >
			</a>
			<li>&nbsp;</li>
			<div id="demo">
			<table cellpadding="0" cellspacing="0" border="0" class="display  table-checkable" id="layanan">
				<thead>
					<tr>
						<th>No</th>
						<th class="checkbox-column"><input type="checkbox" class="icheck-input" onchange="return AreAnyCheckboxesChecked();"></th>
						<th>No Register</th>
						<th>No Kontrak</th>
						<th>Kode / Uraian</th>
						<th>Satker</th>
						<th>Tgl Perolehan / Tgl Pembukuan</th>
						<th>Nilai Perolehan</th>
						<th>Info</th>
						<!--<th>Note Sistem</th>-->
						<th>Detail</th>
					</tr>
				</thead>
				<tbody>		
					 <tr>
                        <!--<td colspan="11">Data Tidak di temukkan</td>-->
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
						<th>&nbsp;</th>
						<!--<th>&nbsp;</th>-->
					</tr>
				</tfoot>
			</table>
			</div>
		</form>
			<div class="spacer"></div> 
		</section> 
	</section>
<?php
	include"$path/footer.php";
?>