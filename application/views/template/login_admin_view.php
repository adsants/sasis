
<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.7
Version: 4.7.5
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>Halaman Login Admin</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="Preview page of Metronic Admin Theme #3 for " name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
		  <style>
		@font-face {
			font-family: 'Open Sans';
			font-style: normal;
			font-weight: 300;
			src: local('Open Sans Regular'), local('OpenSans-Regular'), url(<?=base_url();?>assets/fonts/OpenSans-Regular.ttf) format('truetype');
		}
		</style>
		
        <link href="<?=base_url();?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url();?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url();?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url();?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="<?=base_url();?>assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url();?>assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="<?=base_url();?>assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="<?=base_url();?>assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="<?=base_url();?>assets/pages/css/login-5.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> </head>
    <!-- END HEAD -->

    <body class=" login">
        <!-- BEGIN : LOGIN PAGE 5-1 -->
        <div class="user-login-5">
            <div class="row bs-reset">
                <div class="col-md-6 bs-reset mt-login-5-bsfix">
                    <div class="login-bg" style="background-image:url(<?=base_url();?>assets/pages/img/login/bg1.jpg)">
					
						<img class="login-logo" src="<?=base_url();?>assets/images/logo_sasis.png" width="200px" >
					
                    </div>
                </div>
                <div class="col-md-6 login-container bs-reset mt-login-5-bsfix">
						<div style="margin-top:60px;">
						<center>
						<img width="150px" src="<?=base_url();?>upload/logo/<?=$this->dataProfilAplikasi->icon;?>">
						<br>
						<br>
						<strong class="font-blue-madison font-lg bold uppercase"><?=$this->dataProfilAplikasi->nm_aplikasi;?></strong>
						</center>
						</div>
                    <div class="login-content">
					
						
						<p>Untuk mengakses Halaman <b>Administrator</b>, silahkan anda Login terlebih dahulu dengan Username dan Password Anda.
						<h4 class="font-red font-lg bold ">Form Login Aplikasi Sahabat Siswa<hr></h4>
						<form class="form-horizontal" method="post" action="<?=base_url();?>admin/authentication" role="form">
                            
							<?php if($this->session->notice){echo $this->session->notice;} ?>
                            <div class="row" style="margin-bottom:10px;">
                                <div class="col-sm-6" style="margin-bottom:10px;">
									
									
									<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-user"></i>
									</span>
									<input type="input" autocomplete="off" class="form-control "  placeholder="Username" required=""  oninvalid="this.setCustomValidity('Inputkan Username')" name="user_name" autocomplete="false" oninput="setCustomValidity('')" value="<?=$this->session->flashdata('user_name')?>">
									</div>
									
									
								</div>
                                <div class="col-sm-6">
									<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-lock"></i>
									</span>
									
                                   <input type="password" autocomplete="off" class="form-control"  required oninvalid="this.setCustomValidity('Inputkan Password')"  autocomplete="false"  oninput="setCustomValidity('')" name="pass_word"  placeholder="Password" required="">
								   
									</div>
								</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                </div>
                                <div class="col-sm-8 text-right">
                                    <button class="btn btn-primary" type="submit">Login</button>
                                </div>
                            </div>
                        </form>
                       
                    </div>
                    <div class="login-footer">
                        <div class="row bs-reset">
                            <div class="col-xs-5 bs-reset">
                            </div>
                            <div class="col-xs-7 bs-reset">
                                <div class="login-copyright text-right">
                                    <p>2019 &copy; <a href="http://www.sahabat-siswa.com/" target="_blank">SASIS</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END : LOGIN PAGE 5-1 -->
        <!--[if lt IE 9]>
<script src="<?=base_url();?>assets/global/plugins/respond.min.js"></script>
<script src="<?=base_url();?>assets/global/plugins/excanvas.min.js"></script> 
<script src="<?=base_url();?>assets/global/plugins/ie8.fix.min.js"></script> 
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="<?=base_url();?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="<?=base_url();?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?=base_url();?>assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="<?=base_url();?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="<?=base_url();?>assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="<?=base_url();?>assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="<?=base_url();?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="<?=base_url();?>assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
        <script src="<?=base_url();?>assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
        <script src="<?=base_url();?>assets/global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="<?=base_url();?>assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="<?=base_url();?>assets/pages/scripts/login-5.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <!-- END THEME LAYOUT SCRIPTS -->
        <script>
            $(document).ready(function()
            {
                $('#clickmewow').click(function()
                {
                    $('#radio1003').attr('checked', 'checked');
                });
            })
        </script>
    </body>

</html>
                          