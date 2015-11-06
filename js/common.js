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
		if($(target).hasClass('active')){
			$(target).removeClass('active')
		}else{
			$(target).addClass('active')
		}
		return false;
	});
	
	$(document).bind('click',function(){
		$('.dropdown-menu.active').removeClass('active');
	});
	if(window.isArchive){
		$(window).bind("scroll", ajaxLoadArchives);
	}
	
	$('.btn-like').click(function(){
		var that = $(this),num = parseInt(that.find('.post-likesnum').text()), cid = $(this).data('cid');
		if(cid===undefined) return false;
		$.get(window.siteUrl+'index.php/action/likes?cid='+cid).success(function(rs){
			if(rs.status==1){
				that.find('.post-likesnum').text(num+1);
				dalert(rs.msg===undefined ? '成功点赞!' : rs.msg,'success');
			}else{
				dalert(rs.msg===undefined ? '操作出错!' : rs.msg,'error');
			}
			
		});
		return false;
	});
	//弹出框
	$('.btn-dialog').click(function(){
		var d = $(this).data('dialog');
		if(d===undefined) return false;
		
		if($(d).length<1) return false;
		$('<div id="overlay"></div>').appendTo($('body')).fadeIn(300).click(function(){
			$(this).remove();
			$('.dialog').removeAttr('style');
		});
		var w = $(d).width(),h = $(d).height();
		$(d).css('margin-top',-h/2).css('margin-left',-w/2).show();
		return false;
	});
	backToTopFun();
	showNotice();
});

function showNotice(){
	if(window.notice=='') return false;
	dalert(window.notice.msg,window.notice.type);
}

function dalert(msg,type,time){
	type = type==='error' ? 'error' :'success';
	time = time === undefined ? (type=='success' ? 1500 : 3000) : time;
	var html = '<div class="dialog '+type+'">'+msg+'</div>';
	$(html).css('top',80).appendTo($('body')).fadeIn(300,function(){
		setTimeout(function(){
			$('body > .dialog').remove();
		},1500);
	});
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