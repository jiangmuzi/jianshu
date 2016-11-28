<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;?>
<?php if(!$this->request->isAjax()) $this->need('header_layout.php');
?>
<div class="page-title">
	<ul>
		<li <?php if($this->is('index')): ?>class="active"<?php endif; ?>><a href="<?php $this->options->siteUrl(); ?>">最新</a></li>
		<?php if($this->is('post')): ?>
		<li class="active">
			<?php $categories = $this->categories;
				if($categories):
			?>
				<a href="<?php _e($categories[0]['permalink']); ?>"><?php _e($categories[0]['name']); ?></a>
			<?php endif; ?>
		</li>
		<?php endif; ?>
		<?php if($this->is('archive')):?>
		<li class="active">
			<a href="javascript:jBlog.goTop();"><?php _e($this->getArchiveTitle()); ?></a>
		</li>
		<?php endif; ?>
		<?php if(pluginExists('Jianshu')):?>
		<li><a href="javascript:jBlog.ajaxGetExplore();" title="<?php _e('随机显示一篇文章');?>"><?php _e('探索');?></a></li>
		<?php endif;?>
		<li class="page-search">
			<form id="search" method="post" action="./" role="search">
				<label for="s" class="sr-only"><?php _e('搜索关键字'); ?></label>
				<input type="text" name="s" class="text" placeholder="<?php _e('输入关键字搜索'); ?>" />
				<button type="submit" class="submit" title="<?php _e('搜索'); ?>"><i class="fa fa-search"></i></button>
			</form>
		</li>
	</ul>
</div>

