<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Koreksi extends CI_Controller {	

	public function __construct() {
		parent::__construct();
		
		/// library otomatis untuk Hak Akses
		$this->load->library('session_lib');
		$this->load->library('text_html');
		$this->load->library('encrypt_decrypt');
		$this->session_lib->admin();
		
		$this->load->model('m_ujian_model');
	} 

	public function index(){		
		/// cek Hak Akses (security)
		$this->hak_akses->cek_menu($this->uri->segment(2));
		
		$like 		= null;
		$urlSearch 	= null;
		$order_by	=	"nm_ujian";

		if($this->input->get('search')){
			$urlSearch 	= 	"?search=".$_GET['search'];
			$like		=	$this->input->get('search');			
		}

		$config['base_url'] 	= base_url().'backoffice/'.$this->uri->segment(2).'/index'.$urlSearch;
		
		$this->jumlahData 		= $this->m_ujian_model->showData("",$like);
		$config['total_rows'] 	= count($this->jumlahData);
		$config['per_page'] 	= 10;
		
		$this->showData 		= $this->m_ujian_model->showData("",$like,$order_by,$config['per_page'],$this->input->get('per_page'));
		$this->pagination->initialize($config);		
		
		$this->template_view->load_admin_view('master/koreksi/koreksi_view');
	}
	
	public function detail($idUjian){		
		
		if(!$idUjian){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}						
		
		$this->dataUjian 	= $this->m_ujian_model->getData($idUjian);		
		if(!$this->dataUjian){
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));	
		}	
		
		$this->load->model('m_ujian_mapel_model');
		$this->load->model('detail_siswa_paket_ujian_model');
		
		$this->ShowDataMapelUjian 	= $this->m_ujian_mapel_model->showData(array("m_ujian_mapel.id_m_ujian" => $idUjian, 'm_ujian_mapel.jml_soal_esay > 0' => null  ));
		
		
		if($this->input->get('id_m_ujian_mapel')){
			
			$this->dataMapelUjian 	= $this->m_ujian_mapel_model->getData(array("m_ujian_mapel.id_m_ujian_mapel" => $this->input->get('id_m_ujian_mapel')));
			
			if($this->input->get('order_by')){
				if($this->input->get('order_by') == 'detail_siswa_paket_ujian.nilai'){
					
					$orderBy = $this->input->get('order_by')." desc";
				}
				else{
					
					$orderBy = $this->input->get('order_by')." asc";
				}
			}
			else{
				$orderBy = "m_siswa_paket_ujian.nama";
			}
			
			$this->dataSiswa = $this->detail_siswa_paket_ujian_model->showDataForLaporan(array('detail_siswa_paket_ujian.id_m_ujian_mapel' => $this->input->get('id_m_ujian_mapel')),"",$orderBy);
			
			
			
		}
		
		$this->template_view->load_admin_view('master/koreksi/koreksi_detail_view');
	}
	
	public function ambil_soal($id_detail_siswa_paket_ujian){
		if(!$id_detail_siswa_paket_ujian){			
			echo "Maaf .. pengambilan Data Gagal. Silahkan Reload Halaman Ini.";
		}
		
		
		$this->load->model('soal_siswa_model');
		$this->load->model('detail_siswa_paket_ujian_model');
		$this->load->model('t_paket_soal_ujian_model');
		
		$this->dataSiswa = $this->detail_siswa_paket_ujian_model->getData(array('detail_siswa_paket_ujian.id_detail_siswa_paket_ujian' => $id_detail_siswa_paket_ujian, 'detail_siswa_paket_ujian.id_user_koreksi is null' => null));
		
		if(!$this->dataSiswa){			
			echo "Maaf .. pengambilan Data Gagal. Silahkan Reload Halaman Ini.";
		}
		
		
		
		$this->dataSoalSiswa = $this->soal_siswa_model->showDataForLaporan(array('soal_siswa.id_detail_siswa_paket_ujian' => $id_detail_siswa_paket_ujian , 'm_soal.jenis_soal' => 'E' ),'','id_soal_siswa');
		
		foreach($this->dataSoalSiswa as $dataSoalSiswa){
			
			$this->dataNilai = $this->t_paket_soal_ujian_model->getData(array('t_paket_soal_ujian.id_m_ujian_mapel' => $this->dataSiswa->id_m_ujian_mapel, 't_paket_soal_ujian.id_m_paket_soal' => $dataSoalSiswa->id_m_paket_soal ));
			
			if($dataSoalSiswa->kategori_soal == 'MD'){
				$nilaiMax = $this->dataNilai->nilai_benar_soal_esay;
			}
			if($dataSoalSiswa->kategori_soal == 'SD'){
				$nilaiMax = $this->dataNilai->nilai_benar_soal_esay_sedang;
			}
			if($dataSoalSiswa->kategori_soal == 'SL'){
				$nilaiMax = $this->dataNilai->nilai_benar_soal_esay_sulit;
			}
			
			
			echo '
			<div class="form-group">
				<div class="col-sm-12">
					<b>Soal</b> <br>
					'.$dataSoalSiswa->soal.'
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-10 col-sm-offset-1">
					<b>Jawaban</b> <br>
					'.$dataSoalSiswa->jawaban_esay.'
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-3 col-sm-offset-1">
					<select class="form-control required" onchange="input_nilai(\''.$dataSoalSiswa->id_m_soal.'\', \''.$nilaiMax.'\')" name="benar_salah_'.$dataSoalSiswa->id_m_soal.'" id="benar_salah_'.$dataSoalSiswa->id_m_soal.'" >
						<option value="">Silahkan Pilih Jawaban</option>
						<option value="B">Benar</option>
						<option value="S">Salah</option>
					</select>
				</div>
				<div class="col-sm-3 ">
					<input class="form-control required" max="'.$nilaiMax.'" type="number" id="nilai_'.$dataSoalSiswa->id_m_soal.'" name="nilai_'.$dataSoalSiswa->id_m_soal.'" >
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-12">
					<hr>
				</div>
			</div>
			';
		}
		
	}
	
	
	public function insert_koreksi(){
		if(!$this->input->post('id_detail_siswa_paket_ujian')){
			$status = array('status' => false, 'pesan' => 'Proses Koreksi Pengerjaan Siswa Gagal, silahkan reload Halaman ini (Tekan f5)');
		}	
		
		$this->load->model('soal_siswa_model');
		$this->load->model('detail_siswa_paket_ujian_model');
		$this->load->model('t_paket_soal_ujian_model');
		
		$this->dataSiswa = $this->detail_siswa_paket_ujian_model->getData(array('detail_siswa_paket_ujian.id_detail_siswa_paket_ujian' => $this->input->post('id_detail_siswa_paket_ujian'), 'detail_siswa_paket_ujian.id_user_koreksi is null' => null));
		
		if(!$this->dataSiswa){
			$status = array('status' => false, 'pesan' => 'Proses Koreksi Pengerjaan Siswa Gagal, Dikarenakan sudah pernah dikoreksi. Silahkan reload Halaman ini (Tekan f5)');
		}
		else{
			$this->db->trans_start();
			
			$this->dataSoalSiswa = $this->soal_siswa_model->showDataForLaporan(array('soal_siswa.id_detail_siswa_paket_ujian' => $this->input->post('id_detail_siswa_paket_ujian') , 'm_soal.jenis_soal' => 'E' ),'','id_soal_siswa');
		
			foreach($this->dataSoalSiswa as $dataSoalSiswa){
				
				$dataUpdateSoalSiswa['nilai_jawaban'] = $this->input->post('nilai_'.$dataSoalSiswa->id_m_soal) ;
				$dataUpdateSoalSiswa['status_jawaban']	= $this->input->post('benar_salah_'.$dataSoalSiswa->id_m_soal) ;
				
				$this->soal_siswa_model->update( array('soal_siswa.id_m_soal' =>  $dataSoalSiswa->id_m_soal , 'soal_siswa.id_detail_siswa_paket_ujian' => $this->input->post('id_detail_siswa_paket_ujian')),$dataUpdateSoalSiswa );

				//echo $this->db->last_query();exit();
				
				
			}
			
			$dataDetailSiswa['tgl_koreksi'] 	= date('Y-m-d H:i');
			$dataDetailSiswa['id_user_koreksi'] = $this->session->userdata('id_user');
			$this->detail_siswa_paket_ujian_model->update(array('id_detail_siswa_paket_ujian' => $this->input->post('id_detail_siswa_paket_ujian') ),$dataDetailSiswa);
			
			$this->db->trans_complete();
			if($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				$status = array('status' => false, 'pesan' => 'Proses Koreksi Pengerjaan Siswa Gagal, Silahkan reload Halaman ini (Tekan f5)');
			}
			else {
				$this->db->trans_commit();

				$status = array('status' => true );
			}	
		}
		
		
		
		
		
		echo(json_encode($status));
	}
	
	
}
	
	
	
