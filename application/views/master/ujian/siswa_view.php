 <div class="page-content">
	<div class="containser">

		<div class="page-content-inner">
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light">
						<div class="caption">
							<i class="fa fa-bars font-blue-sharp"></i>
							<span class="caption-subject font-blue-sharp bold">Data Siswa di Ujian : <?=$this->dataUjian->nm_ujian;?></span>
						</div>
					</div>

					<!-- BEGIN Portlet PORTLET-->
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span onclick="location.href='<?=$this->template_view->base_url_admin();?>/<?=$this->uri->segment('2');?>'" class="btn btn-warning"><i class="fa fa-backward"></i> Kembali ke Daftar Ujian</span>
							
								<br>
								<br>
								
								<span data-toggle="modal" data-target="#modal_tambah_siswa" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data Siswa</span>
								
								<a href="<?=$this->template_view->base_url_admin();?>/cetak/kartu_ujian/index/<?=$this->dataUjian->id_m_ujian;?>" target="_blank">
								<span class="btn btn-success text-right">
									<i class="fa fa-print"></i> Cetak Kartu Ujian
								</span>
								</a>
							</div>
							
						</div>
						<div class="portlet-body">
							<?php if($this->session->notice){echo $this->session->notice;} ?>
							<!--<div class="table-scrollable">-->
								<table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_2">
									<thead>
										<tr>
											<th scope="col">No</th>
											<th scope="col">Kelas</th>
											<th scope="col">NIPD</th>
											<th scope="col">NISN</th>
											<th scope="col">Nama Siswa</th>
											<th scope="col">Password</th>
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
											<td><?=$data->nipd;?> </td>
											<td><?=$data->nisn;?> </td>
											<td><?=$data->nama;?> </td>
											<td><?=$data->password;?> </td>
											
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
							<!--</div>-->


						</div>
					</div>
					<!-- END Portlet PORTLET-->
				</div>
			</div>
		</div>
	</div>
</div>


<div id="modal_tambah_siswa" class="modal fade" role="dialog">
	<div class="modal-dialog">

	<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">			
				<h4 class="modal-title">Form Tambah data Siswa</h4>
			</div>
			<div class="modal-body">
				
				<form class="form-horizontal" id="form_standard" method="post" action="<?=$this->template_view->base_url_admin();?>/<?=$this->uri->segment('2');?>/insert_siswa/<?=$this->dataUjian->id_m_ujian;?>">
					<div class="form-group">
						<label class="control-label col-sm-3" >NIPD :</label>
						<div class="col-sm-5">
							<input name="nipd" type="text" class="form-control required">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-3" >NISN :</label>
						<div class="col-sm-5">
							<input name="nisn" type="text" class="form-control required">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-3" >Nama Siswa :</label>
						<div class="col-sm-8">
							<input name="nama" type="text" class="form-control required">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-3" >Kelas :</label>
						<div class="col-sm-5">
							<input name="kelas" type="text" class="form-control required">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-9 col-sm-offset-3">
							<span id="pesan_error"></span>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-9 col-sm-offset-3">
							<span  class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Batal</span>
							<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
						</div>
					</div>
				</form>
				
			</div>
		</div>

	</div>
</div>
