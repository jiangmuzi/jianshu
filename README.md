#jianshu

使用方法
----

在后台启用主题后，设置外观

 - 设置网站导航上的单字
 - 备案号
 - 网站统计代码
 - 网站背景图(支持多图随机显示，只需要在多个图片之间用“,”分隔开即可)
 - 支持CDN加速网站静态资源（基于内容替换，默认使用七牛CDN，其他未测试）
 - 支持缩略图显示（使用七牛CDN自带的缩略图API,未配置时显示原图）

新建页面

 - 分类(categories)对应`分类页面`：博客分类展示，并显示该分类下最新文章
 - 存档(archives)对应`文章存档`：按日期展示博客所有文章
 - 标签(tags)对应`标签云`：显示博客所有标签
 - 友链(links)对应`友情链接`：显示友链

注意事项

 - 注1：页面对应的图标为`font awesome`，可自行修改
 - 注2：友链页面使用到Links插件，插件地址[http://www.imhan.com/archives/typecho_links_20141214](http://www.imhan.com/archives/typecho_links_20141214)
感谢作者分享的插件
 - 注3：文章浏览数统计使用的是[TePostViews](http://lixianhua.com/typecho_viewsnum_plugin.html)，可自行修改为自己使用的插件。需要修改的页面：`index.php`，`archive.php`，`post.php`
