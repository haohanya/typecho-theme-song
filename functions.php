<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; 

//缩略图
function showThumbnail($widget)
{ 
    $mr = 'http://p18.qhimg.com/bdr/__85/t01c253c16e180814f5.jpg'; 
    $attach = $widget->attachments(1)->attachment;
    $pattern = '/\<img.*?src\=\"(.*?)\"[^>]*>/i'; 
if (preg_match_all($pattern, $widget->content, $thumbUrl)) {
         echo $thumbUrl[1][0];
    } elseif ($attach->isImage) {
      echo $attach->url; 
    } else {
        echo $mr;
    }
}
function themeInit($archive)
{
    Helper::options()->commentsAntiSpam = false;
}