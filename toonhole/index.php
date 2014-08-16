<?php
    $server = $_SERVER['HTTP_HOST'];
    if($server=='localhost') $server.='/comichoard';
    $url = 'http://'.$server.'/toonhole/toonhole.php?';
    $source = 'toonhole';
    
    if(isset($_GET['strip']))
        $url .= 'strip='.$_GET['strip'].'&';
 
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
        $title = explode('"',$title[1]);
    }
?>

<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Toonhole - Comic Hoard</title>
        <?php
            if(isset($_GET['strip']))   {
                echo '<meta property="og:title" content="'.$title.'"/>
                    <meta property="og:url" content="http://'.$_SERVER['HTTP_HOST'].'/toonhole/?strip='.$strip.'"/>
                    <meta property="og:description" content="Cartoons that adults laugh at. Updated with cartoons every Monday, Wednesday, and Friday."/>
                    <meta property="og:image" content="'.$imgsrc.'"/>';
            }
            else   {
                echo '<meta property="og:title" content="Toonhole"/>
                    <meta property="og:url" content="http://'.$_SERVER['HTTP_HOST'].'/toonhole"/>
                    <meta property="og:description" content="Cartoons that adults laugh at. Updated with cartoons every Monday, Wednesday, and Friday."/>
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
            <div class="page">
                <?php
                    if(isset($display[1]))
                        echo $display[1];

                ?>
                <div id="scrolldown"><i class="fa fa-backward"></i><i class="fa fa-play"></i><i class="fa fa-forward"></i></div>
                <div id="loadmsg" class="jumbotron">Stay Calm and Wait for More</div>
            </div>
            <div id="footer" class="footer">Help your friends see how awesome Toonhole is too. <a href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fcomichoard.com%2Ftoonhole" class="btn btn-default begsuccess btn-sm" target="_blank">Share Toonhole</i></a></div>
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
        <script type="text/javascript" src="../../googleanalytics.js" ></script>
    </body>
</html>