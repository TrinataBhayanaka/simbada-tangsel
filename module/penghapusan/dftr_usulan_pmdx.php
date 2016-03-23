<?php
include "../../config/config.php";

$PENGHAPUSAN = new RETRIEVE_PENGHAPUSAN;
		$menu_id = 38;
        ($SessionUser['ses_uid']!='') ? $Session = $SessionUser : $Session = $SESSION->get_session(array('title'=>'GuestMenu', 'ses_name'=>'menu_without_login')); 
        $SessionUser = $SESSION->get_session_user();
        $USERAUTH->FrontEnd_check_akses_menu($menu_id, $SessionUser);
        
        $paging = $LOAD_DATA->paging($_GET['pid']);

// $get_data_filter = $RETRIEVE->retrieve_kontrak();
// ////pr($get_data_filter);
				

?>

<?php
	include"$path/meta.php";
	include"$path/header.php";
	include"$path/menu.php";
	
?><script type="text/javascript" language="javascript" src="<?php echo "$url_rewrite/"; ?>js/bootbox.js"></script>

 
	<!-- SQL Sementara -->
	<?php
	  // pr($_SESSION);
			unset($_SESSION['ses_retrieve_filter_'.$menu_id.'_'.$SessionUser['ses_uid']]);
				$parameter = array('menuID'=>$menu_id,'type'=>'','paging'=>$paging);
			// $data = $RETRIEVE->retrieve_daftar_usulan_penghapusan($parameter);
				// ////pr($data);
				$query = "select distinct Usulan_ID from UsulanAset where StatusPenetapan = 1 AND Jenis_Usulan = 'HPS'";
				$result  = mysql_query($query) or die (mysql_error());
				while ($dataNew = mysql_fetch_object($result))
				{
					$dataArr[] = $dataNew->Usulan_ID;
				}


		if ($_POST['submit']){
				// unset($_SESSION['ses_mutasi_filter']);
				// pr($_POST);
				$_SESSION['filterAsetUsulan'] = $_POST;
				
			}
		// $data_post=$PENGHAPUSAN->apl_userasetlistHPS("RVWUSPMD");

		// if($data_post){
			
		// }else{
			
		// }
		// $POST = $_SESSION['filterAsetUsulan'];
	
		$POST['page'] = intval($_GET['pid']);
	// pr($POST);
	    $par_data_table="bup_tahun=&bup_nokontrak=&jenisaset=&kodeSatker=&page={$POST['page']}";

// $data = $PENGHAPUSAN->retrieve_daftar_usulan_penghapusan_pmd($_POST);
// pr($data);

		 // $sql = mysql_query("SELECT * FROM kontrak ORDER BY id ");
   //      while ($dataKontrak = mysql_fetch_assoc($sql)){
   //              $kontrak[] = $dataKontrak;
   //          }
	?>
	<!-- End Sql -->
	<section id="main">
		<ul class="breadcrumb">
			  <li><a href="#"><i class="fa fa-home fa-2x"></i>  Home</a> <span class="divider"><b>&raquo;</b></span></li>
			  <li><a href="#">Penghapusan</a><span class="divider"><b>&raquo;</b></span></li>
			  <li class="active">Daftar Usulan Penghapusan Pemindahtanganan</li>
			  <?php SignInOut();?>
			</ul>
			<div class="breadcrumb">
				<div class="title">Usulan Penghapusan Pemindahtanganan</div>
				<div class="subtitle">Daftar Usulan Penghapusan Pemindahtanganan</div>
			</div>	
