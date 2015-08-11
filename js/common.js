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
	
	$(window).bind("scroll", backToTopFun);
	
	$('.back-to-top').click(function() {
        $("html, body").animate({ scrollTop: 0 }, 120);
        return false;
	});
	
	if(window.isArchive){
		$(window).bind("scroll", ajaxLoadArchives);
	}
	backToTopFun();
});
function backToTopFun() {
    var st = $(document).scrollTop(), winh = $(window).height(),backToTopEle = $('.back-to-top');
    (st > 120)? backToTopEle.show(): backToTopEle.hide();
    //IE6下的定位
    if (!window.XMLHttpRequest) {
        backToTopEle.css("top", st + winh - 166);
    }
};
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
	//console.log(mode);
    if(mode=='day'){
    	$('body').addClass('night-mode');
    	btn.data('mode','night').find('i').attr('class','fa fa-sun-o');
    }else{
	    if($('body').hasClass('night-mode')){
	    	$('body').removeClass('night-mode');
			btn.data('mode','day').find('i').attr('class','fa fa-moon-o');
		}
	}
    setCookie('read-mode',mode,86400);
}
function setCookie(name,value,expires){  
    expires = new Date(+new Date + 1000 * 60 * 60 * 24 * expires);
    expires = ';expires=' + expires.toGMTString();
    path = ';path=/';
    document.cookie = name+"="+escape(value)+expires+path;   //转码并赋值
}
function getCookie(name) { 
	var nameEQ = name + "=";    
	var ca = document.cookie.split(';');//把cookie分割成组    
	for(var i=0;i < ca.length;i++) {    
		var c = ca[i];//取得字符串    
		while (c.charAt(0)==' ') {//判断一下字符串有没有前导空格    
			c = c.substring(1,c.length);//有的话，从第二位开始取    
		}    
		if (c.indexOf(nameEQ) == 0) {//如果含有我们要的name    
			return unescape(c.substring(nameEQ.length,c.length));//解码并截取我们要值    
		}    
	}    
	return false;
}
function delCookie(name){  
	setCookie(name,'',-1);
}