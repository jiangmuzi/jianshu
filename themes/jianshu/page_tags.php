<?php
/**
 * 标签云
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
        <div class="post-content markdown-body" itemprop="articleBody">
            <ul class="tag-list">
                <?php tagCloud(null,'<li><a href="{permalink}">{name}({count})</a></li>');?>
            </ul>
        </div>
    </article>
</div><!-- end #main-->
<?php $this->need('footer.php'); ?>
