	
	
	
	
 
 <div class="page-content">
	<div class="containers">

		<div class="page-content-inner">
			<div class="row" style="margin: 0;">
				<div class="col-md-12" >

					<!-- BEGIN Portlet PORTLET-->
					<div class="portlet light" id="div_soal_ujian" style="">
						<div class="portlet-body" id="div_ujian" >
								<div class="row">
									<div class="col-md-6" style="margin-bottom:5px">
										SOAL NO &nbsp;&nbsp;<span class='btn btn-primary' id='no_soal'><b>1</b></span>
										
										<input id="input_no_soal" type="hidden" value="1">
										<input id="input_id_soal_siswa" type="hidden" value="<?=$this->idSoalSiswaPertama->id_soal_siswa;?>">
										
									</div>
									<div class="col-md-6 text-right">
										<span class='btn default'><b>SISA WAKTU</b></span>
										<span class='btn btn-primary'><b id="menit_mundur"><?=sprintf("%02d", $this->siswaUjian->menit_pengerjaan);?>:00</b></span>
										
										<input id="menit_akhir" type="hidden" value="<?=$this->siswaUjian->menit_pengerjaan;?>">
									</div>
								</div>
								
								<div class="row" id="ukuran_font_soal">
									<div class="col-md-12">
										Ukuran Font Soal : 
										<span style="font-size:14px;margin-right:10px;cursor:pointer" onclick="change_font('14')">A</span> 
										<span style="font-size:20px;margin-right:10px;cursor:pointer" onclick="change_font('20')">A</span>  
										<span style="font-size:26px;cursor:pointer" onclick="change_font('26')">A</span>
									</div>
								</div>
								<?=$this->soalHtml;?>
						</div>
					</div>
				</div>
								
								
			</div>
							
		</div>
		</div>
					<!-- END Portlet PORTLET-->
			</div>
		</div>
	</div>
</div>
</div>





<div id="modal_selesai_ujian" aria-hidden="true" data-backdrop="static" data-keyboard="false" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Konfirmasi Tes</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12">
						<center><h4>Apakah anda yakin akan mengakhiri Ujian ini ..?</h4></center>
						<br>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-1" style="margin-bottom:20px">
					<center>
						<div class="md-checkbox">
							<input type="checkbox" onclick="enableBtnSelesai()" id="check_selesai" class="md-check">
							<label for="check_selesai">
								<span class="inc"></span>
								<span class="check"></span>
								<span class="box"></span> 
							</label>
						</div>
					</center>
					</div>
					<div class="col-sm-11" style="align:justify">
						Centang, kemudian tekan tombol selesai. Anda tidak akan bisa kembali ke soal, jika sudah menekan tombol selesai.
					</div>				
				</div>
				<hr>
				<div class="row">
					<div class="col-sm-12" id="pesan_error_modal_selesai_ujian">												
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">						
						<span class="btn green btn-block" id='btnSelesaiEnabled'  style="margin-top:5px;display:none" onclick="selesai_ujian()">SELESAI</span>
						<span class="btn green btn-block" id='btnTutupUjian'  style="margin-top:5px;display:none" onclick="tutup_ujian()">SELESAI</span>
						<span class="btn green btn-block disabled" id='btnSelesaiDisabled' >SELESAI</span>
					</div>
					
					<div class="col-sm-6" style="margin-top:5px;">
						<span class="btn red btn-block" data-dismiss="modal" id="btnTidak">TIDAK</span>						
					</div>
				</div>
			</div>
		</div>

	</div>
</div>


<div id="modal_waktu_selesai" aria-hidden="true" data-backdrop="static" data-keyboard="false" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Pesan Pemberitahuan</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12">
						Waktu anda untuk mengerjakan Ujian ini telah Selesai, silahkan klik tombol Selesai.
						<hr>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12" id="pesan_error_waktu_habis">								
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6 col-sm-offset-3">
						<span class="btn green btn-block" id='btnSelesaiWaktuHabis' onclick="selesai_ujian()">SELESAI</span>					
					</div>
				</div>
			</div>
		</div>

	</div>
