
<?php

function selectSatker($name,$size=300,$br=false,$upd=false,$status=false){

	global $url_rewrite;
	// pr($status);
	if($br) $span = "span2"; else {$span="";$enter="<br>";}

	if($status == "required"){
	?>
		<script type="text/javascript">
			// $(document).on('submit',function(){
			// 	if($("#<?=$name?>").val() == ""){
			// 		alert("Kode Satker tidak boleh kosong");
			// 		return false;
			// 	}
			// })

			function newruangan(){
				if($("#<?=$satker?>").val() != ""){
					$('#addruangan').css("display","");
				} else {
					$('#addruangan').css("display","none");
				}
			}
		</script>
	<?php	
	}

	?>
	<script type="text/javascript">
	$(document).ready(function() {
	//fungsi dropselect

				$("#<?=$name?>").select2({
               		placeholder: "Pilih Unit Pengelola Barang",
               		dropdownAutoWidth: 'true',
				    <?=($_SESSION['ses_satkerkode']=="") ? 'minimumInputLength: 2,' : ''?>
				    ajax: {
				        url: "<?=$url_rewrite?>/function/api/satker.php",
				        dataType: 'json',
				        type: "GET",
				        quietMillis: 50,
				        data: function (term) {
				            return {
				                sess: '<?=$_SESSION['ses_satkerkode']?>',
				                term: term
				            };
				        },
				        results: function (data) {
				            return {
				                results: $.map(data, function (item) {
				                    return {
				                        text: item.kode+" "+item.NamaSatker,
				                        id: item.kode
				                    }	
				                })
				            };
				        }
				    }
				});
				var id = "<?=$upd?>";
				if(id)
				{
					$("#<?=$name?>").select2('data', {id: id, text: id});	
				}	
				

	} );
	</script>
	<li>
		<span class="<?=$span?>">Kode Satker </span><?=$enter?>
		<input id="<?=$name?>" name="<?=$name?>" type="hidden" style="width:<?=$size?>px" <?=$status?> onchange="return newruangan();"/>
	</li>
	
	
	<?php

}

function selectAllSatker($name,$size=300,$br=false,$upd=false,$status=false){

	global $url_rewrite;
	// pr($_SESSION);
	if($br) $span = "span2"; else {$span="";$enter="<br>";}

	if($status == "required"){
	?>
		<script type="text/javascript">
			// $(document).on('submit',function(){
			// 	if($("#<?=$name?>").val() == ""){
			// 		alert("Kode Satker tidak boleh kosong");
			// 		return false;
			// 	}
			// })
		</script>
	<?php	
	}

	?>
	<script type="text/javascript">
	$(document).ready(function() {
	//fungsi dropselect
				$("#<?=$name?>").select2({
               		placeholder: "Pilih Unit Pengelola Barang",
               		dropdownAutoWidth: 'true',
				    <?=($_SESSION['ses_satkerkode']=="") ? 'minimumInputLength: 2,' : ''?>
				    ajax: {
				        url: "<?=$url_rewrite?>/function/api/satker.php",
				        dataType: 'json',
				        type: "GET",
				        quietMillis: 50,
				        data: function (term) {
				            return {
				            	free: true,
				                sess: '',
				                term: term
				            };
				        },
				        results: function (data) {
				            return {
				                results: $.map(data, function (item) {
				                    return {
				                        text: item.kode+" "+item.NamaSatker,
				                        id: item.kode
				                    }	
				                })
				            };
				        }
				    }
				});
				var id = "<?=$upd?>";
				if(id)
				{
					$("#<?=$name?>").select2('data', {id: id, text: id});	
				}	
				

	} );
	</script>
	<li>
		<span class="<?=$span?>">Kode Satker </span><?=$enter?>
		<input id="<?=$name?>" name="<?=$name?>" type="hidden" style="width:<?=$size?>px" <?=$status?>/>
	</li>
	
	
	<?php

}

