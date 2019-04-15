<?php
class Hak_akses extends CI_Controller {
    protected $_ci;
    
    function __construct(){
        $this->_ci = &get_instance();
		
		$this->_ci->load->library('template_view');

    }
    

	function cek_menu($link_menu){		
		$link_menu	=	"backoffice/".$link_menu;
	
		$this->_ci->load->model('t_hak_akses_model');
		
		$whereMenu 	= array('m_menu.link_menu' => $link_menu, 't_hak_akses.id_kategori_user' => $this->_ci->session->userdata('id_kategori_user'));
		$dataMenu  	= $this->_ci->t_hak_akses_model->getData($whereMenu);
		
		if(!$dataMenu){
			$this->_ci->session->sess_destroy();
			redirect('admin');
		}		
	}
	
	function cek_add($link_menu){		
		$link_menu	=	"backoffice/".$link_menu;
	
		$this->_ci->load->model('t_hak_akses_model');
		
		$whereMenu 	= array('m_menu.link_menu' => $link_menu, 't_hak_akses.id_kategori_user' => $this->_ci->session->userdata('id_kategori_user'),'t_hak_akses.insert_akses' => 'Y');
		$dataMenu  	= $this->_ci->t_hak_akses_model->getData($whereMenu);
		
		if(!$dataMenu){
			$this->_ci->session->sess_destroy();
			redirect('admin');
		}			
	}
	
	function cek_edit($link_menu){		
		$link_menu	=	"backoffice/".$link_menu;
	
		$this->_ci->load->model('t_hak_akses_model');
		
		$whereMenu 	= array('m_menu.link_menu' => $link_menu, 't_hak_akses.id_kategori_user' => $this->_ci->session->userdata('id_kategori_user'),'t_hak_akses.edit_akses' => 'Y');
		$dataMenu  	= $this->_ci->t_hak_akses_model->getData($whereMenu);
		
		//var_dump($dataMenu);
		//var_dump($this->_ci->db->last_query());
		
		if(!$dataMenu){
			//$this->_ci->session->sess_destroy();
			//redirect('admin');
		}			
	}
	function cek_delete($link_menu){	
		$link_menu	=	"backoffice/".$link_menu;
	
		$this->_ci->load->model('t_hak_akses_model');
		
		$whereMenu 	= array('m_menu.link_menu' => $link_menu, 't_hak_akses.id_kategori_user' => $this->_ci->session->userdata('id_kategori_user'),'t_hak_akses.delete_akses' => 'Y');
		$dataMenu  	= $this->_ci->t_hak_akses_model->getData($whereMenu);
		
		if(!$dataMenu){
			$this->_ci->session->sess_destroy();
			redirect('admin');
		}			
	}
	
	
	
	function btn_add($link_menu , $fullLink = null,$hanyaCek = null){	
		
			$link_menu	=	"backoffice/".$link_menu;
		
			$this->_ci->load->model('t_hak_akses_model');
			
			$whereMenu 	= array('m_menu.link_menu' => $link_menu, 't_hak_akses.id_kategori_user' => $this->_ci->session->userdata('id_kategori_user'),'t_hak_akses.insert_akses' => 'Y');
			$dataMenu  	= $this->_ci->t_hak_akses_model->getData($whereMenu);
				if($hanyaCek){
					if($dataMenu){
						return true;	
					}	
					else{
						return false;	
					}
				}
				else{
					if($dataMenu){
						if($fullLink){
							return 
							'<a href="'.$fullLink.'">
								<span class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data</span>
							</a>';
						}
						else{
							return 
							'<a href="'.$this->_ci->template_view->base_url_admin().'/'.$this->_ci->uri->segment("2").'/add">
								<span class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data</span>
							</a>';
						}
						
					}	
				}
	}
	
	function btn_edit($link_menu,$link_edit,$hanyaCek = null){	
		
			$link_menu	=	"backoffice/".$link_menu;
		
			$this->_ci->load->model('t_hak_akses_model');
			
			$whereMenu 	= array('m_menu.link_menu' => $link_menu, 't_hak_akses.id_kategori_user' => $this->_ci->session->userdata('id_kategori_user'),'t_hak_akses.edit_akses' => 'Y');
			$dataMenu  	= $this->_ci->t_hak_akses_model->getData($whereMenu);
			if($hanyaCek){
				if($dataMenu){
					return true;	
				}	
				else{
					return false;	
				}
			}
			else{	
				if($dataMenu){
					return 
					'<a href="'.$link_edit.'">
					  <span class="btn btn-primary"><i class="fa fa-edit"></i></span>
					</a>
					';
				}		
			}
	}
	
	function btn_delete($link_menu,$pesan,$link_delete,$hanyaCek = null){	
		
			$link_menu	=	"backoffice/".$link_menu;
		
			$this->_ci->load->model('t_hak_akses_model');
			
			$whereMenu 	= array('m_menu.link_menu' => $link_menu, 't_hak_akses.id_kategori_user' => $this->_ci->session->userdata('id_kategori_user'),'t_hak_akses.delete_akses' => 'Y');
			$dataMenu  	= $this->_ci->t_hak_akses_model->getData($whereMenu);
			if($hanyaCek){
				if($dataMenu){
					return true;	
				}	
				else{
					return false;	
				}
			}
			else{
				if($dataMenu){
					return 			
					'<span class="btn btn-warning" onclick="show_confirmation_modal(\''.$pesan.'\',\''.$link_delete.'\')"><i class="fa fa-trash"></i></span>';		
				}		
			}
	}

	

}
