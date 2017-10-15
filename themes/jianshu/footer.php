<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php if($this->request->isAjax()) :?>
<script>
	window.token = <?php echo Typecho_Common::shuffleScriptVar(
								$this->security->getToken($this->request->getRequestUrl()));?>
	jApp.initPage({
		title:'<?php $this->archiveTitle(array(
            'category'  =>  _t('分类 %s 下的文章'),
            'search'    =>  _t('包含关键字 %s 的文章'),
            'tag'       =>  _t('标签 %s 下的文章'),
            'author'    =>  _t('%s 发布的文章')
        ), '', ' - '); ?><?php $this->options->title(); ?>',
		current:'<?php echo $this->is('account') ? 'action' : $this->getArchiveType();?>',
		lazyLoad:<?php echo  $this->options->lazyLoad ? 'true' : 'false';?>
	});
	TeCmt.init({action:'<?php $this->options->index('action');?>',current:'<?php echo $this->getArchiveType();?>'});
</script>
<?php if($this->is('post')): ?>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"1","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"32"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
<?php endif;?>
<div class="hidden"><?php if($this->options->siteStat):?><?php $this->options->siteStat();?><?php endif;?></div>
<?php return;endif;?>
		</div><!-- end #main-->
		<footer class="footer">
			<div class="footer-inner">
				<p><?php TeMenu_Plugin::show('footer','wrapTag=&itemTag='); ?></p>
				<p>&copy; <?php echo date('Y'); ?> <a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title(); ?></a>
					<em>·</em> <a href="http://www.typecho.org" target="_blank">Typecho</a>
					<?php if($this->options->siteIcp):?> <span class="hidden-xs"><em>·</em> <a href="http://www.miitbeian.gov.cn/" target="blank"><?php $this->options->siteIcp();?></a></span><?php endif;?>
					<em>·</em> Theme By <a href="http://lixianhua.com/" target="_blank"><?php _e('绛木子');?></a>
				</p>
			</div>
		</footer><!-- end #footer -->
    </div>
	<div class="site-tool">
		<a href="#" class="icon icon-list btn-index-menu<?php if(!$this->is('single')){ _e(' hidden');}?>" title="<?php _e('文章目录'); ?>"></a>
		<a href="#" class="icon icon-top btn-gotop"></a>
	</div>
</div><!-- end #wrapper -->
<script src="<?php $this->options->themeUrl('js/jquery.min.js'); ?>"></script>
<script src="<?php $this->options->themeUrl('js/jquery.plugins.js'); ?>"></script>
<script src="<?php $this->options->themeUrl('js/app.js'); ?>"></script>
<script>
	$(function(){
		window.token = <?php echo Typecho_Common::shuffleScriptVar(
								$this->security->getToken($this->request->getRequestUrl()));?>
		jApp.init({
			url:'<?php $this->options->siteUrl();?>',
			action:'<?php $this->options->index('action');?>',
			usePjax:<?php echo $this->options->usePjax ? 'true' : 'false';?>,
			current:'<?php echo $this->getArchiveType();?>',
			prefix:'<?php echo md5($this->options->rootUrl);?>',
			lazyLoad:<?php echo  $this->options->lazyLoad ? 'true' : 'false';?>
		});
	});
</script>
<div class="hidden"><?php if($this->options->siteStat):?><?php $this->options->siteStat();?><?php endif;?></div>
<?php if($this->is('post')): ?>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"1","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"32"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
<?php endif;?>
<?php $this->footer(); ?>
</body>
</html>
