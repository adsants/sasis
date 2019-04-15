<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Joss extends CI_Controller {
	
	

	public function __construct() {
		parent::__construct();
		
		
	} 

	public function index(){
			$dataSiswas	=	$this->db->query("select * from detail_siswa_paket_ujian where id_m_ujian_mapel='14'");
			$dataSiswas	=	$dataSiswas->result();
			foreach($dataSiswas as $dataSiswa){
				echo $dataSiswa->id_detail_siswa_paket_ujian."<br><br>";
				
				$dataSoals	=	$this->db->query("select * from soal_siswa where id_detail_siswa_paket_ujian='".$dataSiswa->id_detail_siswa_paket_ujian."' order by id_m_soal");
				$dataSoals	=	$dataSoals->result();
				$i=	0;
				foreach($dataSoals as $dataSoal){
					echo $dataSoal->id_soal_siswa." -- ".$dataSoal->id_m_soal."<br>";
					
					$jumlahSoals	=	$this->db->query("select count(id_m_soal) as jumlah from soal_siswa where id_detail_siswa_paket_ujian='".$dataSiswa->id_detail_siswa_paket_ujian."' and id_m_soal='".$dataSoal->id_m_soal."'");
					$jumlahSoal		=	$jumlahSoals->row();
					if($jumlahSoal->jumlah > 1){
						
						$dataSoalHapus	=	$this->db->query("select * from soal_siswa where id_detail_siswa_paket_ujian='".$dataSiswa->id_detail_siswa_paket_ujian."' and id_m_soal='".$dataSoal->id_m_soal."' limit 1 ");
						$dataSoalHapus	=	$dataSoalHapus->row();
						
						echo $this->db->query("delete from soal_siswa where id_soal_siswa = '".$dataSoalHapus->id_soal_siswa."'");
						echo "<br>";
					}
					$i++;
				}
				echo "jumlahSoal = ".$i;
				echo "<hr>";
			}
	}
	
	public function ubah_nilai(){
			$dataSiswas	=	$this->db->query("select * from detail_siswa_paket_ujian where id_m_ujian_mapel='14'");
			$dataSiswas	=	$dataSiswas->result();
			foreach($dataSiswas as $dataSiswa){
				echo $dataSiswa->id_detail_siswa_paket_ujian."<br>";
				echo $dataSiswa->nilai."<br>";
				
				
				$jumlahNilais	=	$this->db->query("select sum(nilai_jawaban) as jumlah from soal_siswa where id_detail_siswa_paket_ujian='".$dataSiswa->id_detail_siswa_paket_ujian."'");
				$jumlahNilai		=	$jumlahNilais->row();
				
				//$this->db->query("update detail_siswa_paket_ujian set nilai = '".$jumlahNilai->jumlah."' where id_detail_siswa_paket_ujian='".$dataSiswa->id_detail_siswa_paket_ujian."'");
				
				
				echo "Nilai ASli = ".$jumlahNilai->jumlah;
				echo "<hr>";
			}
	}
	
}
