<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

function themeConfig($form) {
    $logoText = new Typecho_Widget_Helper_Form_Element_Text('logoText', NULL, NULL, _t('网站文字LOGO'), _t('网站文字LOGO，单个文字;为空时取网站标题第一个文字'));
    $form->addInput($logoText);
    
    $icpNum = new Typecho_Widget_Helper_Form_Element_Text('icpNum', NULL, NULL, _t('网站备案号'), _t('在这里填入网站备案号'));
    $form->addInput($icpNum);
    
    $siteStat = new Typecho_Widget_Helper_Form_Element_Textarea('siteStat', NULL, NULL, _t('统计代码'), _t('在这里填入网站统计代码'));
    $form->addInput($siteStat);
    
    $bgPhoto = new Typecho_Widget_Helper_Form_Element_Text('bgPhoto', NULL, NULL, _t('网站背景图'), _t('在这里填入背景图网址'));
    $form->addInput($bgPhoto);
    
    //附件源地址
    $src_address = new Typecho_Widget_Helper_Form_Element_Text('src_add', NULL, NULL, _t('替换前地址'), _t('即你的附件存放地址，如http://www.yourblog.com/usr/uploads/'));
    $form->addInput($src_address);
    //替换后地址
    $cdn_address = new Typecho_Widget_Helper_Form_Element_Text('cdn_add', NULL, NULL, _t('替换后'), _t('即你的七牛云存储域名，如http://yourblog.qiniudn.com/'));
    $form->addInput($cdn_address);
    
    //默认缩略图
    $default = new Typecho_Widget_Helper_Form_Element_Text('default_thumb', NULL, '', _t('默认缩略图'),_t('文章没有图片时显示的默认缩略图，为空时表示不显示'));
    $form->addInput($default);
    //默认宽度
    $width = new Typecho_Widget_Helper_Form_Element_Text('thumb_width', NULL, '200', _t('缩略图默认宽度'));
    $form->addInput($width);
    //默认高度
    $height = new Typecho_Widget_Helper_Form_Element_Text('thumb_height', NULL, '140', _t('缩略图默认高度'));
    $form->addInput($height);
    
    $listStyle = new Typecho_Widget_Helper_Form_Element_Checkbox('listStyle',
        array('excerpt' => _t('显示摘要'),
            'thumb' => _t('显示缩略图')),
        array('excerpt', 'thumb'), _t('列表显示'));
    
    $form->addInput($listStyle);
    
}

function showThumb($obj,$size=null,$link=false,$pattern='<div class="post-thumb"><a class="thumb" href="{permalink}" title="{title}" style="background-image:url({thumb})"></a></div>'){

    preg_match_all( "/<[img|IMG].*?src=[\'|\"](.*?)[\'|\"].*?[\/]?>/", $obj->content, $matches );
    $thumb = '';
    $options = Typecho_Widget::widget('Widget_Options');
    if(isset($matches[1][0])){
        $thumb = $matches[1][0];;
        if(!empty($options->src_add) && !empty($options->cdn_add)){
            $thumb = str_ireplace($options->src_add,$options->cdn_add,$thumb);
        }
        if($size!='full'){
            $thumb_width = $options->thumb_width;
            $thumb_height = $options->thumb_height;
    
            if($size!=null){
                $size = explode('x', $size);
                if(!empty($size[0]) && !empty($size[1])){
                    list($thumb_width,$thumb_height) = $size;
                }
            }
            $thumb .= '?imageView2/4/w/'.$thumb_width.'/h/'.$thumb_height;
        }
    }

	if(empty($thumb) && empty($options->default_thumb)){
	    return '';
	}else{
	    $thumb = empty($thumb) ? $options->default_thumb : $thumb;
	}
	if($link){
	    return $thumb;
	}
	echo str_replace(
	    array('{title}','{thumb}','{permalink}'),
	    array($obj->title,$thumb,$obj->permalink),
	    $pattern);
}
/**
 * 解析内容以实现附件加速
 * @access public
 * @param string $content 文章正文
 * @param Widget_Abstract_Contents $obj
 */
function parseContent($obj){
    $options = Typecho_Widget::widget('Widget_Options');
    if(!empty($options->src_add) && !empty($options->cdn_add)){
        $obj->content = str_ireplace($options->src_add,$options->cdn_add,$obj->content);
    }
    echo trim($obj->content);
}
/**
 * 实现静态资源的加速
 * @param string $params
 */
function themeCdnUrl($params=null){
    $options = Typecho_Widget::widget('Widget_Options');
    if(!empty($options->src_add) && !empty($options->cdn_add)){
        echo $options->cdn_add.$params;
    }else{
        $options->themeUrl($params);
    }
}

/**
 * 格式化时间
 * @param int $time 时间戳
 * @param string $str 显示格式
 * @return string
 */
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
/**
 * 生成随机颜色值
 * @return string
 */
function randColor(){
    return rand(120,200).','.rand(120,200).','.rand(120,200);
}
/**
 * 显示标签
 * @param string $parse 解析模版
 * @param number $limit 显示条数 为0时表示显示全部
 * @param string $sort 排序字段
 * @param number $desc 默认为0,表示倒序
 * @return void
 */
function showTagCloud($parse=null,$limit=30,$sort='mid',$desc=0){
    $parse = is_null($parse) ? '<li><a href="{permalink}" title="{count}个话题" style="{background}">{name}({count})</a></li>': $parse;
    Typecho_Widget::widget('Widget_Metas_Tag_Cloud', 'sort='.$sort.'&ignoreZeroCount=1&desc='.$desc.'&limit='.$limit)->to($tags);
    $output = '';
    if($tags->have()){
        while ($tags->next()){
            $color = 'color: rgb('.randColor().');';
            $background = 'background-'.$color;
            $output .= str_replace(
                array('{permalink}','{count}','{name}','{background}','{color}'),
                array($tags->permalink,$tags->count,$tags->name,$background,$color),
                $parse);
        }
    }
    echo $output;
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