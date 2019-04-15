 <div class="page-content">
	<div class="containser">

		<div class="page-content-inner">
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light">
						<div class="caption">
							<i class="fa fa-edit font-blue-sharp"></i>
							<span class="caption-subject font-blue-sharp bold">Ubah Data Ujian</span>
						</div>
					</div>

					<!-- BEGIN Portlet PORTLET-->
					<div class="portlet light">
						<div class="portlet-body">
							<?php if($this->session->notice){echo $this->session->notice;} ?>
							
							
							<form class="form-horizontal" id="form_standard" method="post" action="<?=$this->template_view->base_url_admin();?>/<?=$this->uri->segment('2');?>/update_mapel/<?=$this->dataUjian->id_m_ujian;?>/<?=$this->dataUjianMapel->id_m_ujian_mapel;?>">
							
								<div class="form-group">
									<label class="control-label col-sm-4" >Mata Pelajaran :</label>
									<div class="col-sm-5">
										<select name="id_m_mata_pelajaran" class="form-control select2 required">
											<option value=""></option>
											<?php
											foreach($this->dataMapel as $dataMapel) {
												if($this->dataUjianMapel->id_m_mata_pelajaran == $dataMapel->id_m_mata_pelajaran){
											?>									
											<option value="<?=$dataMapel->id_m_mata_pelajaran;?>" selected>
												<?=$dataMapel->nm_mata_pelajaran;?>
											</option>
											<?php
												}
											}
											?>
										</select>
									</div>
								</div>
								<!--<div class="form-group">
									<label class="control-label col-sm-4" >Jenis Soal Ujian :</label>
								
									<div class="col-sm-2">
										<div class="mt-checkbox-list">
											<label class="mt-checkbox mt-checkbox-outline">
												<input type="checkbox" onclick="click_jenis_soal_ujian_ganda()" value="G" name="jenis_soal_ujian_ganda" <?php if($this->dataUjianMapel->jml_soal_ganda > 0) echo "checked"; ?> id="jenis_soal_ujian_ganda"> Pilihan Ganda
												<span></span>
											</label>
										</div>
									</div>
									<div class="col-sm-3">	
										<input type="number" placeholder="Jumlah Soal Pilihan Ganda" style="display:<?php if($this->dataUjianMapel->jml_soal_ganda < 1) echo "none"; ?>" name="jml_soal_ganda" value="<?=$this->dataUjianMapel->jml_soal_ganda;?>" id="jml_soal_ganda" class="form-control">
									</div>
									
								</div>	
											
								<div class="form-group">
									<label class="control-label col-sm-4" ></label>
									
									<div class="col-sm-2">
										<div class="mt-checkbox-list">
											<label class="mt-checkbox mt-checkbox-outline">
												<input type="checkbox" value="U" <?php if($this->dataUjianMapel->jml_soal_esay > 0) echo "checked"; ?> name="jenis_soal_ujian_uraian" onclick="click_jenis_soal_ujian_uraian()" id="jenis_soal_ujian_uraian"> Uraian
												<span></span>
											</label>
										</div>
									</div>
									<div class="col-sm-3">	
										<input type="number" style="display:<?php if($this->dataUjianMapel->jml_soal_esay < 1) echo "none"; ?>"  placeholder="Jumlah Soal Uraian " name="jml_soal_uraian" id="jml_soal_uraian" value="<?=$this->dataUjianMapel->jml_soal_esay;?>" class="form-control">
									</div>
									
								</div>	-->
								<div class="form-group">
									<label class="control-label col-sm-4" >Tampilkan Nilai Ujian :</label>
									<div class="col-sm-3">
										<select class="form-controll select2" name="tampilkan_nilai" id="tampilkan_nilai">
												<option value="">Silahkan Pilih</option>
												<option <?php if($this->dataUjianMapel->tampilkan_nilai =='Y') echo "selected";?> value="Y">Ya</option>
												<option <?php if($this->dataUjianMapel->tampilkan_nilai =='N') echo "selected";?> value="N">Tidak</option>				
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-4" >Tampilkan Detail Jawaban ke Siswa :</label>
									<div class="col-sm-3">
										<select class="form-control select2" name="tampilkan_hasil_jawaban" id="tampilkan_hasil_jawaban" required>
												<option value="">Silahkan Pilih</option>
												<option <?php if($this->dataUjianMapel->tampilkan_hasil_jawaban =='Y') echo "selected";?> value="Y">Ya</option>
												<option <?php if($this->dataUjianMapel->tampilkan_hasil_jawaban =='N') echo "selected";?> value="N">Tidak</option>				
										</select>
									</div>
								</div>
								
								<?php
								$tglMulai = explode(' ',$this->dataUjianMapel->tgl_pengerjaan_indo);
								$jamMenitMulai = explode(':',$tglMulai[1]);
								
								$tglAkhir = explode(' ',$this->dataUjianMapel->tgl_akhir_pengerjaan_indo);
								$jamMenitAkhir = explode(':',$tglAkhir[1]);
								?>
								<div class="form-group">
									<label class="control-label col-sm-4" >Tanggal Mulai Pengerjaan :</label>
									<div class="col-sm-2">
									<input type="text" class="form-control  date-picker"  data-date-format='dd-mm-yyyy' placeholder="" value="<?=$tglMulai[0];?>" required name="tgl_pengerjaan">
									</div>
									<div class="col-sm-2">
										<select class="form-control" required name="jam">
											<option value="">Pilih Jam</option>
											<?php
											for($i=1;$i<25;$i++){
												$fzeropadded = sprintf("%02d", $i);
											?>
											<option <?php if($jamMenitMulai[0]== $fzeropadded) echo "selected";?> value="<?=$fzeropadded;?>"><?=$fzeropadded;?></value>
											<?php
											}
											?>
										</select>
									</div>
									<div class="col-sm-2">
										<select class="form-control" required name="menit">
											<option value="">Pilih Menit</option>
											<?php
											for($i=0;$i<61;$i++){
												$fzeropaddedMenit = sprintf("%02d", $i);
											?>
											<option <?php if($jamMenitMulai[1] == $fzeropaddedMenit) echo "selected";?> value="<?=$fzeropaddedMenit;?>"><?=$fzeropaddedMenit;?></value>
											<?php
											}
											?>
										</select>
									</div>
								</div>
								
								
								<div class="form-group">
									<label class="control-label col-sm-4" >Tanggal Akhir Pengerjaan :</label>
									<div class="col-sm-2">
									<input type="text" class="form-control  date-picker"  data-date-format='dd-mm-yyyy' placeholder="" value="<?=$tglAkhir[0];?>" required name="tgl_akhir_pengerjaan">
									</div>
									<div class="col-sm-2">
										<select class="form-control" required name="jam_akhir">
											<option value="">Pilih Jam</option>
											<?php
											for($i=1;$i<25;$i++){
												$fzeropadded = sprintf("%02d", $i);
											?>
											<option <?php if($jamMenitAkhir[0]== $fzeropadded) echo "selected";?> value="<?=$fzeropadded;?>"><?=$fzeropadded;?></value>
											<?php
											}
											?>
										</select>
									</div>
									<div class="col-sm-2">
										<select class="form-control" required name="menit_akhir">
											<option value="">Pilih Menit</option>
											<?php
											for($i=0;$i<61;$i++){
												$fzeropaddedMenit = sprintf("%02d", $i);
											?>
											<option <?php if($jamMenitAkhir[1] == $fzeropaddedMenit) echo "selected";?> value="<?=$fzeropaddedMenit;?>"><?=$fzeropaddedMenit;?></value>
											<?php
											}
											?>
										</select>
									</div>
								</div>
								
								
									
								
								<div class="form-group">
									<label class="control-label col-sm-4" >Menit Pengerjaan :</label>
									<div class="col-sm-2">
									<input type="number" class="form-control" placeholder="" value="<?=$this->dataUjianMapel->menit_pengerjaan;?>" required name="menit_pengerjaan">
									</div>
								</div>	
								<!--
								<div class="form-group">
									<label class="control-label col-sm-4" >Nilai Maksimal :</label>
									<div class="col-sm-2">
									<input type="number" class="form-control" placeholder="" value="<?=$this->dataUjianMapel->nilai_maksimal_ujian;?>" required name="nilai_maksimal_ujian">
									</div>
								</div>
								-->
								<div class="form-group">	
									
									<label class="control-label col-sm-4" >Aktifkan Ujian :</label>
									<div class="col-sm-3">
										<select class="form-controll select2" name="status_ujian" id="status_ujian" required>
											<option value="">Silahkan Pilih</option>
											<option <?php if($this->dataUjianMapel->status_ujian=='A') echo "selected";?> value="A">Ya</option>
											<option <?php if($this->dataUjianMapel->status_ujian=='N') echo "selected";?> value="N">Tidak</option>				
										</select>
									</div>
								</div>
								
								<div class="form-group">
									<div class="col-sm-8 col-sm-offset-4">
										<span id="pesan_error"></span>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-8 col-sm-offset-4">
										<span  class="btn btn-default" onclick="location.href='<?=$this->template_view->base_url_admin();?>/ujian/mapel/<?=$this->dataUjian->id_m_ujian;?>'"><i class="fa fa-close"></i> Batal</span>
										<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
									</div>
								</div>
							</form>

						</div>
					</div>
					<!-- END Portlet PORTLET-->
				</div>
			</div>
		</div>
	</div>
