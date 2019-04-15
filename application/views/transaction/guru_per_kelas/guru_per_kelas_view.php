 <div class="page-content">
	<div class="contaisner">

		<div class="page-content-inner">
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light">
						<div class="caption">
							<i class="fa fa-bars font-blue-sharp"></i>
							<span class="caption-subject font-blue-sharp bold">Data Guru per Kelas</span>
						</div>
					</div>

					<!-- BEGIN Portlet PORTLET-->
					<div class="portlet light">
						<div class="portlet-title">
							
							<form class="form-horizontal" method="post" >
								<div class="form-group">
									<label class="control-label col-sm-2" >Pilih Tingkat Kelas :</label>
									<div class="col-sm-2">
										<select class="form-control select2" required name="id_tingkat_kelas" id="id_tingkat_kelas" onchange="change_tingkat_kelas(this.val)">
												<option value=""></option>
												<?php
												foreach($this->dataTingkatKelas as $data){
												?>
												<option <?php if($this->input->get('id_tingkat_kelas')== $data->id_tingkat_kelas) echo "selected";?> value="<?=$data->id_tingkat_kelas;?>"><?=$data->nm_tingkat_kelas;?></option>
												<?php
												}
												?>
										</select>
									</div>
								</div>
								<?php
								if($this->input->get('id_tingkat_kelas')){
								?>
								<div class="form-group">
									<label class="control-label col-sm-2" >Pilih Tahun Ajaran :</label>
									<div class="col-sm-5">
										<select class="form-control select2" required name="id_tahun_ajaran" id="id_tahun_ajaran" onchange="change_tahun_ajaran(this.val)">
												<option value=""></option>
												<?php
												foreach($this->dataTahunAjaran as $data){
												?>
												<option <?php if($this->input->get('id_tahun_ajaran')== $data->id_tahun_ajaran) echo "selected";?> value="<?=$data->id_tahun_ajaran;?>"><?=$data->mulai_tahun_ajaran;?> / <?=$data->akhir_tahun_ajaran;?></option>
												<?php
												}
												?>
										</select>
									</div>
								</div>
								<?php
								}
								if($this->input->get('id_tahun_ajaran')){
								?>
								
								<div class="form-group">
									<label class="control-label col-sm-2" >Pilih Kelas :</label>
									<div class="col-sm-3">
										<select class="form-control select2" required name="id_kelas" id="id_kelas" onchange="change_kelas(this.val)">
												<option value=""></option>
												<?php
												foreach($this->dataKelas as $data){
												?>
												<option <?php if($this->input->get('id_kelas')== $data->id_kelas) echo "selected";?> value="<?=$data->id_kelas;?>"><?=$data->nm_kelas;?></option>
												<?php
												}
												?>
										</select>
									</div>
								</div>
								<?php
								}
								?>
								
								<div class="form-group">
									<div class="col-sm-12"></div>
								</div>
							</form>
						</div>	
							<?php
							
							//echo 
							
							if($this->input->get('id_kelas')){
							?>
							
							<?php if($this->session->notice){echo $this->session->notice;} ?>
							<div class="caption">
								<?=$this->hak_akses->btn_add($this->uri->segment('2'), $this->template_view->base_url_admin()."/".$this->uri->segment('2')."/add?".$_SERVER['QUERY_STRING']);?>
							</div>
							<div class="table-scrollable">
								
							
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th scope="col">No</th>
											<th scope="col">Mata Pelajaran</th>
											<th scope="col">NIP</th>
											<th scope="col">Nama Guru</th>
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
											<td><?=$data->nip_pegawai;?> </td>
											<td><?=$data->nm_pegawai;?> </td>
											<td align='center'>
												<?=$this->hak_akses->btn_delete($this->uri->segment('2'), 'Apakah anda yakin akan menghapus Data <b>'.$data->nm_mata_pelajaran.'<b> ..?',$this->template_view->base_url_admin()."/".$this->uri->segment('2')."/delete/".$data->id_t_guru_kelas."?".$_SERVER['QUERY_STRING'] );?>
												

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
							</div>

								<center>
									<?php echo $this->pagination->create_links();?>
								</center>
							<?php
							}
							?>
				
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
		location.href='?id_tingkat_kelas='+$('#id_tingkat_kelas').val();
	}
	function change_tahun_ajaran(){
		location.href='?id_tingkat_kelas='+$('#id_tingkat_kelas').val()+'&id_tahun_ajaran='+$('#id_tahun_ajaran').val();
	}
	function change_kelas(){
		location.href='?id_tingkat_kelas='+$('#id_tingkat_kelas').val()+'&id_tahun_ajaran='+$('#id_tahun_ajaran').val()+'&id_kelas='+$('#id_kelas').val();
	}
</script>
