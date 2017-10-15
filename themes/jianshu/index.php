<?php
/**
 * 仿简书主题
 * 
 * @package JianShu
 * @author 绛木子
 * @version 2.0.0
 * @link http://lixianhua.com
 *
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php'); ?>
<?php if($this->options->siteBanner && $this->is('index') && 1 == $this->getCurrentPage()):?>
	<?php Textends_Plugin::contents('cid='.$this->options->siteBanner)->to($banner);?>
	<?php if($banner->have()):?>
	<div id="banner" class="carousel slide" data-ride="carousel" data-interval="5000" data-multi="true">
		<div class="carousel-inner" role="listbox">
		<?php while($banner->next()): ?>
			<div class="item <?php if(1 == $banner->sequence){_e('active');}?>">
				<?php Textends_Plugin::thumbnail($banner,array('width'=>'620','height'=>'310','format'=>'<a class="banner-item" href="{permalink}" style="background-image:url(\'{thumbnail}\');" title="{title}"></a>')); ?>
			</div>
		<?php endwhile; ?>
		</div>
		<a class="left carousel-control" href="#banner" role="button" data-slide="prev">
			<span class="icon icon-prev" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="right carousel-control" href="#banner" role="button" data-slide="next">
			<span class="icon icon-next" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
	</div>
	<?php endif; ?>
<?php endif; ?>
<div class="post-list">
<?php while($this->next()): ?>
	<article class="post">
		<?php if($this->options->showThumbnail):?>
		<?php 
			if($this->options->lazyLoad){
				$format = '<a class="post-cover pull-right lazy" href="{permalink}" data-original="{thumbnail}" title="{title}"></a>';
			}else{
				$format = '<a class="post-cover pull-right lazy" href="{permalink}" style="background-image:url(\'{thumbnail}\')" title="{title}"></a>';
			}
			Textends_Plugin::thumbnail($this,array('format'=>$format));
		?>
		<?php endif; ?>
		<div class="post-wrap">
			<div class="post-author">
				<a href="<?php $this->author->permalink();?>" class="avatar"><img src="<?php echo TeComment_Plugin::gravatarUrl($this->author->mail);?>" alt="" /></a>
				<a class="author-name" href="<?php $this->author->permalink();?>"><?php $this->author->screenName();?></a>
				<span datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php $this->dateword(); ?></span>
			</div>
			<a class="post-title" href="<?php $this->permalink() ?>"><?php $this->title(); ?></a>
			<div class="post-abstract">
				<?php $this->excerpt(120,''); ?>
			</div>
			<ul class="post-meta">
				<li class="cat"><?php $this->category(','); ?></li>
				<li><a href="<?php $this->permalink() ?>"><i class="icon icon-eye"></i> <?php $this->viewsNum(); ?></a></li>
				<li><a href="<?php $this->permalink() ?>#comments"><i class="icon icon-comment"></i> <?php $this->commentsNum(); ?></a></li>
				<li><i class="icon icon-like"></i> <?php $this->likesNum(); ?></li>
				<li><?php if($this->isTop){_e('置顶');} ?></li>
			</ul>
		</div>
	</article>
<?php endwhile; ?>
</div>
<?php $this->pageNav('&laquo; 前一页', '后一页 &raquo;'); ?>

<?php $this->need('footer.php');?>
