 <div class="page-content">
	<div class="containser">

		<div class="page-content-inner">
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light">
						<div class="caption">
							<i class="fa fa-edit font-blue-sharp"></i>
							<span class="caption-subject font-blue-sharp bold">Koreksi Hasil Ujian : <?=$this->dataUjian->nm_ujian;?></span>
						</div>
					</div>

					<!-- BEGIN Portlet PORTLET-->
					<div class="portlet light">
						<div class="portlet-body">
							<?php if($this->session->notice){echo $this->session->notice;} ?>
							
							
							<form class="form-horizontal" id="" method="post" >
							
								<div class="form-group">
									<label class="control-label col-sm-4" >Mata Pelajaran :</label>
									<div class="col-sm-5">
										<select name="id_m_ujian_mapel" id="id_m_ujian_mapel" onchange="change_mapel()" class="form-control select2 required">
											<option value=""></option>
											<?php
											foreach($this->ShowDataMapelUjian as $ShowDataMapelUjian) {
											?>									
											<option value="<?=$ShowDataMapelUjian->id_m_ujian_mapel;?>" <?php if($this->input->get('id_m_ujian_mapel') == $ShowDataMapelUjian->id_m_ujian_mapel) echo "selected";?>>
												<?=$ShowDataMapelUjian->nm_mata_pelajaran;?>
											</option>
											<?php
											}
											?>
										</select>
									</div>
								</div>
								
								<?php
								if($this->input->get('id_m_ujian_mapel')){
								?>
								
								<div class="form-group">
									<label class="control-label col-sm-4" >Urut Berdasarkan :</label>
									<div class="col-sm-3">
										<select name="order_by" id="order_by" onchange="change_mapel()" class="form-control select2 required">						
											<option value="m_siswa_paket_ujian.nama" <?php if($this->input->get('order_by') == 'm_siswa_paket_ujian.nama') echo "selected";?>>
												Nama Siswa
											</option>
											
											<option value="m_siswa_paket_ujian.nipd" <?php if($this->input->get('order_by') == 'm_siswa_paket_ujian.nipd') echo "selected";?>>
												NIPD
											</option>
											
											<option value="m_siswa_paket_ujian.nisn" <?php if($this->input->get('order_by') == 'm_siswa_paket_ujian.nisn') echo "selected";?>>
												NISN
											</option>
											
											<option value="detail_siswa_paket_ujian.nilai" <?php if($this->input->get('order_by') == 'detail_siswa_paket_ujian.nilai') echo "selected";?>>
												Nilai
											</option>
											
											<option value="m_siswa_paket_ujian.kelas" <?php if($this->input->get('order_by') == 'm_siswa_paket_ujian.kelas') echo "selected";?>>
												Kelas
											</option>
											
										</select>
									</div>
									
								</div>
								<hr>
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th scope="col">No</th>
											<th scope="col">NIPD</th>
											<th scope="col">Nama Siswa</th>
											<th scope="col">Kelas</th>
											<th scope="col">Nilai</th>
											<th scope="col"></th>
										</tr>
									</thead>
									<tbody>
								<?php
								
								$no=1;
								foreach($this->dataSiswa as $dataSiswa){
								?>
										<tr>
											<td align='center'><?=$no;?>.</td>
											<td><?=$dataSiswa->nipd;?> </td>
											<td><?=$dataSiswa->nama;?> </td>
											<td><?=$dataSiswa->kelas;?> </td>
											<td>
												<?=$this->template_view->cek_nilai($dataSiswa->id_detail_siswa_paket_ujian);?> 
											</td>
											<td align=center>
												<?php
												if($dataSiswa->id_user_koreksi == ''){	
													if($dataSiswa->tgl_akhir_pengerjaan != ''){
												?>
													
													<span class="btn btn-primary" onclick="buka_form_koreksi(<?=$dataSiswa->id_detail_siswa_paket_ujian;?>,'<?=$dataSiswa->nipd;?>','<?=$dataSiswa->nama;?>')"><i class="fa fa-check"></i> Koreksi</span>
													
												<?php
													}
													else{
														echo "Belum Mengerjakan";
													}
												}
												else{
													echo "Sudah Dikoreksi";
												}
												?>
											</td>
										</tr>
								
								
								<?php
								$no++;
								}
								?>
									</tbody>
								</table>
								<?php
								}
								?>
							</form>

						</div>
					</div>
					<!-- END Portlet PORTLET-->
				</div>
			</div>
		</div>
	</div>
</div>



<div id="modal_koreksi" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">

	<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">			
				<h4 class="modal-title">Form Koreksi Pengerjaan Siswa</h4>
				<div id="nipdNama"></div>
			</div>
			<div class="modal-body">
				
				<form class="form-horizontal" id="form_standard" method="post" action="<?=$this->template_view->base_url_admin();?>/<?=$this->uri->segment('2');?>/insert_koreksi">
					<input type="hidden" name="id_detail_siswa_paket_ujian" id="id_detail_siswa_paket_ujian">
					<div class="form-group">
						<div class="col-sm-12" id="div_pengerjaan">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-10 col-sm-offset-1">
							<span id="pesan_error"></span>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-10 col-sm-offset-1">
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

	function buka_form_koreksi(id_siswa_ujian,nipd,nama){
		$('#id_detail_siswa_paket_ujian').val(id_siswa_ujian);
		$('#nipdNama').html("<br>NIPD : "+nipd+"<br>Nama : "+nama);
		
		$.ajax({
			url: "<?=$this->template_view->base_url_admin();?>/koreksi/ambil_soal/"+id_siswa_ujian,
			type:'html',
			dataType:'html',
			data: {},
			success: function(data){
				
				$('#div_pengerjaan').html(data);
			}
		})
		
		$('#modal_koreksi').modal('show');
	}

	function input_nilai(idSoal, nilaiMax){
		$('#nilai_'+idSoal).focus();
		
		if($('#benar_salah_'+idSoal).val() == 'B'){
			$('#nilai_'+idSoal).val(nilaiMax);
			$('#nilai_'+idSoal).attr('readonly', true);
		}
		else{
			$('#nilai_'+idSoal).val('0');
			$('#nilai_'+idSoal).attr('readonly', false);
		}
	}
	
	<?php
	if(!$this->input->get('id_m_ujian_mapel')){
	?>
	function change_mapel(){
		location.href='?id_m_ujian_mapel='+$('#id_m_ujian_mapel').val()+'&order_by=m_siswa_paket_ujian.nipd';		
	}
	<?php
	}
	else{
	?>
	
	function change_mapel(){
		location.href='?id_m_ujian_mapel='+$('#id_m_ujian_mapel').val()+'&order_by='+$('#order_by').val();
	}
		
	
	<?php
	}
	?>
	
</script>