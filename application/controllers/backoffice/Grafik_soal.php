<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Grafik_soal extends CI_Controller {	

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
		
		$this->template_view->load_admin_view('laporan/grafik_soal_view');
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
		$this->load->model('soal_siswa_model');
		
		$this->ShowDataMapelUjian 	= $this->m_ujian_mapel_model->showData(array("m_ujian_mapel.id_m_ujian" => $idUjian));
		
		
		if($this->input->get('id_m_ujian_mapel')){
			
			$this->dataMapelUjian 	= $this->m_ujian_mapel_model->getData(array("m_ujian_mapel.id_m_ujian_mapel" => $this->input->get('id_m_ujian_mapel')));
			
		
			
			$this->dataSoal = $this->soal_siswa_model->showDataGrafik(array('detail_siswa_paket_ujian.id_m_ujian_mapel' => $this->input->get('id_m_ujian_mapel')));
			
			$this->tableHtml = "";
			
			$no=1;
			foreach($this->dataSoal as $dataSoal){
				
				$this->tampil = $this->soal_siswa_model->showJumlahDataGrafik(array('detail_siswa_paket_ujian.id_m_ujian_mapel' => $this->input->get('id_m_ujian_mapel'), 'm_soal.id_m_soal' => $dataSoal->id_m_soal));
				
				$this->benar = $this->soal_siswa_model->showJumlahDataGrafik(array('detail_siswa_paket_ujian.id_m_ujian_mapel' => $this->input->get('id_m_ujian_mapel'), 'm_soal.id_m_soal' => $dataSoal->id_m_soal, 'soal_siswa.status_jawaban' => 'B'));
				
				$this->salah = $this->soal_siswa_model->showJumlahDataGrafik(array('detail_siswa_paket_ujian.id_m_ujian_mapel' => $this->input->get('id_m_ujian_mapel'), 'm_soal.id_m_soal' => $dataSoal->id_m_soal, 'soal_siswa.status_jawaban' => 'S'));
				
				$this->tidakJawab = $this->soal_siswa_model->showJumlahDataGrafik(array('detail_siswa_paket_ujian.id_m_ujian_mapel' => $this->input->get('id_m_ujian_mapel'), 'm_soal.id_m_soal' => $dataSoal->id_m_soal, "soal_siswa.status_jawaban = ''" => null));
				
				//echo $this->db->last_query();
				
				$this->tableHtml .= "	
					<tr>
						<td>".$dataSoal->soal." </td>
						<td>".count($this->tampil)." </td>
						<td>".count($this->benar)." </td>
						<td>".count($this->salah)." </td>
						<td>".count($this->tidakJawab)." </td>
					</tr>
				";
		
			$no++;
			}
			
		}
		
		$this->template_view->load_admin_view('laporan/grafik_soal_detail_view');
	}
	
	public function detail_grafik($idUjian){		
		
		if(!$idUjian){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}						
		
		$this->dataUjian 	= $this->m_ujian_model->getData($idUjian);		
		if(!$this->dataUjian){
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));	
		}	
		
		$this->load->model('m_ujian_mapel_model');
		$this->load->model('detail_siswa_paket_ujian_model');
		$this->load->model('soal_siswa_model');
		
		$this->ShowDataMapelUjian 	= $this->m_ujian_mapel_model->showData(array("m_ujian_mapel.id_m_ujian" => $idUjian));
		
		
		if($this->input->get('id_m_ujian_mapel')){
			
			$this->dataMapelUjian 	= $this->m_ujian_mapel_model->getData(array("m_ujian_mapel.id_m_ujian_mapel" => $this->input->get('id_m_ujian_mapel')));
			
		
			
			$this->dataSoal = $this->soal_siswa_model->showDataGrafik(array('detail_siswa_paket_ujian.id_m_ujian_mapel' => $this->input->get('id_m_ujian_mapel')));
			
			$this->tableHtml = "";
			
			$no=1;
			foreach($this->dataSoal as $dataSoal){
				
				$this->tampil = $this->soal_siswa_model->showJumlahDataGrafik(array('detail_siswa_paket_ujian.id_m_ujian_mapel' => $this->input->get('id_m_ujian_mapel'), 'm_soal.id_m_soal' => $dataSoal->id_m_soal));
				
				$this->benar = $this->soal_siswa_model->showJumlahDataGrafik(array('detail_siswa_paket_ujian.id_m_ujian_mapel' => $this->input->get('id_m_ujian_mapel'), 'm_soal.id_m_soal' => $dataSoal->id_m_soal, 'soal_siswa.status_jawaban' => 'B'));
				
				$this->salah = $this->soal_siswa_model->showJumlahDataGrafik(array('detail_siswa_paket_ujian.id_m_ujian_mapel' => $this->input->get('id_m_ujian_mapel'), 'm_soal.id_m_soal' => $dataSoal->id_m_soal, 'soal_siswa.status_jawaban' => 'S'));
				
				$this->tidakJawab = $this->soal_siswa_model->showJumlahDataGrafik(array('detail_siswa_paket_ujian.id_m_ujian_mapel' => $this->input->get('id_m_ujian_mapel'), 'm_soal.id_m_soal' => $dataSoal->id_m_soal, "soal_siswa.status_jawaban = ''" => null));
				
				//echo $this->db->last_query();
				
				$this->tableHtml .= "	
					<tr>
						<td>".$dataSoal->soal." </td>
						<td> 
				";
				
				$this->tableHtml .= '	
					<script type="text/javascript">
						google.charts.load("current", {packages:["corechart"]});
						google.charts.setOnLoadCallback(drawChart_'.$dataSoal->id_m_soal.');
						function drawChart_'.$dataSoal->id_m_soal.'() {
						  var data = google.visualization.arrayToDataTable([
							["Element", "Density", { role: "style" } ],
							["Diujikan", '.count($this->tampil).', "blue"],
							["Benar", '.count($this->benar).', "green"],
							["Salah", '.count($this->salah).', "gold"],
							["Tidak dijawab", '.count($this->tidakJawab).', "color: #e5e4e2"]
						  ]);

						  var view = new google.visualization.DataView(data);
						  view.setColumns([0, 1,
										   { calc: "stringify",
											 sourceColumn: 1,
											 type: "string",
											 role: "annotation" },
										   2]);

						  var options = {
							title: "",
							width: 400,
							height: 200,
							bar: {groupWidth: "95%"},
							legend: { position: "none" },
						  };
						  var chart = new google.visualization.BarChart(document.getElementById("barchart_values_'.$dataSoal->id_m_soal.'"));
						  chart.draw(view, options);
					  }
					  </script>
					<div id="barchart_values_'.$dataSoal->id_m_soal.'" style="width: 400px; height: 100%;"></div>
				';
				$this->tableHtml .= "	
					</td>
					</tr>
						
				";
			$no++;
			}
			
		}
		
		$this->template_view->load_admin_view('laporan/grafik_soal_detail_grafik_view');
	}
	
	
	public function cetak($idUjian){		
		
		if(!$idUjian){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}						
		
		$this->dataUjian 	= $this->m_ujian_model->getData($idUjian);		
		if(!$this->dataUjian){
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));	
		}	
		
		
		$this->load->model('profil_aplikasi_model');	
		$this->dataProfil = $this->profil_aplikasi_model->getData();
		
		$this->load->model('m_ujian_mapel_model');
		$this->load->model('detail_siswa_paket_ujian_model');
		$this->load->model('soal_siswa_model');
		
		$this->ShowDataMapelUjian 	= $this->m_ujian_mapel_model->showData(array("m_ujian_mapel.id_m_ujian" => $idUjian));
		
		
		if($this->input->get('id_m_ujian_mapel')){
			
			$this->dataMapelUjian 	= $this->m_ujian_mapel_model->getData(array("m_ujian_mapel.id_m_ujian_mapel" => $this->input->get('id_m_ujian_mapel')));
			
		
			
			$this->dataSoal = $this->soal_siswa_model->showDataGrafik(array('detail_siswa_paket_ujian.id_m_ujian_mapel' => $this->input->get('id_m_ujian_mapel')));
			
			$this->tableHtml = "";
			
			$no=1;
			foreach($this->dataSoal as $dataSoal){
				
				$this->tampil = $this->soal_siswa_model->showJumlahDataGrafik(array('detail_siswa_paket_ujian.id_m_ujian_mapel' => $this->input->get('id_m_ujian_mapel'), 'm_soal.id_m_soal' => $dataSoal->id_m_soal));
				
				$this->benar = $this->soal_siswa_model->showJumlahDataGrafik(array('detail_siswa_paket_ujian.id_m_ujian_mapel' => $this->input->get('id_m_ujian_mapel'), 'm_soal.id_m_soal' => $dataSoal->id_m_soal, 'soal_siswa.status_jawaban' => 'B'));
				
				$this->salah = $this->soal_siswa_model->showJumlahDataGrafik(array('detail_siswa_paket_ujian.id_m_ujian_mapel' => $this->input->get('id_m_ujian_mapel'), 'm_soal.id_m_soal' => $dataSoal->id_m_soal, 'soal_siswa.status_jawaban' => 'S'));
				
				$this->tidakJawab = $this->soal_siswa_model->showJumlahDataGrafik(array('detail_siswa_paket_ujian.id_m_ujian_mapel' => $this->input->get('id_m_ujian_mapel'), 'm_soal.id_m_soal' => $dataSoal->id_m_soal, "soal_siswa.status_jawaban = ''" => null));
				
				//echo $this->db->last_query();
				
				$this->tableHtml .= "	
					<tr>
						<td>".$dataSoal->soal." </td>
						<td>".count($this->tampil)." </td>
						<td>".count($this->benar)." </td>
						<td>".count($this->salah)." </td>
						<td>".count($this->tidakJawab)." </td>
					</tr>
				";
		
			$no++;
			}
			
		}
		
		$this->load->view('cetak/grafik_soal_view');
	}
	
	
	
}
	
	
	
