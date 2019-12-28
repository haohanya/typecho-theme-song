<?php
/**
 * 这是<a href="http://www.ucuser.cn">浩瀚</a>移植于<a href="https://shanbu.fun/">山卜方</a>的一款模板
 * @package song
 * @author 浩瀚
 * @version 1.0
 * @link https://www.ucuser.cn/
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>
<style>
    .index-list p{
       cursor:pointer;
    }
    .post-title a{
        display: block;
        font-size: 35px;
    }
</style>
    <div id="s" class="mdui-col-md-8 mdui-col-offset-md-2 mdui-m-t-1">
        <?php if ($this->have()): ?>
            <?php while($this->next()): ?>
                <article class="mdui-p-a-5 index-list mdui-m-b-3 animated fadeIn" style="animation-delay: 0.8s;animation-duration: 2s">
                    <div class="mdui-col-sm-12">
                        <div class="mdui-col-sm-8">
                            <div class="mdui-typo-headline mdui-m-b-3 index-list-title index-guo">
                                <a href="<?php $this->permalink() ?>"><?php $this->title() ?></a>
                            </div>
                            <div class="mdui-typo-body-2 mdui-m-b-1" datetime="<?php $this->date(); ?>"><?php $this->date(); ?></div>
                            <div class="mdui-typo-subheading mdui-m-b-2 index-neirong">
                                <p data-href="<?php $this->permalink() ?>" ><?php $this->options->Summary ? $Summary = (int)$this->options->Summary : $Summary = 80;$this->excerpt($Summary, '...'); ?></p>
                            </div>
                        </div>
                        <div class="index-list-img-main mdui-col-sm-4">
                            <div class="main-hover index-list-img mdui-shadow-8" style="background-image:url('<?php showThumbnail($this); ?>')"></div>
                        </div>
                        <div class="index-list-a-main">
                            <div class="index-list-a yinying">
                                <?php $this->category(""); ?>
                            </div>
                            <div class="index-list-fenlei-main index-list-a yinying">
                                <a href="<?php $this->author->permalink(); ?>"><?php $this->author(); ?></a>
                            </div>
                        </div>
                    </div>
                </article>
            <?php endwhile; ?>
        <?php else: ?>
            暂无文章
        <?php endif; ?>
        <nav class="mdui-m-t-5">
            <div class="index-yema mdui-float-left"><?php $this->pageLink('上一页'); ?></div>
            <div class="index-yema mdui-float-right"><?php $this->pageLink('下一页','next'); ?></div>
        </nav>
    </div>
<?php $this->need('footer.php'); ?>