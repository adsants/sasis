 <div class="page-content">
	<div class="contaisner">

		<div class="page-content-inner">
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light">
						<div class="caption">
							<i class="fa fa-plus font-blue-sharp"></i>
							<span class="caption-subject font-blue-sharp bold">Tambah Data Siswa per Kelas</span>
						</div>
					</div>

					<!-- BEGIN Portlet PORTLET-->
					<div class="portlet light">
						<div class="portlet-body">
							<?php if($this->session->notice){echo $this->session->notice;} ?>
							<form class="form-horizontal" method="post" action="<?=$this->template_view->base_url_admin();?>/<?=$this->uri->segment('2');?>/insert?id_tingkat_kelas=<?=$this->input->get('id_tingkat_kelas');?>&id_tahun_ajaran=<?=$this->input->get('id_tahun_ajaran');?>&id_kelas=<?=$this->input->get('id_kelas');?>">
								<div class="form-group">
									<label class="control-label col-sm-3" >Pilih Tingkat Kelas :</label>
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
									<label class="control-label col-sm-3" >Pilih Tahun Ajaran :</label>
									<div class="col-sm-3">
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
									<label class="control-label col-sm-3" >Pilih Kelas :</label>
									<div class="col-sm-2">
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
								if($this->input->get('id_kelas')){
								?>
								<div class="form-group">
									<label class="control-label col-sm-3" >Pilih Siswa :</label>
									<div class="col-sm-5">
										<select class="form-control select2" required name="id_siswa" id="id_siswa" >
												<option value=""></option>
												<?php
												foreach($this->dataSiswa as $data){
												?>
												<option <?php if($this->session->flashdata('id_siswa')== $data->id_siswa) echo "selected";?> value="<?=$data->id_siswa;?>"><?=$data->nis;?> | <?=$data->nm_siswa;?></option>
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
									<div class="col-sm-offset-3 col-sm-9">
									<span onclick="location.href='<?=$this->template_view->base_url_admin();?>/<?=$this->uri->segment('2');?>/?id_tingkat_kelas=<?=$this->input->get('id_tingkat_kelas');?>&id_tahun_ajaran=<?=$this->input->get('id_tahun_ajaran');?>&id_kelas=<?=$this->input->get('id_kelas');?>'" class="btn btn-warning"><i class="fa fa-close"></i> Batal</span>
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
		location.href='?id_tingkat_kelas='+$('#id_tingkat_kelas').val();
	}
	function change_tahun_ajaran(){
		location.href='?id_tingkat_kelas='+$('#id_tingkat_kelas').val()+'&id_tahun_ajaran='+$('#id_tahun_ajaran').val();
	}
	function change_kelas(){
		location.href='?id_tingkat_kelas='+$('#id_tingkat_kelas').val()+'&id_tahun_ajaran='+$('#id_tahun_ajaran').val()+'&id_kelas='+$('#id_kelas').val();
	}
</script>