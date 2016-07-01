<?php
// +----------------------------------------------------------------------
// | SISOME 
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://sisome.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 绛木子 <master@lixianhua.com>
// +----------------------------------------------------------------------
class Tools_Action extends Typecho_Widget implements Widget_Interface_Do{

	private $options;

	/**
	 * 生成网站地图
	 * 一小时更新一次
	 * 需要给tmp目录权限
	 */
	public function sitemap(){
		$xmlFile = __TYPECHO_ROOT_DIR__.__TYPECHO_PLUGIN_DIR__.'/Tools/tmp/baidu_sitemap.xml';
		$xml = @file_get_contents($xmlFile);
		if(!$xml || @filemtime($xmlFile) > time()){
			$stat = Typecho_Widget::widget('Widget_Stat');
			Typecho_Widget::widget('Widget_Contents_Post_Recent@all', 'pageSize='.$stat->publishedPostsNum)->to($list);
			$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
			$xml .= "<urlset>\n";
			while($list->next()){
				$xml .= "\t<url>\n";
				$xml .= "\t\t<loc>" . $list->permalink . "</loc>\n";
				$xml .= "\t\t<lastmod>" . date('Y-m-d', $list->modified) . "</lastmod>\n";
				$xml .= "\t\t<changefreq>daily</changefreq>\n";
				$xml .= "\t\t<priority>0.8</priority>\n";
				$xml .= "\t</url>\n";
			}
			$xml .= "</urlset>";
			file_put_contents($xmlFile, $xml, LOCK_EX);
			@touch($xmlFile, 3600 + time());
		}
		header("Content-Type: application/xml");
        echo $xml;
	}
    
	protected function like(){
		
		$cid = $this->request->cid;
		if(!$cid)
			$this->response->throwJson(array('status'=>0,'msg'=>'请选择喜欢的文章!'));
		$likes = Typecho_Cookie::get('__sis_pls');
		if(empty($likes)){
			$likes = array();
		}else{
			$likes = explode(',', $likes);
		}
		
		if(!in_array($cid,$likes)){
			$db = Typecho_Db::get();
			$row = $db->fetchRow($db->select('likesNum')->from('table.contents')->where('cid = ?', $cid)->limit(1));
			$db->query($db->update('table.contents')->rows(array('likesNum' => (int)$row['likesNum']+1))->where('cid = ?', $cid));
			array_push($likes, $cid);
			$likes = implode(',', $likes);
			Typecho_Cookie::set('__sis_pls', $likes); //记录查看cookie
			$this->response->throwJson(array('status'=>1,'msg'=>'成功点赞!'));
		}
		$this->response->throwJson(array('status'=>0,'msg'=>'你已经点赞过了!'));
	}

	public function thumbnail(){
		$siteUrl = Typecho_Widget::widget('Widget_Options')->siteUrl;
		$url = $this->request->get('url');
		$size = $this->request->get('s');
		
		if($size){
			$size = explode('x',$size);
			$size[1] = isset($size[1]) ? $size[1] : $size[0];
		}else{
			$options = Typecho_Widget::widget('Widget_Options')->plugin('Tools');
			$width = $options->thumbnailwidth;
			$height = $options->thumbnailheight;
			$size = array($width,$height);
		}

		$path = __TYPECHO_ROOT_DIR__ . $url;

		if(!is_file($path)) exit;
		
		require_once ('Image.php');
		$image = new Image();
		$image->open($path);
		$type = $image->type();
		
		$image->thumb($size[0], $size[1],3);
		
		header('Content-Type:image/'.$type.';');
		
		
		//输出图像
		if('jpeg' == $type || 'jpg' == $type){
			// 采用jpeg方式输出
			imagejpeg($image->showImg());
		}elseif('gif' == $type){
			imagegif($image->showImg());
		}else{
			$fun  =   'image'.$type;
			$fun($image->showImg());
		}
	}
	public function explore(){
		$stat = Typecho_Widget::widget('Widget_Stat');
		Typecho_Widget::widget('Widget_Contents_Post_Recent@all', 'pageSize='.$stat->publishedPostsNum)->to($archives);
		
		if(!$archives->have()){
			$this->response->throwJson(array('status'=>0,'msg'=>'暂未发布内容!'));
		}
		$urls = array();
		while($archives->next()){
			$urls[] = $archives->permalink;
		}
		$len = count($urls);
		$url = $urls[rand(0,$len-1)];
		$this->response->throwJson(array('status'=>1,'url'=>$url));
	}
    public function action(){
        $this->on($this->request->is('do=like'))->like();
		$this->on($this->request->is('do=image'))->thumbnail();
		$this->on($this->request->is('do=explore'))->explore();
    }
    
}