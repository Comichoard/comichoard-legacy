<?php
    $server = $_SERVER['HTTP_HOST'];
    if($server=='localhost') $server.='/comichoard';
    $source = 'feed';
    $url = 'http://'.$server.'/'.$source.'.php?';

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    $firstcomic = explode('}', $result);    
    $firstcomic[0].='}';
?>
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
        <div id="fb-root"></div>
        <div id="viewer" class="panel panel-default">
            <div class="px"></div>
            <?php include('top.php');?>
            <div class="jumbotron thumb-main"></div>
            <div class="page"></div>
            <?php include('bottom.php');?>
        </div>
        
        <script type="text/javascript" src="googleanalytics.js" ></script>
    </body>
</html>