<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php if(!$this->request->isAjax()) :?>
	</div><!-- end #main-->
</div><!-- end #body -->
<footer class="footer">
	<div class="footer-inner">
		<?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
		<?php if($pages->have()):?>
		<p>
		<?php while($pages->next()): ?>
		<a<?php if($this->is('page', $pages->slug)): ?> class="current"<?php endif; ?> href="<?php $pages->permalink(); ?>" title="<?php $pages->title(); ?>"><?php $pages->title(); ?></a>
		<?php endwhile; ?>
		</p>
		<?php endif;?>
		<p>&copy; <?php echo date('Y'); ?> <a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title(); ?></a>
			<em>·</em> <a href="http://www.typecho.org" target="_blank">Typecho</a>
			<?php if($this->options->icpNum):?> <em>·</em> <a href="http://www.miitbeian.gov.cn/" target="blank"><?php $this->options->icpNum();?></a><?php endif;?>
			<em>·</em> Theme By <a href="http://lixianhua.com/" target="_blank"><?php _e('绛木子'); ?></a>
			<span><?php if($this->options->siteStat):?><?php $this->options->siteStat();?><?php endif;?></span>
		</p>
	</div>
</footer><!-- end #footer -->
</div>
<div class="fixed-btn">
	<a class="btn-gotop" href="javascript:jBlog.goTop();"> <i class="fa fa-angle-up"></i></a>
</div>
<script>
	$(function(){
		jBlog.init({
			url:'<?php $this->options->siteUrl();?>',
			action:'<?php $this->options->index('action');?>',
			usePjax:'<?php $this->options->usePjax();?>',
			current:'<?php echo $this->getArchiveType();?>',
			prefix:'<?php echo md5($this->options->rootUrl);?>',
			respondId:'<?php $this->respondId(); ?>',
			donateImg:'<?php $this->options->donateImg();?>',
		});
	});
</script>
<?php $this->footer(); ?>
</body>
</html>
<?php else: ?>
	<script id="jBlog-params">
		jBlog.initPageParams({
			current:'<?php echo $this->getArchiveType();?>',
			respondId:'<?php $this->respondId(); ?>',
			title:'<?php $this->archiveTitle(array(
            'category'  =>  _t('分类：%s'),
            'search'    =>  _t('搜索：%s'),
            'tag'       =>  _t('标签：%s'),
            'author'    =>  _t('%s 发布的文章')
        ), '', ' - '); $this->options->title(); ?>',
		});
		<?php if(pluginExists('TeComment')):?>
		TeCmt.init();
		<?php endif;?>
		<?php echo getAntiSpam($this);?>
	</script>
<?php endif; ?>
