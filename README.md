# Jianshu theme for typecho

主题包括配套插件，未开启插件时，不影响使用，但浏览数统计功能、喜欢功能、本地图片缩略图功能无法使用
## 开始安装

1. 切换到默认主题
2. 禁用旧版插件
3. 启用主题
4. 设置主题
5. 启用插件(按需启用)

## 主题设置

 - 文字Logo：单字显示
 - 博主头像：完整头像地址
 - 捐献二维码：完整二维码地址
 - 备案号
 - 网站统计代码
 - 图标样式：css代码，以支持菜单图标显示
 - 网站背景图：支持多图随机显示，只需要在多个图片之间用“,”分隔开即可
 - CDN加速网站静态资源：基于内容替换，默认使用七牛CDN，其他未测试
 - 缩略图显示：使用七牛CDN自带的缩略图API,未配置且未使用插件时显示原图
 - 列表显示：配置是否显示摘要及缩略图
 - Pjax开关：是否启用pjax

新建页面

 - ~~分类(categories)对应`分类页面`：博客分类展示，并显示该分类下最新文章~~
 - 存档(archives)对应`文章存档`：按日期展示博客所有文章
 - 标签(tags)对应`标签云`：显示博客所有标签
 - 友链(links)对应`友情链接`：显示友链

注意事项

 - 注1：页面对应的图标为`font awesome`，可自行修改
 - 注2：友链页面使用到Links插件，插件地址[http://www.imhan.com/archives/typecho_links_20141214](http://www.imhan.com/archives/typecho_links_20141214)
感谢作者分享的插件
 - 注3：~~文章浏览数统计使用的是[TePostViews](http://lixianhua.com/typecho_viewsnum_plugin.html)，可自行修改为自己使用的插件。需要修改的页面：`index.php`，`archive.php`，`post.php`~~
