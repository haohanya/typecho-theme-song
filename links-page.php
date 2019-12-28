<?php
/**
 * Links page
 *
 * @package custom
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>
<div class="mdui-col-md-8 mdui-col-offset-md-2 ">
	<article class="mdui-p-a-2 post animated fadeIn" style="animation-delay: 0.8s;animation-duration: 2s">
        <div class="crumbs_patch">
		    <a href="<?php $this->options->siteUrl(); ?>">Home</a> &raquo;</li>
		    <?php if ($this->is('index')): ?><!-- 页面为首页时 -->
		        Latest Post
		    <?php elseif ($this->is('post')): ?><!-- 页面为文章单页时 -->
		        <?php $this->category(); ?> &raquo; <?php $this->title() ?>
		    <?php else: ?><!-- 页面为其他页时 -->
		        <?php $this->archiveTitle(' &raquo; ','',''); ?>
		    <?php endif; ?>
		</div>
	    <div class="post-title  mdui-m-b-1"><a href="<?php $this->permalink() ?>" title="<?php $this->title() ?>"><?php $this->title() ?></a></div>
	    <div class="mdui-typo-body-2 mdui-m-b-2" datetime="<?php $this->date(); ?>"><?php $this->date(); ?></div>
        <div class="mdui-m-b-2 mdui-typo post-neirong">
            <?php $this->content(); ?>
        </div>
    	<div class="mdui-divider mdui-m-b-2"></div>
        <div class="mdui-row-xs-2 post-fenye">
		</div>
<?php $this->need('comments.php'); ?>
    </article>
</div>
<?php $this->need('footer.php'); ?>