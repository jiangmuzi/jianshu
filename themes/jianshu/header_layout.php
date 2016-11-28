<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * 未加载functions.php则自动加载,防止因404报错
 */
if(!function_exists('getReadMode')) include_once('functions.php');
?>
<!DOCTYPE HTML>
<html class="no-js">
<head>
    <meta charset="<?php $this->options->charset(); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title><?php $this->archiveTitle(array(
            'category'  =>  _t('分类：%s'),
            'search'    =>  _t('搜索：%s'),
            'tag'       =>  _t('标签：%s'),
            'author'    =>  _t('%s 发布的文章')
        ), '', ' - '); ?><?php $this->options->title(); ?></title>
    <link rel="stylesheet" href="<?php $this->options->themeUrl('css/style.css'); ?>">
	<?php if($this->options->iconCss):?><style type="text/css"><?php $this->options->iconCss();?></style><?php endif;?>
    <!--[if lt IE 9]>
    <script src="//cdnjscn.b0.upaiyun.com/libs/html5shiv/r29/html5.min.js"></script>
    <script src="//cdnjscn.b0.upaiyun.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
	<script src="<?php $this->options->themeUrl('js/common.js'); ?>"></script>
    <?php $header = "generator=&template=&pingback=&xmlrpc=&wlw=&commentReply="; if($this->request->isAjax()){$header .='&antiSpam=';} $this->header($header); ?>
</head>
<body class="<?php getReadMode();if($this->is('single')): ?> single<?php endif; ?>">
<!--[if lt IE 8]>
    <div class="browsehappy" role="dialog"><?php _e('当前网页 <strong>不支持</strong> 你正在使用的浏览器. 为了正常的访问, 请 <a href="http://browsehappy.com/">升级你的浏览器</a>'); ?>.</div>
<![endif]-->
<div id="nav">
	<?php
	if($this->options->logoText){
		$logoText = mb_strlen($this->options->logoText)>1 ? Typecho_Common::subStr($this->options->logoText,0,1,'') : $this->options->logoText; 
	}else{
		$logoText = Typecho_Common::subStr($this->options->title,0,1,'');
	}
	?>
	<nav class="nav-menu">
		<a class="site-name<?php if($this->is('index')): ?> current<?php endif; ?>" href="<?php $this->options->siteUrl(); ?>" title="<?php $this->options->description() ?>"><?php _e($logoText);?></a>
		<a class="site-index<?php if($this->is('index')): ?> current<?php endif; ?>" href="<?php $this->options->siteUrl(); ?>"><i class="fa fa-home"></i><span><?php _e('首页'); ?></span></a>
		<?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
		<?php while($pages->next()): ?>
		<a<?php if($this->is('page', $pages->slug)): ?> class="current"<?php endif; ?> href="<?php $pages->permalink(); ?>" title="<?php $pages->title(); ?>"><i class="fa fa-<?php $pages->slug(); ?>"></i><span><?php $pages->title(); ?></span></a>
		<?php endwhile; ?>
	</nav>
	
</div><!-- end #header -->
<div class="nav-user">
	<a class="btn-search" href="#"><i class="fa fa-search"></i></a>
	<a class="btn-read-mode" href="#"><i class="<?php getReadMode(true);?>"></i></a>
	<?php if($this->user->hasLogin()): ?>
		<a href="<?php $this->options->adminUrl(); ?>"><?php $this->user->name(); ?></a>
		<a href="<?php $this->options->logoutUrl(); ?>"><?php _e('退出'); ?></a>
	<?php else: ?>
		<a href="<?php $this->options->loginUrl(); ?>"><?php _e('登录'); ?></a>
	<?php endif; ?>
</div>
<div id="wrapper" class="clearfix">
<div id="cover" <?php if($this->is('single')): ?>style="display:none;"<?php endif; ?>>
	<div class="cover-img" style="background-image:url('<?php if ($this->options->bgPhoto){$photo = explode(',',$this->options->bgPhoto);echo $photo[array_rand($photo,1)];}else{$this->options->themeUrl('img/bg.jpg');}?>')"></div>
	<div class="cover-info">
	<?php if($this->options->avatarUrl):?>
		<img class="avatar" width="72" src="<?php $this->options->avatarUrl();?>" alt="" />
	<?php else:?>
	  <h3><?php $this->options->title(); ?></h3>
	<?php endif;?>
      <p><?php $this->options->description(); ?></p>
      <div class="cover-sns">
		<div class="btn btn-weibo">
			<a href="javascript:void(0);"><i class="fa fa-weibo"></i></a>
			<div class="qrcode"><img src="<?php $this->options->themeUrl('img/site.png'); ?>" alt="" /></div>
			<div class="qrcode-arrow"></div>
		</div>
		<div class="btn btn-weixin">
			<a class="" href="javascript:void(0);"><i class="fa fa-weixin"></i></a>
			<div class="qrcode"><img src="<?php $this->options->themeUrl('img/site.png'); ?>" alt="" /></div>
			<div class="qrcode-arrow"></div>
		</div>
	  </div>
    </div>
</div>

<div id="body">
<div class="main" id="main">