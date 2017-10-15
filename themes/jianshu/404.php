<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<article class="post page">
    <h1 class="post-title">404 - <?php _e('页面没找到'); ?></h1>
    <p><?php _e('你想查看的页面已被转移或删除了, 要不要搜索看看: '); ?></p>
    <form method="post" class="form form-inline">
        <div class="form-group"><input type="text" name="s" class="form-control" autofocus /></div>
        <div class="form-group"><button type="submit" class="btn btn-info"><?php _e('搜索'); ?></button><div class="form-group">
    </form>
</article>
<?php $this->need('footer.php'); ?>
