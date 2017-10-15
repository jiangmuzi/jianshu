<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<div id="comments">
    <?php if($this->allow('comment')): ?>
	<div class="comments-inner">
		<h3><?php $this->commentsNum(_t('暂无评论'), _t('仅有一条评论'), _t('已有 %d 条评论')); ?></h3>
        <?php if($this->options->plugin('TeComment')->commentAjaxLoad): ?>
		    <div id="comment-ajax-list" data-cid="<?php $this->cid();?>" data-num="<?php $this->commentsNum();?>" data-comment-page="<?php echo $this->request->commentPage;?>"></div>
        <?php else: ?>
            <?php $this->comments()->to($comments); ?>
            <?php if ($comments->have()): ?>
            <?php $comments->listComments(); ?>
            <?php $comments->pageNav('&laquo; 前一页', '后一页 &raquo;'); ?>
            <?php endif; ?>
        <?php endif; ?>
	</div>
    <?php endif; ?>
    <?php if($this->allow('comment')): ?>
    <div id="<?php $this->respondId(); ?>" class="respond">
        <div class="cancel-comment-reply">
			<a href="#" id="cancel-comment-reply-link" onclick="return TypechoComment.cancelReply();" style="display:none"><?php _e('取消回复')?></a>
        </div>
    	<h3 id="response"><?php _e('添加新评论'); ?></h3>
        <form class="form" method="post" action="<?php $this->commentUrl() ?>" id="comment-form">
            <div class="form-group">
                <label for="textarea" class="required sr-only"><?php _e('内容'); ?></label>
                <textarea rows="4" name="text" id="textarea" class="form-control" required ><?php $this->remember('text'); ?></textarea>
            </div>
            <?php TeComment_Plugin::showTool();?>
            <?php if($this->user->hasLogin()): ?>
    		<p><?php _e('登录身份: '); ?><a href="<?php $this->options->profileUrl(); ?>"><?php $this->user->screenName(); ?></a>. <a href="<?php $this->options->logoutUrl(); ?>" title="Logout"><?php _e('退出'); ?> &raquo;</a></p>
            <?php else: ?>
    		<div class="form-inline">
                <div class="form-group">
                    <label for="author" class="required"><?php _e('称呼'); ?></label>
                    <input type="text" name="author" id="author" class="form-control" value="<?php $this->remember('author'); ?>" required />
                </div>
                <div class="form-group">
                    <label for="mail"<?php if ($this->options->commentsRequireMail): ?> class="required"<?php endif; ?>><?php _e('Email'); ?></label>
                    <input type="email" name="mail" id="mail" class="form-control" value="<?php $this->remember('mail'); ?>"<?php if ($this->options->commentsRequireMail): ?> required<?php endif; ?> />
                </div>
                <div class="form-group">
                    <label for="url"<?php if ($this->options->commentsRequireURL): ?> class="required"<?php endif; ?>><?php _e('网站'); ?></label>
                    <input type="url" name="url" id="url" class="form-control" placeholder="<?php _e('http://'); ?>" value="<?php $this->remember('url'); ?>"<?php if ($this->options->commentsRequireURL): ?> required<?php endif; ?> />
                </div>
            </div>
            <?php endif; ?>
    		<div class="form-group">
                <button type="submit" class="btn btn-info"><?php _e('回复'); ?></button>
            </div>
    	</form>
    </div>
    <?php else: ?>
    <h3><?php _e('评论已关闭'); ?></h3>
    <?php endif; ?>
</div>
