<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * 简书主题配套工具
 * 
 * @package Tools 
 * @author 绛木子
 * @version 1.0.0
 * @link http://lixianhua.com
 */
class Tools_Plugin implements Typecho_Plugin_Interface
{
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     * 
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate(){
		$db = Typecho_Db::get();
        $prefix = $db->getPrefix();
		// 查看数
        if (!array_key_exists('viewsNum', $db->fetchRow($db->select()->from('table.contents'))))
            $db->query('ALTER TABLE `'. $prefix .'contents` ADD `viewsNum` INT(10) DEFAULT 0;');
        // 喜欢数
        if (!array_key_exists('likesNum', $db->fetchRow($db->select()->from('table.contents'))))
            $db->query('ALTER TABLE `'. $prefix .'contents` ADD `likesNum` INT(10) DEFAULT 0;');
		//增加浏览数
        Typecho_Plugin::factory('Widget_Archive')->singleHandle = array('Tools_Plugin', 'viewCounter');
		//把新增的字段添加到查询中
        Typecho_Plugin::factory('Widget_Archive')->select = array('Tools_Plugin', 'selectHandle');
		//压缩页面
		Typecho_Plugin::factory('Widget_Archive')->afterRender = array('Tools_Plugin', 'compress');
		//增加用户信息统计
		Typecho_Plugin::factory('Widget_Abstract_Users')->filter = array('Tools_Plugin', 'parseUser');
		//工具提供的操作
		Helper::addAction('tools', 'Tools_Action');
		//sitemap
		Helper::addRoute('baidu_sitemap', '/baidu_sitemap.xml', 'Tools_Action', 'sitemap');
	}
    
    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     * 
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate(){
		Helper::removeAction('tools');
		Helper::removeRoute('baidu_sitemap');
	}
    
    /**
     * 获取插件配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form){
		
		$zip = new Typecho_Widget_Helper_Form_Element_Radio(
          'zip', array('0' => '不启用', '1' => '启用'), '0',
          '是否压缩Html', '压缩Html，去除页面空白及注释');
        $form->addInput($zip);
		
		$defaultthumbnail = new Typecho_Widget_Helper_Form_Element_Text('defaultthumbnail', NULL, NULL, _t('默认缩略图'), _t('当文章没有图片时显示的缩略图，为空则不显示'));
        $form->addInput($defaultthumbnail);
		$thumbnailwidth = new Typecho_Widget_Helper_Form_Element_Text('thumbnailwidth', NULL, 100, _t('缩略图宽度'), _t('缩略图显示的宽度'));
        $form->addInput($thumbnailwidth);
        $thumbnailheight = new Typecho_Widget_Helper_Form_Element_Text('thumbnailheight', NULL, 90, _t('缩略图高度'), _t('缩略图显示的高度'));
        $form->addInput($thumbnailheight);
	}
    
    /**
     * 个人用户的配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}
	
	/**
	 * 获取gravatar头像地址
	 *
	 * @param string $mail
	 * @param int $size
	 * @param string $rating
	 * @param string $default
	 * @return string
	 */
	public static function gravatarUrl($mail, $size=32, $rating=null, $default=null){
		$url = 'http://gravatar.duoshuo.com';
		$url .= '/avatar/';

		if (!empty($mail)) {
			$url .= md5(strtolower(trim($mail)));
		}

		$url .= '?s=' . $size;
		$url .= '&amp;r=' . ($rating==null?Typecho_Widget::widget('Widget_Options')->commentsAvatarRating : $rating);
		$url .= '&amp;d=' . $default;

		return $url;
	}
	
