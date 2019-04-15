 <div class="page-content">
	<div class="containser">

		<div class="page-content-inner">
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light">
						<div class="caption">
							<i class="fa fa-bars font-blue-sharp"></i>
							<span class="caption-subject font-blue-sharp bold">Detail Mata Pelajaran <?=$this->dataMapel->nm_mata_pelajaran;?> di Ujian : <?=$this->dataUjian->nm_ujian;?></span>
						</div>
					</div>

					<!-- BEGIN Portlet PORTLET-->
					<div class="portlet light" id="div_detail_soal">
						<div class="portlet-title">
							<div class="caption">
								<span onclick="location.href='<?=$this->template_view->base_url_admin();?>/<?=$this->uri->segment('2');?>/mapel/<?=$this->dataUjian->id_m_ujian;?>'" class="btn btn-warning"><i class="fa fa-backward"></i> Kembali ke Daftar Mata Pelajaran Ujian</span>
							
								
							</div>
							
						</div>
						<div class="portlet-body">
						
							
							<form class="form-horizontal" id="form_detail_mapel" method="post" action="<?=$this->template_view->base_url_admin();?>/<?=$this->uri->segment('2');?>/insert_detail_mapel/<?=$this->dataUjian->id_m_ujian;?>/<?=$this->dataMapel->id_m_ujian_mapel;?>">
							<?php if($this->session->notice){echo $this->session->notice;} ?>
							<!--<div class="table-scrollable">-->
							
								<table class="table table-stripsed table-bordered table-hosver table-checkable order-column" id="sampsle_2">
									<tr>
										<td colspan="3"><b>Info</b></td>
									</tr>
									<tr>
										<td  align=center width="33%">Jumlah Soal ganda</td>
										<td  align=center width="33%">Jumlah Soal Uraian</td>
										<td align=center width="33%">Jumlah Total Nilai</td>
									</tr>
									<tr>
										<td align=center><b><?=$this->dataMapel->jml_soal_ganda;?> Butir</b></td>
										<td align=center><b><?=$this->dataMapel->jml_soal_esay;?> Butir</b></td>
										<td align=center><b><?=$this->dataMapel->nilai_maksimal_ujian;?></b></td>
									</tr>
								</table>
								
								<div  class="alert alert-warning" style="display:none" id="pesan_error"></div>
								
								<table class="table table-stripsed table-bordered table-hosver table-checkable order-column" id="sampsle_2">
									
									<tbody>
										
										
										
										
										
										<?php
										
										echo $this->htmlPaket;
										
										if(!$this->dataPaketSoal){
											echo "<tr><td colspan='25' align='center'>Maaf, tidak ada Data Paket Soal untuk ditampilkan.</td></tr>";
										}
										if($this->dataPaketSoal){
										?>
										
										<tr>
											<td>
											
											</td>
											<td colspan="5">
												
												
												
												<span  class="btn btn-default" onclick="location.href='<?=$this->template_view->base_url_admin();?>/<?=$this->uri->segment('2');?>/mapel/<?=$this->dataUjian->id_m_ujian;?>'" ><i class="fa fa-close"></i> Batal</span>
												<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
											</td>
										</tr>
										<?php
										}
										?>
										
									</tbody>
								</table>
							<!--</div>-->
							
							</form>
							
							
						</div>
					</div>
					<!-- END Portlet PORTLET-->
					
					<div id="divLoading" style="display:none">
						<center>
							<img src="<?=base_url();?>assets/images/loading.gif"><br><br>
							Mohon Tunggu, Proses ini membutuhkan Waktu ...
						<center>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



