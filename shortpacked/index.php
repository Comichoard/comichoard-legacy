<?php
    $server = $_SERVER['HTTP_HOST'];
    if($server=='localhost') $server.='/comichoard';
    $source = 'shortpacked';
    $url = 'http://'.$server.'/'.$source.'/'.$source.'.php?';
    if(isset($_GET['strip']))   {    
        $strip=$_GET['strip'];
        $url .= 'strip='.$_GET['strip'].'&';
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
        <title>Shortpacked - Comic Hoard</title>
        <?php
            if(isset($_GET['strip']))   {
                echo '<meta property="og:title" content="'.$title.'"/>
                    <meta property="og:url" content="http://'.$_SERVER['HTTP_HOST'].'/shortpacked/?strip='.$strip.'"/>
                    <meta property="og:description" content="Comic Hoard is a platform to read webcomics easily. XKCD, Cyanide & Happiness, Garfield, JL8 and many more..."/>
                    <meta property="og:image" content="'.$imgsrc.'"/>';
            }
            else   {
                echo '<meta property="og:title" content="Shortpacked"/>
                    <meta property="og:url" content="http://'.$_SERVER['HTTP_HOST'].'/shortpacked"/>
                    <meta property="og:description" content="Comic Hoard is a platform to read webcomics easily. XKCD, Cyanide & Happiness, Garfield, JL8 and many more..."/>
                    <meta property="og:image" content="/favicon.png"/>';
            }
        ?>
        <?php include('../head.php');?>
    </head>
    <body>
        <?php include('../modalselect.php');?>
        <div id="viewer" class="panel panel-default">
            <div class="px"></div>
            <?php include('../top.php');?>
                <div class="jumbotron cdesc"><h1>Shortpacked 
                    <a href="http://shortpacked.com/" type="button" class="btn btn-default" target="_blank">www.shortpacked.com</a><a class="fb-like btn btn-default" data-href="https://facebook.com/comichoard" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></a><span class="btn btn-default"><a href="https://twitter.com/ComicHoard" class="twitter-follow-button" data-show-count="false" data-dnt="true">Follow @ComicHoard</a></span></h1>
                    <p>Get official Shortpacked merchandise at <a href="http://shortpacked.bigcartel.com/" class="btn btn-default" target="_blank">www.shortpacked.bigcartel.com</a></p>
                </div>
            <div class="page"></div>
            <?php include('../bottom.php');?>
        </div>

        <input id="firstcomic" type="hidden" value="<?php echo base64_encode($firstcomic[0]);?>">
        <input id="source" type="hidden" value="<?php echo $source;?>">
        <input id="website" type="hidden" value="<?php echo $_SERVER['HTTP_HOST'];?>">
        <script>
            var sort = $("#sort").val();
            var source = $("#source").val();
            var website = $("#website").val();
            var firstcomic = $('#firstcomic').val();
            var flag = 0;
		</script>
        <script type="text/javascript" src="../../googleanalytics.js" ></script>
    </body>
</html>