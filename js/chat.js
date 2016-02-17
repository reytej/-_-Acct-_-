$(document).ready(function(){
    $('.chatlistbody').perfectScrollbar({suppressScrollX: true});
    $('.chatbar').click(function(){
        $('.chatbar').hide();
        $('.chatlist').show();
        return false;
    });
    $('.closechatlist').click(function(){
        $('.chatlist').hide();
        $('.chatbar').show();    
    });
    $('.chatlistbody ul li').click(function(){
        $('.chatlist').hide();
        $('.chatbar').show();    
    });
});