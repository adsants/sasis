 <div class="page-content">
	<div class="contaisner">

		<div class="page-content-inner">
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light">
						<div class="caption">
							<i class="fa fa-plus font-blue-sharp"></i>
							<span class="caption-subject font-blue-sharp bold">Import Data Soal</span>
						</div>
					</div>

					<!-- BEGIN Portlet PORTLET-->
					<div class="portlet light">
						<div class="portlet-body">
							<?php if($this->session->notice){echo $this->session->notice;} ?>
							<form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?=$this->template_view->base_url_admin();?>/<?=$this->uri->segment('2');?>/import?id_m_paket_soal=<?=$this->input->get('id_m_paket_soal');?>">
								
								
								<div class="form-group">
									<label class="control-label col-sm-3" >Mata Pelajaran :</label>
									<div class="control-label col-sm-9" style="text-align:left">
										<?=$this->dataPaket->nm_mata_pelajaran;?>
									</div>
								</div>
								
								<div class="form-group">
									<label class="control-label col-sm-3" >Paket Soal :</label>
									<div class=" control-label col-sm-9" style="text-align:left">
										<?=$this->dataPaket->nm_paket_soal;?>
									</div>
								</div>
								
								<div class="form-group">
									<label class="control-label col-sm-3" >Pilih File :</label>
									<div class="col-sm-4">
										<input type="file" class="form-control" required name="file_json">
										<sup>* Catatan : Format file adalah .json</sup>
									</div>
								</div>
								
								<div class="form-group">
									<div class="col-sm-offset-3 col-sm-9">
									
									<span onclick="location.href='<?=$this->template_view->base_url_admin();?>/<?=$this->uri->segment('2');?>/soal?id_m_paket_soal=<?=$this->input->get('id_m_paket_soal');?>'" class="btn btn-warning"><i class="fa fa-close"></i> Batal</span>
									<button type="submit" class="btn btn-primary"><i class="fa fa-download"></i> Import Data</button>
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

<script>
function change_tingkat_kelas(){
		location.href='?id_tingkat_kelas='+$('#id_tingkat_kelas').val();
	}
</script>
