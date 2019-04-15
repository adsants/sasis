 <div class="page-content">
	<div class="contaisner">

		<div class="page-content-inner">
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light">
						<div class="caption">
							<i class="fa fa-plus font-blue-sharp"></i>
							<span class="caption-subject font-blue-sharp bold">Tambah Data Mata Pelajaran per Tingkat Kelas</span>
						</div>
					</div>

					<!-- BEGIN Portlet PORTLET-->
					<div class="portlet light">
						<div class="portlet-body">
							<?php if($this->session->notice){echo $this->session->notice;} ?>
							<form class="form-horizontal" method="post" action="<?=$this->template_view->base_url_admin();?>/<?=$this->uri->segment('2');?>/insert">
								<div class="form-group">
									<label class="control-label col-sm-3" >Tingkat Kelas :</label>
									<div class="col-sm-3">
										<select class="form-control select2" required name="id_tingkat_kelas">
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
								<div class="form-group">
									<label class="control-label col-sm-3" >Mata Pelajaran :</label>
									<div class="col-sm-5">
										<select class="form-control select2" required name="id_mata_pelajaran">
												<option value=""></option>
												<?php
												foreach($this->dataMataPelajaran as $data){
												?>
												<option <?php if($this->session->flashdata('id_mata_pelajaran')== $data->id_mata_pelajaran) echo "selected";?> value="<?=$data->id_mata_pelajaran;?>"><?=$data->nm_mata_pelajaran;?></option>
												<?php
												}
												?>
										</select>
									</div>
								</div>
							
								
								<div class="form-group">
									<div class="col-sm-offset-3 col-sm-9">
									<span onclick="location.href='<?=$this->template_view->base_url_admin();?>/<?=$this->uri->segment('2');?>/'" class="btn btn-warning"><i class="fa fa-close"></i> Batal</span>
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
