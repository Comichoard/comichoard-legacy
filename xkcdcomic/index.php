<?php
    $server = $_SERVER['HTTP_HOST'];
    if($server=='localhost') $server.='/comichoard';
    $source = 'xkcdcomic';
    $url = 'http://'.$server.'/'.$source.'/'.$source.'.php?';
    if(isset($_GET['strip']))   {    
        $strip=$_GET['strip'];
        $url .= 'strip='.$_GET['strip'].'&';
    }
    if(isset($_GET['sort']))   {    
        $strip=$_GET['sort'];
        $url .= 'sort='.$_GET['sort'].'&';
    }

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    $firstcomic = explode('}', $result);    
    $firstcomic[0].='}';

    if(isset($_GET['strip']))   {    
        $data=json_decode($firstcomic[0]);
        $imgsrc = $data->{"image"};
        $title = $data->{"comic"}.': '.$data->{'desc'};
    }
?>

<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>XKCD - Comic Hoard</title>
        <?php
            if(isset($_GET['strip']))   {
                echo '<meta property="og:title" content="'.$title.'"/>
                    <meta property="og:url" content="http://'.$_SERVER['HTTP_HOST'].'/xkcdcomic/?strip='.$strip.'"/>
                    <meta property="og:description" content="Comic Hoard is a platform to read webcomics easily. XKCD, Cyanide & Happiness, Garfield, JL8 and many more..."/>
                    <meta property="og:image" content="'.$imgsrc.'"/>';
            }
            else   {
                echo '<meta property="og:title" content="XKCD"/>
                    <meta property="og:url" content="http://'.$_SERVER['HTTP_HOST'].'/xkcdcomic"/>
                    <meta property="og:description" content="Comic Hoard is a platform to read webcomics easily. XKCD, Cyanide & Happiness, Garfield, JL8 and many more..."/>
                    <meta property="og:image" content="/favicon.png"/>';
            }
        ?>
        <?php include('../head.php');?>
        <style>#comicnumselect{width:70px;display:inline-block;}</style>
    </head>
    <body>
        <?php include('../modalselect.php');?>
        <div id="viewer" class="panel panel-default">
            <div class="px"></div>
            <?php include('../top.php');?>
                <div class="jumbotron cdesc"><h1>XKCD <a href="http://xkcd.com" type="button" class="btn btn-default" target="_blank">www.xkcd.com</a><a class="fb-like btn btn-default" data-href="https://facebook.com/comichoard" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></a><span class="btn btn-default"><a href="https://twitter.com/ComicHoard" class="twitter-follow-button" data-show-count="false" data-dnt="true">Follow @ComicHoard</a></span></h1>
                    <p>
                    <span>Sort in order
                    <a href="http://comichoard.com/xkcdcomic/?sort=asc" type="button" class="btn btn-default">From the start</a>
                    <a href="http://comichoard.com/xkcdcomic/?sort=desc" type="button" class="btn btn-default">Most recent first</a></span>
                    <span>Skip to comic <input id="comicnumselect" type="text" class="form-control" placeholder="####"></span>
                    </p>
                </div>
            <div class="page"></div>
            <?php include('../bottom.php');?>
        </div>
        <script type="text/javascript" src="../googleanalytics.js" ></script>
    </body>
</html>