<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
    </div>
</div>
<footer <?php if($this->is('post')): ?>class="single"<?php endif; ?>> 
   <div class="footer-inner"> 
    <p>
		<?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
        <?php while($pages->next()): ?>
        <a href="<?php $pages->permalink(); ?>" title="<?php $pages->title(); ?>"><?php $pages->title(); ?></a> | 
        <?php endwhile; ?> 
		<a href="<?php $this->options->feedUrl(); ?>"><?php _e('文章 RSS'); ?></a> | 
        <a href="<?php $this->options->commentsFeedUrl(); ?>"><?php _e('评论 RSS'); ?></a>
	</p> 
    <p> &copy; <?php echo date('Y');?> <a href="<?php $this->options->siteUrl(); ?>" target="_blank"> <?php $this->options->title() ?> </a>
        <?php _e(' / Powered by <a href="http://www.typecho.org" target="_blank">Typecho</a>'); ?>
        <?php _e(' / Theme by <a href="http://lixianhua.com" target="_blank">绛木子</a>'); ?>
        <?php if ($this->options->icpNum): ?>
           / <a href="http://www.miitbeian.gov.cn/" target="blank"><?php $this->options->icpNum(); ?></a>
        <?php endif; ?>
	</p> 
   </div> 
  </footer>
<div class="fixed-btn">
    <a class="go-top" href="#" title="返回顶部"><i class="fa fa-chevron-up"></i></a>
     <?php if($this->is('post')): ?>
    <a class="go-comments" href="#comments" title="评论"><i class="fa fa-comments"></i></a>
    <?php endif; ?>
</div>
<?php $this->footer(); ?>
<script src="http://apps.bdimg.com/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="<?php $this->options->themeUrl('common.js'); ?>"></script>
<?php if ($this->is('post')) :?>
<script src="http://apps.bdimg.com/libs/prettify/r298/prettify.min.js"></script>
<script>
$(function(){
	$(window).load(function(){
	     $("pre code").addClass("prettyprint");
	     prettyPrint();
	});
})
</script>
<?php endif;?>
<script>
window.isArchive = <?php if($this->is('index') || $this->is('archive')){echo 'true';}else{echo 'false';}?>;
</script>
<?php if ($this->options->siteStat): ?><div class="hide"><?php $this->options->siteStat(); ?></div><?php endif; ?>
</body>
</html>