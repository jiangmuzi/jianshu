<?php
/**
 * 分类页面
 *
 * @package custom
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
<div class="main-container">
    <div class="categories clearfix">
         <?php $this->widget('Widget_Metas_Category_List')->to($categorys);?>
        <?php if ($categorys->have()): ?>
            <?php while($categorys->next()): ?>
                <div class="span6">
                    <div class="widget">
                        <div class="widget-title">
                            <a href="<?php $categorys->permalink();?>"><?php $categorys->name();?></a>
                            <span>文章：<?php $categorys->count();?></span>
                        </div>
                        <div class="widget-desc">
                            <?php $categorys->description();?>
                        </div>
                        <ul class="widget-list">
                            <?php $this->widget('Widget_Archive@categorys_'.$categorys->mid, 'pageSize=5&type=category', 'mid='.$categorys->mid)->parse('<li><a href="{permalink}">{title}</a></li>'); ?>
                        </ul>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</div><!-- end #main-->
<?php $this->need('footer.php'); ?>
