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
 $this->need('header.php');
?>
<div id="main-container" class="main-container">
<?php while($this->next()): ?>
    <article class="post" itemscope itemtype="http://schema.org/BlogPosting">
		<?php if(!empty($this->options->listStyle) && in_array('thumb',$this->options->listStyle)): ?>
		  <?php showThumb($this);?>
		<?php endif; ?>
		<ul class="post-meta">
		    <li><?php $this->category(','); ?></li>
		    <li><?php $this->dateWord(); ?></li>
			<li><?php _e('阅读');$this->viewsNum(); ?></li>
			<li><?php _e('喜欢');$this->likesNum(); ?></li>
			<li href="<?php $this->permalink() ?>#<?php $this->respondId(); ?>"><?php $this->commentsNum('评论%d'); ?></a></li>
		</ul>
		<h2 class="post-title" itemprop="name headline"><a itemtype="url" href="<?php $this->permalink() ?>"><?php $this->title() ?></a></h2>
        <?php if(!empty($this->options->listStyle) && in_array('excerpt',$this->options->listStyle)): ?>
    	<div class="post-content" itemprop="articleBody">
			<?php $this->description(); ?>
		</div>
		<?php endif; ?>
    </article>
<?php endwhile; ?>
    <div id="ajax-page" class="page-navigator">
        <?php $this->pageLink('更多','next');?>
    </div>
</div>
<?php $this->need('footer.php'); ?>