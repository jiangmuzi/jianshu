/**
 * 
 */
$(function(){
	$('.set-view-mode').click(function(){
		setReadMode($(this).data('mode'));
	});
	window.onload = function(){
		setReadMode();
	};
	
	$(window).scroll(function(){
		if($(this).scrollTop()>180) {
			$('.fixed-btn .go-top').fadeIn();
		}else{
			$('.fixed-btn .go-top').fadeOut();
		}
	});
	$('.go-top').click(function(){$('html,body').animate({scrollTop: '0px'}, 800);return false;});
	
	if(window.isArchive){
		$(window).bind("scroll", ajaxLoadArchives);
	}
});
function ajaxLoadArchives(){
	var st = $(document).scrollTop(), sb = $(document).height() - $(window).height();
	if(st+160>sb){
		ajaxLoad.load();
	}
}
var ajaxLoad = {
		isLoad:false,
		isEnd:false,
		load:function(){
			if(ajaxLoad.isLoad || ajaxLoad.isEnd){
				return;
			}
			ajaxLoad.isLoad = true;
			ajaxLoad.loadContent();
		},
		loadContent:function(){
			var url = $('#ajax-page').find('a').attr('href');
			$('#main-container').find('#ajax-page').remove();
			if(url===undefined || url=='#'){
				ajaxLoad.setEnd();
				return false;
			}
			$.get(url).success(function(rs){
				var main = $(rs).find('#main-container').html();
				$(main).appendTo($('#main-container'));
				ajaxLoad.isLoad = false;
			});
		},
		setEnd:function(){
			ajaxLoad.isEnd = true;
			$('<div id="ajax-page" class="page-navigator"><a>没有更多内容了</a></div>').appendTo($('#main-container'));
		}
}
function setReadMode(mode){
	var btn = $('.set-view-mode');
	mode = mode===undefined ? getCookie('read-mode') : mode;
    if(mode=='day'){
    	$('body').addClass('night-mode');
    	btn.data('mode','night').find('i').attr('class','fa fa-sun-o');
    }else{
	    if($('body').hasClass('night-mode')){
	    	$('body').removeClass('night-mode');
			btn.data('mode','day').find('i').attr('class','fa fa-moon-o');
		}
	}
    setCookie('read-mode',mode);
}
function setCookie(name,value){  
    var Days = 30;  
    var exp  = new Date();  
    exp.setTime(exp.getTime() + Days*24*60*60*1000);  
    document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();  
}
function getCookie(name) {
    var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
    if(arr=document.cookie.match(reg))
        return unescape(arr[2]); 
    else 
        return null; 
}