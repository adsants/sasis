 <div class="page-content">
	<div class="containser">

		<div class="page-content-inner">
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light">
						<div class="caption">
							<i class="fa fa-edit font-blue-sharp"></i>
							<span class="caption-subject font-blue-sharp bold">Laporan Nilai Siswa di Ujian : <?=$this->dataUjian->nm_ujian;?></span>
						</div>
					</div>

					<!-- BEGIN Portlet PORTLET-->
					<div class="portlet light">
						<div class="portlet-body">
							<?php if($this->session->notice){echo $this->session->notice;} ?>
							
							
							<form class="form-horizontal" id="form_standard" method="post" >
							
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
											
											
											<option value="detail_siswa_paket_ujian.nilai" <?php if($this->input->get('order_by') == 'detail_siswa_paket_ujian.nilai') echo "selected";?>>
												Nilai
											</option>
											
											<option value="m_siswa_paket_ujian.kelas" <?php if($this->input->get('order_by') == 'm_siswa_paket_ujian.kelas') echo "selected";?>>
												Kelas
											</option>
											
										</select>
									</div>
									<div class="col-sm-3" style="text-align:right;">
										<span class="btn btn-warning" onclick="location.reload();"><i class="fa fa-refresh"></i> Refresh Nilai</span>
									</div>
									
									
								</div>
								
								<div class="form-group">	
									
									<label class="control-label col-sm-4" ></label>
									<div class="col-sm-8">
										
										<a href="<?=$this->template_view->base_url_admin();?>/lap_nilai/excel/?id_m_ujian_mapel=<?=$this->input->get('id_m_ujian_mapel');?>&order_by=<?=$this->input->get('order_by');?>" target="_blank">
											<span class="btn btn-primary"><i class="fa fa-file-excel-o"></i> Export Excel</span>
										</a>
									
									
										
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
											<th scope="col">Waktu Pengerjaan</th>
										</tr>
									</thead>
									<tbody>
									<?php								
									echo $this->dataNilai;
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



<script>
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