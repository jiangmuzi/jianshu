<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<div id="comments">
    <?php $this->comments()->to($comments); ?>
    <?php if ($comments->have()): ?>
	<p>
		<?php $this->commentsNum(_t('<span>%d</span> 条评论')); ?>
		<a class="fright" href="#<?php $this->respondId(); ?>"><i class="fa fa-pencil"></i> 添加新评论</a>
	</p>
    <?php $comments->listComments(); ?>
    <?php $comments->pageNav('&laquo; 前一页', '后一页 &raquo;'); ?>
    <?php endif; ?>

    <?php if($this->allow('comment')): ?>
    <div id="<?php $this->respondId(); ?>" class="respond">
        <div class="cancel-comment-reply">
        <?php $comments->cancelReply(); ?>
        </div>
    
    	<h3 id="response"><?php _e('添加新评论'); ?></h3>
    	<form method="post" action="<?php $this->commentUrl() ?>" id="comment-form" role="form">
            <p>
				<?php //TeComment_Plugin::showTool(); //未安装评论增强插件时屏蔽?>
                <textarea rows="4" cols="50" name="text" id="textarea" class="textarea" required placeholder="如评论不显示，请等候管理员人工审核"><?php $this->remember('text'); ?></textarea>
            </p>
			<div class="comment-fields">
			<?php if($this->user->hasLogin()): ?>
    		<p><?php _e('登录身份: '); ?><a href="<?php $this->options->profileUrl(); ?>"><?php $this->user->screenName(); ?></a>. <a href="<?php $this->options->logoutUrl(); ?>" title="Logout"><?php _e('退出'); ?> &raquo;</a></p>
            <?php else: ?>
    		<p>
    			<input type="text" name="author" id="author" class="text" value="<?php $this->remember('author'); ?>" required />
				 <label for="author" class="required"><?php _e('称呼'); ?></label>
    		</p>
    		<p> 
    			<input type="email" name="mail" id="mail" class="text" value="<?php $this->remember('mail'); ?>"<?php if ($this->options->commentsRequireMail): ?> required<?php endif; ?> />
				<label for="mail"<?php if ($this->options->commentsRequireMail): ?> class="required"<?php endif; ?>><?php _e('邮箱'); ?></label>
			</p>
    		<p> 
    			<input type="url" name="url" id="url" class="text" placeholder="<?php _e('http://'); ?>" value="<?php $this->remember('url'); ?>"<?php if ($this->options->commentsRequireURL): ?> required<?php endif; ?> />
				<label for="url"<?php if ($this->options->commentsRequireURL): ?> class="required"<?php endif; ?>><?php _e('网站'); ?></label>
			</p>
            <?php endif; ?>
    		
    		<p>
                <button type="submit" class="btn"><?php _e('提交评论'); ?></button>
            </p>
			</div>
    	</form>
    </div>
    <?php else: ?>
    <h3><?php _e('评论已关闭'); ?></h3>
    <?php endif; ?>
</div>