</div>



<div id="modal_ucapan_selesai" aria-hidden="true" data-backdrop="static" data-keyboard="false" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Pesan Pemberitahuan</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12">
						<center>Terima kasih Anda telah melakukan Ujian.</center>
						
						<span id="nilai_ujian"></span>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6 col-sm-offset-3">
						<span class="btn green btn-block" id='btnSelesaiWaktuHabis' onclick="location.href='<?=base_url();?>siswa/dashboard'">Kembali ke Halaman Beranda</span>					
					</div>
				</div>
			</div>
		</div>

	</div>
</div>



<input id="sedang_play" type="hidden">
<!--right menu -->
<div id="rightmenu">
    <br>
		<?=$this->daftarSoal;?>
</div>
<!-- end right menu -->

<script>



function pad(n, width, z) {
  z = z || '0';
  n = n + '';
  return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
}
function startTimer(duration, display) {
    var timer = duration, minutes, seconds, jam, sisaMenit, menitJaml;
    setInterval(function () {
        minutes = parseInt(timer / 60, 10)
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;
		if(minutes > 59){
			jam = Math.floor(minutes / 60);
			menitJam = parseInt(jam) * 60;
			sisaMenit = parseInt(minutes) - parseInt(menitJam);
			display.textContent = pad(jam,2) + ":" +  pad(sisaMenit,2) + ":"+ seconds;	
		}
		else{			
			display.textContent = "00:"+minutes + ":" + seconds;
		}
       	
		
		$('#menit_akhir').val(minutes);
        if (--timer < 0) {
            timer = duration;
        }		
		
		if(minutes == 00){
			
			if(seconds < 30){
				$('#menit_mundur').pulsate();
			}
			if(seconds == 00){
				$('#div_ujian').slideUp();
				
				tutup_ujian();
			}
		}
    }, 1000);
	
}

window.onload = function () {
    var lama = 60 * <?=$this->siswaUjian->menit_pengerjaan;?>,
    display = document.querySelector('#menit_mundur');
    startTimer(lama, display);	
	
};


function kirim_jawaban(id_jawaban,id_soal,id_detail_siswa_paket_ujian,abjad,input_id_soal_siswa,abcd){
	
	
	for (i = 0; i < 6; i++) { 		 
		if(i != abjad){				
			$('#select_'+input_id_soal_siswa+'_'+i).attr('checked', false);
			$('#label_'+input_id_soal_siswa+'_'+i).removeClass('jawab_pilih');
		}
		else{
			
		}
	}		
	
	$('#select_'+input_id_soal_siswa+'_'+abjad).attr('checked', true);
	$('#label_'+input_id_soal_siswa+'_'+abjad).addClass('jawab_pilih');
	
	
	var urlTujuan = $("#form_soal").attr('action');	
	$.ajax({
		url: urlTujuan,
		type:'POST',
		dataType:'json',
		data: {id_m_jawaban:id_jawaban, id_m_soal:id_soal, id_detail_siswa_paket_ujian:id_detail_siswa_paket_ujian, menit_akhir:$('#menit_akhir').val(), id_m_ujian_mapel : <?=$this->dataUjianMapel->id_m_ujian_mapel;?>},
		success: function(data){
			if( data.status ){	
				$('#slide_abcd_'+input_id_soal_siswa).html(abcd);
				
				if(
					$("#btn_ragu_ragu_"+input_id_soal_siswa).is(':checked')){
					
				}
				else{
					$('#daftar_soal_'+input_id_soal_siswa).addClass('sudah_dijawab');
				}
				
				
			}
			else{				
				alert('Maaf Proses Pengiriman Data Jawaban Gagal, silahkan cek koneksi ke Server atau laporkan ke Petugas. klik Ok, maka Sistem akan merefresh Halaman.');
			//location.reload();		 
			}
		},
		error : function(data) {
			alert('Maaf Proses Pengiriman Data Jawaban Gagal, silahkan cek koneksi ke Server atau laporkan ke Petugas. klik Ok, maka Sistem akan merefresh Halaman.');
			//location.reload();
		}
	})
}




