 <div class="page-content">
	<div class="containser">

		<div class="page-content-inner">
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light">
						<div class="caption">
							<i class="fa fa-bars font-blue-sharp"></i>
							<span class="caption-subject font-blue-sharp bold">Data Mata Pelajaran di Ujian : <?=$this->dataUjian->nm_ujian;?></span>
						</div>
					</div>

					<!-- BEGIN Portlet PORTLET-->
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span onclick="location.href='<?=$this->template_view->base_url_admin();?>/<?=$this->uri->segment('2');?>'" class="btn btn-warning"><i class="fa fa-backward"></i> Kembali ke Daftar Ujian</span>
							
								<br>
								<br>
								
								<span data-toggle="modal" data-target="#modal_tambah_mapel" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data Mata Pelajaran</span>
								
							</div>
							
						</div>
						<div class="portlet-body">

							<?php if($this->session->notice){echo $this->session->notice;} ?>
							<!--<div class="table-scrollable">-->
								<table class="table table-striped table-bordered table-hover table-checkable order-column" id="sampsle_2">
									<thead>
										<tr>
											<th scope="col">No</th>
											<th scope="col">Mata Pelajaran</th>
											<th scope="col">Tanggal Ujian</th>
											<th scope="col">Token</th>
											<th scope="col"></th>
											<th scope="col"></th>
										</tr>
									</thead>
									<tbody>
										<?php
										$no 	= $this->input->get('per_page')+ 1;
										foreach($this->showData as $data){
										?>
										<tr>
											<td align='center'><?=$no;?>.</td>
											<td><?=$data->nm_mata_pelajaran;?> </td>
											<td><?=$data->tgl_pengerjaan_indo;?> </td>
											<td align=center>
											
												<span class="btn btn-danger" onclick="show_confirmation_modal('<p>Apakah anda yakin akan mengganti Token mata Pelajaran <br><b><?=$data->nm_mata_pelajaran;?></b> ..?</p>','<?=$this->template_view->base_url_admin();?>/<?=$this->uri->segment('2');?>/ubah_token/<?=$data->id_m_ujian;?>/<?=$data->id_m_ujian_mapel;?>')">
													<?=$data->token_ujian;?> 
												</span>
											</td>
											<td align=center>
											
											<span onclick="location.href='<?=$this->template_view->base_url_admin();?>/<?=$this->uri->segment('2');?>/detail_mapel/<?=$data->id_m_ujian;?>/<?=$data->id_m_ujian_mapel;?>'" class="btn btn-primary"><i class="fa fa-eye"></i> Detail Soal Ujian</span>
											
											</td>
											
											<td align=center>
											<a href="<?=$this->template_view->base_url_admin();?>/<?=$this->uri->segment('2');?>/daftar_hadir/<?=$data->id_m_ujian;?>/<?=$data->id_m_ujian_mapel;?>" >
												<span class="btn btn-warning"><i class="fa fa-print"></i> Daftar Hadir</span>
											</a>
											</td>
											
											<td align='center'>
												<?=$this->hak_akses->btn_edit($this->uri->segment('2'), $this->template_view->base_url_admin()."/".$this->uri->segment('2')."/edit_mapel/".$data->id_m_ujian."/".$data->id_m_ujian_mapel );?>

												<?=$this->hak_akses->btn_delete($this->uri->segment('2'), 'Apakah anda yakin akan menghapus Data <b>'.$data->nm_mata_pelajaran.'<b> ..?',$this->template_view->base_url_admin()."/".$this->uri->segment('2')."/delete_mapel/".$data->id_m_ujian."/".$data->id_m_ujian_mapel );?>
												

											</td>
											
										</tr>
										<?php
										$no++;
										}
										if(!$this->showData){
											echo "<tr><td colspan='25' align='center'>Maaf, tidak ada Data untuk ditampilkan.</td></tr>";
										}
										?>
									</tbody>
								</table>
							<!--</div>-->


						</div>
					</div>
					<!-- END Portlet PORTLET-->
				</div>
			</div>
		</div>
	</div>
</div>



