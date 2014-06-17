<?php
    $server = $_SERVER['HTTP_HOST'];
    if($server=='localhost') $server.='/comichoard';
    $url = 'http://'.$server.'/cyanideandhappiness/cyanideandhappiness.php?';
    $source = 'cyanideandhappiness';
    
    if(isset($_GET['strip']))
        $url .= 'strip='.$_GET['strip'].'&';
 
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    $display = explode('!znavfu',$result);

    if(isset($_GET['strip']))   {
        $metadata = explode('<div class="well">',$display[1]);
        $metadata2 = explode('</div>' , $metadata[1]);
        $imgsrc = explode('src="',$metadata2[0]);
        $imgsrc2 = explode('"',$imgsrc[1]);
        $title = explode('alt="',$metadata[1]);
        $title2 = explode('"',$title[1]);
        if(strpos($metadata[1],'alt') === FALSE)    {
            $title = explode('<span>',$metadata[1]);
            $title2 = explode('</span>',$title[2]);
            $title2[0] = 'Cyanide & Happiness : '.$title2[0];
            $imgsrc2[0] = 'http://'.$_SERVER['HTTP_HOST'].'/cyanideandhappiness/shortimage.jpg';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Cyanide & Happiness - Comic Hoard</title>
        <?php
            if(isset($_GET['strip']))   {
                echo '<meta property="og:title" content="'.$title2[0].'"/>
                    <meta property="og:url" content="http://'.$_SERVER['HTTP_HOST'].'/cyanideandhappiness/?strip='.$strip.'"/>
                    <meta property="og:description" content="Comic Hoard is a platform to read webcomics easily. XKCD, Cyanide & Happiness, Garfield, JL8 and many more..."/>
                    <meta property="og:image" content="'.$imgsrc2[0].'"/>';
            }
            else   {
                echo '<meta property="og:title" content="Cyanide & Happiness"/>
                    <meta property="og:url" content="http://'.$_SERVER['HTTP_HOST'].'/cyanideandhappiness"/>
                    <meta property="og:description" content="Comic Hoard is a platform to read webcomics easily. XKCD, Cyanide & Happiness, Garfield, Jl8 and many more..."/>
                    <meta property="og:image" content="/favicon.png"/>';
            }
        ?>
        <?php include('../head.php');?>
        <style>#comicdateselect{width:170px;display:inline-block;}</style>
    </head>
    <body>
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
                <?php include('../comicselect.php');?>
            
                <?php 
                    if(isset($_COOKIE[$source]))    {
                        echo '<a id="resume" type="button" class="btn btn-default btn-lg" data-del="yes">Continue From Last Time</a>';
                    }
                ?>
            </div>
            <div class="panel-body">
                <?php
                    if($source != '')
                        echo $display[1];

                ?>
                <div id="loadmsg" class="jumbotron">Stay Calm and Wait for More</div>
            </div>
        </div>

        <input id="next" type="hidden" value="<?php echo $display[0];?>">
        <input id="source" type="hidden" value="<?php echo $source;?>">
        <input id="website" type="hidden" value="<?php echo $_SERVER['HTTP_HOST'];?>">
        <input id="sort" type="hidden" value="<?php echo $_GET['sort'];?>">
        <script>
            if ($('.px').css('opacity') == '1') {
                $('#gohome').html('CH');
            }
            $('#selcomic').dropdown({gutter:0,stack:false});
            function savepos(e, t) {
                $.post("pos.php", {
                    source: e,
                    position: t
                });
                $(".well").each(function () {
                    if ($(this).html() == "") {
                        $(this).remove()
                    }
                })
            }
            var next = $("#next").val();
            var sort = $("#sort").val();
            var source = $("#source").val();
            var website = $("#website").val();
            var flag = 0;
            $(window).scroll(function () {
                if ($(window).scrollTop() + $(window).height() > $(document).height() - 4000 && flag == 0) {
                    flag = 1;
                    $.post("cyanideandhappiness.php?comic=" + next, function (e) {
                        next = e.split("!znavfu")[0];
                        e = e.split("!znavfu")[1];
                        e = e.split("<!--")[0];
                        if (e.split("script").length == 1)
                            $("#loadmsg").before(e);
                        flag = 0;
                    });
                    savepos(source, next);
                }
            });
            $(document).on('click','.s',function (event) {
                var srclink = source;
                if (source == 'feed') {
                    srclink = $(this).parent().parent().attr('data-comic');
                }
                window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent('http://' + $('#website').val() + '/cyanideandhappiness/?strip=' + $(this).attr('data-share')));
            });
            $("#resume").click(function () {
                if ($("#resume").attr('data-del') == 'yes') {
                    flag = 1;
                    $.post("pos.php", {
                        source: source,
                        getpos: "1"
                    }, function (e) {
                        next = e.split("<!--")[0];
                        var retain = $(".panel-body div:first-child").html();
                        $(".panel-body").empty();
                        $(".panel-body").append('<div class="jumbotron cdesc">'+retain+'</div>');
                        $(".panel-body").append('<div id="loadmsg" class="jumbotron">Stay Calm and Wait for More</div>');
                        $.post("cyanideandhappiness.php/?comic=" + next + "", function (e) {
                            next = e.split("!znavfu")[0];
                            e = e.split("!znavfu")[1];
                            e = e.split("<!--")[0];
                            if (e.split("script").length == 1)
                                $("#loadmsg").before(e);
                        });
                        flag = 0;
                    });
                }
            });

            
            $(".cd-dropdown ul li").click(function () {
                var scomic = $('input[name=selcomic]').val();
                if(scomic != '-1') {       
                    if(scomic.charAt(0) != '/') {
                        window.location.href = 'http://'+website+'/?comic='+scomic;
                    }
                    else  {
                        window.location.href = 'http://'+website+scomic;
                    }
                }
            });
            
		</script>
        <script type="text/javascript" src="/googleanalytics.js" ></script>
    </body>
</html>