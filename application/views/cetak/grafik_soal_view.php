 <style>
@font-face {
	font-family: 'Open Sans';
	font-style: normal;
	font-weight: 300;
	src: local('Open Sans Regular'), local('OpenSans-Regular'), url(<?=base_url();?>assets/fonts/OpenSans-Regular.ttf) format('truetype');
}
</style>
<link href="<?=base_url();?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="<?=base_url();?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
<link href="<?=base_url();?>assets/global/plugins/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />

<table width="100%" border="0" class="table table-bordered">
			<tr valign="top">
				<td width="30%" align="center">
					<img src="<?=base_url();?>upload/logo/<?=$this->dataProfil->icon;?>" width="300px">
				</td>
				<td width="70%">
					<table width="100%" border="0" classs="borderless">
						<tr valign="bottom">
							<td align="center">
								<br>
								<center>
								<h3><?=$this->dataProfil->nm_aplikasi?></h3>
								<h4><?=$this->dataProfil->alamat?></h4>
								<h4><?=$this->dataProfil->telp?></h4>
								</center>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<table width="100%" border="0" class="table">
			<tr valign="top">
				<td align="center">
					<h4>Laporan Grafik Soal</h4>
					<h4>Ujian : <?=$this->dataMapelUjian->nm_ujian;?></h4>
					<h4>Mata Pelajaran : <?=$this->dataMapelUjian->nm_mata_pelajaran;?></h4>
				</td>
			</tr>
		</table>
		

		
			<table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_2">
				<thead>
					<tr>
						<th scope="col">Soal</th>
						<th scope="col" width="10%">Diujikan</th>
						<th scope="col" width="10%">Benar</th>
						<th scope="col" width="10%">Salah</th>
						<th scope="col" width="10%">Tidak Dijawab</th>
					</tr>
				</thead>
				<tbody>
				<?php	
					echo $this->tableHtml;
				?>
				</tbody>
			</table>
				


<script>
	window.print();
	
</script>