<!-- <input type="button" value="tes" id="tes"/> -->
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
                         // {"bSortable": false,"sClass": "checkbox-column" },
                         {"bSortable": true},
                         {"bSortable": false},
                         {"bSortable": false},
                         {"bSortable": true},
                         {"bSortable": false},
                         {"bSortable": true},
                         {"bSortable": false},
                         {"bSortable": false}],
                    "sPaginationType": "full_numbers",

                    "bProcessing": true,
                    "bServerSide": true,
                    "sAjaxSource": "<?=$url_rewrite?>/api_list/api_usulan_pmd.php?<?php echo $par_data_table?>"
               }
                  );
      });
    </script>
			<p>
			<?php
				if($_SESSION['ses_satkerkode']!=""){
			?>
			<a href="#" id="addUsulan" class="btn btn-info btn-small"><i class="icon-plus-sign icon-white"></i>&nbsp;&nbsp;Tambah Usulan</a>
			<?php
			}
			?>

			&nbsp;
			<div id="demo">
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="usulan_pmd_table">
				<thead>
					<tr>
						<th>No</th>
						<th>Nomor Usulan</th>
						<th>Satker</th>
						<th>Jumlah Aset</th>
						<th>Tgl Usulan</th>
						<th>Nilai</th>
						<th>Keterangan</th>
						<th>Status</th>
						<th>Tindakan</th>
					</tr>
				</thead>
				<tbody>			
					 <tr>
                        <td colspan="9">Data Tidak di temukkan</td>
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
			</div>
			<div class="spacer"></div>
			    
		</section> 
	</section>
	<script type="text/javascript">

function BootboxContent(){    
			// var slect2 ='';
            var frm_str = '<section class="formLegend">'
			+'<form method="POST" id="fdata" action="<?php echo "$url_rewrite/module/penghapusan/"; ?>daftar_usulan_penghapusan_usul_proses_pmdx.php">'
			+'<div class="detailLeft">'
						+'<ul><li>'
								+'<span  class="labelInfo">No Usulan</span>'
								+'<input type="text" name="noUsulan" value="" required/>'
						+'</li><li>'
								+'<span class="labelInfo">Keterangan usulan</span>'
								+'<textarea name="ketUsulan" required></textarea>'
						+'</li><li>'
								+'<span  class="labelInfo">Tanggal Usulan</span>'
									+'<div class="input-prepend">'					
										+'<input name="tanggalUsulan" type="text" class="date" required/>'
										+'<span class="add-on"><i class="fa fa-calendar"></i></span>'
									+'</div></li>'
									+'<li><span class="labelInfo">&nbsp;</span><input type="hidden" name="kdSatkerFilter" value="<?=$_SESSION["ses_satkerkode"]?>"/><input type="submit" class="btn btn-primary" value="Simpan Dokumen Usulan"/> </li>'
									+'</ul></div>'
									+'</form></section>';

            var object = $('<div/>').html(frm_str).contents();

            object.find('.date').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true}).on('changeDate', function (ev) {
                   $(this).blur();
                   $(this).datepicker('hide');
            });

             return object
        }
	$("#addUsulan").click(function() {
		bootbox.dialog({
		  title: "Silahkan Buat Dokumen Usulan Terlebih Dulu",
		  message: BootboxContent
		});

		// $( ".bootbox-close-button.close" ).trigger( "click" );
});
$(document).on('submit','#fdata',function(event) {
// alert("submit");
var postData = $(this).serializeArray();
	    var formURL = $(this).attr("action");
	    
        $.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : formURL, // the url where we want to POST
            data        : postData, // our data object
            dataType    : 'json', // what type of data do we expect back from the server
            encode          : true
        })
            // using the done promise callback
            .done(function(data) {
            		$(document).ready(function() {
          $('#usulan_pmd_table').dataTable(
                   {
                    "aoColumnDefs": [
                         { "aTargets": [2] }
                    ],
                    "aoColumns":[
                         {"bSortable": false},
                         // {"bSortable": false,"sClass": "checkbox-column" },
                         {"bSortable": true},
                         {"bSortable": false},
                         {"bSortable": false},
                         {"bSortable": true},
                         {"bSortable": false},
                         {"bSortable": true},
                         {"bSortable": false},
                         {"bSortable": false}],
                    "sPaginationType": "full_numbers",

                    "bProcessing": true,
                    "bServerSide": true,
                    "sAjaxSource": "<?=$url_rewrite?>/api_list/api_usulan_pmd.php?<?php echo $par_data_table?>"
               }
                  );
      });
		// $( ".bootbox-close-button.close" ).trigger( "click" );
          
            });


        // stop the form from submitting the normal way and refreshing the page
        event.preventDefault();
})
</script>
<?php
	include"$path/footer.php";
?>