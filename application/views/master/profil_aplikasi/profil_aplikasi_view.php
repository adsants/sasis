 <div class="page-content">
	<div class="contaisner">

		<div class="page-content-inner">
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light">
						<div class="caption">
							<i class="fa fa-edit font-blue-sharp"></i>
							<span class="caption-subject font-blue-sharp bold">Ubah Data Profil Sekolah</span>
						</div>
					</div>

					<!-- BEGIN Portlet PORTLET-->
					<div class="portlet light">
						<div class="portlet-body">
							<?php if($this->session->notice){echo $this->session->notice;} ?>
							<form class="form-horizontal" method="post" action="<?=$this->template_view->base_url_admin();?>/<?=$this->uri->segment('2')?>"  enctype="multipart/form-data">
						
							
								
								<div class="form-group">
									<label class="control-label col-sm-3" >Nama Sekolah :</label>
									<div class="col-sm-7">
									<input type="text" class="form-control" value="<?=$this->dataForUpdate->nm_aplikasi;?>" required name="nm_aplikasi">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-3" >Alamat :</label>
									<div class="col-sm-8">
									<input type="text" class="form-control" value="<?=$this->dataForUpdate->alamat;?>" required name="alamat">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-3" >Telp :</label>
									<div class="col-sm-4">
									<input type="text" class="form-control" value="<?=$this->dataForUpdate->telp;?>" required name="telp">
									</div>
								</div>
								
								<div class="form-group">
									<label class="control-label col-sm-3" >Logo Sekolah :</label>
									<div class="col-sm-4">
									<input type="file" class="form-control" name="icon_logo">
									<br>
									<img src="<?=base_url();?>upload/logo/<?=$this->dataForUpdate->icon;?>" height="200px">
									</div>
								</div>
							
								<div class="form-group">
									<div class="col-sm-offset-3 col-sm-9">
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
