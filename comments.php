<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<div id="comments">
    <?php $this->comments()->to($comments); ?>
    <?php if ($comments->have()): ?>
	<p>
	   <?php $this->commentsNum(_t('暂无评论'), _t('仅有一条评论'), _t('已有 %d 条评论')); ?>
	   <a class="pull-right" href="#<?php $this->respondId(); ?>"><i class="fa fa-pencil"></i> 添加新评论</a>
	</p>
    
    <?php $comments->listComments(); ?>

    <?php $comments->pageNav('&laquo; 前一页', '后一页 &raquo;'); ?>
    
    <?php endif; ?>

    <?php if($this->allow('comment')): ?>
    <div id="<?php $this->respondId(); ?>" class="respond">
        <div class="cancel-comment-reply">
        <?php $comments->cancelReply(); ?>
        </div>
    
    	<h3 id="response"><?php _e('发表评论'); ?></h3>
    	<form method="post" action="<?php $this->commentUrl() ?>" id="comment-form" role="form">
    		<div>
                <label for="textarea" class="required hide"><?php _e('内容'); ?></label>
                <textarea rows="4" cols="50" name="text" id="textarea" class="textarea" required ><?php $this->remember('text'); ?></textarea>
            </div>
			<div class="comments-fields">
				<?php if($this->user->hasLogin()): ?>
				<p><?php $this->user->screenName(); ?>. <a href="<?php $this->options->logoutUrl(); ?>" title="Logout"><?php _e('退出'); ?> &raquo;</a></p>
				<?php else: ?>
				
				<p class="field">
					<label for="author" class="required"><?php _e('称呼'); ?></label>
					<input type="text" name="author" id="author" class="text" value="<?php $this->remember('author'); ?>" required />
				</p>
				<p class="field">
					<label for="mail"<?php if ($this->options->commentsRequireMail): ?> class="required"<?php endif; ?>><?php _e('Email'); ?></label>
					<input type="email" name="mail" id="mail" class="text" value="<?php $this->remember('mail'); ?>"<?php if ($this->options->commentsRequireMail): ?> required<?php endif; ?> />
				</p>
				<p class="field">
					<label for="url"<?php if ($this->options->commentsRequireURL): ?> class="required"<?php endif; ?>><?php _e('网站'); ?></label>
					<input type="url" name="url" id="url" class="text" placeholder="<?php _e('http://'); ?>" value="<?php $this->remember('url'); ?>"<?php if ($this->options->commentsRequireURL): ?> required<?php endif; ?> />
				</p>
				<?php endif; ?>
				<p class="alignright">
					<button type="submit" class="submit btn s3"><?php _e('提交评论'); ?></button>
				</p>
			</div>
    	</form>
    </div>
    <?php endif; ?>
</div>