function jawab_esay(id_soal,id_detail_siswa_paket_ujian,abjad,input_id_soal_siswa,abcd){
	
	
	
	var urlTujuan = $("#form_soal").attr('action');	
	$.ajax({
		url: urlTujuan,
		type:'POST',
		dataType:'json',
		data: { 'type_soal' : 'esay', 'id_m_soal':id_soal, 'id_detail_siswa_paket_ujian':id_detail_siswa_paket_ujian, 'menit_akhir':$('#menit_akhir').val(), 'jawaban_esay':$('#textarea_'+input_id_soal_siswa).val()},
		success: function(data){
			if( data.status ){	
				$('#slide_abcd_'+input_id_soal_siswa).html('&#10003;');
				
				if($("#btn_ragu_ragu_"+input_id_soal_siswa).is(':checked')){
					
				}
				else{
					//alert(input_id_soal_siswa);
					$('#daftar_soal_'+input_id_soal_siswa).addClass('sudah_dijawab');
				}
				
				
			}
			else{				
				alert('gagal');				 
			}
		},
		error : function(data) {
			alert('Maaf Proses Pengiriman Data Jawaban Gagal, silahkan cek koneksi ke Server atau laporkan ke Petugas. klik Ok, maka Sistem akan merefresh Halaman.');
			location.reload();
		}
	})
}


function klik(event){
	if(event.keyCode == 37) {
		if($('#input_no_soal').val() > 1){
			var idTSiswaJawabanSebelumnya 	= $('#input_id_soal_siswa').val() - 1;
			var soalSebelumnya 				= $('#input_no_soal').val() - 1;
			buka_soal( idTSiswaJawabanSebelumnya, soalSebelumnya );
		}
		
		event.preventDefault()
	}
	
	if(event.keyCode == 39) {
		if($('#input_no_soal').val() < <?=count($this->soalUjian);?>){
			var input_id_soal_siswa 	= 	parseInt($('#input_id_soal_siswa').val());
			var idTSiswaJawabanNext 	= 	parseInt(input_id_soal_siswa + 1);
			
			var input_no_soal 			= 	parseInt($('#input_no_soal').val());
			var soalNext 				=  	parseInt(input_no_soal + 1);
			buka_soal( idTSiswaJawabanNext, soalNext );
		}
		else{
			btn_selesai_ujian();
		}
		
		event.preventDefault()
	}
	
	var input_id_soal_siswa 	= $('#input_id_soal_siswa').val();

	function hilang_semua(idJangan,abcd){	
		
		
		//kirim_jawaban($('#select_'+input_id_soal_siswa+'_'+idJangan).val(), $('#input_id_soal_'+input_id_soal_siswa).val(), <?=$this->siswaUjian->id_detail_siswa_paket_ujian;?>,'',input_id_soal_siswa,abcd);
	
	}


	if(event.keyCode == 65) {		
		hilang_semua('0','A');			
	}	
	if(event.keyCode == 66) {
		hilang_semua('1','B');			
	}	
	if(event.keyCode == 67) {
		hilang_semua('2','C');			
	}
	if(event.keyCode == 68) {
		hilang_semua('3','D');			
	}
	if(event.keyCode == 69) {
		hilang_semua('4','E');			
	}
	
}



function change_font(ukuranFont){
	$(".font_soal").css("fontSize", ukuranFont+"px");
	
	var sizeImage = ukuranFont * 7;
	//$('.font_soal img').css({'width' : sizeImage+'px'});
}

