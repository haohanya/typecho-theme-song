<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!---评论--->
<style>
	#cancel-comment-reply-link{
		padding: 0 0 0 5px;
	}
	.v * {
	  transition: none;
	}
	ol{
		list-style: none;
	}
	.comment-parent {
    margin: 10px 0;
    border-radius: 5px;
    transition: all .2s;
}
    .comment-by-author::after{
        content: '';
        display: block;
        clear: both;
    }
    .comment-by-author{
        position: relative;
        border-top: 1px solid rgba(150, 150, 150, 0.08);;
    }
.comment-author {
    font-size: 12px;
    margin: 15px 0;
    overflow: hidden;
}
.comment-body>div>p {
    font-size: 12px;
    line-height: 30px;
}
.comment-meta a{
    color: #a9a4a4;
    display: inline-block;
    font-weight: normal;
    font-size: 12.6px;
}
.comment-author .avatar {
    float: left;
    margin-right: 10px;
    border-radius: 5px;
}

img {
    vertical-align: top;
    border: none;
}
</style>
<div id="message-reminder">

</div>
<?php $this->comments()->to($comments); ?>
<div id="comments" class="comment v">
    <?php if($this->allow('comment')): ?>
        <div class="vwrap" id="<?php $this->respondId(); ?>">
        <?php $comments->cancelReply(); ?>
            <form method="post" action="<?php $this->commentUrl() ?>" id="comment-form" role="form">
                 <div class="vheader item3">
                    <?php if($this->user->hasLogin()): ?>
                        <p><?php _e('登录身份: '); ?><a href="<?php $this->options->profileUrl(); ?>"><?php $this->user->screenName(); ?></a>. <a href="<?php $this->options->logoutUrl(); ?>" title="Logout"><?php _e('退出'); ?> &raquo;</a></p>
                    <?php else: ?>
                        <input name="author" id="author" value="<?php $this->remember('author'); ?>" placeholder="昵称" class="vnick vinput" type="text">
                        <input name="mail" id="mail" placeholder="邮箱" class="vmail vinput" value="<?php $this->remember('mail'); ?>"  />
                        <input type="url" name="url" id="url" placeholder="网址(http://)" class="vlink vinput" value="<?php $this->remember('url'); ?>" />
                    <?php endif; ?>
                </div>
                <div class="vedit">
                    <textarea name="text" class="veditor vinput" id="textarea" placeholder="兄台，快来评论下！" ><?php $this->remember('text'); ?></textarea>
                </div>
                <!--评论按钮-->
                <div class="vcontrol">
                    <div class="col col-80 text-right"><button id="submitCom" type="submit" title="Cmd|Ctrl+Enter" class="vsubmit vbtn">回复</button></div>
                </div>
                <div style="display:none;" class="vmark"></div>
            </form>
        </div>
    <?php else: ?>
        <h3><?php _e('评论已关闭'); ?></h3>
    <?php endif; ?>
    <!--评论列表-->
    <div id="comments-box">
        <h3><?php $this->commentsNum(_t('暂无评论'), _t('仅有一条评论'), _t('已有 %d 条评论')); ?></h3>

        <?php $comments->listComments(); ?>

        <?php $comments->pageNav('&laquo; 前一页', '后一页 &raquo;'); ?>
        <div class="vempty" style="display:none;"></div>
        <div class="vpage txt-center"></div>
    </div>
</div>
<!--评论结束-->
<script>
    function msgOk(msg){
        return $("<div class=\"msg msg-ok animated fadeInDown\">"+msg+"</div>");
    }
    function msgWarning(msg){
        return $("<div class=\"msg msg-warning animated fadeInDown\">"+msg+"</div>");
    }
    function msgError(msg){
        return $("<div class=\"msg msg-error animated fadeInDown\">"+msg+"</div>");
    }
    function err(e,msg) {
        if (e == "ok") {
            $("#message-reminder").prepend(msgOk(msg));
        } else if (e == "err") {
            $("#message-reminder").prepend(msgError(msg));
        } else {
            $("#message-reminder").prepend(msgWarning(msg));
        }
        var i = 0;
        var t1 = window.setInterval(refreshCount, 2000);

        function refreshCount() {
            i = $("#message-reminder .msg").length;
            $("#message-reminder .msg:eq(" + (i - 1) + ")").remove();
            if (i == 0) {
                window.clearInterval(t1);
            }
        }
    }
    // Ajax评论
    $("#comment-form").submit(function () {
        var commentParentLength = 0;//子评论标签是否存在
        var cpv = 0;//回复给人的id，从input：value获取
        var commID = 0;
        var commentData = $(this).serializeArray();
        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: commentData,
            error: function (e) {
                //请求出错处理
                NProgress.set(1.0);
                err("err","请求出错");
                return false;
            },
            success: function (data) {
                $("#submitCom").attr("disabled", true).css('cursor', 'not-allowed');
                NProgress.set(0.4);
                commentParentLength = $("#comment-parent").length;
                //请求成功时处理
                //判断 是否有评论。如果没有则直接copy过来
                if ($(".comment-list",data).length > 0) {
                    if ($("#comments-box>.comment-list").length == 0) {
                        $("#comments-box", data).appendTo($("#comments-box"));
                    } else {
                        //获取最新评论id
                        commID = $(".comment-list", data).html().match(/id=\"?comment-\d+/g).join().match(/\d+/g).sort(function (a, b) {
                            return a - b
                        }).pop();
                        if (commentParentLength > 0) {//如果大于0则属于子回复评论
                            cpv = $("#comment-parent").val();
                            var ccl = $("#comment-" + cpv).children(".comment-children").length;
                            if (ccl == 0) {//判断是否存在回复，如果等于0则属于无子回复则创建节点
                                //创建子评论父容器
                                $("#comment-" + cpv).append("<div class=\"comment-children\" itemprop=\"discusses\"><ol class=\"comment-list\"></ol></div>")
                                //创建子评论
                                $("#comment-" + commID, data).appendTo($("#comment-" + cpv + " .comment-list"));
                            }
                        } else {
                            //创建父评论
                            $("#comment-" + commID, data).prependTo($("#comments-box>.comment-list"));
                        }
                    }
                    err("ok","发表成功");
                    $("#textarea").val('');
                }else {
                    err("err",$(".container", data)["prevObject"][7]["innerText"].trim())
                }
                $("#comments a").attr("data-pjax", true);
                $("#submitCom").attr("disabled", false).css('cursor', 'pointer');
                NProgress.set(1.0);
            }
        })
        return false;
    });

</script>