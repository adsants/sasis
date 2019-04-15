 <div class="page-content">
	<div class="container">

		<div class="page-content-inner">
			<div class="row">
				<div class="col-md-12">

					<!-- BEGIN Portlet PORTLET-->
					<div class="portlet light">
						<div class="portlet-body">
							<div class="row">
								
								<div class="col-md-12">
									<?php if($this->session->notice){echo $this->session->notice;} ?>
								</div>
								<div class="col-md-8">
									<div class="portlet box blue">
										<div class="portlet-title">
											<div class="caption">
												Data Detail Ujian
											</div>
											
										</div>
										<div class="portlet-body">
											<form class="form-horizontal" role="form" style="font-size:16px;">
												<div class="form-group">
													<label class="control-label col-sm-4" >Ujian :</label>
													<div class="control-label col-sm-8" style="text-align:left">
														<b><?=$this->dataUjian->nm_ujian;?></b>
													</div>
												</div>
												
												<div class="form-group">
													<label class="control-label col-sm-4" >Mata Pelajaran :</label>
													<div class="control-label col-sm-8" style="text-align:left">
														<?=$this->dataUjianMapel->nm_mata_pelajaran;?>
													</div>
												</div>
												
												<div class="form-group">
													<label class="control-label col-sm-4" >Soal Pilihan Ganda :</label>
													<div class="control-label col-sm-8" style="text-align:left">
														<b><?=$this->dataUjianMapel->jml_soal_ganda;?></b> Butir 
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-4" >Soal Uraian :</label>
													<div class="control-label col-sm-8" style="text-align:left">
														<b><?=$this->dataUjianMapel->jml_soal_esay;?></b> Butir 
													</div>
												</div>
												
												<div class="form-group">
													<label class="control-label col-sm-4" >Waktu Pengerjaan :</label>
													<div class="control-label col-sm-8" style="text-align:left">
														<b><?=$this->dataUjianMapel->menit_pengerjaan;?></b> Menit 
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-4" >Tanggal Pengerjaan :</label>
													<div class="control-label col-sm-8" style="text-align:left">
														<b><?=$this->dataUjianMapel->tgl_pengerjaan_indo;?></b> 
													</div>
												</div>
												<div class="form-group">
												<label class="control-label col-sm-12" ><br></label>
												</div>
												<div class="form-group">
												<label class="control-label col-sm-4" ></label>
												<div class="col-sm-8">
													<a href="<?=$this->template_view->base_url_siswa();?>/dashboard"><span class="btn btn-primary"><i class="fa fa-backward"></i> Kembali</span></a>
												</div>
												</div>
											</form>
											
											</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="portlet box blue">
										<div class="portlet-title">
											<div class="caption">
												Form Token Ujian
											</div>
											
										</div>
										<div class="portlet-body">
											<br>
											<?php
											if($this->dataDetailSiswa->tgl_akhir_pengerjaan!=''){
											?>
											<div class="alert alert-warning text-justify">Anda telah mengerjakan Ujian pada tanggal <?=$this->dataDetailSiswa->tgl_akhir_pengerjaan_indo;?>. Untuk Data selengkapnya silahkan klik menu Data Riwayat Ujian.</div>
											<?php
											}
											else{
												
												
												$sekarang=date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')));
												$contractDateBegin = date('Y-m-d H:i:s', strtotime($this->dataUjianMapel->tgl_pengerjaan_indo));
												$contractDateEnd = date('Y-m-d H:i:s', strtotime($this->dataUjianMapel->tgl_akhir_pengerjaan_indo));
												
												if (($sekarang > $contractDateBegin) && ($sekarang < $contractDateEnd)){
													
													
													if($this->session->userdata('ujian_'.$this->dataUjianMapel->id_m_ujian_mapel) == $this->dataUjianMapel->id_m_ujian_mapel){
												?>		
														<div class="alert alert-warning">Klik Tombol Mulai untuk memulai Pengerjaan Ujian. Bersamaan dengan itu, maka proses Waktu pengerjaan akan dimulai. </div>
														
														<span onclick="location.href='<?=$this->template_view->base_url_siswa();?>/ujian/mulai/<?=$this->dataUjian->id_m_ujian;?>/<?=$this->dataUjianMapel->id_m_ujian_mapel;?>'" class="btn btn-danger btn-lg btn-block">Mulai</span></a>
														
												<?php
													}
													else{
												?>
														<form class="form-horizontal" method="post" action="<?=$this->template_view->base_url_siswa();?>/ujian/authentication/<?=$this->dataUjian->id_m_ujian;?>/<?=$this->dataUjianMapel->id_m_ujian_mapel;?>" role="form">
																							
															<div class="form-group">
																<div class="col-md-12">
																	<div class="input-group">
																		<span class="input-group-addon">
																			<i class="fa fa-lock"></i>
																		</span>
																		<input type="number" name="token" required oninvalid="this.setCustomValidity('Inputkan Token Ujian')"  autocomplete="false"  oninput="setCustomValidity('')" class="form-control" placeholder="Token"> 
																	</div>
																</div>
															</div>
															
																<div class="form-group">
																	<div class="col-md-12">
																		<button type="submit" class="btn btn-success">Login</button>
																	</div>
																</div>
														</form>
												<?php
													}
												}
												else{
													echo '<div class="alert alert-warning">From Token Ujian akan muncul disaat Tanggal Pengerjaan.</div>';
												?>
												
											<?php
												}
											}
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- END Portlet PORTLET-->
				</div>
			</div>
		</div>
	</div>
</div>