function ragu_ragu(id_soal_siswa){
	if($("#btn_ragu_ragu_"+id_soal_siswa).is(':checked')){
		var hasilRagu = "Y";
		
		
		$('#daftar_soal_'+id_soal_siswa).addClass("circle_ragu");
		$('#daftar_soal_'+id_soal_siswa).removeClass("sudah_dijawab");
	}
	
	else{
		var hasilRagu = "N";	
		$('#daftar_soal_'+id_soal_siswa).removeClass("circle_ragu");
		$('#daftar_soal_'+id_soal_siswa).addClass("sudah_dijawab");
	}
	$.ajax({
		url: '<?=base_url();?>siswa/ujian/ragu_submit',
		type:'POST',
		dataType:'json',
		data: {id_soal_siswa:id_soal_siswa, hasil_ragu :hasilRagu },
		success: function(data){
			if( data.status ){	
				//alert('oke');
				$('#daftar_soal_'+id_soal_siswa).addClass("circle_ragu");
			}
			else{				
				alert('gagal');				 
			}
		},
		error : function(data) {	
			alert('Maaf Proses Pengiriman Data Jawaban Gagal, silahkan cek koneksi ke Server atau laporkan ke Petugas. klik Ok, maka Sistem akan merefresh Halaman.');
			location.reload();
		}
	})
	
}

function buka_soal(id_soal_siswa, nomor_soal){
	
	if($('#sedang_play').val() == 'Y'){
		alert('Silahkan pause dulu Audio/Video yang berjalan.');
	}
	else{
		
		if ($("#btn_next_"+id_soal_siswa).is('[disabled=""]')) {
			alert("disabled");
		} 
		else if ($("#btn_prev_"+id_soal_siswa).is('[disabled=""]')) {
			alert("disabled");
		}
		else {
			$('#no_soal').html('<b>'+nomor_soal+'</b>');	
			$('#input_no_soal').val(nomor_soal);	
			$('#input_id_soal_siswa').val(id_soal_siswa);	
			<?php
			foreach($this->soalUjian as $data){
			?>
			$('#div_soal_<?=$data->id_soal_siswa;?>').hide();
			$('#daftar_soal_<?=$data->id_soal_siswa;?>').removeClass('current_soal');
			<?php
			}
			?>	
			$('#div_soal_'+id_soal_siswa).show();		
			$('#daftar_soal_'+id_soal_siswa).addClass('current_soal');
		 }
	}
	
}

function btn_selesai_ujian(){
	if($('#sedang_play').val() == 'Y'){
		alert('Silahkan pause dulu Audio/Video yang berjalan.');
	}
	else{
	
		$('#pesan_error_modal_selesai_ujian').html('');
		$('#modal_waktu_selesai').modal('hide');
		$('#modal_selesai_ujian').modal('show');
	}
}

function enableBtnSelesai(){
	if($("#check_selesai").is(':checked')){		
		
		$('#btnSelesaiEnabled').show();
		$('#btnSelesaiDisabled').hide();
	}
	else{
		$('#btnSelesaiEnabled').hide();
		$('#btnSelesaiDisabled').show();
	}
}

function pause_jon(idSoal){
	$('#sedang_play').val('N');
}

function play_jon(idSoal){
	$('#sedang_play').val('Y');
	
}

function cek_pause_audio(idSoal){
	var myAudio = document.getElementById('audio_'+idSoal);

	if (myAudio.duration > 0 && !myAudio.paused) {		
		$('#btn_next_'+idSoal).show(); 
		$('#btn_prev_'+idSoal).show(); 
		
		$('#div_next_pesan_pause_'+idSoal).hide(); 
		$('#div_prev_pesan_pause_'+idSoal).hide(); 

	} else {
		$('#btn_next_'+idSoal).hide();
		$('#btn_prev_'+idSoal).hide();		
		
		$('#div_next_pesan_pause_'+idSoal).show(); 
		$('#div_prev_pesan_pause_'+idSoal).show();
	}
}

