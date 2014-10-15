<?php
include "../../config/config.php";
$menu_id = 10;
            $SessionUser = $SESSION->get_session_user();
            ($SessionUser['ses_uid']!='') ? $Session = $SessionUser : $Session = $SESSION->get_session(array('title'=>'GuestMenu', 'ses_name'=>'menu_without_login')); 
            $USERAUTH->FrontEnd_check_akses_menu($menu_id, $Session);

// $get_data_filter = $RETRIEVE->retrieve_kontrak();
// pr($get_data_filter);
?>

<?php
	include"$path/meta.php";
	include"$path/header.php";
	include"$path/menu.php";
	
?>
	<!-- SQL Sementara -->
	<?php

		if(isset($_POST['kodeKelompok'])){
		    if($_POST['Aset_ID'] == "")
		    {
		      $dataArr = $STORE->store_aset($_POST);
		    }  else
		    {
		      $dataArr = $STORE->store_edit_aset($_POST,$_POST['Aset_ID']);
		    }
		  }

		//kontrak
		$idKontrak = $_GET['id'];
		$sql = mysql_query("SELECT * FROM kontrak WHERE id='{$idKontrak}' LIMIT 1");
			while ($dataKontrak = mysql_fetch_assoc($sql)){
					$kontrak[] = $dataKontrak;
				}
		// pr($kontrak);

		//sum total 
		$sqlsum = mysql_query("SELECT SUM(NilaiPerolehan) as total FROM aset WHERE noKontrak = '{$kontrak[0]['noKontrak']}'");
		while ($sum = mysql_fetch_array($sqlsum)){
					$sumTotal = $sum;
				}

	?>
	<!-- End Sql -->
	<section id="main">
		<ul class="breadcrumb">
			  <li><a href="#"><i class="fa fa-home fa-2x"></i>  Home</a> <span class="divider"><b>&raquo;</b></span></li>
			  <li><a href="#">Perolehan Aset</a><span class="divider"><b>&raquo;</b></span></li>
			  <li><a href="#">Kontrak</a><span class="divider"><b>&raquo;</b></span></li>
			  <li class="active">Rincian Barang</li>
			  <?php SignInOut();?>
			</ul>
			<div class="breadcrumb">
				<div class="title">Rincian Barang</div>
				<div class="subtitle">Input Data Aset</div>
			</div>		

		<section class="formLegend">
			
		<div class="detailLeft">
						
						<ul>
							<li>
								<span class="labelInfo">No. Kontrak</span>
								<input type="text" value="<?=$kontrak[0]['noKontrak']?>" disabled/>
							</li>
							<li>
								<span class="labelInfo">Tgl. Kontrak</span>
								<input type="text" value="<?=$kontrak[0]['tglKontrak']?>" disabled/>
							</li>
						</ul>
							
					</div>
			<div class="detailRight">
						
						<ul>
							<li>
								<span class="labelInfo">Nilai SPK</span>
								<input type="text" id="spk" value="<?=number_format($kontrak[0]['nilai'])?>" disabled/>
							</li>
							<li>
								<span  class="labelInfo">Total Rincian Barang</span>
								<input type="text" id="totalRB" value="<?=isset($sumTotal) ? number_format($sumTotal['total']) : '0'?>" disabled/>
							</li>
						</ul>
							
					</div>
			<div style="height:5px;width:100%;clear:both"></div>
			
			<div>
			<form action="" method="POST">
				 <div class="formKontrak">
						<ul>
							<?php selectAset('kodeKelompok','255',true,false); ?>
						</ul>
						<ul class="tanah" style="display:none">
							<li>
								<span class="span2">Luas Total</span>
								<input type="text" class="span3" name="LuasTotal" disabled/>
							</li>
							<li>
								<span class="span2">No. Sertifikat</span>
								<input type="text" class="span3" name="NoSertifikat" disabled/>
							</li>
							<li>
								<span class="span2">Tgl. Sertifikat</span>
								<input type="text" class="span3" name="TglSertifikat" id="datepicker" disabled/>
							</li>
						</ul>
						<ul class="mesin" style="display:none">
							<li>
								<span class="span2">Merk</span>
								<input type="text" class="span3" name="Merk" disabled/>
							</li>
							<li>
								<span class="span2">Model</span>
								<input type="text" class="span3" name="Model" disabled/>
							</li>
							<li>
								<span class="span2">Ukuran</span>
								<input type="text" class="span3" name="Ukuran" disabled/>
							</li>
						</ul>
						<ul class="bangunan" style="display:none">
							<li>
								<span class="span2">Jumlah Lantai</span>
								<input type="text" class="span3" name="JumlahLantai" disabled/>
							</li>
							<li>
								<span class="span2">Luas Lantai</span>
								<input type="text" class="span3" name="LuasLantai" disabled/>
							</li>
						</ul>
						<ul class="jaringan" style="display:none">
							<li>
								<span class="span2">Panjang</span>
								<input type="text" class="span3" name="Panjang" disabled/>
							</li>
							<li>
								<span class="span2">Lebar</span>
								<input type="text" class="span3" name="Lebar" disabled/>
							</li>
							<li>
								<span class="span2">Luas Jaringan</span>
								<input type="text" class="span3" name="LuasJaringan" disabled/>
							</li>
						</ul>
						<ul class="asetlain" style="display:none">
							<li>
								<span class="span2">Judul</span>
								<input type="text" class="span3" name="Judul" disabled/>
							</li>
							<li>
								<span class="span2">Pengarang</span>
								<input type="text" class="span3" name="Pengarang" disabled/>
							</li>
							<li>
								<span class="span2">Penerbit</span>
								<input type="text" class="span3" name="Penerbit" disabled/>
							</li>
						</ul>
						<ul class="kdp" style="display:none">
							<li>
								<span class="span2">Jumlah Lantai</span>
								<input type="text" class="span3" name="JumlahLantai" disabled/>
							</li>
							<li>
								<span class="span2">Luas Lantai</span>
								<input type="text" class="span3" name="LuasLantai" disabled/>
							</li>
						</ul>
						<ul>
							<li>
								<span class="span2">Alamat</span>
								<textarea name="Alamat" class="span3" ></textarea>
							</li>
							<li>
								<span class="span2">Jumlah</span>
								<input type="text" class="span3" name="Kuantitas" id="jumlah" onchange="return totalHrg()" required/>
							</li>
							<li>
								<span class="span2">Harga Satuan</span>
								<input type="text" class="span3" name="Satuan" id="hrgSatuan" onchange="return totalHrg()" required/>
							</li>
							<li>
								<span class="span2">Nilai Perolehan</span>
								<input type="text" class="span3" name="NilaiPerolehan" id="total" readonly/>
							</li>
							<li>
								<span class="span2">Info</span>
								<textarea name="Info" class="span3" ></textarea>
							</li>
							<li>
								<span class="span2">
								  <button class="btn" type="reset">Reset</button>
								  <button type="submit" id="submit" class="btn btn-primary">Simpan</button></span>
							</li>
						</ul>
							
					</div>
					<!-- hidden -->
					<input type="hidden" name="Aset_ID" value="">
					<input type="hidden" name="id" value="<?=$kontrak[0]['id']?>">
					<input type="hidden" name="kodeSatker" value="<?=$kontrak[0]['kodeSatker']?>">
					<input type="hidden" name="noKontrak" value="<?=$kontrak[0]['noKontrak']?>">
					<input type="hidden" name="TglPerolehan" value="<?=$kontrak[0]['tglKontrak']?>">
					<input type="hidden" name="kondisi" value="1">
					<input type="hidden" name="UserNm" value="<?=$_SESSION['ses_uoperatorid']?>">
					<input type="hidden" name="Tahun" value="<?=date('Y', strtotime($kontrak[0]['tglKontrak']));?>">
					<input type="hidden" name="TipeAset" id="TipeAset" value="">
			
		</form>
		</div>  
			    
		</section> 
		     
	</section>
	
