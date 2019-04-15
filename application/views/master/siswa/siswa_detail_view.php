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
							<div class="row">
							<div class="col-md-12">
								<span onclick="location.href='<?=$this->template_view->base_url_admin();?>/<?=$this->uri->segment('2');?>'" class="btn btn-warning"><i class="fa fa-backward"></i> Kembali ke Daftar Ujian</span>
							
								
							
							</div>	
							</div>	
							<br>
							<div class="row">
							<div class="col-md-6">
								<!--<span data-toggle="modal" data-target="#modal_tambah_siswa" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data Siswa</span>-->
								
								<?php
								if($this->hak_akses->btn_add($this->uri->segment('2'),'','')){?>
								
								
								
								
								<a href="<?=$this->template_view->base_url_admin();?>/<?=$this->uri->segment('2');?>/add/<?=$this->dataUjian->id_m_ujian;?>"<span  class="btn btn-primary">
									<i class="fa fa-upload"></i> Upload Data Siswa</span>
								</a>
								
								<?php
								}
								?>
							
							</div>
							<div class="col-md-6">	
								<!--
								<a href="<?=$this->template_view->base_url_admin();?>/cetak/kartu_ujian/index/<?=$this->dataUjian->id_m_ujian;?>?jenis=word" target="_blank" >
								<span class="btn btn-warning text-right">
									<i class="fa fa-file-word-o"></i> Export Word Semua Siswa
								</span>
								</a>
								-->
								&nbsp;&nbsp;
								<a href="<?=$this->template_view->base_url_admin();?>/cetak/kartu_ujian/index/<?=$this->dataUjian->id_m_ujian;?>?jenis=excel" target="_blank" >
								<span class="btn btn-success text-right">
									<i class="fa fa-file-excel-o"></i> Export Excel Semua Siswa
								</span>
								</a>
								

							
							</div>
							</div>
							<br>
							<div class="row">
							<div class="col-md-6">
								<!--<span data-toggle="modal" data-target="#modal_tambah_siswa" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data Siswa</span>-->
								
								<?php
								if($this->hak_akses->btn_add($this->uri->segment('2'),'','')){?>
								
								
								
								
								<span onclick="hapus_siswa()" class="btn btn-danger">
									<i class="fa fa-trash"></i> Hapus Siswa
								</span>
								
								
								<?php
								}
								?>
							
							</div>
							</div>
							<br>
						</div>
						<div class="portlet-body">
							<?php if($this->session->notice){echo $this->session->notice;} ?>
							<!--<div class="table-scrollable">-->
								<form method="post" action="<?=$this->template_view->base_url_admin();?>/siswa/hapus_siswa" name="form_hapus_siswa" id="form_hapus_siswa">
									<input type="hidden" name="id_m_ujian" value="<?=$this->dataUjian->id_m_ujian;?>"/>
								<table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_2">
									<thead>
										<tr>
											<th scope="col">No <br>
											            <input type="checkbox" id="selectAll" /> 
											</th>
											<th scope="col">NIPD</th>
											<th scope="col">Nama Siswa</th>
											<th scope="col">Kelas</th>
											<th scope="col">Password</th>
											<th scope="col"></th>
										</tr>
									</thead>
									<tbody>
										<?php
										$no 	= $this->input->get('per_page')+ 1;
										foreach($this->showData as $data){
										?>
										<tr>
											<td align='center'><?=$no;?>.<br>
											<input type="checkbox" name="id_m_siswa_paket_ujian[]" value="<?=$data->id_m_siswa_paket_ujian;?>"/>
											</td>
											<td><?=$data->nipd;?> </td>
											<td><?=$data->nama;?> </td>
											<td><?=$data->kelas;?> </td>
											<td><?=$data->password;?> </td>
											<td align="center">
												<a href="<?=$this->template_view->base_url_admin();?>/cetak/kartu_ujian_satu/index/<?=$data->id_m_ujian;?>/<?=$data->id_m_siswa_paket_ujian;?>" target="_blank">
												<span class="btn btn-primary text-right">
													<i class="fa fa-print"></i> Cetak Kartu Ujian
												</span>
												</a>
												<?php
												if($this->session->userdata('id_kategori_user') == '1'){
												?>
													<!--
													<span class="btn btn-danger text-right"  onclick="show_confirmation_modal('<p>Apakah anda yakin akan Mereset Semua Jawaban dari Hasil Pengerjaan Siswa : <?=$data->nama;?> ..?</p>','<?=$this->template_view->base_url_admin();?>/<?=$this->uri->segment('2');?>/reset/<?=$data->id_m_siswa_paket_ujian;?>')">
														<i class="fa fa-cancel"></i> Reset Jawaban
													</span>
													-->
													<span class="btn btn-danger text-right"  onclick="show_reset_jawaban('<?=$data->id_m_siswa_paket_ujian;?>')">
														<i class="fa fa-cancel"></i> Reset Jawaban
													</span>
													
												<?php
												}
												?>
												
												
												<?php
												if($this->hak_akses->btn_add($this->uri->segment('2'),'','')){?>
												
													<span class="btn btn-warning text-right"  onclick="show_reset_device('<?=$data->id_m_siswa_paket_ujian;?>')">
														<i class="fa fa-cancel"></i> Reset Device
													</span>
													
												
												<?php
												}
												?>
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
							<span type="submit" class="btn btn-primary" id="btnSubmit"><i class="fa fa-save"></i> Simpan</span>
						</div>
					</div>
				</form>
				
			</div>
		</div>

	</div>
</div>



<div id="modal_hapus_siswa" class="modal fade" role="dialog">
	<div class="modal-dialog">

	<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">			
				<h4 class="modal-title">Pesan Konfirmasi</h4>
			</div>
			<div class="modal-body">
				
				Apakah anda yakin akan menghapus Siswa terpilih ..?
				
			</div>
			<div class="modal-footer">
				<div class="pull-left">
					<span class="btn btn-warning" data-dismiss="modal">Tidak</span >
				</div>
					<span class="btn btn-primary" onclick="hapus_siswa_ya()">Ya</span>
			</div>
		</div>

	</div>
</div>

<div id="modal_reset_device" class="modal fade" role="dialog">
	<div class="modal-dialog">

	<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">			
				<h4 class="modal-title">Form Reset Device</h4>
			</div>
			<div class="modal-body" id="div_modal_reset_device">
				
				
				
			</div>
		</div>

	</div>
</div>

<div id="modal_reset_jawaban" class="modal fade" role="dialog">
	<div class="modal-dialog">

	<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">			
				<h4 class="modal-title">Form Reset Jawaban</h4>
			</div>
			<div class="modal-body" id="div_modal_reset_jawaban">
				
				
				
			</div>
		</div>

	</div>
</div>

<script>
	function show_reset_device(id_m_siswa_paket_ujian){
		var formAction = "<?=$this->template_view->base_url_admin();?>/siswa/get_reset_device/<?=$this->dataUjian->id_m_ujian;?>/"+id_m_siswa_paket_ujian;
		$.ajax({
			url: formAction,
			type:'POST',
			dataType:'html',
			data: $('#form_detail_mapel').serialize(),
			success: function(data){
				$('#div_modal_reset_device').html(data);
				$('#modal_reset_device').modal('show');
			}
		})		
	}
	
	function show_reset_jawaban(id_m_siswa_paket_ujian){
		var formAction = "<?=$this->template_view->base_url_admin();?>/siswa/get_reset_jawaban/<?=$this->dataUjian->id_m_ujian;?>/"+id_m_siswa_paket_ujian;
		$.ajax({
			url: formAction,
			type:'POST',
			dataType:'html',
			data: $('#form_detail_mapel').serialize(),
			success: function(data){
				$('#div_modal_reset_jawaban').html(data);
				$('#modal_reset_jawaban').modal('show');
			}
		})		
	}
	
	$('#selectAll').click(function(e){
		var table= $(e.target).closest('table');
		$('td input:checkbox',table).prop('checked',this.checked);
	});
	
	function hapus_siswa(){
		
		var checkedNum = $('input[name="id_m_siswa_paket_ujian[]"]:checked').length;
		if (!checkedNum) {
			alert('Silahkan pilih dahulu Siswa yang akan dihapus.');
		}
		else{
			$("#modal_hapus_siswa").modal('show'); 
		}
		
	}
	
	function hapus_siswa_ya(){
		$("#form_hapus_siswa").submit();
	}
</script>