	/**
	 * 缩略图
	 */
	public static function thumbnail($obj,$size=null,$link=false,$pattern='<div class="post-cover"><a href="{permalink}" title="{title}" style="background-image:url({image})"></a></div>'){
		
		$image = self::getThumbnail($obj->content,$size);

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
	public static function getThumbnail($content,$size=null){
		preg_match_all( "/<[img|IMG].*?src=[\'|\"](.*?)[\'|\"].*?[\/]?>/", $content, $matches );
		$image = '';
		
		if(isset($matches[1][0])){
			$image = $matches[1][0];
			$index = Typecho_Widget::widget('Widget_Options')->index;
			$siteUrl = Typecho_Widget::widget('Widget_Options')->siteUrl;
			$imageApi = Typecho_Common::url('/action/tools', $index);;
			if(strpos($image,$siteUrl)===0){
				$image = substr($image,strlen($siteUrl));
			}
			
			if($size!='full'){
				if($size==null){
					$options = Typecho_Widget::widget('Widget_Options')->plugin('Tools');
					$width = $options->thumbnailwidth;
					$height = $options->thumbnailheight;
					$size = $width.'x'.$height;
				}
				
				$image = $imageApi."?do=image&url={$image}&s={$size}";
				//$image .= '?imageView2/4/w/'.$width.'/h/'.$height;
			}
		}
		if(empty($image) && empty($options->defaultthumbnail)){
			return '';
		}else{
			$image = empty($image) ? $options->defaultthumbnail : $image;
		}
		return $image;
	}
	
	//压缩页面
	public static function compress($archive){
		$zip = Typecho_Widget::widget('Widget_Options')->plugin('Tools')->zip;
		
		if(!$zip || $archive->is('single')) return;
        $string = ob_get_contents();
		ob_end_clean();

		$string = str_replace("\r\n", '', $string); //清除换行符
		$string = str_replace("\n", '', $string); //清除换行符
		$string = str_replace("\t", '', $string); //清除制表符
		$pattern = array (
						"/> *([^ ]*) *</", //去掉注释标记
						"/[\s]+/",
						"/<!--[\\w\\W\r\\n]*?-->/",
						"/\" /",
						"/ \"/",
						"'/\*[^*]*\*/'"
						);
		$replace = array (
						">\\1<",
						" ",
						"",
						"\"",
						"\"",
						""
						);
		$string = preg_replace($pattern, $replace, $string);
		echo trim($string);
    }
	
	public static function parseUser($value,$users){
		static $_stat = array();
		if(isset($_stat[$value['uid']])){
			$value['postsNum'] = $_stat[$value['uid']]['postsNum'];
			$value['commentsNum'] = $_stat[$value['uid']]['commentsNum'];
		}else{
			$db = Typecho_Db::get();
			//文章数
			$_stat[$value['uid']]['postsNum'] = $value['postsNum'] = $db->fetchObject($db->select(array('COUNT(cid)' => 'num'))
						->from('table.contents')
						->where('table.contents.type = ?', 'post')
						->where('table.contents.status = ?', 'publish')
						->where('table.contents.authorId = ?', $value['uid']))->num;
			$_stat[$value['uid']]['commentsNum'] = $value['commentsNum'] = $db->fetchObject($db->select(array('COUNT(coid)' => 'num'))
						->from('table.comments')
						->where('table.comments.status = ?', 'approved')
						->where('table.comments.ownerId = ?', $value['uid']))->num;
		}
		
		return $value;
	}
	
	/**
	 * 标签云
	 * @params string 配置字符串
	 * @format string 格式化输出
	 * @return void
	 */
	public static function tagCloud($params=null,$format='<a href="{permalink}" style="{fontsize};{color};" title="{count}篇文章">{name}</a>'){
	
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
			$color = 'color:#'.self::randColor();
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
	public static function randColor(){
		$colors=array('ff3300','0517c2','0fc317','e7cc17','601165','ffb900','f74e1e','00a4ef','7fba00');
		return $colors[rand(0,8)];
		//return rand(120,200).','.rand(120,200).','.rand(120,200);
	}
	
	/**
     * 增加浏览量
     * @params Widget_Archive   $archive
     * @return void
     */
    public static function viewCounter($archive){
        if($archive->is('single')){
            $cid = $archive->cid;
            $views = Typecho_Cookie::get('__sis_pvs');
            if(empty($views)){
                $views = array();
            }else{
                $views = explode(',', $views);
            }
            if(!in_array($cid,$views)){
                $db = Typecho_Db::get();
                $row = $db->fetchRow($db->select('viewsNum')->from('table.contents')->where('cid = ?', $cid));
                $db->query($db->update('table.contents')->rows(array('viewsNum' => (int)$row['viewsNum']+1))->where('cid = ?', $cid));
                array_push($views, $cid);
                $views = implode(',', $views);
                Typecho_Cookie::set('__sis_pvs', $views); //记录查看cookie
            }
        }
    }
	
	//cleanAttribute('fields')清除查询字段，select * 
    public static function selectHandle($archive){
        $user = Typecho_Widget::widget('Widget_User');
		if ('post' == $archive->parameter->type || 'page' == $archive->parameter->type) {
            if ($user->hasLogin()) {
                $select = $archive->select()->where('table.contents.status = ? OR table.contents.status = ? OR
                        (table.contents.status = ? AND table.contents.authorId = ?)',
                        'publish', 'hidden', 'private', $user->uid);
            } else {
                $select = $archive->select()->where('table.contents.status = ? OR table.contents.status = ?',
                        'publish', 'hidden');
            }
        } else {
            if ($user->hasLogin()) {
                $select = $archive->select()->where('table.contents.status = ? OR
                        (table.contents.status = ? AND table.contents.authorId = ?)', 'publish', 'private', $user->uid);
            } else {
                $select = $archive->select()->where('table.contents.status = ?', 'publish');
            }
        }
        $select->where('table.contents.created < ?', Typecho_Date::gmtTime());
        $select->cleanAttribute('fields');
        return $select;
	}
}