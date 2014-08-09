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
            <?php include('top.php');?>
            <div class="panel-body">
                <div class="jumbotron thumb-main">
                    <br><h4>Now serving on Comic Hoard</h4>
                    <div class="thumb-container">
                        <a class="btn btn-default" href="http://comichoard.com/jl8">JL8</a>
                        <a class="btn btn-default" href="http://comichoard.com/xkcdcomic">XKCD</a>
                        <a class="btn btn-default" href="http://comichoard.com/toonhole">Toonhole</a>
                        <a class="btn btn-default" href="http://comichoard.com/mercworks">MercWorks</a>
                        <a class="btn btn-default" href="http://comichoard.com/maximumble">Maximumble</a>
                        <a class="btn btn-default" href="http://comichoard.com/spikedmath">Spiked Math</a>
                        <a class="btn btn-default" href="http://comichoard.com/garfield">Garfield</a>
                        <a class="btn btn-default" href="http://comichoard.com/pennyarcade">Penny Arcade</a>
                        <a class="btn btn-default" href="http://comichoard.com/shortpacked">Shortpacked</a>
                        <a class="btn btn-default" href="http://comichoard.com/pcweenies">PC Weenies</a>
                        <a class="btn btn-default" href="http://comichoard.com/buttersafe">Buttersafe</a>
                        <a class="btn btn-default" href="http://comichoard.com/threewordphrase">Three Word Phrase</a>
                        <a class="btn btn-default" href="http://comichoard.com/smbc">SMBC</a>
                        <a class="btn btn-default" href="http://comichoard.com/calvinandhobbes">Calvin and Hobbes</a>
                        <a class="btn btn-default" href="http://comichoard.com/cyanideandhappiness">Cyanide &amp; Happiness</a>
                        <a class="btn btn-default" href="http://comichoard.com/channelate">Channelate</a>
                        <a class="btn btn-default" href="http://comichoard.com/poorlydrawnlines">Poorly Drawn Lines</a>
                        <a class="btn btn-default" href="http://comichoard.com/doghousediaries">Doghouse Diaries</a>
                    </div>
                </div>
                <?php
                    if(isset($display[1]))
                        echo $display[1];
                ?>
                <div id="scrolldown"><i class="fa fa-backward"></i><i class="fa fa-play"></i><i class="fa fa-forward"></i></div>
                <div id="loadmsg" class="jumbotron">Stay Calm and Wait for More</div>
            </div>
        </div>

        <input id="next" type="hidden" value="<?php echo $display[0];?>">
        <input id="source" type="hidden" value="<?php echo $source;?>">
        <input id="website" type="hidden" value="<?php echo $_SERVER['HTTP_HOST'];?>">
        <script>
            var next = $("#next").val();
            var sort = $("#sort").val();
            var source = $("#source").val();
            var website = $("#website").val();
            var flag = 0;
		</script>
        
        <script type="text/javascript" src="googleanalytics.js" ></script>
    </body>
</html>