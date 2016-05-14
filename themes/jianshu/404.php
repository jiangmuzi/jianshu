<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
<div class="main-inner">
	<article class="post" itemscope itemtype="http://schema.org/BlogPosting">
        <div class="post-header">
			<h2 class="post-title"><?php _e('哎哟～您访问的页面弄丢了'); ?></h2>
		</div>
        <div class="post-content" itemprop="articleBody">
            <p><?php _e('随便逛逛: '); ?></p>
			<ul>
				<?php $this->widget('Widget_Metas_Category_List')->parse('<li><a href="{permalink}">{name}</a></li>'); ?>
			</ul>
        </div>
    </article>
</div><!-- end #content-->
<?php $this->need('footer.php'); ?>
