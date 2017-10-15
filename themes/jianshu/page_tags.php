<?php
/**
 * 标签云
 *
 * @package custom
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
<article class="post page">
	<h1 class="post-title"><?php $this->title() ?></h1>
	<div class="post-content markdown">
		<?php Textends_Plugin::tags(null,'<a href="{permalink}" class="btn" style="{fontsize};color:{color};">{name}({count})</a>');?>
	</div>
</article>
<?php $this->need('footer.php'); ?>
