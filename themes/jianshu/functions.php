<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

function themeConfig($form) {
    // 1. 基础设置
    $logoText = new Typecho_Widget_Helper_Form_Element_Text('logoText', NULL, NULL, _t('网站文字LOGO'), _t('网站文字LOGO，单个文字;为空时将获取网站标题第一个文字'));
    $logoText->setAttribute('tab','base');	
    $form->addInput($logoText);
    
	$avatarUrl = new Typecho_Widget_Helper_Form_Element_Text('avatarUrl', NULL, NULL, _t('博主头像'), _t('博主头像地址，为空则不显示'));
    $avatarUrl->setAttribute('tab','base');	
    $form->addInput($avatarUrl);
	
    $siteIcp = new Typecho_Widget_Helper_Form_Element_Text('siteIcp', NULL, NULL, _t('网站备案号'), _t('在这里填入网站备案号'));
    $siteIcp->setAttribute('tab','base');	
    $form->addInput($siteIcp);

    $siteStat = new Typecho_Widget_Helper_Form_Element_Textarea('siteStat', NULL, NULL, _t('统计代码'), _t('在这里填入网站统计代码'));
    $siteStat->setAttribute('tab','base');	
    $form->addInput($siteStat);

    // 2. 显示设置
    $siteBanner = new Typecho_Widget_Helper_Form_Element_Text('siteBanner', NULL, NULL, _t('幻灯片'), _t('在这里填入幻灯片文章的cid；支持置顶多篇文章；多篇文请用“,”分隔'));
    $siteBanner->setAttribute('tab','show');	
    $form->addInput($siteBanner);

    $siteCover = new Typecho_Widget_Helper_Form_Element_Text('siteCover', NULL, NULL, _t('网站背景图'), _t('在这里填入背景图网址；支持多张图随机显示；多张图请用“,”分隔'));
    $siteCover->setAttribute('tab','show');	
    $form->addInput($siteCover);

    $siteExtendStyle = new Typecho_Widget_Helper_Form_Element_Textarea('siteExtendStyle', NULL, NULL, _t('附加样式'), _t('附加样式CSS代码,不需要使用 <code>style</code>标签'));
    $siteExtendStyle->setAttribute('tab','show');	
    $form->addInput($siteExtendStyle);

    $showThumbnail = new Typecho_Widget_Helper_Form_Element_Radio('showThumbnail',
        array('0' => _t('不显示'),
            '1' => _t('显示')),
        '1', _t('显示缩略图'));
    $showThumbnail->setAttribute('tab','show');
    $form->addInput($showThumbnail);

    // 3. 功能设置
    $cdn = new Typecho_Widget_Helper_Form_Element_Text('cdn', NULL, NULL, _t('CDN地址'), _t('静态资源CDN地址'));
    $cdn->setAttribute('tab','func');	
    $form->addInput($cdn);

    $lazyLoad = new Typecho_Widget_Helper_Form_Element_Radio('lazyLoad',
        array('0' => _t('禁用'),
            '1' => _t('启用')),
        '1', _t('图片按需加载'), _t('是否启用图片按需加载；启用时未显示在屏幕的图片将不会加载'));
    $lazyLoad->setAttribute('tab','func');
    $form->addInput($lazyLoad);

    $usePjax = new Typecho_Widget_Helper_Form_Element_Radio('usePjax', array('0' => _t('不启用'), '1' => _t('启用')), '0', _t('是否启用Pjax'),
        _t('提升用户体验和资源利用率;适用于现代浏览器'));
    $usePjax->setAttribute('tab','func');
    $form->addInput($usePjax);

    // 4. 缩略图设置
    // 缩略图间隔标识符
    $thumbnailIdent = new Typecho_Widget_Helper_Form_Element_Text('thumbnailIdent', NULL, '!', _t('缩略图间隔标识符'),_t('用于分隔图片 URL 和处理信息，有 3 种可选，分别是：!（感叹号/默认值）、-（中划线）和 _（下划线）'));
    $thumbnailIdent->setAttribute('tab','thumbnail');
    $form->addInput($thumbnailIdent);
    // 缩略图默认宽度
    $thumbnailW = new Typecho_Widget_Helper_Form_Element_Text('thumbnailW', NULL, 200, _t('缩略图默认宽度'),_t('缩略图默认显示的宽度'));
    $thumbnailW->setAttribute('tab','thumbnail');
    $form->addInput($thumbnailW);
    // 缩略图默认高度
    $thumbnailH = new Typecho_Widget_Helper_Form_Element_Text('thumbnailH', NULL, 140, _t('缩略图默认高度'),_t('缩略图默认显示的高度'));
    $thumbnailH->setAttribute('tab','thumbnail');
    $form->addInput($thumbnailH);
    // 缩略图默认质量
    $thumbnailQ = new Typecho_Widget_Helper_Form_Element_Text('thumbnailQ', NULL, 75, _t('缩略图默认质量'),_t('缩略图的图片质量'));
    $thumbnailQ->setAttribute('tab','thumbnail');
    $form->addInput($thumbnailQ);

    $thumbnailDefault = new Typecho_Widget_Helper_Form_Element_Text('thumbnailDefault', NULL, NULL, _t('默认缩略图'),_t('在内容没有缩略图时，显示默认缩略图'));
    $thumbnailDefault->setAttribute('tab','thumbnail');
    $form->addInput($thumbnailDefault);
    // 缩略图模式
    $thumbnailMode = new Typecho_Widget_Helper_Form_Element_Select('thumbnailMode',
        array(0=>'等比例缩放',1=>'缩放后填充',2=>'居中裁剪',3=>'左上角裁剪',4=>'右下角裁剪',5=>'固定尺寸缩放'), 0 ,_t('缩略图模式'),_t('缩略图模式，不同模式进行缩略图的处理方式不同;仅本地模式有效'));
    $thumbnailMode->setAttribute('tab','thumbnail');
    $form->addInput($thumbnailMode);

    // 缩略图地址
    $thumbnailFormat = new Typecho_Widget_Helper_Form_Element_Text('thumbnailFormat', NULL, '{thumbnail}/{image}{ident}m/{mode}/w/{width}/h/{height}', _t('缩略图地址'),_t('支持的参数有<code>thumbnail</code>:自带的缩略图生成,<code>image</code>:图片上传地址usr/uploads下的路径,<code>ident</code>:标识符,<code>mode</code>:模式,
                        <code>width</code>:宽度,<code>height</code>:高度,<code>quality</code>:图片质量'));
    $thumbnailFormat->setAttribute('tab','thumbnail');
    $form->addInput($thumbnailFormat);

    // 5. 捐赠设置
	$donateAlipay = new Typecho_Widget_Helper_Form_Element_Text('donateAlipay', NULL, NULL, _t('支付宝收款地址'), _t('支付宝收款二维码图片地址'));
	$donateAlipay->setAttribute('tab','donate');	
    $form->addInput($donateAlipay);

    $donateWechat = new Typecho_Widget_Helper_Form_Element_Text('donateWechat', NULL, NULL, _t('微信收款地址'), _t('微信收款二维码图片地址'));
	$donateWechat->setAttribute('tab','donate');	
    $form->addInput($donateWechat);
	// 6. follow me
	$github = new Typecho_Widget_Helper_Form_Element_Text('github', NULL, NULL, _t('Github'), _t('Github链接地址'));
	$github->setAttribute('tab','follow');	
    $form->addInput($github);
	
	$weibo = new Typecho_Widget_Helper_Form_Element_Text('weibo', NULL, NULL, _t('微博'), _t('微博链接地址'));
	$weibo->setAttribute('tab','follow');	
    $form->addInput($weibo);
	
	$wechat = new Typecho_Widget_Helper_Form_Element_Text('wechat', NULL, NULL, _t('微信'), _t('微信、公众号二维码图片地址'));
	$wechat->setAttribute('tab','follow');	
    $form->addInput($wechat);
	
	$qqqun = new Typecho_Widget_Helper_Form_Element_Text('qqqun', NULL, NULL, _t('QQ群'), _t('微信、公众号二维码图片地址'));
	$qqqun->setAttribute('tab','follow');	
    $form->addInput($qqqun);

    parseTabNav($form,array('base'=>'基础设置','show'=>'显示设置','func'=>'功能设置','thumbnail'=>'缩略图','donate'=>'捐赠设置','follow'=>'社交网站'));
}

function parseTabNav($form, $tabsName = array('base'=>'基本设置')){
    $tabConName = 'extends-tab-item-' . Typecho_Common::randString(4);
    $tabNav = new Typecho_Widget_Helper_Layout('ul', array('class'=>'typecho-option-tabs extends-tabs-nav','style'=>'overflow:hidden;','for-tab-item'=>$tabConName));
    foreach($tabsName as $index=>$tabName){
        $tab = new Typecho_Widget_Helper_Layout('li', array('for'=>$index));
        $tab->html('<a href="javascript:;">'.$tabName.'</a>');
        $tabNav->addItem($tab);
    }
    
    $items = $form->getItems();
    $form->addItem($tabNav);
    foreach($items as $item){
        $form->removeItem($item);
        $tabIndex = $item->getAttribute('tab');
        if(empty($tabIndex)){
            $item->setAttribute('tab','base');
        }
        $item->setAttribute('class',$item->getAttribute('class').' extends-tab-item');
        $item->setAttribute('tab-item-name',$tabConName);
        $form->addItem($item);
    }
}

function getLogoText(){
    if(Helper::options()->logoText){
		$logoText = Helper::options()->logoText; 
	}else{
		$logoText = Helper::options()->title; 
	}
    echo Typecho_Common::subStr($logoText,0,1,'');
}
function showCover($archive){	
	$siteCover = Helper::options()->siteCover;
	if(empty($siteCover)) return;
	$siteCover = explode(',',$siteCover);
	if($count = count($siteCover) >1){
		$cover = $siteCover[rand(0,($count-1))];
	}else{
		$cover = $siteCover[0];
	}
	echo 'style="background-image: url(\''.$cover.'\')"';
}
/**
 * 重写评论显示函数
 */
function threadedComments($comments, $options){
	$html = TeComment_Plugin::parseCommentHtml($comments, $options);
	
	$children = '';
	if ($comments->children) {
		ob_start();
        $comments->threadedComments();
		$children = ob_get_clean();
    }
	$html = str_replace('>{children}<','>'.$children.'<',$html);
	echo $html;
}