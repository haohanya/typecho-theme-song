<?php
/**
 * Archive page
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
			<?php $this->widget('Widget_Metas_Tag_Cloud', 'ignoreZeroCount=1&limit=50')->to($tagcloud); ?>
			<div class="tag-cloud">
				<div class="tagcloud-title">标签云</div>
				<div class="tagcloud-label">
					<?php while ($tagcloud->next()): ?>
						<a class="tagcloud-item" style="color: <?php $tagcloud_color = array("rgb(255, 189, 41)", "rgb(35, 171, 251)", "rgb(251, 35, 185)", "rgb(255, 112, 112)", "rgb(44, 204, 204)", "rgb(217, 65, 255)", "rgb(255, 64, 73)", "rgb(28, 137, 249)", "rgb(81, 206, 40)", "rgb(239, 78, 78)");echo $tagcloud_color[rand(0, 9)]; ?>;" href="<?php $tagcloud->permalink(); ?>" title='<?php $tagcloud->name(); ?>'><?php $tagcloud->name(); ?></a>
					<?php endwhile; ?>
				</div>
			</div>
                <?php
                    $stat = Typecho_Widget::widget('Widget_Stat');
                    $this->widget('Widget_Contents_Post_Recent', 'pageSize=' . $stat->publishedPostsNum)->to($archives);
                    $year = 0; $mon = 0;
                    $output = '<div class="archive-content">';
                    while ($archives->next()) {
                        $year_tmp = date('Y', $archives->created);
                        $mon_tmp = date('m', $archives->created);
                        if ($year > $year_tmp || $mon > $mon_tmp) {
                            $output .= '</div>';
                        }
                        if ($year != $year_tmp || $mon != $mon_tmp) {
                            $year = $year_tmp;
                            $mon = $mon_tmp;
                            $output .= '<div class="archive-title">' . date('F Y', $archives->created) . '</div><div class="archive-list">';
                        }
                        $output .= '<div class="archive-list-item"><div class="item-title"><a href="' . $archives->permalink . '">' . $archives->title . '</a></div><div class="item-date">---------- ' . date('d 日', $archives->created) . '</div></div>';
                    }
                    $output .= '</div></div>';
                    echo $output;
                ?>
	    </div>
	</article>
</div>
<?php $this->need('footer.php'); ?>