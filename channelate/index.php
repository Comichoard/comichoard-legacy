<?php
    $url = 'http://'.$_SERVER['HTTP_HOST'].'/channelate/channelate.php?';
    $source = 'channelate';
    $strip = $_GET['strip'];
    if(isset($_GET['strip']))
        $url .= 'strip='.$_GET['strip'].'&';
 
    $data = array('nothing' => 'blahblah');
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
        ),
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);    
    $display = explode('!znavfu',$result);

    if(isset($_GET['strip']))   {
        $metadata = explode('<div class="well">',$display[1]);
        $metadata2 = explode('</div>' , $metadata[1]);
        $imgsrc = explode('src="',$metadata2[0]);
        $imgsrc2 = explode('"',$imgsrc[1]);
        $title = explode('alt="',$metadata[1]);
        $title2 = explode('"',$title[1]);
        if(strpos($metadata[1],'alt') === FALSE)    {
            $title2[0] = $source;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Channelate - Comic Hoard</title>
        <?php
            if(isset($_GET['strip']))   {
                echo '<meta property="og:title" content="'.$title2[0].'"/>
                    <meta property="og:url" content="http://'.$_SERVER['HTTP_HOST'].'/channelate/?strip='.$strip.'"/>
                    <meta property="og:description" content="Comic Hoard is a platform to read webcomics easily. XKCD, Cyanide & Happiness, Channelate, JL8 and many more..."/>
                    <meta property="og:image" content="'.$imgsrc2[0].'"/>';
            }
            else   {
                echo '<meta property="og:title" content="Channelate"/>
                    <meta property="og:url" content="http://'.$_SERVER['HTTP_HOST'].'/channelate"/>
                    <meta property="og:description" content="Comic Hoard is a platform to read webcomics easily. XKCD, Cyanide & Happiness, Channelate, JL8 and many more..."/>
                    <meta property="og:image" content="'.$imgsrc2[0].'"/>';
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
                    $.post("channelate.php?comic=" + next, function (e) {
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
                window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent('http://' + $('#website').val() + '/channelate/?strip=' + $(this).attr('data-share')));
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
                        $.post("channelate.php/?comic=" + next + "", function (e) {
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
            
            $(document).on('change','#comicdateselect',function(event) {
                var retain = $(".panel-body div:first-child").html();
                $(".panel-body").empty();
                $(".panel-body").append('<div class="jumbotron cdesc">'+retain+'</div>');
                $(".panel-body").append('<div id="loadmsg" class="jumbotron">Stay Calm and Wait for More</div>');
                $.post("channelate.php?comic=" + btoa($(this).val()), function (e) {
                    next = e.split("!znavfu")[0];
                    e = e.split("!znavfu")[1];
                    e = e.split("<!--")[0];
                    if (e.split("script").length == 1)
                        $("#loadmsg").before(e);
                });
            });
		</script>
        <script type="text/javascript" src="/googleanalytics.js" ></script>
    </body>
</html>