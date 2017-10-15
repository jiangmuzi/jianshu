<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<article class="post page">
	<h1 class="post-title"><?php $this->title() ?></h1>
	<div class="post-content markdown">
		<?php $this->content(); ?>
	</div>
</article>
<?php $this->need('comments.php'); ?>

<?php $this->need('footer.php'); ?>
