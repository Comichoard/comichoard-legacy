    <?php
    $server = $_SERVER['HTTP_HOST'];
    if($server=='localhost') $server.='/comichoard';
    $url = 'http://'.$server.'/smbc/smbc.php?';
    $source = 'smbc';
    
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
        $title = explode('"',$title[1]);
        if(strpos($metadata[1],'alt') === FALSE)    {
            $title = $source;
        }
    }
?>

<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>SMBC - Comic Hoard</title>
        <?php
            if(isset($_GET['strip']))   {
                echo '<meta property="og:title" content="'.$title.'"/>
                    <meta property="og:url" content="http://'.$_SERVER['HTTP_HOST'].'/smbc/?strip='.$strip.'"/>
                    <meta property="og:description" content="Comic Hoard is a platform to read webcomics easily. SMBC, Cyanide & Happiness, Garfield, JL8 and many more..."/>
                    <meta property="og:image" content="'.$imgsrc.'"/>';
            }
            else   {
                echo '<meta property="og:title" content="Saturday Morning Breakfast Cereal"/>
                    <meta property="og:url" content="http://'.$_SERVER['HTTP_HOST'].'/smbc"/>
                    <meta property="og:description" content="Comic Hoard is a platform to read webcomics easily. SMBC, Cyanide & Happiness, Garfield, JL8 and many more..."/>
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
            <div class="page">
                <?php echo $display[1];?>
                <div id="scrolldown"><i class="fa fa-backward"></i><i class="fa fa-play"></i><i class="fa fa-forward"></i></div>
                <div id="loadmsg" class="jumbotron">Stay Calm and Wait for More</div>
            </div>
            <div id="footer" class="footer">Help your friends see how awesome SMBC is too. <a href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fcomichoard.com%2Fsmbc" class="btn btn-default begsuccess btn-sm" target="_blank">Share SMBC</i></a></div>
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