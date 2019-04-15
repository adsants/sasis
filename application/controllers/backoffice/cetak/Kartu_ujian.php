<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kartu_ujian extends CI_Controller {	

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

	public function index($id_m_ujian){		
		/// cek Hak Akses (security)
		$this->hak_akses->cek_edit($this->uri->segment(2));
			
		if(!$id_m_ujian){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}			
		
		$this->dataUjian	=	$this->m_ujian_model->getData($id_m_ujian);
		
		
		if($this->input->get('jenis') == 'excel'){
			$this->load->model('m_ujian_mapel_model');
			
			$this->dataUjian 	= $this->m_ujian_model->getData($id_m_ujian );
			
			//var_dump($this->db->last_query());exit();
			
			if(!$this->dataUjian){
				redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
			}
			
				$orderBy = "m_siswa_paket_ujian.kelas";
			
			
			$filename = "Kartu Ujian - ".$this->dataUjian->nm_ujian.".xls"; // File Name
			// Download file
			header("Content-Disposition: attachment; filename=\"$filename\"");
			header("Content-Type: application/vnd.ms-excel");
			
			$this->dataSiswa = $this->m_siswa_paket_ujian_model->showData(array('id_m_ujian' => $id_m_ujian),"",$orderBy);
			$this->tableHtml	=	"<style> .str{ mso-number-format:\@; } </style>";
			$this->tableHtml .= '
			<table class="table table-striped table-bordered table-hover" style="border:border-collapse" border="1">
				<thead>
					<tr>
						<th scope="col">No</th>
						<th scope="col">NIPD</th>
						<th scope="col">Nama Siswa</th>
						<th scope="col">Kelas</th>
						<th scope="col">Password</th>
			';
			$no	=	1;
			foreach($this->dataSiswa as $dataSiswa){
					$this->tableHtml .= '		
											<tr>
												<td align="center">'.$no.'</td>
												<td>'.$dataSiswa->nipd.'</td>
												<td>'.$dataSiswa->nama.'</td>
												<td>'.$dataSiswa->kelas.'</td>
												<td  class="str">'.$dataSiswa->password.'</td>
											';
						$no++;					
			}
			$this->tableHtml .= '	</tbody>
								</table>';
								
			
			echo $this->tableHtml;					
		}
		
		if($this->input->get('jenis') == 'word'){
			$this->siswaKelas	=	$this->m_siswa_paket_ujian_model->showData(array('m_siswa_paket_ujian.id_m_ujian' => $id_m_ujian));
			
			$this->load->model('profil_aplikasi_model');	
			$this->dataProfilAplikasi = $this->profil_aplikasi_model->getData();
		
			$this->load->view('cetak/kartu_ujian_view');
		
		}
		
	}
	
}
	
	
	