function selesai_ujian(){
	
	$.ajax({
		url: '<?=base_url();?>siswa/ujian/selesai',
		type:'POST',
		dataType:'json',
		data: {id_detail_siswa_paket_ujian:<?=$this->siswaUjian->id_detail_siswa_paket_ujian;?> },
		beforeSend: function(){	
			$('#btnSelesaiWaktuHabis').html('Proses Simpan ...');
			$('#btnSelesaiDisabled').html('Proses Simpan ...');
		},
		success: function(data){
			if( data.status ){	
				
				tutup_ujian();
			
			}
			else{		
				$('#pesan_error_modal_selesai_ujian').html(data.pesan);		 
				$('#pesan_error_modal_selesai_ujian').show();	
			
				if(data.ragu){
					$('#btnSelesaiEnabled').hide();
					$('#btnTutupUjian').show();
					$('#btnTidak').show();	
				}
				else if(data.sudah_ujian){
					$('#btnSelesaiEnabled').hide();
					$('#btnTutupUjian').show();
					$('#btnTidak').hide();					
				}
				else{
					$('#btnSelesaiEnabled').show();
					$('#btnTutupUjian').hide();
					
					
					$('#btnTidak').show();		
				}
					 
			}
		},
		error : function(data) {			
			alert('Maaf Proses Pengiriman Data Jawaban Gagal, silahkan cek koneksi ke Server atau laporkan ke Petugas. klik Ok, maka Sistem akan merefresh Halaman.');
			location.reload();
		}
	})
}

function tutup_ujian(){
	$.ajax({
		url: '<?=base_url();?>siswa/ujian/tutup_ujian',
		type:'POST',
		dataType:'json',
		data: {id_detail_siswa_paket_ujian:<?=$this->siswaUjian->id_detail_siswa_paket_ujian;?> , id_m_ujian_mapel : <?=$this->dataUjianMapel->id_m_ujian_mapel;?>},
		beforeSend: function(){	
			$('#btnSelesaiWaktuHabis').html('Proses Simpan ...');
			$('#btnTutupUjian').html('Proses Simpan ...');
		},
		success: function(data){
			if( data.status ){	
				
				$('#div_ujian').slideUp();
				
				$('#modal_waktu_selesai').modal('hide');
				$('#modal_selesai_ujian').modal('hide');
				
				$('#nilai_ujian').html(data.nilai);
				$('#modal_ucapan_selesai').modal('show');
				
				/**
				$.ajax({
					url: '<?=base_url();?>siswa/ujian/nilai_ujian',
					type:'POST',
					dataType:'html',
					data: {id_detail_siswa_paket_ujian:<?=$this->siswaUjian->id_detail_siswa_paket_ujian;?> },
					
					success: function(data){
						$('#nilai_ujian').html(data);
						$('#modal_ucapan_selesai').modal('show');
					},
					
					error : function(data) {			
						alert('Maaf Proses Pengiriman Data Jawaban Gagal, silahkan cek koneksi ke Server atau laporkan ke Petugas. Sistem menyarankan anda untuk refresh Halaman ini dengan menekan tombol F5. Sebagai catatan bahwa Hasil Jawaban anda tidak akan hilang (sudah tersimpan), jadi tidak perlu khawatir jika me-Refresh Halaman ini.');
					}
				})
				**/
				
			
			}
			else{		
				$('#pesan_error_modal_selesai_ujian').html(data.pesan);		 
				$('#pesan_error_modal_selesai_ujian').show();	
			 
				$('#div_ujian').show();
			}
		},
		error : function(data) {			
			alert('Maaf Proses Pengiriman Data Jawaban Gagal, silahkan cek koneksi ke Server atau laporkan ke Petugas. klik Ok, maka Sistem akan merefresh Halaman.');
			location.reload();
		}
	})
				
}	

$(function() {
	$('#rightmenu').BootSideMenu({
		side: "right",
		pushBody: true,
		autoClose: true,
		remember: false,
	});
});




</script>