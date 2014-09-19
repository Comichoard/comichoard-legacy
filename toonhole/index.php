<?php
    $server = $_SERVER['HTTP_HOST'];
    if($server=='localhost') $server.='/comichoard';
    $source = 'toonhole';
    $url = 'http://'.$server.'/'.$source.'/'.$source.'.php?';
    if(isset($_GET['sort']))   {    
        $sort=$_GET['sort'];
        $url .= 'sort='.$_GET['sort'].'&';
    }
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
        <div id="viewer">
            <div class="px"></div>
            <?php include('../top.php');?>
                <div class="jumbotron cdesc"><h1>Toonhole <a href="http://www.toonhole.com" type="button" class="btn btn-default" target="_blank">www.toonhole.com</a></h1>
                    <p>Get official Toonhole merchandise at <a href="http://www.toonhole.com/store/" class="btn btn-default" target="_blank">www.toonhole.com/store</a></p>
                </div>
            <div class="page"></div>
            <?php include('../bottom.php');?>
        </div>
        <script type="text/javascript" src="../googleanalytics.js" ></script>
    </body>
</html>