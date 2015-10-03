<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
<div class="main-container">
    <article class="post preview" itemscope itemtype="http://schema.org/BlogPosting">
		<div class="post-author clearfix">
			<a class="fl" href="<?php $this->author->permalink(); ?>" title="<?php $this->author(); ?>"><img class="avatar" width="32" src="<?php echo gravatarUrl($this->author->mail,32); ?>" alt="" /></a>
			<a href="<?php $this->author->permalink(); ?>"><?php $this->author(); ?></a><?php _e('发布在');?><?php $this->category(','); ?>
			<span><?php $this->date('Y.m.d H:i:s'); ?></span>
		</div>
        <h1 class="post-title" itemprop="name headline"><?php $this->title() ?></h1>
        <ul class="post-meta clearfix">
            <li><?php _e('阅读'); ?> <?php $this->viewsNum(); ?></li>
            <li itemprop="interactionCount"><a itemprop="discussionUrl" href="<?php $this->permalink() ?>#comments"><?php $this->commentsNum('评论 %d'); ?></a></li>
            <li class="post-qrcode"><i class="fa fa-qrcode"></i>
                <div id="qrcode-img"></div>
            </li>
            
        </ul>
        <div class="post-content" itemprop="articleBody">
            <?php parseContent($this); ?>
        </div>
		<div class="post-donate">
			<p><i class="fa fa-rmb"></i> 打赏几块钱，帮我买杯咖啡吧，谢谢大家！<button class="btn s2 fr" onclick="$('#alipay-form').submit();"><i class="fa fa-cny"> <?php _e('打赏支持');?></i></button></p>
			<div class="post-donate-img">
				<p>支付宝二维码</p>
				<img src="<?php $this->options->themeUrl('img/alipay.png'); ?>">
			</div>
			<form id="alipay-form" action="https://shenghuo.alipay.com/send/payment/fill.htm" method="POST" target="_blank" accept-charset="GBK">
				<input type="hidden" name="optEmail" value="<?php $this->options->alipayAccount();?>">
				<input type="hidden" name="payAmount" value="<?php $this->options->alipayAmount();?>">
				<input type="hidden" name="title" value="<?php _e('打赏：');$this->title();?>">
			</form>
		</div>
        
		<div class="post-foot clearfix">
			<div class="post-tags"><?php _e('标签: '); ?><?php $this->tags(', ', true, 'none'); ?></div>
		</div>
    </article>
    
    <ul class="post-near">
        <li>上一篇: <?php $this->thePrev('%s','没有了'); ?></li>
        <li>下一篇: <?php $this->theNext('%s','没有了'); ?></li>
    </ul>
    <?php $this->need('comments.php'); ?>
</div>
<?php $this->need('footer.php'); ?>