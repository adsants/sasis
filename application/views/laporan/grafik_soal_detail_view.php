 <div class="page-content">
	<div class="containser">

		<div class="page-content-inner">
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light">
						<div class="caption">
							<i class="fa fa-edit font-blue-sharp"></i>
							<span class="caption-subject font-blue-sharp bold">Analisa Butir Soal di Ujian : <?=$this->dataUjian->nm_ujian;?></span>
						</div>
					</div>

					<!-- BEGIN Portlet PORTLET-->
					<div class="portlet light">
						<div class="portlet-body">
							<?php if($this->session->notice){echo $this->session->notice;} ?>
							
							
							<form class="form-horizontal" id="form_standard" method="post" >
							
								<div class="form-group">
									<label class="control-label col-sm-4" >Mata Pelajaran :</label>
									<div class="col-sm-5">
										<select name="id_m_ujian_mapel" id="id_m_ujian_mapel" onchange="change_mapel()" class="form-control select2 required">
											<option value=""></option>
											<?php
											foreach($this->ShowDataMapelUjian as $ShowDataMapelUjian) {
											?>									
											<option value="<?=$ShowDataMapelUjian->id_m_ujian_mapel;?>" <?php if($this->input->get('id_m_ujian_mapel') == $ShowDataMapelUjian->id_m_ujian_mapel) echo "selected";?>>
												<?=$ShowDataMapelUjian->nm_mata_pelajaran;?>
											</option>
											<?php
											}
											?>
										</select>
									</div>
								</div>
								
								<?php
								if($this->input->get('id_m_ujian_mapel')){
								?>
								<div class="form-group">
									<label class="control-label col-sm-4" ></label>
									<div class="col-sm-3">
										
										
										<a href="<?=$this->template_view->base_url_admin();?>/grafik_soal/cetak/<?=$this->dataUjian->id_m_ujian;?>?id_m_ujian_mapel=<?=$this->input->get('id_m_ujian_mapel');?>&order_by=<?=$this->input->get('order_by');?>" target="_blank">
											<span class="btn btn-primary"><i class="fa fa-print"></i> Cetak</span>
										</a>
									
									</div>
								</div>
								
								
								<hr>
								
								

								<div class="tabbable-custom nav-justified">
									<ul class="nav nav-tabs nav-justified">
										<li class="active">
											<a href="<?=$this->template_view->base_url_admin();?>/grafik_soal/detail/<?=$this->dataMapelUjian->id_m_ujian;?>?id_m_ujian_mapel=<?=$this->input->get('id_m_ujian_mapel');?>" > Angka </a>
										</li>
										<li class="">
											<a href="<?=$this->template_view->base_url_admin();?>/grafik_soal/detail_grafik/<?=$this->dataMapelUjian->id_m_ujian;?>?id_m_ujian_mapel=<?=$this->input->get('id_m_ujian_mapel');?>" > Grafik </a>
										</li>
									</ul>
									<div class="tab-content">
										<div class="tab-pane active" id="tab_1_1_1">
											<table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_2">
												<thead>
													<tr>
														<th scope="col">Soal</th>
														<th scope="col" width="10%">Diujikan</th>
														<th scope="col" width="10%">Benar</th>
														<th scope="col" width="10%">Salah</th>
														<th scope="col" width="10%">Tidak Dijawab</th>
													</tr>
												</thead>
												<tbody>
											<?php
												
												echo $this->tableHtml;
											
											?>
												</tbody>
											</table>
										</div>
										
									</div>
								</div>
								
								
								<?php
								}
								?>
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
	<?php
	if(!$this->input->get('id_m_ujian_mapel')){
	?>
	function change_mapel(){
		location.href='?id_m_ujian_mapel='+$('#id_m_ujian_mapel').val()+'&order_by=m_siswa_paket_ujian.nipd';		
	}
	<?php
	}
	else{
	?>
	
	function change_mapel(){
		location.href='?id_m_ujian_mapel='+$('#id_m_ujian_mapel').val()+'&order_by='+$('#order_by').val();
	}
		
	
	<?php
	}
	?>
	
</script>