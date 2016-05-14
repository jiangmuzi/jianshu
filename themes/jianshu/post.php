<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<div class="main-inner">
    <article class="post" itemscope itemtype="http://schema.org/BlogPosting">
        <div class="post-header">
			<div class="post-author clearfix">
				<a class="avatar fleft" href="<?php $this->author->permalink(); ?>"><img width="48" src="<?php echo Tools_Plugin::gravatarUrl($this->author->mail,48); ?>" alt="" /></a>
				<p><span class="label"><?php _e('作者');?></span> <a href="<?php $this->author->permalink(); ?>"><?php $this->author(); ?></a> <span title="<?php _e('最后编辑于');echo date('Y.m.d H:i:s',$this->modified); ?>"><?php $this->date('Y.m.d H:i:s'); ?></span></p>
				<p><?php _e('写了%d篇文章,',$this->author->postsNum);?><?php _e('回复%d人,',$this->author->commentsNum);?></p>
			</div>
			<h2 class="post-title"><?php $this->title() ?></h2>
			<div class="post-meta">
				<a href="<?php $this->permalink() ?>"><?php _e('阅读：'); $this->viewsNum(); ?></a><em>·</em>
				<a href="<?php $this->permalink() ?>#comments"><?php $this->commentsNum('评论：%d'); ?></a><em>·</em>
				<span><?php _e('喜欢：'); $this->likesNum(); ?></span>
			</div>
		</div>
        <div class="post-content">
            <?php $this->content(); ?>
        </div>
		<div class="post-tool">
			<a class="btn-like" href="javascript:void(0);" data-cid="<?php $this->cid();?>" title="<?php $this->likesNum();?>"><i class="fa fa-heart-o"></i> 赞 | <span><?php $this->likesNum();?></span></a>
			<a class="btn-donate"  href="javascript:void(0);">赏</a>
		</div>
        <div class="post-tags"><?php _e('标签：'); ?><?php $this->tags('', true, 'none'); ?></div>
    </article>
	
    <?php $this->need('comments.php'); ?>
</div><!-- end #main-->
<?php $this->need('footer.php'); ?>
