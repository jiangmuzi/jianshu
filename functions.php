<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

function themeConfig($form) {
    $logoText = new Typecho_Widget_Helper_Form_Element_Text('logoText', NULL, NULL, _t('网站LOGO'), _t('网站LOGO文字，单个文字;为空时取网站标题第一个文字'));
    $form->addInput($logoText);
    $icpNum = new Typecho_Widget_Helper_Form_Element_Text('icpNum', NULL, NULL, _t('网站备案号'), _t('在这里填入网站备案号'));
    $form->addInput($icpNum);
    $siteStat = new Typecho_Widget_Helper_Form_Element_Textarea('siteStat', NULL, NULL, _t('统计代码'), _t('在这里填入网站统计代码'));
    $form->addInput($siteStat);
    $bgPhoto = new Typecho_Widget_Helper_Form_Element_Text('bgPhoto', NULL, NULL, _t('网站背景图'), _t('在这里填入背景图网址'));
    $form->addInput($bgPhoto);
    $viewMode = new Typecho_Widget_Helper_Form_Element_Checkbox('viewMode',
    		array('full'=>'完整模式'),'',_t('列表样式'),_t('列表将显示为：标题+内容')
		);
    $form->addInput($viewMode);
}
function formatTime($time,$str='Y-m-d'){
    isset($str)?$str:$str='m-d';
    $way = time() - $time;
    $r = '';
    if($way < 60){
        $r = '刚刚';
    }elseif($way >= 60 && $way <3600){
        $r = floor($way/60).'分钟前';
    }elseif($way >=3600 && $way <86400){
        $r = floor($way/3600).'小时前';
    }elseif($way >=86400 && $way <2592000){
        $r = floor($way/86400).'天前';
    }elseif($way >=2592000 && $way <15552000){
        $r = floor($way/2592000).'个月前';
    }else{
        $r = date("$str",$time);
    }
    return $r;
}
function showArchives($obj){
    $stat = Typecho_Widget::widget('Widget_Stat');
    $obj->widget('Widget_Contents_Post_Recent', 'pageSize='.$stat->publishedPostsNum)->to($archives);
    $year=0; $mon=0; $i=0; $j=0;
    $output = '<div class="archives">';
    while($archives->next()){
        $year_tmp = date('Y',$archives->created);
        $mon_tmp = date('m',$archives->created);
        $y=$year; $m=$mon;
        if ($year > $year_tmp || $mon > $mon_tmp) {
            $output .= '</ul></div>';
        }
        if ($year != $year_tmp || $mon != $mon_tmp) {   
			 $year = $year_tmp;
			 $mon = $mon_tmp;
			 $output .= '<div class="archives-item"><h2>'.date('Y年m月',$archives->created).'</h2><ul class="archives_list">'; //输出年份   
        }   
        $output .= '<li>'.date('d日',$archives->created).' <a href="'.$archives->permalink .'">'. $archives->title .'</a></li>'; //输出文章
    }
    $output .= '</ul></div></div>';
    echo $output;
}
function showTagCloud($obj,$options=array()){
    $defautlOptions = array(
        'wrapDiv'=>'ul',
        'wrapClass'=>'tag-list',
        'parse'=>'<li><a href="{permalink}" title="{count}个话题">{name}({count})</a></li>',
        'where'=>'sort=mid&ignoreZeroCount=1&desc=0&limit=30'
    );
    $options = !empty($options) ? array_merge($defautlOptions,$options) : $defautlOptions;
    $obj->widget('Widget_Metas_Tag_Cloud', $options['where'])->to($tags);
    $output = '';
    if($tags->have()){
        $output .='<'.$options['wrapDiv'].' class="'.$options['wrapClass'].'">';
        while ($tags->next()){
            $output .= str_replace(array('{permalink}','{count}','{name}'), array($tags->permalink,$tags->count,$tags->name), $options['parse']);
        }
        $output .='</'.$options['wrapDiv'].'>';
    }
    echo $output;
}

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
    
    <div class="comment-meta">
        <div class="comment-meta-author" itemprop="creator" itemscope itemtype="http://schema.org/Person">
            <span itemprop="image"><?php $comments->gravatar($options->avatarSize, $options->defaultAvatar); ?></span>
            <cite class="fn" itemprop="name"><?php $options->beforeAuthor();
            $comments->author();
            $options->afterAuthor(); ?></cite>
        </div>
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