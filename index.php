<?php
    $server = $_SERVER['HTTP_HOST'];
    if($server=='localhost') $server.='/comichoard';
    $url = 'http://'.$server.'/feed.php';
    $source = 'feed';
    if($source != '')   {
        $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);    
        $display = explode('!znavfu',$result);
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Comic Hoard</title>
        
        <meta property="og:title" content="Comic Hoard"/>
        <meta property="og:url" content="http://comichoard.com"/>
        <meta property="og:description" content="Comic Hoard is a platform to read webcomics easily. XKCD, Cyanide &amp; Happiness, Garfield, JL8 and many more..."/>
        <meta property="og:image" content="http://comichoard.com/favicon.png"/>

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@ComicHoard">
        <meta name="twitter:title" content="Comic Hoard">
        <meta name="twitter:description" content="Comic Hoard is a platform to read webcomics easily. XKCD, Cyanide &amp; Happiness, Garfield, JL8 and many more...">
        <meta name="twitter:image:src" content="http://comichoard.com/favicon.png">
        
        <?php include('head.php');?>
    </head>
    <body>
        <?php include('modalselect.php');?>
        <div id="fb-root"></div>
        <div id="viewer" class="panel panel-default">
            <div class="px"></div>
            <div id="top" class="panel-heading">
                <a id="gohome" class="btn btn-default btn-lg" href="http://comichoard.com">
                    Comic Hoard
                </a>
                <a id="gotofb" class="btn btn-default btn-lg" href="https://facebook.com/comichoard" target="_blank">
                    <i class="fa fa-facebook"></i>
                </a>
                <a id="gototwitter" class="btn btn-default btn-lg" href="https://twitter.com/ComicHoard" target="_blank">
                    <i class="fa fa-twitter"></i>
                </a>
                <button id="comicselect-btn" class="btn btn-default btn-lg" data-toggle="modal" data-target="#comicselect">
                    Select Comic To Read
                </button>
                <a id="fbpage" href="contact.php" class="btn btn-default btn-lg" target="_blank">
                    Contact us
                </a>
            </div>
            <div class="panel-body">
                <div class="jumbotron cdesc index-cdesc">
                    <p><br>Now serving on Comic Hoard</p>
                    <?php include('thumbs.php');?>
                </div>
                <p id="prompter">Scroll Down to read latest from all</p>
                <br>                    
                <?php
                    echo $display[1];
                ?>
                <div id="loadmsg" class="jumbotron">Stay Calm and Wait for More</div>
            </div>
        </div>

        <input id="next" type="hidden" value="<?php echo $display[0];?>">
        <input id="source" type="hidden" value="<?php echo $source;?>">
        <input id="website" type="hidden" value="<?php echo $_SERVER['HTTP_HOST'];?>">
        <script>
            if ($('.px').css('opacity') == '1') {
                $('#gohome').html('CH');
            }
            var next = $("#next").val();
            var source = $("#source").val();
            var website = $("#website").val();
            var flag = 0;
            $(window).scroll(function () {
                if ($(window).scrollTop() + $(window).height() > $(document).height() - 4000 && flag == 0) {
                    flag = 1;
                    $.post("feed.php?comic=" + next + "", function (e) {
                        next = e.split("!znavfu")[0];
                        e = e.split("!znavfu")[1];
                        e = e.split("<!--")[0];
                        if (e.split("script").length == 1)
                            $("#loadmsg").before(e);
                        flag = 0;
                    });
                }
            });
            $(document).on('click','.s',function (event) {
                var srclink = source;
                if (source == 'feed') {
                    srclink = $(this).parent().parent().attr('data-comic');
                }
                window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent('http://' + $('#website').val() + '/' + srclink + '/?strip=' + $(this).attr('data-share')));
            });
		</script>
        
        <script type="text/javascript" src="googleanalytics.js" ></script>
    </body>
</html>