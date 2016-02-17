<script>
$(document).ready(function(){
	<?php if($use_js == 'profileJs'): ?>
		var ctr = 1;
		$('.load-btn').each(function(){
			if(ctr == 1){
				var url = $(this).attr('href');
			 	load_div(url);
				return false;
			}
		});
		$('.load-btn').click(function(){
			var url = $(this).attr('href');
		 	load_div(url);
			return false;
		});
		function load_div(url){
			$('#load-div').rLoad({'url':url});
		}
		function readURL(input) {
        	$("#img-form").submit(function(e){
			    var formObj = $(this);
			    var formURL = formObj.attr("action");
			    var formData = new FormData(this);
			    $.ajax({
			        url: baseUrl+formURL,
			        type: 'POST',
			        data:  formData,
			        dataType:  'json',
			        mimeType:"multipart/form-data",
			        contentType: false,
			        cache: false,
			        processData:false,
			        success: function(data, textStatus, jqXHR){
			        	if(data.msg == "" ){
							// rMsg('Image Uploaded.','success');
							location.reload();
				        	if (input.files && input.files[0]) {
					            var reader = new FileReader();
					            reader.onload = function (e) {
					            	// alert(e.target.result);
					                $('#target').attr('src', e.target.result);
					                // $('#target').html(e.target.result);
					            }
					            reader.readAsDataURL(input.files[0]);
					        }
						}
						else{
							rMsg(data.msg,'error');
						}
						// alert(data);
			        },
			        error: function(jqXHR, textStatus, errorThrown){
			        }         
			    });
			    e.preventDefault();
			    e.unbind();
			});
			$("#img-form").submit();
	    }
    	$("#fileUpload").change(function(){
	        readURL(this);
	    });
	    $('#target').click(function(e){
	    	$('#fileUpload').trigger('click');
	    	// alert('jere');
	    }).css('cursor', 'pointer');
	    $('#target').hover(
		  function () {
		    $('.img-title').show();
		  }, 
		  function () {
		    $('.img-title').hide();
		  }
		);
	<?php elseif($use_js == 'changePasswordJs'): ?>
		$('#change-password-btn').click(function(){
				var noError = $('#change-form').rOkay({
			     				btn_load		: 	$('#change-password-btn'),
			     				goSubmit		: 	false,
			     				bnt_load_remove	: 	true
							  });
				if(noError){
					var btn = $('#change-password-btn');
					var formData = $('#change-form').serialize();
					btn.goLoad();
					$.post(baseUrl+'user/change_password_db',formData,function(data){
						btn.goLoad({load:false});
						if(data.error == 1){
							rMsg(data.msg,'error');
						}
						else{
							rMsg(data.msg,'success');
						}
					},'json');
					// });
				}
			return false;
		});
	<?php elseif($use_js == 'editProfileJs'): ?>
		$('#edit-profile-save-btn').click(function(){
			$('#edit-profile-form').rOkay({
				btn_load 	: 	$('#edit-profile-save-btn'),
				asJson 		: 	false,
				onComplete 	: 	function(data){
					// alert(data);
					location.reload();
					// rMsg(data.desc,'success');
				}
			});
			return false;
		});
	<?php endif; ?>
});
</script>