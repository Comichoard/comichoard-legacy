<?php
    $server = $_SERVER['HTTP_HOST'];
    if($server=='localhost') $server.='/comichoard';
    $url = 'http://'.$server.'/jl8/jl8.php?';
    $source = 'jl8';
    
    if(isset($_GET['strip']))
        $url .= 'strip='.$_GET['strip'].'&';
    if(isset($_GET['sort']))
        $url .= 'sort='.$_GET['sort'].'&';
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    $display = explode('!znavfu',$result);

    if(isset($_GET['strip']))   {
        $strip=$_GET['strip'];
        $metadata = explode('<div class="card">',$display[1]);

        $metadata2 = explode('</div>' , $metadata[1]);
        $imgsrc = explode('src="',$metadata2[0]);
        $imgsrc2 = explode('"',$imgsrc[1]);
        $title = explode('alt="',$metadata[1]);
        $title2 = explode('"',$title[1]);
        if(strpos($metadata[1],'alt') === FALSE)    {
            $title2[0] = 'JL8';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>JL8 - Comic Hoard</title>
        <?php
            if(isset($_GET['strip']))   {
                echo '<meta property="og:title" content="'.$title2[0].'"/>
                    <meta property="og:url" content="http://'.$_SERVER['HTTP_HOST'].'/jl8/?strip='.$strip.'"/>
                    <meta property="og:description" content="Comic Hoard is a platform to read webcomics easily. XKCD, Cyanide & Happiness, Garfield, JL8 and many more..."/>
                    <meta property="og:image" content="'.$imgsrc2[0].'"/>';
            }
            else   {
                echo '<meta property="og:title" content="JL8"/>
                    <meta property="og:url" content="http://'.$_SERVER['HTTP_HOST'].'/jl8"/>
                    <meta property="og:description" content="Comic Hoard is a platform to read webcomics easily. XKCD, Cyanide & Happiness, Garfield, JL8 and many more..."/>
                    <meta property="og:image" content="/favicon.png"/>';
            }
        ?>
        <?php include('../head.php');?>
        <style>#comicnumselect{width:70px;display:inline-block;}.cdesc>p>span{margin-right: 50px;}</style>
    </head>
    <body>
        <?php include('../modalselect.php');?>
        <div id="viewer" class="panel panel-default">
            <div class="px"></div>
            <div id="top" class="panel-heading">
                <a id="gohome" class="btn btn-default btn-lg" href="http://comichoard.com">
                    Comic Hoard
                </a>
                <a id="gotofb" class="btn btn-default btn-lg" href="https://facebook.com/comichoard" target="_blank">
                    FCBK
                </a>
                <a id="gototwitter" class="btn btn-default btn-lg" href="https://twitter.com/ComicHoard" target="_blank">
                    TWTR
                </a>
                <button id="comicselect-btn" class="btn btn-default btn-lg" data-toggle="modal" data-target="#comicselect">
                    Select Comic To Read
                </button>

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
                <div id="scrolldown">NEXT<p class="glyphicon glyphicon-chevron-down"></p></div>
<div id="loadmsg" class="jumbotron">Stay Calm and Wait for More</div>
            </div>
            <div id="footer" class="footer">Help your friends see how awesome JL8 is too. <a href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fcomichoard.com%2Fjl8" class="btn btn-default begsuccess btn-sm" target="_blank">Share JL8</i></a></div>
        </div>

        <input id="next" type="hidden" value="<?php echo $display[0];?>">
        <input id="source" type="hidden" value="<?php echo $source;?>">
        <input id="website" type="hidden" value="<?php echo $_SERVER['HTTP_HOST'];?>">
        <input id="sort" type="hidden" value="<?php echo $_GET['sort'];?>">
        <script>
            var next = $("#next").val();
            var sort = $("#sort").val();
            var source = $("#source").val();
            var website = $("#website").val();
            var flag = 0;		
        </script>
        <script type="text/javascript" src="../googleanalytics.js" ></script>
    </body>
</html>