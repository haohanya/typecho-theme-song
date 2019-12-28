<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport"
        content="width=device-width,minimum-scale=1,maximum-scale=1,initial-scale=1,user-scalable=no" />
    <meta charset="utf-8">
    <title><?php if ($this->is('index')): ?><?php if ($this->options->SiteSubtitle): ?><?php $this->options->title(); ?> - <?php $this->options->SiteSubtitle(); ?><?php else: ?><?php $this->options->title(); ?><?php endif; ?><?php else: ?><?php $this->archiveTitle(array('category'  =>  _t('分类 %s 下的文章'),'search'    =>  _t('包含关键字 %s 的文章'),'tag' =>  _t('标签 %s 下的文章'),'author'  =>  _t('%s 发布的文章')), '', ' - '); ?><?php $this->options->title(); ?><?php endif; ?></title>
    <?php $this->header(); ?>
    <!-- 通过自有函数输出HTML头部信息 -->
    <?php $this->header(); ?>
    <link rel="stylesheet" href="<?php $this->options->themeUrl('css/main.css'); ?>">
    <link href="<?php $this->options->themeUrl('css/animate.min.css'); ?>" rel="stylesheet">
    <link href="<?php $this->options->themeUrl('css/nprogress.css'); ?>" rel="stylesheet">
    <script src="<?php $this->options->themeUrl('js/jquery.min.js'); ?>"></script>
    <script src="<?php $this->options->themeUrl('js/jquery.pjax.js'); ?>"></script>
    <script src="<?php $this->options->themeUrl('js/nprogress.js'); ?>"></script>
</head>
<body>
    <header class="header mdui-m-b-5">
        <div class="container">
        	<div class="container-main">
            <div class="index-title animated fadeInDown mdui-text-center mdui-text-color-white mdui-m-b-2"
                style="animation-delay: 0.2s"><a href="<?php Helper::options()->siteUrl()?>">浩瀚</a>
            </div>
            <nav id="nav" class="mdui-text-center animated fadeInDown" style="animation-delay: 0.6s">
            	<li><a<?php if($this->is('index')): ?> class="current"<?php endif; ?> href="<?php $this->options->siteUrl(); ?>"><?php _e('首页'); ?></a></li>
			<?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
			<?php while($pages->next()): ?>
			<li><a<?php if($this->is('page', $pages->slug)): ?> class="current"<?php endif; ?> href="<?php $pages->permalink(); ?>" title="<?php $pages->title(); ?>"><?php $pages->title(); ?></a></li>
			<?php endwhile; ?>
            </nav>
        </div>
        </div>
    </header>
    <div id="pjax-container" class="mdui-container post-main">
        <div class="mdui-row">