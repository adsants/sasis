
<style>
tr td{
	font-family:Arial, Helvetica, sans-serif;
}
.kta{
	width:85mm;
	height:55mm;
	border:1px solid #333;
	float:left;
	margin-right:20px;
	margin-bottom:20px;
}
.identiti tr td{
	font-size:11px;
	font-weight:bold;
	padding:3px;
}
</style>


<?php
$break = 1;
	
	
?>

<div class="kta">
<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>
		<td width="23%" align="center">
			<img src="<?=base_url();?>upload/logo/<?=$this->dataProfilAplikasi->icon;?>" width="70px" alt="logo" class="logo-default">
		</td>
		<td width="77%" align="center">
			<div style="font-size:14px; font-weight:bold;">
				<?=$this->dataProfilAplikasi->nm_aplikasi;?></br>
			</div>	 
				
			<div style="font-size:12px; font-weight:bold;">
				<?=$this->dataProfilAplikasi->alamat;?></br>
				<?=$this->dataProfilAplikasi->telp;?></br>  
			</div>	 
		</td>
	
	</tr>
	<tr>
		<td colspan="2"><hr></td>
	</tr>
	<tr>
	
		<td colspan="2">
		<table class="identiti" width="100%" border="0" cellspacing="0" cellpadding="0">
			
			<tr>
				<td colspan="4" align="center">Kartu Tanda Peserta Ujian<br><?=$this->dataUjian->nm_ujian;?><hr></td>
			</tr>
			
		</table>
		</td>
	
    </tr>
    <tr>
		<td colspan="2">
		<table class="identiti" width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="25%" align=center>
					
					<?php	echo "<image src='".base_url()."assets/images/logo1.png' width='70px'>"; ?>
					
					
				</td>
				<td width="75%">
				<table class="identiti" width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td>NIPD </td>
					<td>: </td>
					<td><?=$this->siswaKelas->nipd;?> </td>
				</tr>
				<tr valign="top">
					<td width="20%">Nama </td>
					<td width="5%">: </td>
					<td valign="top"><?=$this->siswaKelas->nama;?> </td>
				</tr>
				<tr valign="top">
					<td width="20%">Password </td>
					<td width="5%">: </td>
					<td valign="top"><?=$this->siswaKelas->password;?> </td>
				</tr>
				</table>
				</td>
			</tr>
			
		</table>
		</td>
    </tr>
</table>

</div>