 <div class="page-content">
	<div class="contaisner">

		<div class="page-content-inner">
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light">
						<div class="caption">
							<i class="fa fa-edit font-blue-sharp"></i>
							<span class="caption-subject font-blue-sharp bold">Ubah Data Profil</span>
						</div>
					</div>

					<!-- BEGIN Portlet PORTLET-->
					<div class="portlet light">

						<div class="portlet-body">
							<?php if($this->session->notice){echo $this->session->notice;} ?>
							<form class="form-horizontal" method="post" action="<?=$this->template_view->base_url_admin();?>/<?=$this->uri->segment('2')?>/profil"  enctype="multipart/form-data">
						
							
								<div class="form-group">
									<label class="control-label col-sm-3" >Nama User :</label>
									<div class="col-sm-4">
									<input type="text" class="form-control" value="<?=$this->dataForUpdate->nama_user;?>" disabled name="nm_aplikasi">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-3" >Username :</label>
									<div class="col-sm-3">
									<input type="text" class="form-control" value="<?=$this->dataForUpdate->user_name;?>" required name="user_name">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-3" >Password :</label>
									<div class="col-sm-3">
									<input type="text" class="form-control" value="<?=$this->encrypt_decrypt->getText('decrypt', $this->dataForUpdate->pass_word )?>" required name="pass_word">
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
