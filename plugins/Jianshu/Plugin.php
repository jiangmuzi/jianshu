<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * 简书主题配套工具
 * 添加浏览数统计、喜欢功能
 * @package Jianshu 
 * @author 绛木子
 * @version 1.0.0
 * @link http://lixianhua.com
 */
class Jianshu_Plugin implements Typecho_Plugin_Interface
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
        Typecho_Plugin::factory('Widget_Archive')->singleHandle = array('Jianshu_Plugin', 'viewCounter');
		//把新增的字段添加到查询中
        Typecho_Plugin::factory('Widget_Archive')->select = array('Jianshu_Plugin', 'selectHandle');
		//处理内容
		Typecho_Plugin::factory('Widget_Archive')->beforeRender = array('Jianshu_Plugin', 'beforeRender');
		//处理用户字段
		Typecho_Plugin::factory('Widget_Abstract_Users')->filter = array('Jianshu_Plugin', 'filterUser');
		//sitemap
		Helper::addRoute('sitemap', '/sitemap.xml', 'Jianshu_Action', 'sitemap');
		//工具提供的操作
		Helper::addAction('tools', 'Jianshu_Action');
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
		Helper::removeRoute('sitemap');
	}
    
    /**
     * 获取插件配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form){
		
		
	}
    
    /**
     * 个人用户的配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}
	
	//图片地址替换为七牛CDN
	public static function beforeRender($contents){
		$options = Typecho_Widget::widget('Widget_Options');
		$siteUrl = $options->siteUrl;
		$qiniu = $options->qiniu;
		
		if(!empty($qiniu)){
			$local = Typecho_Common::url('/usr/uploads', $siteUrl);
			$qiniu = Typecho_Common::url('/', $qiniu);
			$contents->text = str_ireplace($local,$qiniu,$contents->text);
		}
	}
	
	// 获取用户信息
	public static function filterUser($value,$users){
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