function selectAset($name,$size=300,$br=false,$upd=false,$status=false){

	global $url_rewrite;
	if($br) $span = "span2"; else {$span="";$enter="<br>";}

	if($status == "required"){
	?>
		<script type="text/javascript">
			$(document).on('submit',function(){
				if($("#<?=$name?>").val() == ""){
					alert("Jenis aset tidak boleh kosong");
					return false;
				}
			})
		</script>
	<?php	
	}

	?>
	<script type="text/javascript">
	$(document).ready(function() {
	//fungsi dropselect
				$("#<?=$name?>").select2({
               		placeholder: "Pilih Jenis Aset",
               		dropdownAutoWidth: 'true',
				    minimumInputLength: 2,
				    ajax: {
				        url: "<?=$url_rewrite?>/function/api/aset.php",
				        dataType: 'json',
				        type: "GET",
				        quietMillis: 50,
				        data: function (term) {
				            return {
				                term: term
				            };
				        },
				        results: function (data) {
				            return {
				                results: $.map(data, function (item) {
				                    return {
				                        text: item.Kode+" "+item.Uraian,
				                        id: item.Kode
				                    }
				                })
				            };
				        }
				    }
				});

			var id = "<?=$upd?>";
				if(id)
				{
					$("#<?=$name?>").select2('data', {id: id, text: id});	
				}	

	} );
	</script>
	<li>
		<span class="<?=$span?>">Jenis Aset </span><?=$enter?>
		<input id="<?=$name?>" name="<?=$name?>" type="hidden" style="width:<?=$size?>px" <?=$status?>/>
	</li>
	
	
	<?php

}

function selectRekening($name,$size=300,$br=false,$upd=false){

	global $url_rewrite;
	if($br) $span = "span2"; else {$span="";$enter="<br>";}
	?>
	<script type="text/javascript">
	$(document).ready(function() {
	//fungsi dropselect
				$("#<?=$name?>").select2({
               		placeholder: "Pilih Kode Rekening",
               		dropdownAutoWidth: 'true',
				    minimumInputLength: 3,
				    ajax: {
				        url: "<?=$url_rewrite?>/function/api/rekening.php",
				        dataType: 'json',
				        type: "GET",
				        quietMillis: 50,
				        data: function (term) {
				            return {
				                term: term
				            };
				        },
				        results: function (data) {
				            return {
				                results: $.map(data, function (item) {
				                    return {
				                        text: item.KodeRekening+" "+item.NamaRekening,
				                        id: item.KodeRekening
				                    }
				                })
				            };
				        }
				    }
				});

			var id = "<?=$upd?>";
				if(id)
				{
					$("#<?=$name?>").select2('data', {id: id, text: id});	
				}	

	} );
	</script>
	<li>
		<span class="<?=$span?>">Kode Rekening </span><?=$enter?>
		<input id="<?=$name?>" name="<?=$name?>" type="hidden" style="width:<?=$size?>px"/>
	</li>
	
	
	<?php

}

function selectRekening2($name,$size=300,$br=false,$upd=false){

	global $url_rewrite;
	if($br) $span = "span2"; else {$span="";$enter="<br>";}

	$sql = mysql_query("SELECT * FROM koderekening WHERE Kelompok IS NULL AND Jenis IS NULL AND Objek IS NULL AND RincianObjek IS NULL");
	while ($dataRek = mysql_fetch_assoc($sql)){
                    $tipe[] = $dataRek;
                }
	?>

	<script type="text/javascript">
		$(document).ready(function() {
			$("#tipe,#kelompok,#jenis,#objek,#rincian").select2({
				placeholder: "Pilih Kode Rekening",
               	dropdownAutoWidth: 'true'
			});	
		});	

		function autoLocation(name,dest){  
            //get the id  
            var idLocation = $('#'+name).val();  
			if(idLocation==''){
				$('#'+dest)
					.find('option')
					.remove()
					.end()
				;
			}
            //use ajax to run the check
			if(idLocation != 0)
			{
				$.post(basedomain+"dok_perencanaan/ajax", { idLocation: idLocation},  
					function(data){
					var locType = $('#'+dest);
					$('#'+dest)
						.find('option')
						.remove()
						.end()
					;
					locType.append("<option value=''>--</option>")
					for(i=0;i<data.length;i++){
						locType.append("<option value='" + data[i].kode_wilayah+ "_"+ data[i].nama_wilayah +"'>" + data[i].nama_wilayah + "</option>")
					}
				}, "JSON");
			}
    }
	</script>

	<li>
		<span class="<?=$span?>">Kode Rekening </span><?=$enter?>
		<select id="tipe" type="hidden" style="width:50px" >
		<?php
			foreach ($tipe as $key => $value) {
				echo "<option value='{$value['Tipe']}'>{$value['Tipe']} {$value['NamaRekening']}</option>";
			}
		?>	
		</select>
		.
		<select id="kelompok" type="hidden" style="width:50px">
		<?php
			foreach ($tipe as $key => $value) {
				echo "<option value='{$value['Tipe']}'>{$value['Tipe']} {$value['NamaRekening']}</option>";
			}
		?>	
		</select>
		.
		<select id="jenis" type="hidden" style="width:50px">
		<?php
			foreach ($tipe as $key => $value) {
				echo "<option value='{$value['Tipe']}'>{$value['Tipe']} {$value['NamaRekening']}</option>";
			}
		?>	
		</select>
		.
		<select id="objek" type="hidden" style="width:50px">
		<?php
			foreach ($tipe as $key => $value) {
				echo "<option value='{$value['Tipe']}'>{$value['Tipe']} {$value['NamaRekening']}</option>";
			}
		?>	
		</select>
		.
		<select id="rincian" type="hidden" style="width:50px">
		<?php
			foreach ($tipe as $key => $value) {
				echo "<option value='{$value['Tipe']}'>{$value['Tipe']} {$value['NamaRekening']}</option>";
			}
		?>	
		</select>
	</li>

	<?php
	

}

