 <div class="page-content">
	<div class="contaisner">

		<div class="page-content-inner">
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light">
						<div class="caption">
							<i class="fa fa-edit font-blue-sharp"></i>
							<span class="caption-subject font-blue-sharp bold">Ubah Data Kategori User</span>
						</div>
					</div>

					<!-- BEGIN Portlet PORTLET-->
					<div class="portlet light">
						<div class="portlet-body">
							<?php if($this->session->notice){echo $this->session->notice;} ?>
							<form class="form-horizontal" method="post" action="<?=$this->template_view->base_url_admin();?>/<?=$this->uri->segment('2')?>/update/<?=$this->dataForUpdate->id_kategori_user;?>">
								<div class="form-group">
									<label class="control-label col-sm-3">Kategori User :</label>
									<div class="col-sm-6">
										<input type="hidden" value="<?php echo $this->dataForUpdate->id_kategori_user;?>" name="ID_KATEGORI_USER">
										<input type="input" class="form-control " required id="nm_kategori_user" value="<?php echo $this->dataForUpdate->nm_kategori_user;?>" name="nm_kategori_user">
									</div>
								</div>	
								<div class="form-group">
									<div class="col-sm-6 col-sm-offset-3 "><hr></div>
									
								</div>	
								<div class="form-group">
									<?php echo $this->checkboxMenu; ?>
								</div>	
								<div class="form-group">
									<div class="col-sm-offset-3 col-sm-9">
										<img src="<?php echo base_url();?>assets/img/loading.gif" id="loading" style="display:none">
										<p id="pesan_error" style="display:none" class="text-warning" style="display:none"></p>
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

			
