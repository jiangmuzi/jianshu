<?php
/**
 * 仿简书主题
 * 
 * @package JianShu
 * @author 绛木子
 * @version 1.1.1
 * @link http://lixianhua.com
 * ----------------------------------------
 * update log
 * ----------------------------------------
 * 2015.08.03
 * ----------
 * 导航单字添加设置项
 * 优化functions中方法
 * 添加AJAX支持（前端实现）
 * ----------------------------------------
 * 2015.08.19
 * ----------
 * 添加七牛CDN支持
 * 能够显示文章缩略图了
 * 优化前端显示，精简了css代码
 * 修复了阅读模式切换的的Bug
 * 修复小屏下菜单打开后无法收起的Bug
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
		    <li><?php _e('<i class="fa fa-book"></i> '); ?><?php $this->category(','); ?></li>
		    <li><?php _e('<i class="fa fa-clock-o"></i> '); ?><time datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php echo formatTime($this->created); ?></time></li>
		      	<li><?php _e('<i class="fa fa-eye"></i> 阅读 '); ?><?php $this->viewsNum(); ?></li>
			<li itemprop="interactionCount"><a itemprop="discussionUrl" href="<?php $this->permalink() ?>#<?php $this->respondId(); ?>"><?php $this->commentsNum('<i class="fa fa-comments-o"></i> 评论 %d'); ?></a></li>
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
