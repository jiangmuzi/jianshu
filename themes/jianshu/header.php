<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;
if($this->request->isAjax()) return;
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
            'author'    =>  _t('作者：%s')
        ), '', ' - '); ?><?php $this->options->title(); ?></title>

    <link href="<?php $this->options->siteUrl('favicon.ico'); ?>" rel="icon" />
    <link rel="stylesheet" href="<?php $this->options->themeUrl('css/icon.css'); ?>">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('css/global.css'); ?>">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('css/markdown.css'); ?>">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('css/style.css'); ?>">
    <?php if($this->options->siteExtendStyle):?>
    <style type="text/css"><?php $this->options->siteExtendStyle();?></style>
    <?php endif; ?>
    <!--[if lt IE 9]>
    <script src="//cdnjscn.b0.upaiyun.com/libs/html5shiv/r29/html5.min.js"></script>
    <script src="//cdnjscn.b0.upaiyun.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <?php $this->header(); ?>
</head>
<body>
<div id="wrapper" class="<?php if($this->is('post') || $this->is('page')){_e('single');}?><?php if('mini' == Typecho_Cookie::get('menuSize')){_e(' mini-nav');}
	if('mini' == Typecho_Cookie::get('screenSize')){_e(' mini');}
	if('dark' == Typecho_Cookie::get('themeMode')){_e(' theme-dark');}?>">
    <header id="header">
		<a class="site-name<?php if($this->is('index')): ?> current<?php endif; ?>" href="<?php $this->options->siteUrl(); ?>" title="<?php $this->options->description() ?>"><?php getLogoText();?></a>
        <nav class="nav">
            <?php TeMenu_Plugin::show('header',array(
                'wrapTag'=>'',
                'itemTag'=>'',
                'childTag'=>'',
                'item'=>'<a {current} href="{url}" title="{name}">{icon} <span>{name}</span></a>')); ?>
        </nav>
    </header>
    <div id="cover" <?php showCover($this);?>>
		<div class="cover-info">
            <?php if($this->options->avatarUrl):?>
                <img src="<?php $this->options->avatarUrl();?>" alt="<?php $this->options->title(); ?>" class="avatar" />
            <?php endif;?>
			<h1><?php $this->options->title(); ?></h1>
			<p><?php $this->options->description(); ?></p>
			<div class="follow-me">
				<?php if($this->options->weibo):?>
				<a href="<?php $this->options->weibo(); ?>" class="icon icon-weibo" target="_blank"></a>
				<?php endif;?>
				<?php if($this->options->wechat):?>
				<a href="javascript:;" class="icon icon-wechat"><img src="<?php $this->options->wechat(); ?>" alt="" /></a>
				<?php endif;?>
				<?php if($this->options->github):?>
				<a href="<?php $this->options->github(); ?>" class="icon icon-github" target="_blank"></a>
				<?php endif;?>
			</div>
		</div>
	</div>
    <div id="body">
        <div class="body-header">
			<a href="#" class="btn btn-default btn-nav-size pull-left hidden-xs"><i class="icon icon-<?php if('mini' == Typecho_Cookie::get('menuSize')){_e('indent');}else{_e('outdent');}?>"></i></a>
			<a href="#" class="btn btn-default btn-screen-size pull-left hidden-xs"><i class="icon icon-<?php if('mini' == Typecho_Cookie::get('screenSize')){_e('expand');}else{_e('compress');}?>"></i></a>
			<div class="site-search pull-left">
                <form id="search" class="form" method="post" action="<?php $this->options->siteUrl(); ?>" role="search">
                    <label for="s" class="sr-only"><?php _e('搜索关键字'); ?></label>
                    <input type="text" name="s" class="form-control" placeholder="<?php _e('搜索'); ?>" />
                    <button type="submit" class="btn btn-default" title="<?php _e('搜索'); ?>"><i class="icon icon-search"></i></button>
                </form>
            </div>
			<?php if($this->user->hasLogin()):?>
				<a href="<?php $this->options->logoutUrl(); ?>" class="btn btn-default pull-right" title="<?php _e('退出登录'); ?>"><i class="icon icon-logout"></i></a>
				<a class="btn btn-default pull-right" href="<?php $this->options->adminUrl(); ?>" title="<?php _e('后台'); ?>"><i class="icon icon-setting"></i> <?php $this->user->screenName(); ?> </a>
			<?php else:?>
                <?php if($this->options->allowRegister):?>
                <a href="<?php $this->options->adminUrl('register.php'); ?>" class="btn btn-default pull-right" title="<?php _e('注册'); ?>"><i class="icon icon-register"></i></a>
                <?php endif;?>
                <a href="<?php $this->options->adminUrl('login.php'); ?>" class="btn btn-default pull-right" title="<?php _e('登录'); ?>"><i class="icon icon-login"></i></a>
            <?php endif;?>
            <a href="#" class="btn btn-default btn-mode pull-right"><i class="icon icon-<?php if('dark' == Typecho_Cookie::get('themeMode')){_e('sun');}else{_e('moon');}?>"></i></a>
            <a href="#" class="btn btn-default btn-search pull-right visible-xs-block"><i class="icon icon-search"></i></a>
        </div>
        <div id="main" class="clearfix">
    
