 <div class="page-content">
	<div class="contaisner">

		<div class="page-content-inner">
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light">
						<div class="caption">
							<i class="fa fa-bars font-blue-sharp"></i>
							<span class="caption-subject font-blue-sharp bold">Halaman Dashboard</span>
						</div>
					</div>

					<!-- BEGIN Portlet PORTLET-->
					<div class="portlet light">
						
						<div class="portlet-body">
							
							<div class="row">
								<div class="col-sm-12">
											<div class="alert alert-success">
											Selamat datang di Aplikasi Sahabat Siswa (SASIS), Anda Login sebagai : 
											<br>
											<br>
											<b><?=$this->session->userdata('nama');?></b>
											</div>
											
                                        
								</div>
							</div>
						</div>
						<br>
						<br>
						<br>
						<sup>Powered by &copy; Sahabat Siswa </sup>
					</div>
					<!-- END Portlet PORTLET-->
				</div>
			</div>
		</div>
	</div>
</div>



<div id="modalUserGuide" class="modal fade bs-modal-lg in" role="dialog" data-backdrop="stsatic">
	<div class="modal-dialog modal-lg ">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Petunjuk Penggunaan Aplikasi</h4>
			</div>
			<div class="modal-body">
				<iframe src="<?=base_url();?>assets/userguide/userguide.pdf" frameborder="0" style="overflow:hidden;height:500px;width:100%" height="100%" width="100%"></iframe>
			</div>
		</div>
		

	</div>
</div>
