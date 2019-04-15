 <div class="page-content">
	<div class="containser">

		<div class="page-content-inner">
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light">
						<div class="caption">
							<i class="fa fa-bars font-blue-sharp"></i>
							<span class="caption-subject font-blue-sharp bold">Cetak Daftar Hadir Ujian : <?=$this->dataUjianMapel->nm_ujian;?>, Mata Pelajaran :  <?=$this->dataUjianMapel->nm_mata_pelajaran;?></span>
						</div>
					</div>

					<!-- BEGIN Portlet PORTLET-->
					<div class="portlet light">
						<div class="portlet-title">
								<span onclick="location.href='<?=$this->template_view->base_url_admin();?>/<?=$this->uri->segment('2');?>/mapel/<?=$this->dataUjianMapel->id_m_ujian;?>'" class="btn btn-warning"><i class="fa fa-backward"></i> Kembali ke Daftar Mata Pelajaran</span>
							
								<a href="<?=$this->template_view->base_url_admin();?>/cetak/daftar_hadir/index/<?=$this->dataUjianMapel->id_m_ujian;?>/<?=$this->dataUjianMapel->id_m_ujian_mapel;?>" class="pull-right" target="_blank">
									<span class="btn btn-primary"><i class="fa fa-print"></i> Cetak Semua Kelas</span>
								</a>
						</div>
						<div class="portlet-body">
							<?php if($this->session->notice){echo $this->session->notice;} ?>
							<div class="table-scrollable">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th scope="col" width="10%">No</th>
											<th scope="col">Kelas</th>
											<th scope="col" width="35%"></th>
										</tr>
									</thead>
									<tbody>
										<?php
										$no 	= $this->input->get('per_page')+ 1;
										foreach($this->showData as $data){
										?>
										<tr>
											<td align='center'><?=$no;?>.</td>
											<td><?=$data->kelas;?> </td>
											<td align='center'>												
												<a href="<?=$this->template_view->base_url_admin();?>/cetak/daftar_hadir/index/<?=$this->dataUjianMapel->id_m_ujian;?>/<?=$this->dataUjianMapel->id_m_ujian_mapel;?>?kelas=<?=$data->kelas;?>" class="pull-rigsht" target="_blank">
													<span class="btn btn-primary"><i class="fa fa-print"></i> Cetak</span>
												</a>
											</td>
										</tr>
										<?php
										$no++;
										}
										if(!$this->showData){
											echo "<tr><td colspan='25' align='center'>Maaf, tidak ada Data untuk ditampilkan.</td></tr>";
										}
										?>
									</tbody>
								</table>
							</div>

								<center>
									<?php echo $this->pagination->create_links();?>
								</center>

						</div>
					</div>
					<!-- END Portlet PORTLET-->
				</div>
			</div>
		</div>
	</div>
</div>
