 <div class="page-content">
	<div class="contaisner">

		<div class="page-content-inner">
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light">
						<div class="caption">
							<i class="fa fa-edit font-blue-sharp"></i>
							<span class="caption-subject font-blue-sharp bold">Ubah Data User</span>
						</div>
					</div>

					<!-- BEGIN Portlet PORTLET-->
					<div class="portlet light">
						<div class="portlet-body">
							<?php if($this->session->notice){echo $this->session->notice;} ?>
							<form class="form-horizontal" method="post" action="<?=$this->template_view->base_url_admin();?>/<?=$this->uri->segment('2')?>/update/<?=$this->dataForUpdate->id_user;?>">
								<div class="form-group">
									<label class="control-label col-sm-3">Kategori User :</label>
									<div class="col-sm-4">
										<select name="id_kategori_user_form" class="form-control" required>
											<option value=""></option>
											<?php
											foreach($this->dataKategoriUser as $katUser){
											?>
												
											<option <?php if($this->dataForUpdate->id_kategori_user == $katUser->id_kategori_user) echo "selected";?> value="<?= $katUser->id_kategori_user;?>"><?= $katUser->nm_kategori_user;?></option>
											<?php
											}
											?>
										</select>
									</div>
								</div>
							
								<div class="form-group">
									<label class="control-label col-sm-3">Nama User :</label>
									<div class="col-sm-3">
										<input type="text" class="form-control" value="<?php echo $this->dataForUpdate->nama_user;?>" name="nama_user_form">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-3">Username :</label>
									<div class="col-sm-3">
										<input type="text" class="form-control" value="<?php echo $this->dataForUpdate->user_name;?>" name="user_name_form">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-3">Password :</label>
									<div class="col-sm-3">
										<input type="text" class="form-control" value="<?php echo $this->encrypt_decrypt->getText('decrypt', $this->dataForUpdate->pass_word); ?>" name="pass_word_form">
									</div>
								</div>	
								<div class="form-group">
									<label class="control-label col-sm-3">Status :</label>
									<div class="col-sm-2">
										<select name="aktif_user" class="form-control" required>
											<option value=""></option>
											<option <?php if($this->dataForUpdate->aktif_user == 'A') echo "selected";?> value="A">Aktif</option>
											<option <?php if($this->dataForUpdate->aktif_user == 'N') echo "selected";?> value="N">Tidak Aktif</option>
											
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

			
