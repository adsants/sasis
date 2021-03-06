 <div class="page-content">
	<div class="contaisner">

		<div class="page-content-inner">
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light">
						<div class="caption">
							<i class="fa fa-plus font-blue-sharp"></i>
							<span class="caption-subject font-blue-sharp bold">Tambah Data Ujian</span>
						</div>
					</div>

					<!-- BEGIN Portlet PORTLET-->
					<div class="portlet light">
						<div class="portlet-body">
							<?php if($this->session->notice){echo $this->session->notice;} ?>
							<form class="form-horizontal"  method="post" action="<?=$this->template_view->base_url_admin();?>/<?=$this->uri->segment('2');?>/insert"  enctype="multipart/form-data">
								
								<div class="form-group">
									<label class="control-label col-sm-3" >Nama Ujian :</label>
									<div class="col-sm-7">
									<input type="text" class="form-control" placeholder="Contoh : Ujian Akhir Semester" value="<?=$this->session->flashdata('nm_ujian')?>" required name="nm_ujian">
									</div>
								</div>
								
								<div class="form-group">
									<label class="control-label col-sm-3" >Data Siswa :</label>
									<div class="col-sm-5">
									<input type="file" class="form-control"  name="data_siswa">
									<sup>* Format file adalah xls, Maksimal 2 Mb</sup>
									</div>
									<div class="control-label col-sm-3">									
										<span class="btn btn-warning"><i class="fa fa-excel"></i>
											<a  href="<?=base_url();?>assets/userguide/template_data_siswa.xls" target="_blank">
												Contoh Template Data Siswa
											</a>
										</span>
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