function selectRuang($name,$satker,$size=300,$br=false,$upd=false,$status=false){

	global $url_rewrite;
	// pr($_SESSION);
	if($br) $span = "span2"; else {$span="";$enter="<br>";}
	?>
	<script type="text/javascript">
	$(document).ready(function() {
	//fungsi dropselect

				$("#<?=$name?>").select2({
               		placeholder: "Pilih Ruang",
				    // minimumInputLength: 2,
				    ajax: {
				        url: "<?=$url_rewrite?>/function/api/ruang.php",
				        dataType: 'json',
				        type: "GET",
				        quietMillis: 50,
				        data: function (term) {
				            return {
				                term: $("#<?=$satker?>").val()
				            };
				        },
				        results: function (data) {
				            return {
				                results: $.map(data, function (item) {
				                    return {
				                        text: item.Kd_Ruang+" "+item.NamaSatker,
				                        id: item.Kd_Ruang
				                    }	
				                })
				            };
				        }
				    }
				});
				var id = "<?=$upd?>";
				if(id)
				{
					$("#<?=$name?>").select2('data', {id: id, text: id});	
				}	
				

	} );

	$('.detailLeft').on('click', '#simpan', function (){
       $.post('<?=$url_rewrite?>/function/api/addruang.php', {ruangan:$("#ruangan").val(), kodesatker:$("#<?=$satker?>").val()}, function(data){
	
		})
    });
	</script>
	<li>
		<span class="<?=$span?>">Kode Ruang</span><?=$enter?>
		<input id="<?=$name?>" name="<?=$name?>" type="hidden" style="width:<?=$size?>px" <?=$status?> />&nbsp;
		<a style="display:none" data-toggle="modal" href="#addruang" class="btn btn-small btn-success" id="addruangan"><i class="fa fa-plus"></i>&nbsp;Tambah</a>
	</li>
	
	<div id="addruang" class="modal hide fade  login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div id="titleForm" class="modal-header" >
				  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				  <h3 id="myModalLabel">Tambah Ruangan</h3>
				</div>
				<div class="modal-body">
				
				<div class="detailLeft">
						
						<ul>
							<li>
								<span class="span2">Nama Ruangan</span>
								<input type="text" name="ruangan" id="ruangan"/>
							</li>
						</ul>
							
					</div>
					
			</div>
			<div class="modal-footer">
			  <input type="button" value="Save" name="save" class="btn btn-default" id="simpan" data-dismiss="modal" />
			</div>
		</div> 
	
	<?php

}

function selectSatkerFree($name,$size=300,$br=false,$upd=false,$status=false){

	global $url_rewrite;
	// pr($_SESSION);
	if($br) $span = "span2"; else {$span="";$enter="<br>";}
	?>
	<script type="text/javascript">
	$(document).ready(function() {
	//fungsi dropselect
				$("#<?=$name?>").select2({
               		placeholder: "Pilih Unit Pengelola Barang",
				    minimumInputLength: 2,
				    ajax: {
				        url: "<?=$url_rewrite?>/function/api/satker.php",
				        dataType: 'json',
				        type: "GET",
				        quietMillis: 50,
				        data: function (term) {
				            return {
				                term: term
				            };
				        },
				        results: function (data) {
				            return {
				                results: $.map(data, function (item) {
				                    return {
				                        text: item.kode+" "+item.NamaSatker,
				                        id: item.kode
				                    }	
				                })
				            };
				        }
				    }
				});
				var id = "<?=$upd?>";
				if(id)
				{
					$("#<?=$name?>").select2('data', {id: id, text: id});	
				}	
				

	} );
	</script>
	<li>
		<span class="<?=$span?>">Kode Satker </span><?=$enter?>
		<input id="<?=$name?>" name="<?=$name?>" type="hidden" style="width:<?=$size?>px" <?=$status?>/>
	</li>
	
	
	<?php

}

?>
