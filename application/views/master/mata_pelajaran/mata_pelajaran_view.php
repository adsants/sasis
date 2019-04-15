 <div class="page-content">
	<div class="contaisner">

		<div class="page-content-inner">
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light">
						<div class="caption">
							<i class="fa fa-bars font-blue-sharp"></i>
							<span class="caption-subject font-blue-sharp bold">Data Mata Pelajaran</span>
						</div>
					</div>

					<!-- BEGIN Portlet PORTLET-->
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<?=$this->hak_akses->btn_add($this->uri->segment('2'));?>
							</div>
							<div class="inputs">
								<div class="portlet-input input-inline input-large">

									<form method="get" action="<?=$this->template_view->base_url_admin();?>/<?=$this->uri->segment('2');?>">
									<div class="input-group">
										<input type="text" name="search" value="<?=$this->input->get('search');?>" required class="form-control input-circle-left" placeholder="Ketikkan Kata Kunci ...">
										<span class="input-group-btn">
											<button class="btn btn-primary	" type="submit"><i class="fa fa-search"></i> Cari</button>
											<?php
											if($this->input->get('search')){
											?>
											<span style="margin-left:10px;" class="btn btn-warning" onclick="location.href='<?=$this->template_view->base_url_admin();?>/<?=$this->uri->segment('2');?>'"><i class="fa fa-refresh"></i></span>
											<?php
											}
											?>
										</span>
									</div>

									</form>
								</div>

							</div>
						</div>
						<div class="portlet-body">
							<?php if($this->session->notice){echo $this->session->notice;} ?>
							<div class="table-scrollable">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th scope="col">No</th>
											<th scope="col">Nama Mata Pelajaran</th>
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
											<td><?=$data->nm_mata_pelajaran;?> </td>
											<td align='center'>
												<?=$this->hak_akses->btn_edit($this->uri->segment('2'), $this->template_view->base_url_admin()."/".$this->uri->segment('2')."/edit/".$data->id_m_mata_pelajaran );?>

												<?=$this->hak_akses->btn_delete($this->uri->segment('2'), 'Apakah anda yakin akan menghapus Data <b>'.$data->nm_mata_pelajaran.'<b> ..?',$this->template_view->base_url_admin()."/".$this->uri->segment('2')."/delete/".$data->id_m_mata_pelajaran );?>
												

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
