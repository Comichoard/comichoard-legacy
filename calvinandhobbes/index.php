<?php
    $server = $_SERVER['HTTP_HOST'];
    if($server=='localhost') $server.='/comichoard';
    $url = 'http://'.$server.'/calvinandhobbes/calvinandhobbes.php?';
    $source = 'calvinandhobbes';
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
        <title>Calvin and Hobbes - Comic Hoard</title>
        <?php
            if(isset($_GET['strip']))   {
                echo '<meta property="og:title" content="'.$title.'"/>
                    <meta property="og:url" content="http://'.$_SERVER['HTTP_HOST'].'/calvinandhobbes/?strip='.$strip.'"/>
                    <meta property="og:description" content="Comic Hoard is a platform to read webcomics easily. XKCD, Cyanide & Happiness, Garfield, JL8 and many more..."/>
                    <meta property="og:image" content="'.$imgsrc.'"/>';
            }
            else   {
                echo '<meta property="og:title" content="Calvin and Hobbes"/>
                    <meta property="og:url" content="http://'.$_SERVER['HTTP_HOST'].'/calvinandhobbes"/>
                    <meta property="og:description" content="Comic Hoard is a platform to read webcomics easily. XKCD, Cyanide & Happiness, Garfield, JL8 and many more..."/>
                    <meta property="og:image" content="/favicon.png"/>';
            }
        ?>
        <?php include('../head.php');?>
    </head>
    <body>
        <div id="viewer">
            <div class="px"></div>
            <?php include('../top.php');?>
                <div class="jumbotron cdesc"><h1>Calvin and Hobbes 
                    <a href="http://www.gocomics.com/calvinandhobbes/" type="button" class="btn btn-default" target="_blank">www.gocomics.com/calvinandhobbes</a>
                    </h1>
                  </div>
            <div class="page"></div>
            <?php include('../bottom.php');?>
        </div>
        <script type="text/javascript" src="../googleanalytics.js" ></script>
    </body>
</html>