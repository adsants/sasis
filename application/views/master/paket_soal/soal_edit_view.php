 <div class="page-content">
	<div class="contasiner">

		<div class="page-content-inner">
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light">
						<div class="caption">
							<i class="fa fa-edit font-blue-sharp"></i>
							<span class="caption-subject font-blue-sharp bold">Ubah Data Bank Soal</span>
						</div>
					</div>

					<!-- BEGIN Portlet PORTLET-->
					<div class="portlet light">
						<div class="portlet-body">
							
							<?php if($this->session->notice){echo $this->session->notice;} ?>
							<form class="form-horizontal" method="post" action="<?=$this->template_view->base_url_admin();?>/<?=$this->uri->segment('2')?>/update_soal/<?=$this->dataForUpdate->id_m_paket_soal;?>/?id_m_soal=<?=$this->input->get('id_m_soal');?>" enctype="multipart/form-data">
						
								
								<div class="form-group">
									
									<label class="control-label col-sm-2" >Jenis Soal :</label>
									<div class="col-sm-2">
								
										<select class="form-control select2" readonly required name="jenis_soal" onchange="change_jenis_soal()" id="jenis_soal">
												<option value=""></option>
												<option <?php if($this->dataForUpdate->jenis_soal =='G') echo "selected";?> value="G">Pilihan Ganda</option>
												<option <?php if($this->dataForUpdate->jenis_soal =='E') echo "selected";?> value="E">Uraian</option>			
										</select>
										
									</div>
									<label class="control-label col-sm-2" >Kategori Soal :</label>
									<div class="col-sm-2">
										<select class="form-control select2" required name="kategori_soal" id="kategori_soal" >
												<option value=""></option>
												<option <?php if($this->dataForUpdate->kategori_soal=='MD') echo "selected";?> value="MD">Mudah</option>			
												<option <?php if($this->dataForUpdate->kategori_soal=='SD') echo "selected";?> value="SD">Sedang</option>			
												<option <?php if($this->dataForUpdate->kategori_soal=='SL') echo "selected";?> value="SL">Sulit</option>				
										</select>
									
									</div>
								</div>
								
								<div class="form-group">
									<label class="control-label col-sm-2" >Jumlah Jawaban :</label>
									<div class="col-sm-2">
										<select class="form-control select2" disabled required name="jml_jawaban" id="jml_jawaban" >
												<option value=""></option>
												<option <?php if($this->dataForUpdate->jml_jawaban=='0') echo "selected";?> value="0">0</option>			
												<option <?php if($this->dataForUpdate->jml_jawaban=='3') echo "selected";?> value="3">3</option>			
												<option <?php if($this->dataForUpdate->jml_jawaban=='4') echo "selected";?> value="4">4</option>			
												<option <?php if($this->dataForUpdate->jml_jawaban=='5') echo "selected";?> value="5">5</option>			
										</select>
									
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2" >Soal :</label>
									<div class="col-sm-9">
									<textarea class="ckeditor" required name="soal"><?=$this->dataForUpdate->soal;?></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2" >File Soal :</label>
									<div class="col-sm-10">
										<input type="file" class="from-control" name="file_soal">
										<sup style="color:red"> * max = 10 MB</sup>
									</div>
								</div>
								
								
								
								<?php
								if($this->dataForUpdate->file_soal != ''){
									
								?>
								<div class="form-group">
								<div class="col-sm-10 col-sm-offset-2">
									<?php
									if($this->dataForUpdate->type_file_soal == 'mpeg' || $this->dataForUpdate->type_file_soal == 'mp3'){
										echo '
										<audio controls id="file_soal">
											<source src="data:video/mpeg;base64,'.$this->dataForUpdate->file_soal.'" type="audio/mpeg">
											Your browser does not support the audio element.
										</audio>
										';
									}
									else{
										echo '
										<video width="450" height="250" controls id="file_soal">
											<source src="data:video/mp4;base64,'.$this->dataForUpdate->file_soal.'" type="video/mp4">
											Your browser does not support the video tag.
										</video> 
										
										';
									}
									?>
								<br>
								<br>
								<label>
									<input type="checkbox" id="tanpa_file" name="tanpa_file" value="Y"> Hapus FIle
								</label>
								</div>
								</div>
								<?php
								}
								?>
								
								<?php
								
								if($this->dataForUpdate->jenis_soal =='G'){
								echo "<hr>";
								foreach($this->dataJawaban as  $jawaban){
								?>
										<div class="form-group" id="div_jawaban_" style="display:">
											<label class="control-label col-sm-2" >Jawaban :</label>
											<div class="col-sm-8" >
												<textarea class="ckeditor" id="input_jawaban_" name="jawaban[<?=$jawaban->id_m_jawaban;?>][<?=$jawaban->id_m_jawaban;?>]"><?=$jawaban->jawaban;?></textarea>
											</div>									
											<div class="col-sm-2">
												<label class="mt-radio mt-radio-outline">
													<input type="radio" name="status" <?php if($jawaban->status == 'B') echo "checked"; ?> value="<?=$jawaban->id_m_jawaban;?>"> 
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
									<span onclick="location.href='<?=$this->template_view->base_url_admin();?>/<?=$this->uri->segment('2');?>/soal?id_m_paket_soal=<?=$this->dataForUpdate->id_m_paket_soal;?>'" class="btn btn-warning"><i class="fa fa-close"></i> Batal</span>
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
		//alert($('#jenis_soal').val());
		if($('#jenis_soal').val() == 'G'){			
			$('#jml_jawaban').val('')			
			$('#jml_jawaban').focus();					
			$('#jml_jawaban').attr('disabled', false)
			
		}
		else{
			$('#jml_jawaban').val('0')
			$('#jml_jawaban').attr('disabled', true)			
			
		}
	}
	

	
		$('#tanpa_file').click(function(){
			if ($('#tanpa_file').is(':checked')) {
				$('#file_soal').hide();
			}
			else{
				$('#file_soal').show();
				
			}
		})
</script>
