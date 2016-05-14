<?php
/**
 * 友情链接
 *
 * @package custom
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<div class="main-inner">
    <article class="post" itemscope itemtype="http://schema.org/BlogPosting">
        <div class="post-header">
			<h2 class="post-title"><?php $this->title() ?></h2>
		</div>
        <div class="post-content" itemprop="articleBody">
            <?php $this->content(); ?>
			<ul class="tag-list flinks">
				<?php Links_Plugin::output(null,0,'');?>
			</ul>
        </div>
		
    </article>
    <?php $this->need('comments.php'); ?>
</div><!-- end #main-->
<?php $this->need('footer.php'); ?>
