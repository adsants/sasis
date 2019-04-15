 <div class="page-content">
	<div class="contaisner">

		<div class="page-content-inner">
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light">
						<div class="caption">
							<i class="fa fa-plus font-blue-sharp"></i>
							<span class="caption-subject font-blue-sharp bold">Tambah Data User</span>
						</div>
					</div>

					<!-- BEGIN Portlet PORTLET-->
					<div class="portlet light">
						<div class="portlet-body">
							<?php if($this->session->notice){echo $this->session->notice;} ?>
							<form class="form-horizontal" method="post" action="<?=$this->template_view->base_url_admin();?>/<?=$this->uri->segment('2');?>/insert">
								<div class="form-group">
									<label class="control-label col-sm-3">Kategori User :</label>
									<div class="col-sm-4">
										<select name="id_kategori_user_form" class="form-control" required>
											<option value=""></option>
											<?php
											foreach($this->dataKategoriUser as $katUser){
											?>
												
											<option <?php if($this->session->flashdata('id_kategori_user_form') == $katUser->id_kategori_user) echo "selected";?> value="<?= $katUser->id_kategori_user;?>"><?= $katUser->nm_kategori_user;?></option>
											<?php
											}
											?>
										</select>
									</div>
								</div>
								
								<div class="form-group">
									<label class="control-label col-sm-3">Nama :</label>
									<div class="col-sm-3">
										<input type="text" class="form-control" value="<?php echo $this->session->flashdata('nama_user_form');?>" name="nama_user_form">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-3">Username :</label>
									<div class="col-sm-3">
										<input type="text" class="form-control" value="<?php echo $this->session->flashdata('user_name_form');?>" name="user_name_form">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-3">Password :</label>
									<div class="col-sm-3">
										<input type="text" class="form-control" value="<?php echo $this->session->flashdata('pass_word_form');?>" name="pass_word_form">
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



	
