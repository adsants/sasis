 

 <div class="page-content">
	<div class="constainer">

		<div class="page-content-inner">
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light">
						<div class="caption">
							<i class="fa fa-plus font-blue-sharp"></i>
							<span class="caption-subject font-blue-sharp bold">Tambah Data Bank Soal</span>
						</div>
					</div>

					<!-- BEGIN Portlet PORTLET-->
					<div class="portlet light">
						<div class="portlet-body">
							<?php if($this->session->notice){echo $this->session->notice;} ?>
							<div class="alert alert-warning" id="pesan_error" style="display:none"></div>
							<form class="form-horizontal" method="post" action="<?=$this->template_view->base_url_admin();?>/<?=$this->uri->segment('2');?>/insert_soal/?id_m_paket_soal=<?=$this->input->get('id_m_paket_soal');?>" enctype="multipart/form-data" id="form_zstandard">
								<div class="form-group">
									<label class="control-label col-sm-2" > Mata Pelajaran :</label>
									<div class="control-label col-sm-10" style="text-align:left">
										
										<?=$this->dataPaket->nm_mata_pelajaran;?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2" > Paket Soal :</label>
									<div class=" control-label col-sm-10 pull-left"  style="text-align:left">
										<?=$this->dataPaket->nm_paket_soal;?>
									</div>
								</div>
								
								<div class="form-group">
									<span id="div_urut_soal" style="display:<?php if(!$this->session->flashdata('urut_soal')) echo "none";?>">
										<label class="control-label col-sm-2" >Nomor Urut Soal :</label>
										<div class="col-sm-2">
											<input type="number" class="form-control" value="<?=$this->session->flashdata('urut_soal');?>" name="urut_soal" id="urut_soal">
										</div>
									</span>
								
									<label class="control-label col-sm-2" >Jenis Soal :</label>
									<div class="col-sm-2">
										<select class="form-control select2" required name="jenis_soal" id="jenis_soal" onchange="change_jenis_soal()">
												<option value=""></option>
												<option selected <?php if($this->session->flashdata('jenis_soal')=='G') echo "selected";?> value="G">Pilihan Ganda</option>
												<option <?php if($this->session->flashdata('jenis_soal')=='E') echo "selected";?> value="E">Uraian</option>			
										</select>
									</div>
									<label class="control-label col-sm-2" >Kategori Soal :</label>
									<div class="col-sm-2">
										<select class="form-control select2" required name="kategori_soal" id="kategori_soal" >
												<option value=""></option>
												<option <?php if($this->session->flashdata('kategori_soal')=='MD') echo "selected";?> value="MD">Mudah</option>			
												<option <?php if($this->session->flashdata('kategori_soal')=='SD') echo "selected";?> value="SD">Sedang</option>			
												<option <?php if($this->session->flashdata('kategori_soal')=='SL') echo "selected";?> value="SL">Sulit</option>				
										</select>
									
									</div>
								</div>
								
								<div class="form-group">
									<label class="control-label col-sm-2" >Jumlah Jawaban :</label>
									<div class="col-sm-2">					
										<!--
										<input type="number" class="form-control" value="<?=$this->session->flashdata('jml_jawaban');?>" <?php if($this->session->flashdata('jenis_soal') =='E') echo "readonly";?> max="5" required name="jml_jawaban" id="jml_jawaban">
										-->
										<select class="form-control select2" name="jml_jawaban" id="jml_jawaban" onchange="change_jml_jawaban()">
												<option <?php if($this->session->flashdata('jml_jawaban')=='0') echo "selected";?> value="0">0</option>			
												<option <?php if($this->session->flashdata('jml_jawaban')=='3') echo "selected";?> value="3">3</option>			
												<option <?php if($this->session->flashdata('jml_jawaban')=='4') echo "selected";?> value="4">4</option>			
												<option <?php if($this->session->flashdata('jml_jawaban')=='5') echo "selected";?> value="5">5</option>			
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2" >Soal :</label>
									<div class="col-sm-10">
									<textarea class="ckeditor" required name="soal"><?=$this->session->flashdata('soal')?></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2" >File Soal :</label>
									<div class="col-sm-5">
										<input type="file" class="from-control" name="file_soal">
									</div>
								</div>
								<hr>
								<?php
								if($this->session->flashdata('jml_jawaban')){
									$i=1;
									foreach($this->session->flashdata('jawaban') as $urutJawaban  =>  $jawaban){
										if($jawaban[$urutJawaban]){
								?>
										<div class="form-group" id="div_jawaban_<?=$i;?>" style="display:">
											<label class="control-label col-sm-2" >Jawaban :</label>
											<div class="col-sm-8" >
												<textarea class="ckeditor" id="input_jawaban_<?=$i;?>" name="jawaban[<?=$i;?>][<?=$i;?>]"><?=$jawaban[$urutJawaban];?></textarea>
											</div>									
											<div class="col-sm-2">
												<label class="mt-radio mt-radio-outline">
													<input type="radio" name="status"  value="<?=$i;?>"> 
													Jawaban Benar
													<span></span>
												</label>								
											</div>
										</div>
								<?php
										$i++;
										}
									}
								}
								else{
									for($i=1;$i<6;$i++){
								?>
									<div class="form-group" id="div_jawaban_<?=$i;?>" style="display:none">
										<label class="control-label col-sm-2" >Jawaban :</label>
										<div class="col-sm-8" >
											<textarea class="ckeditor" id="input_jawaban_<?=$i;?>" name="jawaban[<?=$i;?>][<?=$i;?>]"></textarea>
										</div>									
										<div class="col-sm-2">
											<label class="mt-radio mt-radio-outline">
												<input type="radio" name="status"  value="<?=$i;?>"> 
												Jawaban Benar
												<span></span>
											</label>								
										</div>
									</div>
								<?php
									}
								}
								?>
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-9">
									<span onclick="location.href='<?=$this->template_view->base_url_admin();?>/<?=$this->uri->segment('2');?>/?<?=$_SERVER['QUERY_STRING'];?>'" class="btn btn-warning"><i class="fa fa-close"></i> Batal</span>
									<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
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

	
	
	function change_jenis_soal(){
		if($('#jenis_soal').val() == 'G'){			
			$('#jml_jawaban').val('')
			
			$('#jml_jawaban').focus();	
			$('#jml_jawaban').prop('readonly', false);	
			$('#jml_jawaban').attr('disabled', false)
			$('#jml_jawaban').attr('required', false)
			
		}
		else{
			$('#jml_jawaban').val(0).change();	
			$('#jml_jawaban').prop('readonly', true);
			$('#jml_jawaban').attr('disabled', true)			
			for (i = 1; i < 6; i++) { 
				$('#div_jawaban_'+i).hide();
			}
		}
	}
	
	
	function change_jml_jawaban(){
		var jumlah_jawaban = $('#jml_jawaban').val();
		//alert(jumlah_jawaban);
		jumlah_jawaban = parseInt(jumlah_jawaban) + 1;
		for (i = 1; i < jumlah_jawaban; i++) { 
			$('#div_jawaban_'+i).show();
		}		
	}
</script>
