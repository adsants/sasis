 <div class="page-content">
	<div class="container">

		<div class="page-content-inner">
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light" style="margin-top:10px;">
						<div class="caption">
							<i class="fa fa-history font-blue-sharp"></i>
							<span class="caption-subject font-blue-sharp bold">Daftar Riwayat Ujian</span>
						</div>
					</div>
					<!-- BEGIN Portlet PORTLET-->
					<div class="portlet light">
						<div class="portlet-body">
							<div class="row">
								<div class="table-scrollable">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th scope="col" width="5%">No</th>
											<th scope="col">Mata Pelajaran</th>
											<th scope="col">Tgl Pengerjaan</th>
											<th scope="col" ></th>
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
												<td><?=$this->template_view->waktu_pengerjaan_ujian($data->id_detail_siswa_paket_ujian);?>
											</td>
											<td align='center'>											
												<a href="<?=$this->template_view->base_url_siswa();?>/riwayat_ujian/detail/?id_detail_siswa_paket_ujian=<?=$data->id_detail_siswa_paket_ujian;?>&id_m_ujian_mapel=<?=$data->id_m_ujian_mapel;?>"><span class="btn btn-success"><i class="fa fa-eye"></i> Detail Ujian</span></a>
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
							</div>
						</div>
					</div>
					<!-- END Portlet PORTLET-->
				</div>
			</div>
		</div>
	</div>
</div>


