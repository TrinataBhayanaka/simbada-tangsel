<?php
include "../../config/config.php";

//include "/config/config.php";
$PENGHAPUSAN = new RETRIEVE_PENGHAPUSAN;
$menu_id = 76;
$SessionUser = $SESSION->get_session_user();
($SessionUser['ses_uid']!='') ? $Session = $SessionUser : $Session = $SESSION->get_session(array('title'=>'GuestMenu', 'ses_name'=>'menu_without_login')); 
$USERAUTH->FrontEnd_check_akses_menu($menu_id, $Session);
//pr($_POST);
if(isset($_POST)){
	$bup_tahun 		= $_POST['bup_tahun'];
	$jenisaset 		= $_POST['jenisaset'];
	$kodeSatker 	= $_POST['kodeSatker'];
	$kodepemilik 	= $_POST['kodepemilik'];
	$kodeKelompok 	= $_POST['kodeKelompok'];
	$Penggunaan_ID  = $_POST['Penggunaan_ID']; 
}
//pr($_POST);
//exit;
include"$path/meta.php";
include"$path/header.php";
include"$path/menu.php";

	$par_data_table ="bup_tahun={$bup_tahun}&jenisaset={$jenisaset}&kodeSatker={$kodeSatker}&kodepemilik={$kodepemilik}&kodeKelompok={$kodeKelompok}";
	?>
	<script>
		function confirmValidate(){	
			var checkedValue = $('#cekAll:checked').val();
			if(checkedValue){
				//alert("Checked");
				var r = confirm("Anda Yakin Mengusulkan Semua Data!");
		    	if (r == true) {
		    	    return true;
		    	} else {
		        	return false;
		    	}	
			}else{
				//alert("Unchecked");				
				var ConfH = $("#countcheckboxH").html();
				var conf = confirm(ConfH);
				if(conf){return true;} else {return false;}	
			}			
		}
		function countCheckbox(item,rvwitem){
			setTimeout(function() {
				$.post('<?=$url_rewrite?>/function/api/countapplist.php', { UserNm:'<?=$_SESSION['ses_uoperatorid']?>',act:item,rvwact:rvwitem,sess:'<?=$_SESSION['ses_utoken']?>'}, function(data){
						$("#countcheckbox").html("<h5>Jumlah Data yang akan dibuat usulan <div class='blink_text_blue'>"+data.countAset+" Data Aset</div><div>Total Nilai Rp."+data.totalNilaiAset+",-</div></h5>");
						$("#countcheckboxH").html("Jumlah Data yang akan dibuat usulan "+data.countAset+" Data Aset dengan Total Nilai Rp."+data.totalNilaiAset+",-");
					 },"JSON")
			}, 500);
		}
		function AreAnyCheckboxesChecked () 
		{

			setTimeout(function() {
		  if ($("#Form2 input:checkbox:checked").length > 0)
			{
				$("#submit").removeAttr("disabled");
			    updDataCheckbox('RVWUSPNG');
			    countCheckbox('RVWUSPNG');
			}
			else
			{
			   $('#submit').attr('disabled','disabled');
			   updDataCheckbox('RVWUSPNG');
			    countCheckbox('RVWUSPNG');
			}}, 100);
		}
		jQuery(function($) {
      		AreAnyCheckboxesChecked();
      		$("#cekAll").click( function(){
   				if($(this).is(':checked')){
					//alert("checked");
					$("#submit").removeAttr("disabled");
				}else{
					$('#submit').attr('disabled','disabled');
				}   					 
			});
      	});
		</script>
	<section id="main">
		<ul class="breadcrumb">
			 <li><a href="#"><i class="fa fa-home fa-2x"></i>  Home</a> <span class="divider"><b>&raquo;</b></span></li>
			  <li><a href="#">Penggunaan</a><span class="divider"><b>&raquo;</b></span></li>
			  <li class="active">Daftar Penetapan Penggunaan</li>
			  <?php SignInOut();?>
		</ul>
			<div class="breadcrumb">
				<div class="title">Penetapan Penggunaan</div>
				<div class="subtitle">Daftar Penetapan Penggunaan</div>
			</div>	
		<div class="grey-container shortcut-wrapper">
			<a class="shortcut-link active" href="<?=$url_rewrite?>/module/penggunaanv2/dftr_usulan_penggunaan.php">
				<span class="fa-stack fa-lg">
			      <i class="fa fa-circle fa-stack-2x"></i>
			      <i class="fa fa-inverse fa-stack-1x">1</i>
			    </span>
				<span class="text">Penetapan Penggunaan</span>
			</a>
			<a class="shortcut-link" href="<?=$url_rewrite?>/module/penggunaanv2/dftr_validasi_penggunaan.php">
				<span class="fa-stack fa-lg">
			      <i class="fa fa-circle fa-stack-2x"></i>
			      <i class="fa fa-inverse fa-stack-1x">2</i>
			    </span>
				<span class="text">Validasi Penggunaan</span>
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
                         {"bSortable": false},	
                         {"bSortable": true},	
                         {"bSortable": true},
                         {"bSortable": true},
                         {"bSortable": true},
                         {"bSortable": true},
                         {"bSortable": true},
                         {"bSortable": true}],
                    "sPaginationType": "full_numbers",

                    "bprocessing": true,
                    "bServerSide": true,
                    "sAjaxSource": "<?=$url_rewrite?>/api_list/api_aset_usulan_penggunaan.php?<?php echo $par_data_table?>"
               }
                  );
      });
    </script>
			<div id="demo">
			<form method="POST" ID="Form2" onsubmit="return confirmValidate()"  action="<?php echo"$url_rewrite"?>/module/penggunaanv2/daftar_tambahan_usulan_penggunaan.php"> 
			<table cellpadding="0" cellspacing="0" border="0" class="display  table-checkable" id="usulan_pmd_table">
				<thead>
					<tr>
						<td colspan="10" align="center">
							<span id="countcheckbox"><h5>Jumlah Data yang akan dibuat usulan <div class="blink_text_blue"><?=$CountData?> Data</div></h5></span>
							<span id="countcheckboxH" class="label label-success" style="display:none">Jumlah Data yang akan dibuat usulan <?=$CountData?> Data</span>
							<input type="hidden" name="Penggunaan_ID" value="<?=$_POST[Penggunaan_ID]?>">
							<input type="hidden" name="bup_tahun" value="<?=$_POST[bup_tahun]?>">
							<input type="hidden" name="kodepemilik" value="<?=$_POST[kodepemilik]?>">
							<input type="hidden" name="kodeKelompok" value="<?=$_POST[kodeKelompok]?>">
							<input type="hidden" name="jenisaset" value="<?=$_POST[jenisaset]?>">
							<input type="hidden" name="kodeSatker" value="<?=$_POST[kodeSatker]?>">
							<input type="hidden" name="kodeSatker" value="<?=$_POST[kodeSatker]?>">
						</td>
						
					</tr>
					<tr>
						<td colspan="10" align="center">
							<h4>Ceklis dibawah ini untuk memilih semua aset :</h4>
							  <label><input type="checkbox" value="1" name ="cekAll" id="cekAll"><h4>Select All</h4></label>
						</td>
					</tr>
					<tr>
						<td colspan="7" align="left">
								<span><button type="submit" name="submit" class="btn btn-info " id="submit" disabled/><i class="icon-plus-sign icon-white"></i>&nbsp;&nbsp;Buat Penetapan penggunaan</button></span>
						</td>
						<td colspan="3" align="right">
							<a href="<?php echo"$url_rewrite"?>/module/penggunaanv2/filter_tambah_aset_usulan_penggunaan.php?Penggunaan_ID=<?php echo $Penggunaan_ID?>" class="btn">Kembali Ke Pencarian</a>
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