<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

function themeConfig($form) {
	$logoText = new Typecho_Widget_Helper_Form_Element_Text('logoText', NULL, NULL, _t('网站文字LOGO'), _t('网站文字LOGO，单个文字;为空时取网站标题第一个文字'));
    $form->addInput($logoText);
    
	$avatarUrl = new Typecho_Widget_Helper_Form_Element_Text('avatarUrl', NULL, NULL, _t('博主头像'), _t('博主头像地址，为空则不显示'));
    $form->addInput($avatarUrl);
	
    $icpNum = new Typecho_Widget_Helper_Form_Element_Text('icpNum', NULL, NULL, _t('网站备案号'), _t('在这里填入网站备案号'));
    $form->addInput($icpNum);
    
    $siteStat = new Typecho_Widget_Helper_Form_Element_Textarea('siteStat', NULL, NULL, _t('统计代码'), _t('在这里填入网站统计代码'));
    $form->addInput($siteStat);
    
    $bgPhoto = new Typecho_Widget_Helper_Form_Element_Text('bgPhoto', NULL, NULL, _t('网站背景图'), _t('在这里填入背景图网址'));
    $form->addInput($bgPhoto);
    
	$iconCss = new Typecho_Widget_Helper_Form_Element_Textarea('iconCss', NULL, NULL, _t('图标样式'), _t('在这里填入图标样式代码'));
    $form->addInput($iconCss);
	
    $listStyle = new Typecho_Widget_Helper_Form_Element_Checkbox('listStyle',
        array('excerpt' => _t('显示摘要'),
            'thumb' => _t('显示缩略图')),
        array('excerpt', 'thumbnail'), _t('列表显示'));
    
    $form->addInput($listStyle);
}

function getReadMode($icon=false){
	$class = Typecho_Cookie::get('read-mode','day');
	if($icon){
		$class = $class == 'day' ? 'fa fa-sun-o' : 'fa fa-moon-o';
	}else{
		$class = 'day' == $class ? '' : 'night-mode';
	}
		
	echo $class;
}

/**
 * 重写评论显示函数
 */
function threadedComments($comments, $options){
    $commentClass = '';
    if ($comments->authorId) {
        if ($comments->authorId == $comments->ownerId) {
            $commentClass .= ' comment-by-author';
        } else {
            $commentClass .= ' comment-by-user';
        }
    }

    $commentLevelClass = $comments->levels > 0 ? ' comment-child' : ' comment-parent';
    ?>
<li itemscope itemtype="http://schema.org/UserComments" id="<?php $comments->theId(); ?>" class="comment-body<?php
    if ($comments->levels > 0) {
        echo ' comment-child';
        $comments->levelsAlt(' comment-level-odd', ' comment-level-even');
    } else {
        echo ' comment-parent';
    }
    $comments->alt(' comment-odd', ' comment-even');
    echo $commentClass;
?>">
    <div class="comment-avatar">
		<img class="avatar" src="<?php echo Tools_Plugin::gravatarUrl($comments->mail, $options->avatarSize, null,$options->defaultAvatar);?>" width="<?php echo $options->avatarSize;?>">
	</div>
    <div class="comment-meta">
        <div class="comment-meta-author"><?php $comments->author();?></div>
        <div class="comment-meta-time">
        <a href="<?php $comments->permalink(); ?>"><time itemprop="commentTime" datetime="<?php $comments->date('c'); ?>"><?php $options->beforeDate();
        $comments->date($options->dateFormat);
        $options->afterDate(); ?></time></a>
        </div>
        <?php if ('waiting' == $comments->status) { ?>
        <em class="comment-awaiting-moderation"><?php $options->commentStatus(); ?></em>
        <?php } ?>
        <div class="comment-meta-reply">
            <?php $comments->reply($options->replyWord); ?>
        </div>
    </div>
    <div class="comment-content" itemprop="commentText">
    <?php $comments->content(); ?>
    </div>
    
    <?php if ($comments->children) { ?>
    <div class="comment-children" itemprop="discusses">
        <?php $comments->threadedComments(); ?>
    </div>
    <?php } ?>
</li>
<?php
}