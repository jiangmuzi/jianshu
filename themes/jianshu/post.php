<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php');?>
<article class="post page">
	<h1 class="post-title"><?php $this->title() ?></h1>
	<div class="post-author">
		<a href="<?php $this->author->permalink();?>" class="avatar pull-left"><img src="<?php echo TeComment_Plugin::gravatarUrl($this->author->mail);?>" alt="" /></a>
		<div class="post-author-info">
			<p><span class="tag"><?php _e('作者');?></span> <a class="author-name" href="<?php $this->author->permalink();?>"><?php $this->author->screenName();?></a></p>
			<p class="post-meta">
				<span datetime="<?php $this->date('c'); ?>" title="<?php echo $this->date->format('Y-m-d H:i:s'); ?>"><?php $this->dateword(); ?></span>
				<span><?php _e('阅读');?> <?php $this->viewsNum(); ?></span>
				<span><?php _e('评论');?> <?php $this->commentsNum(); ?></span>
				<span><?php _e('喜欢');?> <?php $this->likesNum(); ?></span>
			</p>
		</div>
	</div>
	<div class="post-content markdown">
		<?php $this->content(); ?>
	</div>
	<div class="post-foot">
		<span class="post-tags"><i class="icon icon-tag"></i> <?php $this->category(' '); ?> <?php $this->tags(' ', true, ''); ?></span>
		<span class="pull-right" title="<?php _e('转载请注明出处');?>">&copy; <?php _e('著作权归作者所有');?></span>
	</div>
	<div class="post-tool">
		<div class="social">
			<div class="social-inner">
				<a class="social-left btn-like" href="#" data-cid="<?php $this->cid();?>"><i class="icon icon-like"></i> <?php _e('点赞');?> <span class="likes-num"><?php $this->likesNum();?></span></a>
				<div class="social-round">
					<div class="social-round-border"><span></span></div>
					<a class="social-round-inner" href="#"><?php _e('赏');?>
						<?php if(!empty($this->options->donateAlipay) || !empty($this->options->donateWechat)):?>
						<div class="donate">
							<h4><i class="icon icon-donate"></i> <?php _e('如果认为本文对您有所帮助请赞助本站');?></h4>
							<div class="donate-item">
								<?php if($this->options->donateAlipay):?>
								<div><img src="<?php $this->options->donateAlipay(); ?>" alt="alipay" /><h5><?php _e('支付宝扫一扫赞助');?></h5></div>
								<?php endif;?>
								<?php if($this->options->donateWechat):?>
								<div><img src="<?php $this->options->donateWechat(); ?>" alt="wechat" /><h5><?php _e('微信扫一扫赞助');?></h5></div>
								<?php endif;?>
							</div>
						</div>
						<?php endif;?>
					</a>
				</div>
				<div class="social-right share" href="#"><i class="icon icon-share"></i> <?php _e('分享');?>
					<div class="share-list">
						<div class="bdsharebuttonbox">
							<a href="#" class="bds_more" data-cmd="more"></a>
							<a href="#" class="bds_weixin" data-cmd="weixin" title="<?php _e('分享到微信');?>"></a>
							<a href="#" class="bds_sqq" data-cmd="sqq" title="<?php _e('分享到QQ好友');?>"></a>
							<a href="#" class="bds_tsina" data-cmd="tsina" title="<?php _e('分享到新浪微博');?>"></a>
							<a href="#" class="bds_mail" data-cmd="mail" title="<?php _e('分享到邮件分享');?>"></a>
							<a href="#" class="bds_copy" data-cmd="copy" title="<?php _e('分享到复制网址');?>"></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</article>
<div id="post-index-wrap">
	<div class="post-index-menu"><i class="icon icon-list btn-index-menu" title="<?php _e('文章目录'); ?>"></i> <?php _e('文章目录'); ?></div>
	<div class="post-index-box">
		<div class="post-index-highlight"></div>
		<ul id="post-index" class="post-index"></ul>
	</div>
</div>
<?php $this->need('comments.php'); ?>
<?php $this->need('footer.php');?>
