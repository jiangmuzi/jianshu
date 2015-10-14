<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
<div class="main-container">
    <article class="post preview" itemscope itemtype="http://schema.org/BlogPosting">
		<div class="post-author clearfix">
			<a class="fl" href="<?php $this->author->permalink(); ?>" title="<?php $this->author(); ?>"><img class="avatar" width="32" src="<?php echo gravatarUrl($this->author->mail,32); ?>" alt="" /></a>
			<a href="<?php $this->author->permalink(); ?>"><?php $this->author(); ?></a><?php _e('发布在');?><?php $this->category(','); ?>
			<span><?php $this->date('Y.m.d H:i:s'); ?></span>
		</div>
        <h1 class="post-title" itemprop="name headline"><?php $this->title() ?></h1>
        <ul class="post-meta clearfix">
            <li><?php _e('阅读');$this->viewsNum(); ?></li>
            <li><a href="<?php $this->permalink() ?>#comments"><?php $this->commentsNum('评论%d'); ?></a></li>
			<li><?php _e('喜欢');$this->likesNum(); ?></li>
            <li class="post-qrcode"><i class="fa fa-qrcode"></i>
                <div id="qrcode-img"></div>
            </li>
        </ul>
        <div class="post-content" itemprop="articleBody">
            <?php parseContent($this); ?>
        </div>
		<div class="post-tool">
			<span class="post-like"><a class="btn s3 btn-like" data-cid="<?php $this->cid();?>" href="#"><i class="fa fa-thumbs-up"></i> <?php _e('赞'); ?> <span class="post-likesnum"><?php $this->likesNum();?></span></a></span>
			<span class="post-share"><a class="btn s3 btn-dialog" data-dialog="#dialog-share" href="#"><i class="fa fa-share-alt"></i> <?php _e('分享'); ?></a></span>
			<span class="post-donate">
				<a href="#" class="btn s3 btn-dialog" data-dialog="#dialog-donate"><?php _e('赏'); ?></a>
				
			</span>
			<div class="dialog" id="dialog-donate" >
				<h4><?php _e('您可以选择一种方式赞助本站'); ?></h4>
				<form id="alipay-form" action="https://shenghuo.alipay.com/send/payment/fill.htm" method="POST" target="_blank" accept-charset="GBK">
					<input type="hidden" name="optEmail" value="<?php $this->options->alipayAccount();?>">
					<input type="hidden" name="payAmount" value="<?php $this->options->alipayAmount();?>">
					<input type="hidden" name="title" value="<?php _e('赞助');$this->options->title();?>">
					<input type="hidden" name="memo" value="<?php _e('《');$this->title();_e('》写的很好，打赏一个!');?>">
					<input title="点击此按钮赞助本站" name="pay" src="<?php $this->options->themeUrl('img/alipay_btn.png')?>" type="image" value="赞助本站">
				</form>
				<p><?php _e('支付宝扫码赞助'); ?></p>
				<img src="<?php $this->options->themeUrl('img/alipay.png')?>" alt="支付宝扫码赞助" width="200" />
			</div>
			<div class="dialog" id="dialog-share">
				<div class="bdsharebuttonbox" data-tag="share_1">
					<a class="bds_tsina fa fa-weibo" data-cmd="tsina"></a>
					<a class="bds_weixin fa fa-weixin" data-cmd="weixin"></a>
					<a class="bds_mail fa fa-envelope" data-cmd="mail"></a>
					<a class="bds_more fa fa-plus" data-cmd="more"></a>
				</div>
				<script>
					window._bd_share_config = {
						common:{
							bdText:'<?php $this->title();?>',
							bdDesc:'<?php $this->description();?>',
							bdUrl:'<?php $this->permalink();?>',
							bdPic:''
						},
						share : [{
							bdCustomStyle:'<?php $this->options->themeUrl('css/bdshare.css');?>'
						}],
					}
					with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?cdnversion='+~(-new Date()/36e5)];
				</script>
			</div>
		</div>
        
		<div class="post-foot clearfix">
			<div class="post-tags"><?php _e('标签: '); ?><?php $this->tags(', ', true, 'none'); ?></div>
		</div>
    </article>
    
    <ul class="post-near">
        <li>上一篇: <?php $this->thePrev('%s','没有了'); ?></li>
        <li>下一篇: <?php $this->theNext('%s','没有了'); ?></li>
    </ul>
    <?php $this->need('comments.php'); ?>
</div>
<?php $this->need('footer.php'); ?>