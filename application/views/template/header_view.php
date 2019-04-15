<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>SASIS (Sahabat Siswa)</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="Preview page of Metronic Admin Theme #3 for " name="description" />
        <meta content="" name="author" />
		
        <style>
		@font-face {
			font-family: 'Open Sans';
			font-style: normal;
			font-weight: 300;
			src: local('Open Sans Regular'), local('OpenSans-Regular'), url(<?=base_url();?>assets/fonts/OpenSans-Regular.ttf) format('truetype');
		}
		</style>
        <link href="<?=base_url();?>assets/global/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url();?>assets/global/plugins/simple-line-icons/simple-line-icons.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url();?>assets/global/plugins/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
        <!--<link href="<?=base_url();?>assets/global/plugins/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />-->
        <link href="<?=base_url();?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.css" rel="stylesheet" type="text/css" />
     
	 
        <link href="<?=base_url();?>assets/global/css/components.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="<?=base_url();?>assets/global/css/plugins.css" rel="stylesheet" type="text/css" />
		
		
        <link href="<?=base_url();?>assets/global/plugins/jquery-file-upload/css/jquery.fileupload.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url();?>assets/global/plugins/jquery-file-upload/css/jquery.fileupload-ui.css" rel="stylesheet" type="text/css" />
		

        <link href="<?=base_url();?>assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url();?>assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url();?>assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url();?>assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
  
        <link href="<?=base_url();?>assets/layouts/layout3/css/layout.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url();?>assets/layouts/layout3/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color" />
        <link href="<?=base_url();?>assets/layouts/layout3/css/custom.css" rel="stylesheet" type="text/css" />
		
        <link href="<?=base_url();?>assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url();?>assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
		
		
        <link href="<?=base_url();?>assets/css/tambahan.css" rel="stylesheet" type="text/css" />
		
		
		 <script src="<?=base_url();?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
		 
        <script src="<?=base_url();?>assets/global/plugins/pulsate.js" type="text/javascript"></script>
		
		
        <link href="<?=base_url();?>assets/css/BootSideMenu.css" rel="stylesheet" type="text/css" />
       
        <link rel="shortcut icon" href="favicon.ico" /> </head>

    <body class="page-container-bg-solid" onkeydown="klik(event)">
            <div class="page-wrapper">
                <div class="page-wrapper-row">
                    <div class="page-wrapper-top" style="border-bottom:2px solid #ed6b75;">
                        <div class="page-header">
                            <div class="page-header-top">
                                <div class="container">
                                    <div class="page-logo">                                       
                                            <img src="<?=base_url();?>upload/logo/<?=$this->dataProfilAplikasi->icon;?>" alt="logo" class="logo-default">
											<div id='text_sekolah'>
												<h1><?=$this->dataProfilAplikasi->nm_aplikasi;?></h1>
												<p><?=$this->dataProfilAplikasi->alamat;?></p>
												<p><?=$this->dataProfilAplikasi->telp;?></p>
											</div>
											
                                    </div>
									
									<a href="javascript:;" class="menu-toggler"></a>
									<?php
									if($this->session->userdata('nm_siswa')){
									?>
									<div class="page-logo" style="float:right">                                       
                                           <img src="<?=base_url();?>assets/images/student.png" style="height:65px;margin-top:10px" >
											<div id='text_sekolah' class="text-right">
												
												
												<p style="font-size:15px;">
												<b><?=$this->session->userdata('nm_siswa');?></b>
												<br>NIPD : <?=$this->session->userdata('nipd');?>
												<br>Kelas : <?=$this->session->userdata('kelas');?>
												</p>
											</div>
											
                                    </div>
									<?php
									}
									?>
                                </div>
                            </div>
							
							<?php 
							if($this->menu){
								$this->load->view('template/menu_view');
							}
							if($this->menu_siswa){
								$this->load->view('template/menu_siswa_view');
							}
							?>
							
						</div>
					</div>
				</div>
				
				<div class="page-wrapper-row full-height">
                    <div class="page-wrapper-middle">
                        <div class="page-container">
                            <div class="page-content-wrapper">
                 