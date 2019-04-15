 <div class="page-content">
	<div class="contaisner">

		<div class="page-content-inner">
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light">
						<div class="caption">
							<i class="fa fa-plus font-blue-sharp"></i>
							<span class="caption-subject font-blue-sharp bold">Tambah Data Paket Soal</span>
						</div>
					</div>

					<!-- BEGIN Portlet PORTLET-->
					<div class="portlet light">
						<div class="portlet-body">
							<?php if($this->session->notice){echo $this->session->notice;} ?>
							<form class="form-horizontal" method="post" action="<?=$this->template_view->base_url_admin();?>/<?=$this->uri->segment('2');?>/insert">
							
								<div class="form-group">
									<label class="control-label col-sm-3" >Pilih Mata Pelajaran :</label>
									<div class="col-sm-5">
										<select class="form-control select2" required name="id_m_mata_pelajaran" id="id_m_mata_pelajaran" onchange="change_mapel(this.val)">
												<option value=""></option>
												<?php
												foreach($this->dataMapel as $data){
												?>
												<option <?php if($this->input->get('id_m_mata_pelajaran')== $data->id_m_mata_pelajaran) echo "selected";?> value="<?=$data->id_m_mata_pelajaran;?>"><?=$data->nm_mata_pelajaran;?></option>
												<?php
												}
												?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-3" >Nama Paket Soal :</label>
									<div class="col-sm-5">
									<input type="text" class="form-control" placeholder="Contoh : Bab Pengurangan, Try Out ... " value="<?=$this->session->flashdata('nm_paket_soal')?>" required name="nm_paket_soal">
									</div>
								</div>
							
								<div class="form-group">
									<div class="col-sm-offset-3 col-sm-9">
									<span onclick="location.href='<?=$this->template_view->base_url_admin();?>/<?=$this->uri->segment('2');?>/?id_m_mata_pelajaran=<?=$this->input->get('id_m_mata_pelajaran');?>'" class="btn btn-warning"><i class="fa fa-close"></i> Batal</span>
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
