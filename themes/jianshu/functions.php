<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

function themeConfig($form) {
	$logoText = new Typecho_Widget_Helper_Form_Element_Text('logoText', NULL, NULL, _t('网站文字LOGO'), _t('网站文字LOGO，单个文字;为空时将获取网站标题第一个文字'));
    $form->addInput($logoText);
    
	$avatarUrl = new Typecho_Widget_Helper_Form_Element_Text('avatarUrl', NULL, NULL, _t('博主头像'), _t('博主头像地址，为空则不显示'));
    $form->addInput($avatarUrl);
	
	$donateImg = new Typecho_Widget_Helper_Form_Element_Text('donateImg', NULL, NULL, _t('捐献二维码'), _t('捐献二维码图片地址'));
	$form->addInput($donateImg);
	
    $icpNum = new Typecho_Widget_Helper_Form_Element_Text('icpNum', NULL, NULL, _t('网站备案号'), _t('在这里填入网站备案号'));
    $form->addInput($icpNum);
    
    $siteStat = new Typecho_Widget_Helper_Form_Element_Textarea('siteStat', NULL, NULL, _t('统计代码'), _t('在这里填入网站统计代码'));
    $form->addInput($siteStat);
    
    $bgPhoto = new Typecho_Widget_Helper_Form_Element_Text('bgPhoto', NULL, NULL, _t('网站背景图'), _t('在这里填入背景图网址'));
    $form->addInput($bgPhoto);
    
	$iconCss = new Typecho_Widget_Helper_Form_Element_Textarea('iconCss', NULL, NULL, _t('图标样式'), _t('在这里填入图标样式代码'));
    $form->addInput($iconCss);
	
	$defaultthumbnail = new Typecho_Widget_Helper_Form_Element_Text('defaultthumbnail', NULL, NULL, _t('默认缩略图'), _t('当文章没有图片时显示的缩略图，为空则不显示'));
	$form->addInput($defaultthumbnail);
	
	$thumbnailwidth = new Typecho_Widget_Helper_Form_Element_Text('thumbnailwidth', NULL, 100, _t('缩略图宽度'), _t('缩略图显示的宽度'));
	$form->addInput($thumbnailwidth);
	
	$thumbnailheight = new Typecho_Widget_Helper_Form_Element_Text('thumbnailheight', NULL, 90, _t('缩略图高度'), _t('缩略图显示的高度'));
	$form->addInput($thumbnailheight);
	
	$qiniu = new Typecho_Widget_Helper_Form_Element_Text('qiniu', NULL, NULL, _t('七牛CDN地址'), _t('七牛CDN域名，测试域名或自定义域名，以‘http://’或‘https://’开头'));
	$form->addInput($qiniu);
		
    $listStyle = new Typecho_Widget_Helper_Form_Element_Checkbox('listStyle',
        array('excerpt' => _t('显示摘要'),
            'thumb' => _t('显示缩略图')),
        array('excerpt', 'thumbnail'), _t('列表显示'));
    $form->addInput($listStyle);
	
	$usePjax = new Typecho_Widget_Helper_Form_Element_Radio('usePjax', array('0' => _t('不启用'), '1' => _t('启用')), '0', _t('是否启用Pjax'),
        _t('提升用户体验和资源利用率;适用于现代浏览器'));
    $form->addInput($usePjax);
    
}
/**
 * 判断插件是否启用
 *
 * @param string $pluginName
 * @return bool
 */
function pluginExists($pluginName){
	static $_plugins;
	if(is_null($_plugins)){
		$_plugins = Typecho_Plugin::export();
	}
	return isset($_plugins['activated'][$pluginName]);
}

