<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {	

	public function __construct() {
		parent::__construct();
		
		/// library otomatis untuk Hak Akses
		$this->load->library('session_lib');
		$this->session_lib->siswa();
				
		$this->load->library('text_html');
		$this->load->model('m_siswa_paket_ujian_model');
		$this->load->model('m_ujian_model');
		$this->load->model('detail_siswa_paket_ujian_model');
		
	} 

	public function index(){
		
		//echo $this->template_view->mac();
		
		$this->dataUjian		=	$this->m_ujian_model->getData( $this->session->userdata('id_m_ujian'));
		
		$dataMapel = $this->detail_siswa_paket_ujian_model->showDataForDashboardSiswa('','','tgl_pengerjaan');
		$this->htmlMapelUjian = "";
		
		
		
		foreach($dataMapel as $dataMataPelajaran) {
			$this->htmlMapelUjian .= '
			<div class="timeline-item">
				<div class="timeline-badge">
					<div class="timeline-icon">
						<i class="icon-docs font-yellow"></i>
					</div>
				</div>
				<div class="timeline-body">
					<div class="timeline-body-arrow"> </div>
					<div class="timeline-body-head">
						<div class="timeline-body-head-caption">
							<span class="timeline-body-alerttitle font-green-haze">
								'.$dataMataPelajaran->nm_mata_pelajaran.'
							</span>
						</div>
						<div class="timeline-body-head-actions">
							<button class="btn btn-circle red" onclick="location.href=\''.$this->template_view->base_url_siswa().'/ujian/login/'.$dataMataPelajaran->id_m_ujian.'/'.$dataMataPelajaran->id_m_ujian_mapel.'\'" > 		
								Detail Ujian
								<i class="fa fa-eye"></i>
							</button>
						</div>
					</div>
					<div class="timeline-body-content">
						<span class="font-grey-cascade bold"> 
							
							Tanggal Pengerjaan : '.$dataMataPelajaran->tgl_pengerjaan_indo.'
						</span>
					</div>
				</div>
			</div>
										
			';
		}
		
		if(!$dataMapel){
			$this->htmlMapelUjian .= '
			<div class="timeline-item">
				<div class="timeline-badge">
					<div class="timeline-icon">
						<i class="fa fa-child font-yellow"></i>
					</div>
				</div>
				<div class="timeline-body">
					<div class="timeline-body-arrow"> </div>
					<div class="timeline-body-head">
						<div class="timeline-body-head-caption">
							<span class="timeline-body-alerttitle font-yellow">
								Anda Sudah mengerjakan Ujian semua Mata Pelajaran. Silahkan klik menu Riwayat Ujian untuk melihat Detail Pengerjaan Ujian Anda.
							</span>
						</div>
					</div>
				</div>
			</div>
			';
		}
		
		$this->template_view->load_siswa_view('siswa/dashboard_view');
	}
	
}
