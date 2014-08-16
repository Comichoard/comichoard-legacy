<?php
    $server = $_SERVER['HTTP_HOST'];
    if($server=='localhost') $server.='/comichoard';
    $url = 'http://'.$server.'/channelate/channelate.php?';
    $source = 'channelate';
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
        $data=json_decode($result[0].'}');
        $imgsrc = $data->{"image"};
        $title = $data->{"comic"}.': '.$data->{'desc'};
    }
?>

<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Channelate - Comic Hoard</title>
        <?php
            if(isset($_GET['strip']))   {
                echo '<meta property="og:title" content="'.$title.'"/>
                    <meta property="og:url" content="http://'.$_SERVER['HTTP_HOST'].'/channelate/?strip='.$strip.'"/>
                    <meta property="og:description" content="Comic Hoard is a platform to read webcomics easily. XKCD, Cyanide & Happiness, Channelate, JL8 and many more..."/>
                    <meta property="og:image" content="'.$imgsrc.'"/>';
            }
            else   {
                echo '<meta property="og:title" content="Channelate"/>
                    <meta property="og:url" content="http://'.$_SERVER['HTTP_HOST'].'/channelate"/>
                    <meta property="og:description" content="Comic Hoard is a platform to read webcomics easily. XKCD, Cyanide & Happiness, Channelate, JL8 and many more..."/>
                    <meta property="og:image" content="/favicon.png"/>';
            }
        ?>
        <?php include('../head.php');?>
        <style>#comicdateselect{width:170px;display:inline-block;}</style>
    </head>
    <body>
        <?php include('../modalselect.php');?>
        <div id="viewer" class="panel panel-default">
            <div class="px"></div>
            <?php include('../top.php');?>
            <div class="page">
                <div class="jumbotron cdesc">
                    <h1>Channelate <a href="http://www.channelate.com" type="button" class="btn btn-default" target="_blank">www.channelate.com</a>
                    <a class="fb-like btn btn-default" data-href="https://facebook.com/comichoard" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></a></h1>
                    <p>Get official Channelate merchandise at <a href="http://channelate.bigcartel.com/" class="btn btn-default" target="_blank">www.channelate.bigcartel.com</a></p>
                </div>
                <div id="scrolldown"><i class="fa fa-backward"></i><i class="fa fa-play"></i><i class="fa fa-forward"></i></div>
                <div id="loadmsg" class="jumbotron">Stay Calm and Wait for More</div>
            </div>
            <div id="footer" class="footer">Help your friends see how awesome Channelate is too. <a href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fcomichoard.com%2Fchannelate" class="btn btn-default begsuccess btn-sm" target="_blank">Share Channelate</i></a></div>
        </div>

        <input id="firstcomic" type="hidden" value="<?php echo base64_encode($firstcomic[0]);?>">
        <input id="source" type="hidden" value="<?php echo $source;?>">
        <input id="website" type="hidden" value="<?php echo $_SERVER['HTTP_HOST'];?>">
        <script>
            var next = $("#next").val();
            var sort = $("#sort").val();
            var source = $("#source").val();
            var website = $("#website").val();
            var firstcomic = $('#firstcomic').val();
            var flag = 0;
		</script>
        <script type="text/javascript" src="../../googleanalytics.js" ></script>
    </body>
</html>