<?php
    $server = $_SERVER['HTTP_HOST'];
    if($server=='localhost') $server.='/comichoard';
    $url = 'http://'.$server.'/cyanideandhappiness/cyanideandhappiness.php?';
    $source = 'cyanideandhappiness';
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
        <title>Cyanide & Happiness - Comic Hoard</title>
        <?php
            if(isset($_GET['strip']))   {
                echo '<meta property="og:title" content="'.$title.'"/>
                    <meta property="og:url" content="http://'.$_SERVER['HTTP_HOST'].'/cyanideandhappiness/?strip='.$strip.'"/>
                    <meta property="og:description" content="Comic Hoard is a platform to read webcomics easily. XKCD, Cyanide & Happiness, Garfield, JL8 and many more..."/>
                    <meta property="og:image" content="'.$imgsrc.'"/>';
            }
            else   {
                echo '<meta property="og:title" content="Cyanide & Happiness"/>
                    <meta property="og:url" content="http://'.$_SERVER['HTTP_HOST'].'/cyanideandhappiness"/>
                    <meta property="og:description" content="Comic Hoard is a platform to read webcomics easily. XKCD, Cyanide & Happiness, Garfield, Jl8 and many more..."/>
                    <meta property="og:image" content="/favicon.png"/>';
            }
        ?>
        <?php include('../head.php');?>
        <style>#comicnumselect{width:80px;display:inline-block;}</style>
    </head>
    <body>
        <div id="viewer" class="panel panel-default">
            <div class="px"></div>
            <?php include('../top.php');?>
                <div class="jumbotron cdesc"><h1>Cyanide &amp; Happiness <a href="http://explosm.net" type="button" class="btn btn-default" target="_blank">www.explosm.net</a>
                    </h1>
                    <p>
                      <span>Sort in order
                          <a href="http://comichoard.com/cyanideandhappiness/?sort=asc" type="button" class="btn btn-default">From the start</a>
                          <a href="http://comichoard.com/cyanideandhappiness/?sort=desc" type="button" class="btn btn-default">Most recent first</a>
                      </span>
                      <span>Skip to comic <input id="comicnumselect" type="text" class="form-control" placeholder="####"></span>
                      <span>Get official Cyanide and Happiness merchandise at <a href="http://store.explosm.net/" class="btn btn-default" target="_blank">www.store.explosm.net</a></span>
                    </p>                
                </div>
            <div class="page"></div>
            <?php include('../bottom.php');?>
        </div>
        <script type="text/javascript" src="../googleanalytics.js" ></script>
    </body>
</html>