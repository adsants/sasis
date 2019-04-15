 <div class="page-content">
	<div class="contaisner">

		<div class="page-content-inner">
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light">
						<div class="caption">
							<i class="fa fa-bars font-blue-sharp"></i>
							<span class="caption-subject font-blue-sharp bold">Data Soal Mata pelajaran <?=$this->dataPaketSoal->nm_mata_pelajaran;?>, Paket : <?=$this->dataPaketSoal->nm_paket_soal;?></span>
						</div>
					</div>

					<!-- BEGIN Portlet PORTLET-->
					<div class="portlet light">
					
					
					
						<div class="portlet-title">
							<div class="row">
							<div class="col-md-12">
								
								<span onclick="location.href='<?=$this->template_view->base_url_admin();?>/<?=$this->uri->segment('2');?>?id_m_mata_pelajaran=<?=$this->dataPaketSoal->id_m_mata_pelajaran;?>'" class="btn btn-warning"><i class="fa fa-backward"></i> Kembali ke Daftar Paket Soal</span>
							</div>
							</div>
							<br>
							<div class="row">
							<div class="col-md-12">
								<?=$this->hak_akses->btn_add($this->uri->segment('2'),$this->template_view->base_url_admin()."/".$this->uri->segment('2')."/add_soal/?id_m_paket_soal=".$this->input->get('id_m_paket_soal'));?>
								
								<a href="<?=$this->template_view->base_url_admin();?>/<?=$this->uri->segment('2');?>/import/?id_m_paket_soal=<?=$this->dataPaketSoal->id_m_paket_soal;?>" class="pull-right">
									<span class="btn btn-warning"><i class="fa fa-download"></i> Import Data </span>
								</a>
								<a href="<?=$this->template_view->base_url_admin();?>/<?=$this->uri->segment('2');?>/export/?id_m_paket_soal=<?=$this->dataPaketSoal->id_m_paket_soal;?>" target="_blank" class="pull-right" style="margin-right:10px;">
									<span class="btn btn-success"><i class="fa fa-upload"></i> Export Data </span>
								</a>
							</div>
							</div>
							<br>
						</div>
						<div class="portlet-body">
							<?php if($this->session->notice){echo $this->session->notice;} ?>
							<div class="table-scrollable">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th scope="col">No</th>
											<th scope="col"> Soal</th>
										
											<th scope="col"></th>
											<th scope="col"></th>
										</tr>
									</thead>
									<tbody>
										<?php
										$no 	= $this->input->get('per_page')+ 1;
										foreach($this->showData as $data){
										?>
										<tr>
											<td align='center'><?=$no;?>.</td>
											<td><?=$data->soal;?> </td>
											<td>
												<?php 
												if($data->status_soal == 'A'){
												?>
												<a onclick="show_confirmation_modal('<p>Apakah anda yakin akan Me Non Aktifkan Soal ini ..?</p>','<?=$this->template_view->base_url_admin();?>/<?=$this->uri->segment('2');?>/aktif_soal/<?=$this->input->get('id_m_paket_soal');?>/<?=$data->id_m_soal;?>/N')">
													Aktif
												</a>
												<?php
												}
												else{
												?>
												<a onclick="show_confirmation_modal('<p>Apakah anda yakin akan Mengaktifkan Soal ini ..?</p>','<?=$this->template_view->base_url_admin();?>/<?=$this->uri->segment('2');?>/aktif_soal/<?=$this->input->get('id_m_paket_soal');?>/<?=$data->id_m_soal;?>/A')">
													Tidak Aktif
												</a>
												<?php
												}
												?> 
											</td>
											
									
											
											<td align='center'>
												<?=$this->hak_akses->btn_edit($this->uri->segment('2'), $this->template_view->base_url_admin()."/".$this->uri->segment('2')."/edit_soal/".$data->id_m_paket_soal."?id_m_soal=".$data->id_m_soal );?>

												<?=$this->hak_akses->btn_delete($this->uri->segment('2'), 'Apakah anda yakin akan menghapus Data Soal terpilih ..?',$this->template_view->base_url_admin()."/".$this->uri->segment('2')."/delete_soal/".$data->id_m_paket_soal."/".$data->id_m_soal );?>
												

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

<script>
	function change_mapel(){
		location.href='?id_m_mata_pelajaran='+$('#id_m_mata_pelajaran').val();
	}
</script>
