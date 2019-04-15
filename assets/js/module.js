function show_confirmation_modal(pesan, link){
	$('.divForModal').html('');
	$('.divForModal').append('<div class="modal fade" id="confirmation_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><h4 class="modal-title" id="myModalLabel">Pesan Konfirmasi</h4></div><div class="modal-body">'+pesan+'</div><div class="modal-footer"><div class="pull-left"><button type="button" class="btn btn-warning" data-dismiss="modal">Tidak</button></div><a href="'+link+'"> <button type="button" class="btn btn-primary">Ya</button></a></div></div></div></div>');
	$('#confirmation_modal').modal('show');
}





// Standard Form
$('#form_standard').validate({
	submitHandler: function(form) {	
		
		var formAction = $("#form_standard").attr('action');
		$.ajax({
			url: formAction,
			type:'POST',
			dataType:'json',
			data: $('#form_standard').serialize(),
			beforeSend: function(){	
				$('#btnSubmit').html('Proses Simpan ...');
				$('#pesan_error').hide();
			},
			success: function(data){
				if( data.status ){	
					if(data.pesan){
						$('.page-footer').append('<div class="modal fade" id="container-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="false"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><h4 class="modal-title" id="myModalLabel">'+data.pesan+'</div><div class="modal-footer"><a href="'+data.redirect_link+'"> <button type="button" class="btn btn-primary">Ok</button></a></div></div></div></div>');
						$('#container-modal').modal('show');

					}
					else{
						if( data.redirect_link){
							location.href = data.redirect_link;
						}else{
							location.reload();
						}
						
					}					
				}
				else{				
					$('#btnSubmit').html('<i class="fa fa-save"></i> Simpan'); $('#pesan_error').show(); $('#pesan_error').html(data.pesan);
					$("html, body").animate({ scrollTop: 0 }, "slow");					 
				}
			},
			error : function(data) {
				$('#pesan_error').html('maaf telah terjadi kesalahan dalam program, silahkan anda mengakses halaman lainnya.'); 
				$('#pesan_error').show(); 
				$('#btnSubmit').html('<i class="fa fa-save"></i> Simpan');
				//$('#pesan_error').html( '<h3>Error Response : </h3><br>'+JSON.stringify( data ));
			}
		})
	}
});



$('#form_detail_mapel').validate({
	submitHandler: function(form) {	
		
		var formAction = $("#form_detail_mapel").attr('action');
		$.ajax({
			url: formAction,
			type:'POST',
			dataType:'json',
			data: $('#form_detail_mapel').serialize(),
			beforeSend: function(){	
				
				
				$('#div_detail_soal').hide();
				
				$('#pesan_error').hide();				
				
				
				$('#divLoading').show();
			},
			success: function(data){
				if( data.status ){	
					if(data.pesan){
						$('.page-footer').append('<div class="modal fade" id="container-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="false"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><h4 class="modal-title" id="myModalLabel">'+data.pesan+'</div><div class="modal-footer"><a href="'+data.redirect_link+'"> <button type="button" class="btn btn-primary">Ok</button></a></div></div></div></div>');
						$('#container-modal').modal('show');

					}
					else{
						if( data.redirect_link){
							location.href = data.redirect_link;
						}else{
							location.reload();
						}
						
					}					
				}
				else{				
					
					$('#div_detail_soal').show();
					
					$('#divLoading').hide();
					$('#pesan_error').show(); $('#pesan_error').html(data.pesan);
					$("html, body").animate({ scrollTop: 0 }, "slow");			
					
				}
			},
			error : function(data) {
				$('#pesan_error').html('maaf telah terjadi kesalahan dalam program, silahkan anda mengakses halaman lainnya.'); 
				$('#pesan_error').show(); 
				$('#divLoading').hide();
				
				$('#div_detail_soal').show();
				//$('#pesan_error').html( '<h3>Error Response : </h3><br>'+JSON.stringify( data ));
			}
		})
	}
});
