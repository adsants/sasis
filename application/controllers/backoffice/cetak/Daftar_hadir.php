<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Daftar_hadir extends CI_Controller {	

	public function __construct() {
		parent::__construct();
		
		/// library otomatis untuk Hak Akses
		$this->load->library('session_lib');
		$this->load->library('text_html');
		$this->load->library('encrypt_decrypt');
		$this->session_lib->admin();
		
		$this->load->model('m_ujian_model');
		$this->load->model('m_siswa_paket_ujian_model');
	} 

	public function index($id_m_ujian,$id_ujian_maple){		
		
		
		
		//$this->load->helper('pdf_helper');
		
		if(!$id_ujian_maple){
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}
		
		$this->load->model('m_ujian_mapel_model');
		$this->load->model('detail_siswa_paket_ujian_model');
		$this->load->model('soal_siswa_model');
		$this->load->model('m_jawaban_model');
		
		$this->dataMapelUjian 	= $this->m_ujian_mapel_model->getData(array("m_ujian_mapel.id_m_ujian_mapel" => $id_ujian_maple));
		
		if(!$this->dataMapelUjian){
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}
			
			
		
		
		//var_dump($this->dataSiswa);
		
		echo "<title>Cetak Daftar Hadir</title>";
		
		$this->tableHtml = '<link href="'.base_url().'assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		';
		$this->tableHtml .= '
		<script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>		
		<link rel="stylesheet" href="https://printjs-4de6.kxcdn.com/print.min.css" type="text/css">
		';
		
		$this->tableHtml .= '
		<style>
		.borderless td, .borderless th {
			border: none;
		}
		</style>
		';
		
		
		$this->load->model('profil_aplikasi_model');	
		$this->dataProfil = $this->profil_aplikasi_model->getData();
		
		$this->tableHtml .= '
		
		<table width="100%" border="0" class="table table-bordered">
			<tr valign="center">
				<td width="30%" align="center">
					<img src="'.base_url().'upload/logo/'.$this->dataProfil->icon.'" width="300px">
				</td>
				<td width="70%">
					<table width="100%" border="0" classs="borderless">
						<tr valign="bottom">
							<td align="center">
								<br>
								<center>
								<h3>'.$this->dataProfil->nm_aplikasi.'</h3>
								<h4>'.$this->dataProfil->alamat.'</h4>
								<h4>'.$this->dataProfil->telp.'</h4>
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
					<h4>Daftar Hadir Ujian : '.$this->dataMapelUjian->nm_ujian.'</h4>
					<h4>Mata Pelajaran : '.$this->dataMapelUjian->nm_mata_pelajaran.'</h4>
				</td>
			</tr>
		</table>
		
		';
		
		if($this->input->get('kelas')!=''){
			$this->siswaKelas	=	$this->m_siswa_paket_ujian_model->showData(array('m_siswa_paket_ujian.id_m_ujian' => $id_m_ujian ,'m_siswa_paket_ujian.kelas' => $this->input->get('kelas')));
		}
		else{
			$this->siswaKelas	=	$this->m_siswa_paket_ujian_model->showData(array('m_siswa_paket_ujian.id_m_ujian' => $id_m_ujian));
		}
		
		$this->tableHtml .= '
		
		<table width="100%" border="0" class="table table-bordered">
			<tr valign="center">
				<th>No</th>
				<th>NIPD</th>
				<th>Nama</th>
				<th>Kelas</th>
				<th>Tanda Tangan</th>
			</tr>
				';
		$i=1;
		foreach($this->siswaKelas as  $siswa){
			$this->tableHtml .= '
			<tr valign="center">
				<td width="5%">'.$i.'.</td>
				<td width="15%">'.$siswa->nipd.'</td>
				<td width="45%">'.$siswa->nama.'</td>
				<td width="15%">'.$siswa->kelas.'</td>
				<td></th>
			</tr>
				';
		$i++;
		}
		$this->tableHtml .= '</table>
				';
		$this->tableHtml .= '<br><br>Powered By www.sahabat-siswa.com';
		
		
		echo $this->tableHtml;
		echo "
		
		<script>
		window.print();
		</script>
		
		";
	//	$mpdf = new \Mpdf\Mpdf();
		
	//	$mpdf->SetTitle('Hasil Ujian');
	//	$mpdf->WriteHTML($this->tableHtml );
	//	$mpdf->Output('Hasil Ujian '.$this->dataSiswa->nm_ujian.' - '.$this->dataSiswa->nis.'.pdf', 'I');     
		//$payStub->Output('yourFileName.pdf', 'I');
	
		
	}
	
}
	
	
	
