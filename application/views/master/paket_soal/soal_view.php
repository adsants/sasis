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
								<!--<a href="<?=$this->template_view->base_url_admin();?>/<?=$this->uri->segment('2');?>/export/?id_m_paket_soal=<?=$this->dataPaketSoal->id_m_paket_soal;?>" target="_blank" class="pull-right" style="margin-right:10px;">
									<span class="btn btn-success"><i class="fa fa-upload"></i> Export Data </span>
								</a>-->
								<span class="btn btn-success pull-right" onclick="export_soal()" style="margin-right:10px;"><i class="fa fa-upload"></i> Export Data </span>
							</div>
							</div>
							<br>
						</div>
						<div class="portlet-body">
							<?php if($this->session->notice){echo $this->session->notice;} ?>
							<div class="table-scrollable">
								<form method="post" action="<?=$this->template_view->base_url_admin();?>/<?=$this->uri->segment('2');?>/export/?id_m_paket_soal=<?=$this->dataPaketSoal->id_m_paket_soal;?>" name="form_export" id="form_export">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th scope="col">No<br>
											<input type="checkbox" id="selectAll" /> 
											</th>
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
											<td align='center'><?=$no;?>.
											<br>
											<input type="checkbox" name="id_m_soal[]" value="<?=$data->id_m_soal;?>"/>
											
											</td>
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
								</form>
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


<div id="modal_export" class="modal fade" role="dialog">
	<div class="modal-dialog">

	<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">			
				<h4 class="modal-title">Pesan Konfirmasi</h4>
			</div>
			<div class="modal-body">
				
				Apakah anda yakin akan Export Data soal terpilih  ..?
				
			</div>
			<div class="modal-footer">
				<div class="pull-left">
					<span class="btn btn-warning" data-dismiss="modal">Tidak</span >
				</div>
					<span class="btn btn-primary" onclick="export_soal_ya()">Ya</span>
			</div>
		</div>

	</div>
</div>

<script>
	function change_mapel(){
		location.href='?id_m_mata_pelajaran='+$('#id_m_mata_pelajaran').val();
	}
	
	
	$('#selectAll').click(function(e){
		var table= $(e.target).closest('table');
		$('td input:checkbox',table).prop('checked',this.checked);
	});
	
	function export_soal(){
		
		var checkedNum = $('input[name="id_m_soal[]"]:checked').length;
		if (!checkedNum) {
			alert('Silahkan pilih dahulu Soal yang akan diExport.');
		}
		else{
			$("#modal_export").modal('show'); 
		}
		
	}
	
	function export_soal_ya(){
		$("#form_export").submit();
			$("#modal_export").modal('hide'); 
	}
</script>
