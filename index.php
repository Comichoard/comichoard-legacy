<?php
    $url = 'http://'.$_SERVER['HTTP_HOST'].'/feed.php';
    $source = 'feed';
    if($source != '')   {
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
        
        <meta name="google-site-verification" content="xlNcZc8ArGnPwoG6k_ttQ7TROqAmNWMahmzX2_DxgsM" />
        <link rel="icon" type="image/png" href="favicon.png">
        <meta name="description" content="Comic Hoard - The Webcomic Library" />
        <meta name="keywords" content="webcomic,comic,hoard,xkcd,maximumble,cyanide and happiness,channelate,jl8" />
        <link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css" rel="stylesheet">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,700,600,300,800" rel="stylesheet" type="text/css">
        <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/cdstyle.css?v=41" />
        <link rel="stylesheet" type="text/css" href="css/default.css?v=41" />
        <script type="text/javascript" src="js/jquery.dropdown.js"></script>
        <script src="js/modernizr.custom.63321.js"></script>
    </head>
    <body>
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
                <?php include('comicselect.php');?>
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
            $('#selcomic').dropdown({gutter:0,stack:false});
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
            
            
            $(".cd-dropdown ul li").click(function () {
                var scomic = $('input[name=selcomic]').val();
                if(scomic != '-1') {
                    window.location.href = 'http://'+website+scomic;
                }
            });
		</script>
        <script type="text/javascript" src="googleanalytics.js" ></script>
    </body>
</html>