</div>



<script>
	function change_tingkat_kelas(){
		location.href='?id_tingkat_kelas='+$('#id_tingkat_kelas').val()+'&id_tahun_ajaran='+$('#id_tahun_ajaran').val();
	}
	
	function change_jenis_soal_ujian(){
		if($('#jenis_soal_ujian').val() == 'G'){			
			$('#jml_soal_esay').val('0')
			$('#jml_soal_esay').prop('readonly', true);				
			$('#jml_soal_ganda').prop('readonly', false);	
			$('#jml_soal_ganda').focus();	
			
						
			$('#tampilkan_nilai').prop('disabled', false);
			
		}
		else if($('#jenis_soal_ujian').val() == 'E'){
			$('#jml_soal_ganda').val('0');
			$('#jml_soal_ganda').prop('readonly', true);
			$('#jml_soal_esay').prop('readonly', false);					
			$('#jml_soal_esay').focus();					
			
			$('#tampilkan_nilai').val('N');
			$('#tampilkan_nilai').prop('disabled', true);
		}
		else{
			$('#jml_soal_esay').prop('readonly', false);
			$('#jml_soal_ganda').prop('readonly', false);
			
			
			$('#tampilkan_nilai').val('N');
			$('#tampilkan_nilai').prop('disabled', true);
		}
	}
	
	function click_jenis_soal_ujian_ganda(){
		if ($('#jenis_soal_ujian_ganda').is(':checked')){
			
			$('#jml_soal_ganda').prop('required',true);
			$('#jml_soal_ganda').show();
			$('#jml_soal_ganda').focus();
		} else {
			$('#jml_soal_ganda').hide();			
			$('#jml_soal_ganda').prop('required',false);
			$('#jml_soal_ganda').val('');
		}
	}
	
	function click_jenis_soal_ujian_uraian(){
		if ($('#jenis_soal_ujian_uraian').is(':checked')){
			
			$('#jml_soal_uraian').prop('required',true);
			$('#jml_soal_uraian').show();
			$('#jml_soal_uraian').focus();
		} else {
			$('#jml_soal_uraian').hide();
			$('#jml_soal_uraian').prop('required',false);
			$('#jml_soal_uraian').val('');
		}
		
		$('#tampilkan_nilai').val('N');
		
	}
</script>