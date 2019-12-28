<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
</div>
    </div>
    <footer class="footer mdui-m-t-5 mdui-text-center">
        <nav class="social-links">
            <ul>
                <li class="social-link"><a href="" target="_blank"><i class="iconfont icon-rss"></i></a></li>
            </ul>
        </nav>
        <div class="copyright">
            <div class="col-md-6">2019 ©
                <a target="_blank" href="http://typecho.org/" rel="external nofollow">Typecho</a> Theme
                <a target="_blank" href="http://ucuser.cn" rel="external nofollow">song</a>
            </div>
        </div>
    </footer>
<style>
    #ref-url{
        width: 100%;
    }
    #ref-url>a{
        display: block;
        width: 100%;
        line-height: 50px;
        text-align: center;
        background-color: #0b98ff;
    }
</style>
<?php $this->footer(); ?>
<script>
    NProgress.start();
    window.onload=function(){
        NProgress.done();
    }
    var isok = true;
    $( "body" ).on( "click",".windowed,#ref-url>a", function() {
        $("#ajax-post-home-t").remove();
        $("html").css("overflow-y", "");
        $("body").css("overflow-y", "");
        isok = true;
    });

    function indexPost(){
        $(".index-list p").click(function () {
            if(!isok){
                return;
            }
            isok = false;
            var dh = $(this).attr("data-href");
            $.ajax({
                type:"get",
                url:dh,
                data:null,
                //请求数据
                beforeSend:function(){
                    //请求前的处理
                    NProgress.set(0.0);
                    commentParentLength = $("#comment-parent").length;
                },
                success:function(data){
                    NProgress.set(0.4);
                    $("html").css("overflow-y","hidden");
                    $("body").css("overflow-y","scroll");
                    $("<div id=\"ajax-post-home-t\" class=\"animated fadeIn\"\"><div id='modal'><div class=\"windowed\"></div><div class='pd'>"+$("#ajax-post-home",data).html()+"</div><div id='ref-url'><a href='"+dh+"'>查看全文</a> </div></div></div>").appendTo("body")
                },
                error:function(e){
                    //请求出错处理
                    NProgress.set(1.0);
                    return false;
                },
                complete:function(){
                    //请求完成的处理
                    NProgress.set(1.0);
                }
            })
        })
    }
    $(function () {indexPost();
        $(document).pjax('a[href^="<?php Helper::options()->siteUrl()?>"]:not(a[target="_blank"], a[no-pjax])', {
            container: '#pjax-container',
            fragment: '#pjax-container',
            timeout: 8000
        })
        $(document).on('pjax:send', function() {
            NProgress.start()
        }).on('pjax:complete', function() {
            $("#comments a").attr("data-pjax","");
            NProgress.done();
            indexPost();
        })
    })
</script>
</body>

</html>