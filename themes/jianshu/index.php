<?php
/**
 * 仿简书主题
 * 
 * @package JianShu
 * @author 绛木子
 * @version 1.2.0
 * @link http://lixianhua.com
 *
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
 ?>
<div class="main-inner">
	<?php while($this->next()): ?>
		<article class="post">
			<?php if (!empty($this->options->listStyle) && in_array('thumb', $this->options->listStyle)):?>
				<?php thumbnail($this);?>
			<?php endif; ?>
			<div class="post-header">
				<div class="post-meta"><a href="<?php $this->author->permalink(); ?>"><strong><?php $this->author(); ?></strong></a><em>·</em><?php $this->dateWord(); ?></div>
				<a class="post-title" href="<?php $this->permalink() ?>" title="<?php $this->title() ?>"><?php $this->title(); ?></a>
				<div class="post-meta">
					
					<a href="<?php $this->permalink() ?>#comments"><?php $this->commentsNum('评论：%d'); ?></a>
					<?php if(pluginExists('Jianshu')):?>
					<em>·</em>
					<a href="<?php $this->permalink() ?>"><?php _e('阅读：'); $this->viewsNum(); ?></a><em>·</em>
					<span><?php _e('喜欢：'); $this->likesNum(); ?></span>
					<?php endif;?>
				</div>
			</div>
			<?php if (!empty($this->options->listStyle) && in_array('excerpt', $this->options->listStyle)):?>
			<div class="post-desc"><?php $this->description(); ?></div>
			<?php endif; ?>
		</article>
	<?php endwhile; ?>
	
</div>
<?php if($this->getTotalPage()>1):?>
<div id="btn-archive">
	<?php $this->pageNav();?>
</div>
<?php endif; ?>
<?php $this->need('footer.php'); ?>
