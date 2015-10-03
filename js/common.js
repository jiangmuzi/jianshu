/**
 * 
 */
$(function(){
	$('.set-view-mode').click(function(){
		switchReadMode();
	});
	$(window).bind("scroll", backToTopFun);
	
	$('.back-to-top').click(function() {
        $("html, body").animate({ scrollTop: 0 }, 120);
        return false;
	});
	
	$('.dropdown-toggle').click(function(){
		var target = $(this).data('target');
		console.log(target);
		if($(target).hasClass('active')){
			$(target).removeClass('active')
		}else{
			$(target).addClass('active')
		}
		return false;
	});
	$('.donate-tab li').click(function(){
		var num=$(this).data('num');
		$(this).addClass('active').siblings().removeClass('active');
		$('#donate-form').find('input[name=payAmount]').val(num);
		$('#donate-form').find('button').text('赞助：￥'+num);
	});
	//帐号解绑
	$('.sns-btn .active').click(function(){
		var type = $(this).data('type');
		$.get('/user/bind?type='+type).success(function(rs){
			if(rs.status==1){
				window.location.href = window.location.href;
			}
		});
		return false;
	});
	
	$('.bind-tab a').click(function(){
		var that = $(this),li = that.parent(),id = that.attr('href');
		if(li.hasClass('active')){
			return false;
		}
		li.addClass('active').siblings().removeClass('active');
		$(id).show().siblings('.tab-item').hide();
		return false;
	});
	
	$(document).bind('click',function(){
		$('.dropdown-menu.active').removeClass('active');
	});
	if(window.isArchive){
		$(window).bind("scroll", ajaxLoadArchives);
	}
	backToTopFun();
	showNotice();
});
function showNotice(){
	if(window.notice=='') return false;
	showAlert(window.notice.msg,window.notice.type,2000);
}
function showAlert(msg,type,time){
	var type = type==='error' ? 'alert-error' :'';
	var html = '<div id="ui-alert" class="'+type+'">';
		html += msg;
		html += '</div>';
	$(html).prependTo($('body'));
	setTimeout(function(){
		$('#ui-alert').animate({ top: -50}, 500);
	},time);
}
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
function switchReadMode(){
	var btn = $('.set-view-mode');
	var next_mode = $('body').hasClass('night-mode') ? 'day' : 'night';

    if(next_mode!='day'){
    	$('body').addClass('night-mode');
    	btn.find('i').attr('class','fa fa-sun-o');
    }else{
    	$('body').removeClass('night-mode');
		btn.find('i').attr('class','fa fa-moon-o');
	}
    setCookie('read-mode', next_mode, 86400);
}
function setCookie(name,value,expires){  
    expires = new Date(+new Date + 1000 * 60 * 60 * 24 * expires);
    expires = ';expires=' + expires.toGMTString();
    path = ';path=/';
    document.cookie = window.siteKey+name+"="+escape(value)+expires+path;   //转码并赋值
}