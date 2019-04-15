
                          
<div class="page-content">
	<div class="container">	
		<div class="row">											
			<div class="col-md-6 col-md-offset-3">
				<div class="col-xs-12">
					<div class="mt-element-ribbon bg-grey-steel" style="margin-top:20px;">
						<div class="ribbon ribbon-border-hor ribbon-clip ribbon-color-danger uppercase">
							<div class="ribbon-sub ribbon-clip"></div> <h4>Form Login Siswa</h4> 
						</div>
						<br>
						<div >
						<form class="form-horizontal" method="post" action="<?=base_url();?>login/authentication" role="form" style="margin-top:55px;margin-bottom:50px;padding:20px;background:#ffffff;border-bottom:2px solid #336799;">
								
							<?php if($this->session->notice){echo $this->session->notice;} ?>
							
							<div class="form-group">
								<label class="col-md-2 control-label"></label>
								<div class="col-md-8">
									<div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-user"></i>
										</span>
										<input type="input" name="nipd" required  oninvalid="this.setCustomValidity('Inputkan Nomor Induk Peserta Didik')" autocomplete="off" oninput="setCustomValidity('')" autofocus value="<?=$this->session->flashdata('nipd')?>" class="form-control" placeholder="Nomor Induk Peserta Didik" onfocus="this.removeAttribute('readonly');" > </div>
								</div>
								<label class="col-md-2 control-label"></label>
							</div>
							
							<div class="form-group">
								<label class="col-md-2 control-label"></label>
								<div class="col-md-8">
									<div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-lock"></i>
										</span>
										<input type="password" name="pass_word" required oninvalid="this.setCustomValidity('Inputkan Password')"  autocomplete="off"  oninput="setCustomValidity('')" class="form-control" placeholder="Password"> </div>
								</div>
								<label class="col-md-2 control-label"></label>
							</div>
							
							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<button type="submit" class="btn btn-success">Login</button>
								</div>
							</div>
						</form>
					
						</div>
					</div>
			</div>											
		</div>
	</div>
	</div>
</div>
						
			
			