
<style>
@page {
     margin: 20px 10px;
    }
tr td{
	font-family:Arial, Helvetica, sans-serif;
}
.kta{
	width:85mm;
	height:60mm;
	border:1px solid #333;
	float:left;
	margin-left:20px;
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
foreach($this->siswaKelas as $dataSiswa){
?>
<div class="kta">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2"><div style="height:8px;"></div></td>
    </tr>
  <tr>
    <td width="23%" align="center">
		<img src="<?=base_url();?>upload/logo/<?=$this->dataProfilAplikasi->icon;?>" width="70px" alt="logo" class="logo-default">
	</td>
    <td width="77%" align="center">
	<div style="font-size:12px; font-weight:bold;">
			
		
		<?=$this->dataProfilAplikasi->nm_aplikasi;?><br>
	
		<?=$this->dataProfilAplikasi->alamat;?><br>
		<?=$this->dataProfilAplikasi->telp;?><br>  
			
	
	</div>	 
	</td>
  </tr>
	<tr>
    <td colspan="5">
		<hr>
	</td>
	</tr>
	<tr>
    <td colspan="5" align="center">
	<div style="font-size:11px; font-weight:bold;">
		Kartu Peserta Ujian <br> <?=$this->dataUjian->nm_ujian;?>
	</div>
	</td>
	</tr>
	<tr>
    <td colspan="5">
		<hr>
	</td>
	</tr>
  <tr>
    <td colspan="2"><table class="identiti" width="100%" border="0" cellspacing="0" cellpadding="0">
    
      <tr>
        <td width="6%">&nbsp;</td>
        <td width="25%" align="right">NIPD</td>
        <td width="6%" align="center">:</td>
        <td><?=$dataSiswa->nipd;?></td>
      </tr>
	   <tr >
        <td >&nbsp;</td>
        <td valign=top  align="right">Nama</td>
        <td valign=top align="center">:</td>
        <td valign=top ><?=$dataSiswa->nama;?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td align="right">Kelas</td>
        <td align="center">:</td>
        <td><?=$dataSiswa->kelas;?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td align="right">Password </td>
        <td align="center">:</td>
        <td><?=$dataSiswa->password;?></td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
        </tr>
    </table></td>
    </tr>
</table>

</div>
<?php if($break%8==0){ echo "<div style='page-break-after:always'></div>";} $break++; } ?>

