<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * 获取提示消息
 */
function getNotice(){
    $notice = Typecho_Cookie::get('__typecho_notice');
    if(empty($notice)){
        echo "''";
        return ;
    }
    $notice = json_decode($notice,true);
    $rs = array(
        'msg'=>$notice[0],
        'type'=>Typecho_Cookie::get('__typecho_notice_type')
    );
    Typecho_Cookie::delete('__typecho_notice');
    Typecho_Cookie::delete('__typecho_notice_type');
    echo json_encode($rs);
}
$screen_mode = Typecho_Cookie::get('read-mode','day');
?>
<!DOCTYPE HTML>
<html class="no-js">
<head <?php echo $screen_mode;?>>
    <meta charset="<?php $this->options->charset(); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta property="qc:admins" content="31010062301160516375" />
    <title><?php $this->archiveTitle(array(
            'category'  =>  _t('分类 %s 下的文章'),
            'search'    =>  _t('包含关键字 %s 的文章'),
            'tag'       =>  _t('标签 %s 下的文章'),
            'author'    =>  _t('%s 发布的文章')
        ), '', ' - '); ?><?php $this->options->title(); ?></title>
    <link rel="stylesheet" href="http://apps.bdimg.com/libs/fontawesome/4.2.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('css/style.css'); ?>">
    <!--[if lt IE 9]>
    <script src="http://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="http://cdn.staticfile.org/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <script src="http://apps.bdimg.com/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- 通过自有函数输出HTML头部信息 -->
    <?php $this->header(); ?>
    <script>
    window.notice = <?php getNotice();?>;
    window.siteUrl = '<?php $this->options->siteUrl();?>';
    window.siteKey = '<?php echo md5($this->options->index);?>';
    </script>
    <?php if($this->options->siteStat):?><?php $this->options->siteStat();?><?php endif;?>
</head>
<body class="<?php if($screen_mode=='night'){echo 'night-mode ';}?><?php if($this->is('post') || $this->is('user')): ?>single<?php endif; ?><?php if($this->is('user')): ?> user-page<?php endif; ?>">
<!--[if lt IE 8]>
    <div class="browsehappy" role="dialog"><?php _e('当前网页 <strong>不支持</strong> 你正在使用的浏览器. 为了正常的访问, 请 <a href="http://browsehappy.com/">升级你的浏览器</a>'); ?>.</div>
<![endif]-->
<div class="navbar navbar-jianshu shrink"> 
	<div class="dropdown">
		<a class="dropdown-toggle logo" data-target="#nav-menu" href="#"><?php if($this->options->logoText){$this->options->logoText();}else{echo mb_substr($this->options->title,0,1,'utf-8');} ?></a> 
		<ul class="dropdown-menu" id="nav-menu"> 
			<li><a href="<?php $this->options->siteUrl(); ?>"><i class="fa fa-home"></i><?php _e('首页 '); ?></a></li> 
		    <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
            <?php while($pages->next()): ?>
            <li><a href="<?php $pages->permalink(); ?>" title="<?php $pages->title(); ?>"><i class="fa fa-<?php $pages->slug(); ?>"> </i> <?php $pages->title(); ?></a></li>
            <?php endwhile; ?>
		</ul> 
	</div> 
</div> 
<div class="navbar-user">
    <?php if($this->user->hasLogin()): ?>
        <a class="login" href="<?php $this->options->logoutUrl(); ?>"> <i class="fa fa-sign-out"> </i> <?php _e('退出'); ?></a>
        <a class="login" href="<?php $this->options->adminUrl(); ?>"> <i class="fa fa-user"> </i> <?php $this->user->screenName(); ?></a>
    <?php else: ?>
        <a class="login" href="<?php $this->options->registerUrl(); ?>"><i class="fa fa-user"></i> <?php _e('注册 '); ?></a> 
	    <a class="login" href="<?php $this->options->loginUrl(); ?>"> <i class="fa fa-sign-in"> </i> <?php _e('登录'); ?> </a> 
	<?php endif; ?>
	<a class="set-view-mode" href="javascript:void(0)">
	   <i class="fa <?php if($screen_mode=='day'){echo 'fa-moon-o';}else{ echo 'fa-sun-o';}?>"> </i>
    </a> 
</div> 
<div class="navbar navbar-jianshu">
	<div class="dropdown"> 
		<a class="logo<?php if($this->is('index')): ?> active<?php endif; ?>" role="button" data-original-title="个人主页" data-container="div.expanded" href="<?php $this->options->siteUrl(); ?>"> <b> <?php if($this->options->logoText){$this->options->logoText();}else{echo mb_substr($this->options->title,0,1,'utf-8');} ?></b> <i class="fa fa-home"> </i> <span class="title"> <?php _e('首页 '); ?> </span> </a>
		<?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
        <?php while($pages->next()): ?>
        <a<?php if($this->is('page', $pages->slug)): ?> class="active"<?php endif; ?> href="<?php $pages->permalink(); ?>" title="<?php $pages->title(); ?>"><i class="fa fa-<?php $pages->slug(); ?>"> </i> <span class="title"> <?php $pages->title(); ?> </span> </a>
        <?php endwhile; ?> 
	</div> 
</div>
<div class="wrapper">
<div class="sidebar">
    <div class="cover-img" style="background-image: url(<?php if ($this->options->bgPhoto){$photo = explode(',',$this->options->bgPhoto);echo $photo[array_rand($photo,1)];}else{$this->options->themeUrl('img/defaultBg.jpg');}?>)"></div>
    <div class="bottom-block">
	  <img class="avatar" width="72" src="<?php echo gravatarUrl('master@lixianhua.com',72); ?>" alt="" />
      <h1><?php $this->options->title(); ?></h1>
      <p><?php $this->options->description(); ?></p>
    </div>
</div>
<div class="main">
    <div class="page-title clearfix"> 
      <ul class="navigation clearfix"> 
       <li><a href="<?php $this->options->siteUrl(); ?>"><?php _e('首页'); ?></a> &raquo;</li>
        <?php if ($this->is('index')): ?><!-- 页面为首页时 -->
    		<li class="active"><a href="javascript:;"><?php _e('最近更新'); ?></a></li>
    	<?php elseif ($this->is('post')): ?><!-- 页面为文章单页时 -->
    		<li class="active"><?php $this->category(); ?></li>
    	<?php elseif ($this->is('user','login')): ?><!-- 页面为文章单页时 -->
    		<li class="active"><a href="javascript:;"><?php _e('登录'); ?></a></li>
    	<?php elseif ($this->is('user','register')): ?><!-- 页面为文章单页时 -->
    		<li class="active"><a href="javascript:;"><?php _e('注册'); ?></a></li>
    	<?php elseif ($this->is('user','index')): ?><!-- 页面为文章单页时 -->
    		<li class="active"><a href="javascript:;"><?php _e('用户中心'); ?></a></li>
    	<?php else: ?><!-- 页面为其他页时 -->
    		<li class="active"><a href="javascript:;"><?php $this->archiveTitle(' &raquo; ','',''); ?></a></li>
    	<?php endif; ?>
       <li class="search"> 
        <form class="search-form" method="post" action="./" role="search"> 
    	 <input type="text" name="s" class="text" placeholder="<?php _e('输入关键字搜索'); ?>" autocomplete="off"/>
         <button type="submit" class="btn s3"><i class="fa fa-search"></i></button>
        </form>
        </li> 
      </ul> 
     </div>