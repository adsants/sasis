 <div class="page-content">
	<div class="contaisner">

		<div class="page-content-inner">
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light">
						<div class="caption">
							<i class="fa fa-bars font-blue-sharp"></i>
							<span class="caption-subject font-blue-sharp bold">Data Paket Soal</span>
						</div>
					</div>

					<!-- BEGIN Portlet PORTLET-->
					<div class="portlet light">
					
						<form class="form-horizontal" method="post" >
								<div class="form-group">
									<label class="control-label col-sm-3" >Pilih Mata Pelajaran :</label>
									<div class="col-sm-5">
										<select class="form-control select2" required name="id_m_mata_pelajaran" id="id_m_mata_pelajaran" onchange="change_mapel(this.val)">
												<option value=""></option>
												<?php
												foreach($this->dataMapel as $data){
												?>
												<option <?php if($this->input->get('id_m_mata_pelajaran')== $data->id_m_mata_pelajaran) echo "selected";?> value="<?=$data->id_m_mata_pelajaran;?>"><?=$data->nm_mata_pelajaran;?></option>
												<?php
												}
												?>
										</select>
									</div>
								</div>
								
								
								<div class="form-group">
									<div class="col-sm-12"><hr></div>
								</div>
							</form>
						<?php
						if($this->input->get('id_m_mata_pelajaran')){	
						?>
					
						<div class="portlet-title">
							<div class="caption">
								<?=$this->hak_akses->btn_add($this->uri->segment('2'),$this->template_view->base_url_admin()."/".$this->uri->segment('2')."/add?id_m_mata_pelajaran=".$this->input->get('id_m_mata_pelajaran'));?>
							</div>
						</div>
						<div class="portlet-body">
							<?php if($this->session->notice){echo $this->session->notice;} ?>
							<div class="table-scrollable">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th scope="col">No</th>
											<th scope="col">Nama Paket Soal</th>
											<?php
											if($this->hak_akses->btn_add($this->uri->segment('2'))){
											?>
											<th scope="col"></th>
											<?php
											}
											?>
											<th scope="col"></th>
										</tr>
									</thead>
									<tbody>
										<?php
										$no 	= $this->input->get('per_page')+ 1;
										foreach($this->showData as $data){
										?>
										<tr>
											<td align='center'  width="5%"><?=$no;?>.</td>
											<td><?=$data->nm_paket_soal;?> </td>
											
											<?php
											if($this->hak_akses->btn_add($this->uri->segment('2'))){
											?>
											<td align='center' width="20%">
												<span onclick="location.href='<?=$this->template_view->base_url_admin();?>/<?=$this->uri->segment('2');?>/soal?id_m_paket_soal=<?=$data->id_m_paket_soal;?>'" class="btn btn-primary"><i class="fa fa-pencil"></i> Data Soal</span>
											</td>
											<?php
											}
											?>
											
											<td align='center' width="15%">
												<?=$this->hak_akses->btn_edit($this->uri->segment('2'), $this->template_view->base_url_admin()."/".$this->uri->segment('2')."/edit/".$data->id_m_paket_soal."?id_m_mata_pelajaran=".$data->id_m_mata_pelajaran );?>

												<?=$this->hak_akses->btn_delete($this->uri->segment('2'), 'Apakah anda yakin akan menghapus Data <b>'.$data->nm_paket_soal.'<b> ..?',$this->template_view->base_url_admin()."/".$this->uri->segment('2')."/delete/".$data->id_m_paket_soal );?>
												

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
						<?php
						}
						?>
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