<?php
	include"$path/footer.php";
?>

<script type="text/javascript">
	$(document).on('change','#aset', function(){

		var kode = $('#aset').val();
		var gol = kode.split(".");

		if(gol[0] == '01')
		{
			$("#TipeAset").val('A');
			$(".mesin,.bangunan,.jaringan,.asetlain,.kdp").hide('');
			$(".mesin,.bangunan,.jaringan,.asetlain,.kdp li > input,textarea").attr('disabled','disabled');
			$(".tanah li > input,textarea").removeAttr('disabled');
			$(".tanah").show('');
		} else if(gol[0] == '02')
		{
			$("#TipeAset").val('B');
			$(".tanah,.bangunan,.jaringan,.asetlain,.kdp").hide('');
			$(".tanah,.bangunan,.jaringan,.asetlain,.kdp li > input,textarea").attr('disabled','disabled');
			$(".mesin li > input,textarea").removeAttr('disabled');
			$(".mesin").show('');
		} else if(gol[0] == '03')
		{
			$("#TipeAset").val('C');
			$(".tanah,.mesin,.jaringan,.asetlain,.kdp").hide('');
			$(".tanah,.mesin,.jaringan,.asetlain,.kdp li > input,textarea").attr('disabled','disabled');
			$(".bangunan li > input,textarea").removeAttr('disabled');
			$(".bangunan").show('');
		} else if(gol[0] == '04')
		{
			$("#TipeAset").val('D');
			$(".tanah,.mesin,.bangunan,.asetlain,.kdp").hide('');
			$(".tanah,.mesin,.bangunan,.asetlain,.kdp li > input,textarea").attr('disabled','disabled');
			$(".jaringan li > input,textarea").removeAttr('disabled');
			$(".jaringan").show('');
		} else if(gol[0] == '05')
		{
			$("#TipeAset").val('E');
			$(".tanah,.mesin,.bangunan,.jaringan,.kdp").hide('');
			$(".tanah,.mesin,.bangunan,.jaringan,.kdp li > input,textarea").attr('disabled','disabled');
			$(".asetlain li > input,textarea").removeAttr('disabled');
			$(".asetlain").show('');
		} else if(gol[0] == '06')
		{
			$("#TipeAset").val('F');
			$(".tanah,.mesin,.bangunan,.asetlain,.jaringan").hide('');
			$(".tanah,.mesin,.bangunan,.asetlain,.jaringan li > input,textarea").attr('disabled','disabled');
			$(".kdp li > input,textarea").removeAttr('disabled');
			$(".kdp").show('');
		} else {
			$("#TipeAset").val('G');
			$(".tanah,.mesin,.bangunan,.asetlain,.jaringan,.kdp").hide('');
			$(".tanah,.mesin,.bangunan,.asetlain,.jaringan,.kdp li > input").attr('disabled','disabled');
		}			
		
	})

	$(document).on('submit', function(){
		var perolehan = $("#total").val();
		var total = $("#totalRB").val();
		var spk = $("#spk").val();
		var str = parseInt(spk.replace(/[^0-9\.]+/g, ""));
		var rb = parseInt(total.replace(/[^0-9\.]+/g, ""));

		var diff = parseInt(perolehan) + parseInt(rb);

		if(diff > str) {
			alert("Total rincian barang melebihi nilai SPK");
			return false;	
		}
	})

	function totalHrg(){
		var jml = $("#jumlah").val();
		var hrgSatuan = $("#hrgSatuan").val();
		var total = jml*hrgSatuan;
		$("#total").val(total);
	}
</script>