 <div class="page-content">
	<div class="container">

		<div class="page-content-inner">
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light" style="margin-top:10px;">
						<div class="caption">
							<i class="fa fa-user font-blue-sharp"></i>
							<span class="caption-subject font-blue-sharp bold">Form Ubah data Profil</span>
						</div>
					</div>
					<!-- BEGIN Portlet PORTLET-->
					<div class="portlet light">
						<div class="portlet-body">
							<div class="row">
								<div class="col-md-3 text-center">
									<div class="portlet light profile-sidebar-portlet ">
										<!-- SIDEBAR USERPIC -->
										<div class="profile-userpic">
											<?php
											if($this->dataSiswa->photo != ''){
											?>											
											<img width="250px" src="<?=base_url();?>upload/siswa/<?=$this->dataSiswa->photo;?>" >
											<?php
											}
											else{
											?>
											<img src="<?=base_url();?>assets/images/murid.png" >
											<?php
											}
											?>
										</div>
									</div>
								</div>
								<div class="col-md-9">
									<?php if($this->session->notice){echo $this->session->notice;} ?>
							<form class="form-horizontal" method="post" action="<?=$this->template_view->base_url_siswa();?>/<?=$this->uri->segment('2')?>"  enctype="multipart/form-data">
						
							
								
								<div class="form-group">
									<label class="control-label col-sm-3" >Nomor Induk Siswa :</label>
									<div class="col-sm-3">
									<input type="text" class="form-control" value="<?=$this->dataSiswa->nis;?>" disabled >
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-3" >Nama Siswa :</label>
									<div class="col-sm-5">
									<input type="text" class="form-control" value="<?=$this->dataSiswa->nm_siswa;?>" disabled >
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-3" >Password :</label>
									<div class="col-sm-3">
									<input type="text" class="form-control" value="<?=$this->encrypt_decrypt->getText('decrypt', $this->dataSiswa->password )?>" required name="pass_word">
									
									<?php
								//	echo $this->encrypt_decrypt->getText('decrypt', $this->dataSiswa->password );
								//	echo $this->dataSiswa->nis;
									?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-3" >Ubah Foto :</label>
									<div class="col-sm-5">
										<input type="file" class="from-control" name="foto_siswa">
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
						</div>
					</div>
					<!-- END Portlet PORTLET-->
				</div>
			</div>
		</div>
	</div>
</div>


