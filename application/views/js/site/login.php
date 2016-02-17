<script>
$(document).ready(function(){
	<?php if($use_js == 'loginJs'): ?>
		$(".center").center();
		$('#username').focus();
		

		// var imageIndex = 0;
		// var imagesArray = [
		//     "img/loginBG/1.jpg",
		//     "img/loginBG/2.jpg",
		// ];
		// function changeBackground(){
		//     var index = imageIndex++ % imagesArray.length;
		//     $(".lockscreen").stop().fadeOut("1000", function () {
	 //            $(this).css({
	 //    					 	"background":"url('"+ imagesArray[index] +"') no-repeat center center fixed",
	 //    					 	"-webkit-background-size": "cover",
	 //    					 	"-moz-background-size": "cover",
	 //    					 	"-o-background-size" : "cover",
	 //    					 	"background-size" : "cover",
		// 					 }).fadeIn(1000);
	 //        });
		//     // $(".lockscreen").css({
		//     // 					 	"background":"url('"+ imagesArray[index] +"') no-repeat center center fixed",
		//     // 					 	"-webkit-background-size": "cover",
		//     // 					 	"-moz-background-size": "cover",
		//     // 					 	"-o-background-size" : "cover",
		//     // 					 	"background-size" : "cover",
		// 				// 		 });      
		// }
	 //    setInterval(changeBackground, 3000);

		$('#login-btn').click(function(){
			$("#login-form").rOkay({
				btn_load		: 	$('#login-btn'),
				bnt_load_remove	: 	true,
				asJson			: 	true,
				onComplete		:	function(data){
										// alert(data);
										if(data.error_msg != null){
											rMsg(data.error_msg,'error');
										}
										else{
											window.location = baseUrl+'user/profile';
										}
									}
			});
			return false;
		});
	<?php endif; ?>
});
</script>