<script>
	
	function click_jenis_soal_ujian_ganda(id_m_paket_soal){
		if ($('#jenis_soal_ujian_ganda_'+id_m_paket_soal).is(':checked')){
			
			$('#jml_soal_ganda_'+id_m_paket_soal).addClass('required');
			$('#nilai_benar_ganda_'+id_m_paket_soal).addClass('required');
			$('#nilai_salah_ganda_'+id_m_paket_soal).addClass('required');
			
			$('#jml_soal_ganda_'+id_m_paket_soal).show();
			$('#nilai_benar_ganda_'+id_m_paket_soal).show();
			$('#nilai_salah_ganda_'+id_m_paket_soal).show();		
			$('#div_acak_soal_ganda_'+id_m_paket_soal).show();
			$('#div_acak_jawaban_ganda_'+id_m_paket_soal).show();
			
			$('#jml_soal_ganda_'+id_m_paket_soal).focus();
		} else {
			$('#jml_soal_ganda_'+id_m_paket_soal).hide();			
			$('#nilai_benar_ganda_'+id_m_paket_soal).hide();			
			$('#nilai_salah_ganda_'+id_m_paket_soal).hide();		
			$('#div_acak_soal_ganda_'+id_m_paket_soal).hide();
			$('#div_acak_jawaban_ganda_'+id_m_paket_soal).hide();	
			
			$('#jml_soal_ganda_'+id_m_paket_soal).removeClass('required');
			$('#nilai_benar_ganda_'+id_m_paket_soal).removeClass('required');
			$('#nilai_salah_ganda_'+id_m_paket_soal).removeClass('required');
			
			$('#jml_soal_ganda_'+id_m_paket_soal).val('');
			$('#nilai_benar_ganda_'+id_m_paket_soal).val('');
			$('#nilai_salah_ganda_'+id_m_paket_soal).val('');	
			$('#acak_soal_ganda_'+id_m_paket_soal).attr('checked', false);
			$('#acak_jawaban_ganda_'+id_m_paket_soal).attr('checked', false);
		}
		
		
		cek_paket_soal(id_m_paket_soal);
	}
	
	function click_jenis_soal_ujian_uraian(id_m_paket_soal){
		if ($('#jenis_soal_ujian_uraian_'+id_m_paket_soal).is(':checked')){
			
			$('#jml_soal_uraian_'+id_m_paket_soal).addClass('required');
			$('#nilai_benar_uraian_'+id_m_paket_soal).addClass('required');
			$('#nilai_salah_uraian_'+id_m_paket_soal).addClass('required');
			
			$('#jml_soal_uraian_'+id_m_paket_soal).show();
			$('#nilai_benar_uraian_'+id_m_paket_soal).show();
			$('#nilai_salah_uraian_'+id_m_paket_soal).show();			
			$('#div_acak_soal_uraian_'+id_m_paket_soal).show();
			
			$('#paket_soal_'+id_m_paket_soal).attr('checked', true);
			
			$('#jml_soal_uraian_'+id_m_paket_soal).focus();
		} else {
			$('#jml_soal_uraian_'+id_m_paket_soal).hide();			
			$('#nilai_benar_uraian_'+id_m_paket_soal).hide();
			$('#nilai_salah_uraian_'+id_m_paket_soal).hide();			
			$('#div_acak_soal_uraian_'+id_m_paket_soal).hide();
			
			$('#jml_soal_uraian_'+id_m_paket_soal).removeClass('required');
			$('#nilai_benar_uraian_'+id_m_paket_soal).removeClass('required');
			$('#nilai_salah_uraian_'+id_m_paket_soal).removeClass('required');			
			
			$('#jml_soal_uraian_'+id_m_paket_soal).val('');
			$('#nilai_benar_uraian_'+id_m_paket_soal).val('');
			$('#nilai_salah_uraian_'+id_m_paket_soal).val('');
			$('#acak_soal_uraian_'+id_m_paket_soal).attr('checked', false);
			
			
		}
		
		$('#tampilkan_nilai').val('N');
		
		cek_paket_soal(id_m_paket_soal);
		
	}
	
	
	
	///////////////////
	
	
	
	
	function click_jenis_soal_ujian_ganda_sedang(id_m_paket_soal){
		if ($('#jenis_soal_ujian_ganda_sedang_'+id_m_paket_soal).is(':checked')){
			
			$('#jml_soal_ganda_sedang_'+id_m_paket_soal).addClass('required');
			$('#nilai_benar_ganda_sedang_'+id_m_paket_soal).addClass('required');
			$('#nilai_salah_ganda_sedang_'+id_m_paket_soal).addClass('required');
			
			$('#jml_soal_ganda_sedang_'+id_m_paket_soal).show();
			$('#nilai_benar_ganda_sedang_'+id_m_paket_soal).show();
			$('#nilai_salah_ganda_sedang_'+id_m_paket_soal).show();		
			$('#div_acak_soal_ganda_sedang_'+id_m_paket_soal).show();
			$('#div_acak_jawaban_ganda_sedang_'+id_m_paket_soal).show();
			
			$('#jml_soal_ganda_sedang_'+id_m_paket_soal).focus();
		} else {
			$('#jml_soal_ganda_sedang_'+id_m_paket_soal).hide();			
			$('#nilai_benar_ganda_sedang_'+id_m_paket_soal).hide();			
			$('#nilai_salah_ganda_sedang_'+id_m_paket_soal).hide();		
			$('#div_acak_soal_ganda_sedang_'+id_m_paket_soal).hide();
			$('#div_acak_jawaban_ganda_sedang_'+id_m_paket_soal).hide();	
			
			$('#jml_soal_ganda_sedang_'+id_m_paket_soal).removeClass('required');
			$('#nilai_benar_ganda_sedang_'+id_m_paket_soal).removeClass('required');
			$('#nilai_salah_ganda_sedang_'+id_m_paket_soal).removeClass('required');
			
			$('#jml_soal_ganda_sedang_'+id_m_paket_soal).val('');
			$('#nilai_benar_ganda_sedang_'+id_m_paket_soal).val('');
			$('#nilai_salah_ganda_sedang_'+id_m_paket_soal).val('');	
			$('#acak_soal_ganda_sedang_'+id_m_paket_soal).attr('checked', false);
			$('#acak_jawaban_ganda_sedang_'+id_m_paket_soal).attr('checked', false);
		}
		
		
		cek_paket_soal(id_m_paket_soal);
	}
	
	function click_jenis_soal_ujian_uraian_sedang(id_m_paket_soal){
		if ($('#jenis_soal_ujian_uraian_sedang_'+id_m_paket_soal).is(':checked')){
			
			$('#jml_soal_uraian_sedang_'+id_m_paket_soal).addClass('required');
			$('#nilai_benar_uraian_sedang_'+id_m_paket_soal).addClass('required');
			$('#nilai_salah_uraian_sedang_'+id_m_paket_soal).addClass('required');
			
			$('#jml_soal_uraian_sedang_'+id_m_paket_soal).show();
			$('#nilai_benar_uraian_sedang_'+id_m_paket_soal).show();
			$('#nilai_salah_uraian_sedang_'+id_m_paket_soal).show();			
			$('#div_acak_soal_uraian_sedang_'+id_m_paket_soal).show();
			
			$('#paket_soal_sedang_'+id_m_paket_soal).attr('checked', true);
			
			$('#jml_soal_uraian_sedang_'+id_m_paket_soal).focus();
		} else {
			$('#jml_soal_uraian_sedang_'+id_m_paket_soal).hide();			
			$('#nilai_benar_uraian_sedang_'+id_m_paket_soal).hide();
			$('#nilai_salah_uraian_sedang_'+id_m_paket_soal).hide();			
			$('#div_acak_soal_uraian_sedang_'+id_m_paket_soal).hide();
			
			$('#jml_soal_uraian_sedang_'+id_m_paket_soal).removeClass('required');
			$('#nilai_benar_uraian_sedang_'+id_m_paket_soal).removeClass('required');
			$('#nilai_salah_uraian_sedang_'+id_m_paket_soal).removeClass('required');			
			
			$('#jml_soal_uraian_sedang_'+id_m_paket_soal).val('');
			$('#nilai_benar_uraian_sedang_'+id_m_paket_soal).val('');
			$('#nilai_salah_uraian_sedang_'+id_m_paket_soal).val('');
			$('#acak_soal_uraian_sedang_'+id_m_paket_soal).attr('checked', false);
			
			
		}
		
		$('#tampilkan_nilai').val('N');
		
		cek_paket_soal(id_m_paket_soal);
		
	}
	
	
	/////////////////
	
	
	///////////////////
	
	
	
	
	function click_jenis_soal_ujian_ganda_sulit(id_m_paket_soal){
		if ($('#jenis_soal_ujian_ganda_sulit_'+id_m_paket_soal).is(':checked')){
			
			$('#jml_soal_ganda_sulit_'+id_m_paket_soal).addClass('required');
			$('#nilai_benar_ganda_sulit_'+id_m_paket_soal).addClass('required');
			$('#nilai_salah_ganda_sulit_'+id_m_paket_soal).addClass('required');
			
			$('#jml_soal_ganda_sulit_'+id_m_paket_soal).show();
			$('#nilai_benar_ganda_sulit_'+id_m_paket_soal).show();
			$('#nilai_salah_ganda_sulit_'+id_m_paket_soal).show();		
			$('#div_acak_soal_ganda_sulit_'+id_m_paket_soal).show();
			$('#div_acak_jawaban_ganda_sulit_'+id_m_paket_soal).show();
			
			$('#jml_soal_ganda_sulit_'+id_m_paket_soal).focus();
		} else {
			$('#jml_soal_ganda_sulit_'+id_m_paket_soal).hide();			
			$('#nilai_benar_ganda_sulit_'+id_m_paket_soal).hide();			
			$('#nilai_salah_ganda_sulit_'+id_m_paket_soal).hide();		
			$('#div_acak_soal_ganda_sulit_'+id_m_paket_soal).hide();
			$('#div_acak_jawaban_ganda_sulit_'+id_m_paket_soal).hide();	
			
			$('#jml_soal_ganda_sulit_'+id_m_paket_soal).removeClass('required');
			$('#nilai_benar_ganda_sulit_'+id_m_paket_soal).removeClass('required');
			$('#nilai_salah_ganda_sulit_'+id_m_paket_soal).removeClass('required');
			
			$('#jml_soal_ganda_sulit_'+id_m_paket_soal).val('');
			$('#nilai_benar_ganda_sulit_'+id_m_paket_soal).val('');
			$('#nilai_salah_ganda_sulit_'+id_m_paket_soal).val('');	
			$('#acak_soal_ganda_sulit_'+id_m_paket_soal).attr('checked', false);
			$('#acak_jawaban_ganda_sulit_'+id_m_paket_soal).attr('checked', false);
		}
		
		
		cek_paket_soal(id_m_paket_soal);
	}
	
	function click_jenis_soal_ujian_uraian_sulit(id_m_paket_soal){
		if ($('#jenis_soal_ujian_uraian_sulit_'+id_m_paket_soal).is(':checked')){
			
			$('#jml_soal_uraian_sulit_'+id_m_paket_soal).addClass('required');
			$('#nilai_benar_uraian_sulit_'+id_m_paket_soal).addClass('required');
			$('#nilai_salah_uraian_sulit_'+id_m_paket_soal).addClass('required');
			
			$('#jml_soal_uraian_sulit_'+id_m_paket_soal).show();
			$('#nilai_benar_uraian_sulit_'+id_m_paket_soal).show();
			$('#nilai_salah_uraian_sulit_'+id_m_paket_soal).show();			
			$('#div_acak_soal_uraian_sulit_'+id_m_paket_soal).show();
			
			$('#paket_soal_sulit_'+id_m_paket_soal).attr('checked', true);
			
			$('#jml_soal_uraian_sulit_'+id_m_paket_soal).focus();
		} else {
			$('#jml_soal_uraian_sulit_'+id_m_paket_soal).hide();			
			$('#nilai_benar_uraian_sulit_'+id_m_paket_soal).hide();
			$('#nilai_salah_uraian_sulit_'+id_m_paket_soal).hide();			
			$('#div_acak_soal_uraian_sulit_'+id_m_paket_soal).hide();
			
			$('#jml_soal_uraian_sulit_'+id_m_paket_soal).removeClass('required');
			$('#nilai_benar_uraian_sulit_'+id_m_paket_soal).removeClass('required');
			$('#nilai_salah_uraian_sulit_'+id_m_paket_soal).removeClass('required');			
			
			$('#jml_soal_uraian_sulit_'+id_m_paket_soal).val('');
			$('#nilai_benar_uraian_sulit_'+id_m_paket_soal).val('');
			$('#nilai_salah_uraian_sulit_'+id_m_paket_soal).val('');
			$('#acak_soal_uraian_sulit_'+id_m_paket_soal).attr('checked', false);
			
			
		}
		
		$('#tampilkan_nilai').val('N');
		
		cek_paket_soal(id_m_paket_soal);
		
	}
	
	
	/////////////////
	
	function cek_paket_soal(id_m_paket_soal){
		if ($('#jenis_soal_ujian_ganda_'+id_m_paket_soal).is(':checked')){
			$('#paket_soal_'+id_m_paket_soal).val(id_m_paket_soal);
		}
		else if ($('#jenis_soal_ujian_uraian_'+id_m_paket_soal).is(':checked')){
			$('#paket_soal_'+id_m_paket_soal).val(id_m_paket_soal);
		}
		
		else if ($('#jenis_soal_ujian_ganda_sedang_'+id_m_paket_soal).is(':checked')){
			$('#paket_soal_'+id_m_paket_soal).val(id_m_paket_soal);
		}
		else if ($('#jenis_soal_ujian_uraian_sedang_'+id_m_paket_soal).is(':checked')){
			$('#paket_soal_'+id_m_paket_soal).val(id_m_paket_soal);
		}
		
		else if ($('#jenis_soal_ujian_ganda_sulit_'+id_m_paket_soal).is(':checked')){
			$('#paket_soal_'+id_m_paket_soal).val(id_m_paket_soal);
		}
		else if ($('#jenis_soal_ujian_uraian_sulit_'+id_m_paket_soal).is(':checked')){
			$('#paket_soal_'+id_m_paket_soal).val(id_m_paket_soal);
		}
		
		else{
			$('#paket_soal_'+id_m_paket_soal).val('');
		}
	}
	
	
	

</script>