<div id="modal_tambah_mapel" class="modal "  data-backdrop="static" role="dialog">
	<div class="modal-dialog  modal-lg">

	<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">			
				<h4 class="modal-title">Form Tambah Data Mata Pelajaran</h4>
			</div>
			<div class="modal-body">
				
				<form class="form-horizontal" id="form_standard" method="post" action="<?=$this->template_view->base_url_admin();?>/<?=$this->uri->segment('2');?>/insert_mapel/<?=$this->dataUjian->id_m_ujian;?>">
					<div class="form-group">
						<label class="control-label col-sm-4" >Mata Pelajaran :</label>
						<div class="col-sm-5">
							<select name="id_m_mata_pelajaran" class="form-control select2 required">
								<option value=""></option>
								<?php
								foreach($this->dataMapel as $dataMapel) {
								?>									
								<option value="<?=$dataMapel->id_m_mata_pelajaran;?>"><?=$dataMapel->nm_mata_pelajaran;?></option>
								<?php
								}
								?>
							</select>
						</div>
					</div>
						<div class="form-group">
									<label class="control-label col-sm-4" >Jenis Soal Ujian :</label>
									<!--<div class="col-sm-3">
										<select class="form-control select2" required name="jenis_soal_ujian" id="jenis_soal_ujian" onchange="change_jenis_soal_ujian()">
												<option value=""></option>
												<option <?php if($this->session->flashdata('jenis_soal_ujian')=='G') echo "selected";?> value="G">Hanya Pilihan Ganda</option>
												<option <?php if($this->session->flashdata('jenis_soal_ujian')=='E') echo "selected";?> value="E">Hanya Uraian</option>		
												<option <?php if($this->session->flashdata('jenis_soal_ujian')=='C') echo "selected";?> value="C">Pilihan Ganda dan Uraian</option>		
										</select>
									</div>-->
									<div class="col-sm-3">
										<div class="mt-checkbox-list">
											<label class="mt-checkbox mt-checkbox-outline">
												<input type="checkbox" onclick="click_jenis_soal_ujian_ganda()" value="G" name="jenis_soal_ujian_ganda" id="jenis_soal_ujian_ganda"> Pilihan Ganda
												<span></span>
											</label>
										</div>
									</div>
									<div class="col-sm-4">	
										<input type="number" placeholder="Jumlah Soal Pilihan Ganda" style="display:none" name="jml_soal_ganda" id="jml_soal_ganda" class="form-control">
									</div>
									
								</div>	
								
								<div class="form-group">
									<label class="control-label col-sm-4" ></label>
									
									<div class="col-sm-3">
										<div class="mt-checkbox-list">
											<label class="mt-checkbox mt-checkbox-outline">
												<input type="checkbox" value="U" name="jenis_soal_ujian_uraian" onclick="click_jenis_soal_ujian_uraian()" id="jenis_soal_ujian_uraian"> Uraian
												<span></span>
											</label>
										</div>
									</div>
									<div class="col-sm-3">	
										<input type="number" style="display:none"  placeholder="Jumlah Soal Uraian " name="jml_soal_uraian" id="jml_soal_uraian" class="form-control">
									</div>
									
								</div>	
								<div class="form-group">
									<label class="control-label col-sm-4" >Tampilkan Nilai Ujian :</label>
									<div class="col-sm-3">
										<select class="form-controll select2" name="tampilkan_nilai" id="tampilkan_nilai">
												<option value="">Silahkan Pilih</option>
												<option <?php if($this->session->flashdata('tampilkan_nilai')=='Y') echo "selected";?> value="Y">Ya</option>
												<option <?php if($this->session->flashdata('tampilkan_nilai')=='N') echo "selected";?> value="N">Tidak</option>				
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-4" >Tampilkan Detail Jawaban ke Siswa :</label>
									<div class="col-sm-3">
										<select class="form-control select2" name="tampilkan_hasil_jawaban" id="tampilkan_hasil_jawaban" required>
												<option value="">Silahkan Pilih</option>
												<option <?php if($this->session->flashdata('tampilkan_hasil_jawaban')=='Y') echo "selected";?> value="Y">Ya</option>
												<option <?php if($this->session->flashdata('tampilkan_hasil_jawaban')=='N') echo "selected";?> value="N">Tidak</option>				
										</select>
									</div>
								</div>
								<!--
								<div class="form-group">
									<label class="control-label col-sm-4" >Jumlah Soal Pilihan Ganda :</label>
									<div class="col-sm-2">
									<input type="number" class="form-control"  id="jml_soal_ganda" value="<?=$this->session->flashdata('jml_soal_ganda')?>" required name="jml_soal_ganda">
									</div>
									<label class="control-label col-sm-4" >Jumlah Soal Uraian :</label>
									<div class="col-sm-2">
									<input type="number" class="form-control"  id="jml_soal_esay"  value="<?=$this->session->flashdata('jml_soal_esay')?>" required name="jml_soal_esay">
									</div>
								</div>
								-->
								<div class="form-group">
									<label class="control-label col-sm-4" >Tanggal Mulai Pengerjaan :</label>
									<div class="col-sm-2">
									<input type="text" class="form-control  date-picker"  data-date-format='dd-mm-yyyy' placeholder="" value="<?=$this->session->flashdata('tgl_pengerjaan')?>" required name="tgl_pengerjaan">
									</div>
									<div class="col-sm-2">
										<select class="form-control" required name="jam">
											<option value="">Pilih Jam</option>
											<?php
											for($i=1;$i<25;$i++){
												$fzeropadded = sprintf("%02d", $i);
											?>
											<option <?php if($this->session->flashdata('jam')== $fzeropadded) echo "selected";?> value="<?=$fzeropadded;?>"><?=$fzeropadded;?></value>
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
											<option <?php if($this->session->flashdata('menit')== $fzeropaddedMenit) echo "selected";?> value="<?=$fzeropaddedMenit;?>"><?=$fzeropaddedMenit;?></value>
											<?php
											}
											?>
										</select>
									</div>
								</div>
								
								
								<div class="form-group">
									<label class="control-label col-sm-4" >Tanggal Akhir Pengerjaan :</label>
									<div class="col-sm-2">
									<input type="text" class="form-control  date-picker"  data-date-format='dd-mm-yyyy' placeholder="" value="<?=$this->session->flashdata('tgl_akhir_pengerjaan')?>" required name="tgl_akhir_pengerjaan">
									</div>
									<div class="col-sm-2">
										<select class="form-control" required name="jam_akhir">
											<option value="">Pilih Jam</option>
											<?php
											for($i=1;$i<25;$i++){
												$fzeropadded = sprintf("%02d", $i);
											?>
											<option <?php if($this->session->flashdata('jam_akhir')== $fzeropadded) echo "selected";?> value="<?=$fzeropadded;?>"><?=$fzeropadded;?></value>
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
											<option <?php if($this->session->flashdata('menit_akhir')== $fzeropaddedMenit) echo "selected";?> value="<?=$fzeropaddedMenit;?>"><?=$fzeropaddedMenit;?></value>
											<?php
											}
											?>
										</select>
									</div>
								</div>
								
								<div class="form-group">
									<label class="control-label col-sm-4" >Menit Pengerjaan :</label>
									<div class="col-sm-2">
									<input type="number" class="form-control" placeholder="" value="<?=$this->session->flashdata('menit_pengerjaan')?>" required name="menit_pengerjaan">
									</div>
								</div>	
								<div class="form-group">
									<label class="control-label col-sm-4" >Nilai Maksimal :</label>
									<div class="col-sm-2">
									<input type="number" class="form-control" placeholder="" value="<?=$this->session->flashdata('nilai_maksimal_ujian')?>" required name="nilai_maksimal_ujian">
									</div>
								</div>
								
								<div class="form-group">	
									
									<!--<label class="control-label col-sm-4" >Tanggal Publish :</label>
									<div class="col-sm-2">
									<input type="text" class="form-control  date-picker"  data-date-format='dd-mm-yyyy' placeholder="" value="<?=$this->session->flashdata('tgl_publish')?>" required name="tgl_publish">
									</div>
									-->
									
									<label class="control-label col-sm-4" >Aktifkan Ujian :</label>
									<div class="col-sm-3">
										<select class="form-controll select2" name="status_ujian" id="status_ujian" required>
											<option value="">Silahkan Pilih</option>
											<option <?php if($this->session->flashdata('status_ujian')=='A') echo "selected";?> value="A">Ya</option>
											<option <?php if($this->session->flashdata('status_ujian')=='N') echo "selected";?> value="N">Tidak</option>				
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
							<span  class="btn btn-default" onclick="location.reload()"><i class="fa fa-close"></i> Batal</span>
							<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
						</div>
					</div>
				</form>
				
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
