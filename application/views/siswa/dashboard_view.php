 <div class="page-content">
	<div class="container">

		<div class="page-content-inner">
			<div class="row">
				<div class="col-md-12">

					<!-- BEGIN Portlet PORTLET-->
					<div class="portlet light" style="margin-top:10px;">
						<div class="portlet-body">
						
							<div class="row">	
								
								<div class="col-md-12">
								<div class="panel panel-default">
								<div class="panel-body" style="font-size:14px;">
								<b>Selamat datang di Ujian Berbasis Komputer.</b> <br>Berikut adalah Petunjuk Pengerjaan :<br><br>
								<ol >
									   <li style="margin-left:-25px"> Kerjakan soal-soal berikut dengan kemampuan anda, dilarang membuka buku atau catatan, menyontek, atau bekerjasama dengan peserta lain.</li>
										<li style="margin-left:-25px">Gunakan kertas buram yang telah disediakan, apabila diperlukan untuk membantu perhitungan.</li>
										<li style="margin-left:-25px">Pilihlah salah satu jawaban yang Anda anggap paling benar atau paling tepat. </li>
										<li style="margin-left:-25px">Anda dapat mengerjakan soal-soal yang anda anggap lebih mudah dahulu. Gunakan tombol "back" atau "panah kiri pada keyboard" untuk menuju soal sebelumnya,"next" atau "panah kanan pada keyboard" menuju soal berikutnya.</li>
										<li style="margin-left:-25px">Apabila Anda telah selesai mengerjakan seluruh butir soal dan yakin untuk mengakhiri tes, tekan "SELESAI".</li>
										<li style="margin-left:-25px">Perhatikan sisa waktu yang tersedia di bagian kanan atas.</li>
										<li style="margin-left:-25px">Pilih soal dibawah.</li>
								</ol>
								<b>Selamat Mengerjakan.</b>
								</div>
								</div>
								</div>
							</div>
						
							<div class="row">
								<!--<div class="col-md-3 text-center">
									<img src="<?=base_url();?>assets/images/siswa.png" width="200px"><hr>
									<u class="font-blue bold"><h4><?=$this->session->userdata('nm_siswa');?></h4></u>								
									<h5>NIPD : <?=$this->session->userdata('nipd');?></h5>							
									<h5>Kelas : <?=$this->session->userdata('kelas');?></h5>
									</br>
								</div>-->
								
								<div class="col-md-12">
									<!--<div class="alert alert-success">Selamat Datang di Sistem Informasi Ujian Berbasis Komputer Sahabat Siswa (SASIS)</div>-->
									<p>Berikut adalah daftar Mata Pelajaran di Ujian 
										<b><?=$this->dataUjian->nm_ujian;?></b> yang dapat Anda ikuti :</p><hr>
									
							
											
									
									
									<div class="timeline">
									<?=$this->htmlMapelUjian ;?>
								
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


