<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<div class="main-container">
    <?php if ($this->have()): ?>
    <?php while($this->next()): ?>
        <article class="post" itemscope itemtype="http://schema.org/BlogPosting">
    		<h2 class="post-title" itemprop="name headline"><a itemtype="url" href="<?php $this->permalink() ?>"><?php $this->title() ?></a></h2>
            <ul class="post-meta clearfix">
    		    <li><?php _e('<i class="fa fa-book"></i> '); ?><?php $this->category(','); ?></li>
    		    <li><?php _e('<i class="fa fa-clock-o"></i> '); ?><time datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php echo formatTime($this->created); ?></time></li>
    			<li><?php _e('<i class="fa fa-eye"></i> 阅读 '); ?><?php $this->viewsNum(); ?></li>
    			<li itemprop="interactionCount"><a itemprop="discussionUrl" href="<?php $this->permalink() ?>#comments"><?php $this->commentsNum('<i class="fa fa-comments-o"></i> 评论 %d'); ?></a></li>
    		</ul>
            <?php if(!empty($this->options->viewMode)): ?>
        	<div class="post-content" itemprop="articleBody">
    			<?php $this->content('- 阅读剩余部分 -'); ?>
    		</div>
    		<?php endif; ?>
        </article>
    <?php endwhile; ?>
    <?php else: ?>
        <article class="post">
            <h2 class="post-title"><?php _e('没有找到内容'); ?></h2>
        </article>
    <?php endif; ?>
    <div id="ajax-page" class="page-navigator">
        <?php $this->pageLink('更多','next');?>
    </div>
</div>

<?php $this->need('footer.php'); ?>