function thumbnail($obj,$size=null,$link=false,$pattern='<div class="post-cover"><a href="{permalink}" title="{title}" style="background-image:url({image})"></a></div>'){
	$image = getThumbnail($obj->content,$size);
	if(empty($image)) return;
	if($link){
		return $image;
	}
	echo str_replace(
		array('{title}','{image}','{permalink}'),
		array($obj->title,$image,$obj->permalink),
		$pattern);
}
//解析内容，从中获取缩略图
function getThumbnail($content,$size=null){
	preg_match_all( "/<[img|IMG].*?src=[\'|\"](.*?)[\'|\"].*?[\/]?>/", $content, $matches );
	$image = '';
	$isLocal = false;
	if(isset($matches[1][0])){
		$image = $matches[1][0];
		$siteUrl = Typecho_Widget::widget('Widget_Options')->siteUrl;
		if(strpos($image,$siteUrl)===0){
			$imgDir = substr($image,strlen($siteUrl)-1);

			if(is_file(__TYPECHO_ROOT_DIR__ . $imgDir)){
				$image = $imgDir;
				$isLocal = true;
			}
		}
	}
	
	if($isLocal){
		$options = Typecho_Widget::widget('Widget_Options');
		if($size==null){
			$size = array($options->thumbnailwidth,$options->thumbnailheight);
		}elseif($size=='full'){
			$size = null;
		}else{
			$size = explode('x',$size);
			$size[1] = (isset($size[1]) && !empty($size[1])) ? $size[1] : $size[0];
		}

		if(empty($options->qiniu)){
			$image = getLocalImageThumbnail($image,$size);
		}else{
			$image = getQiniuImageThumbnail($image,$size,$options->qiniu);
		}
	}
	if(empty($image) && empty($options->defaultthumbnail)){
		return '';
	}else{
		$image = empty($image) ? $options->defaultthumbnail : $image;
	}
	return $image;
}
//本地接口生成缩略图
function getLocalImageThumbnail($url,$size){
	$options = Typecho_Widget::widget('Widget_Options');
	$siteUrl = $options->siteUrl;
	if(is_null($size) || !pluginExists('Jianshu')){
		return Typecho_Common::url($url, $siteUrl);
	}
	
	$index = $options->index;
	$imageApi = Typecho_Common::url('/action/tools', $index);
	$s = $size[0] . 'x' . $size[1];
	return $imageApi."?do=image&url={$url}&s={$s}";
}

//使用七牛CDN生成缩略图
function getQiniuImageThumbnail($url,$size,$qiniu){
	$url = substr($url,12);
	if(!is_null($size)){
		$url = $url.'?imageView2/4/w/' . $size[0] . '/h/' . $size[1];
	}
	$url = Typecho_Common::url($url, $qiniu);
	return $url;
}
/**
 * 标签云
 * @params string 配置字符串
 * @format string 格式化输出
 * @return void
 */
function tagCloud($params=null,$format='<a href="{permalink}" style="{fontsize};{color};" title="{count}篇文章">{name}</a>'){

	Typecho_Widget::widget('Widget_Metas_Tag_Cloud', $params)->to($tags);

	$list = $counts = array();
	while($tags->next()){
		$list[] = array(
			'mid'=>$tags->mid,
			'name'=>$tags->name,
			'permalink'=>$tags->permalink,
			'count'=>$tags->count,
		);
		$counts[] = $tags->count;
	}
	if(empty($counts)){
		echo '暂无标签';
		return;
	}
	$min_count = min($counts);
	$spread = max($counts) - $min_count;
	
	$params = new Typecho_Config($params);
	$params->setDefault(array(
		'smallest' => 8, 'largest' => 22, 'unit' => 'pt'
	));
	
	if ( $spread <= 0 ){
		$spread = 1;
	}
		
	$font_spread = $params->largest - $params->smallest;
	if ( $font_spread < 0 )
		$font_spread = 1;
	$font_step = $font_spread / $spread;
	$html = '';
	foreach($list as $tag){
		$color = 'color:#'.randColor();
		$fontsize = 'font-size:'.( $params->smallest + (( $tag['count'] - $min_count ) * $font_step) ).$params->unit;
		$html .= str_replace(array('{name}','{permalink}','{count}','{fontsize}','{color}'),
		array($tag['name'],$tag['permalink'],$tag['count'],$fontsize,$color),$format);
	}
	echo $html;
}

/**
 * 生成随机颜色值
 * @return string
 */
function randColor(){
	$colors=array('ff3300','0517c2','0fc317','e7cc17','601165','ffb900','f74e1e','00a4ef','7fba00');
	return $colors[rand(0,8)];
}
function getAntiSpam($archive){
	if(!$archive->is('single') || !$archive->allowComment || !$archive->widget('Widget_Options')->commentsAntiSpam){
		return;
	}
	$script = "(function () {
    var event = document.addEventListener ? {
        add: 'addEventListener',
        focus: 'focus',
    } : {
        add: 'attachEvent',
        focus: 'onfocus',
    };

    var r = document.getElementById('{$archive->respondId}');

	if (null != r) {
		var forms = r.getElementsByTagName('form');
		if (forms.length > 0) {
			var f = forms[0], textarea = f.getElementsByTagName('textarea')[0], added = false;

			if (null != textarea && 'text' == textarea.name) {
				textarea[event.add](event.focus, function () {
					if (!added) {
						var input = document.createElement('input');
						input.type = 'hidden';
						input.name = '_';
						input.value = " . Typecho_Common::shuffleScriptVar(
							$archive->widget('Widget_Security')->getToken($archive->request->getRequestUrl())) . "
						f.appendChild(input);
						added = true;
					}
				});
			}
		}
	}
})();";
	return $script;
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
		<img class="avatar" src="<?php echo Typecho_Common::gravatarUrl($comments->mail, $options->avatarSize, null,$options->defaultAvatar);?>" width="<?php echo $options->avatarSize;?>">
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