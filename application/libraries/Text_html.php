<?php

Class Text_html {
	public function __construct(){
		$this->CI =& get_instance();
	}
	
		
	public function status_pegawai($status){
		switch ($status) {
			case 'G':
				return "Guru";
				break;
			case 'A':
				return "Administrasi";
				break;
		}
	}
	
	
	public function jkl($jenis){
		switch ($jenis) {
			case 'L':
				return "Laki-Laki";
				break;
			case 'P':
				return "Perempuan";
				break;
		}
	}
	
	public function status_aktif($status){
		switch ($status) {
			case 'A':
				return "<span class='btn btn-success btn-sm'><div class='list-icon-container green'><i class='icon-check'></i> Aktif</div></span> ";
				break;
			case 'Y':
				return "<span class='btn btn-success btn-sm'><div class='list-icon-container green'><i class='icon-check'></i> Aktif</div></span> ";
				break;
			case 'N':
				return "<span class='btn btn-danger btn-sm'><div class='list-icon-container'><i class='icon-close'></i> Tidak Aktif</div></span> ";
				break;
			case 'S':
				return "<span class='btn btn-warning btn-sm'><div class='list-icon-container'><i class='fa fa-question-circle '></i> Ujian Susulan</div></span>";
				break;
		}
	}
	
	public function jenis_soal($jenis){
		switch ($jenis) {
			case 'G':
				return "Pilihan Ganda";
				break;
			case 'E':
				return "Uraian";
				break;
		}
	}
	
	public function kategori_soal($kat){
		switch ($kat) {
			case 'M':
				return "Menengah";
				break;
			case 'S':
				return "Sulit";
				break;
			case 'D':
				return "Mudah";
				break;
		}
	}
	public function status_jawaban($status){
		switch ($status) {
			case 'B':
				return "Benar";
				break;
			case 'S':
				return "Salah";
				break;
			case '':
				return "BJ";
				break;
		}
	}
	
	public function status_jawaban_huruf($status){
		switch ($status) {
			case 'B':
				return "Benar";
				break;
			case 'S':
				return "Salah";
				break;
			case '':
				return "Belum Dijawab";
				break;
		}
	}
	
	public function status_jawaban_huruf_warna($status,$jenis_soal = null){
		switch ($status) {
			case 'B':
				return "<span style='color:green;'>Benar</span>";
				break;
			case 'S':
				return "<span style='color:red;'>Salah</span>";
				break;
			case '':
				if($jenis_soal == 'E'){
					return "<span style='color:blue;'>Belum Dikoreksi</span>";
				}
				else{
					return "<span style='color:blue;'>Belum Dijawab</span>";
				}
				
				break;
		}
	}
	
	public function status_jawaban_huruf_btn($status){
		switch ($status) {
			case 'B':
				return "<span class='btn btn-success'>B</span>";
				break;
			case 'S':
				return "<span class='btn btn-warning'>S</span>";
				break;
			case '':
				return "<span class='btn btn-danger'>BJ</span>";
				break;
		}
	}
	
}
