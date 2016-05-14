<?php
/**
 * 仿简书主题
 * 
 * @package JianShu
 * @author 绛木子
 * @version 1.1.0
 * @link http://lixianhua.com
 *
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
 if(!$this->request->isAjax())
 $this->need('header.php');
 ?>
<div class="main-inner">
	<?php while($this->next()): ?>
		<article class="post">
			<?php if (!empty($this->options->listStyle) && in_array('thumb', $this->options->listStyle)):?>
				<?php Tools_Plugin::thumbnail($this);?>
			<?php endif; ?>
			<div class="post-header">
				<div class="post-meta"><a href="<?php $this->author->permalink(); ?>"><strong><?php $this->author(); ?></strong></a><em>·</em><?php $this->dateWord(); ?></div>
				<a class="post-title" href="<?php $this->permalink() ?>" title="<?php $this->title() ?>"><?php $this->title(); ?></a>
				<div class="post-meta">
					<a href="<?php $this->permalink() ?>"><?php _e('阅读：'); $this->viewsNum(); ?></a><em>·</em>
					<a href="<?php $this->permalink() ?>#comments"><?php $this->commentsNum('评论：%d'); ?></a><em>·</em>
					<span><?php _e('喜欢：'); $this->likesNum(); ?></span>
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
	<div class="btn"><?php $this->pageLink('点击查看更多','next');?></div>
</div>
<?php endif; ?>
<?php if(!$this->request->isAjax()) $this->need('footer.php'); ?>
