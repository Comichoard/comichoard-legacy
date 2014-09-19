<?php
    $server = $_SERVER['HTTP_HOST'];
    if($server=='localhost') $server.='/comichoard';
    $source = 'twoguysandguy';
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
        <title>Two Guys and Guy - Comic Hoard</title>
        <?php
            if(isset($_GET['strip']))   {
                echo '<meta property="og:title" content="'.$title.'"/>
                    <meta property="og:url" content="http://'.$_SERVER['HTTP_HOST'].'/twoguysandguy/?strip='.$strip.'"/>
                    <meta property="og:description" content="Comic Hoard is a platform to read webcomics easily. XKCD, Cyanide & Happiness, Garfield, JL8 and many more..."/>
                    <meta property="og:image" content="'.$imgsrc.'"/>';
            }
            else   {
                echo '<meta property="og:title" content="Two Guys and Guy"/>
                    <meta property="og:url" content="http://'.$_SERVER['HTTP_HOST'].'/twoguysandguy"/>
                    <meta property="og:description" content="Comic Hoard is a platform to read webcomics easily. XKCD, Cyanide & Happiness, Garfield, Jl8 and many more..."/>
                    <meta property="og:image" content="/favicon.png"/>';
            }
        ?>
        <?php include('../head.php');?>
        <style>#comicnumselect{width:80px;display:inline-block;}</style>
    </head>
    <body>
        <div id="viewer">
            <div class="px"></div>
            <?php include('../top.php');?>
                <div class="jumbotron cdesc"><h1>Two Guys and Guy <a href="http://twogag.com/" type="button" class="btn btn-default" target="_blank">www.twogag.com</a>
                    </h1>
                    <p>
                      <span>Sort in order
                          <a href="http://comichoard.com/twoguysandguy/?sort=asc" type="button" class="btn btn-default">From the start</a>
                          <a href="http://comichoard.com/twoguysandguy/?sort=desc" type="button" class="btn btn-default">Most recent first</a>
                      </span>
                      <span>Get official Two Guys and Guy merchandise at <a href="http://www.twogag.com/store-2" class="btn btn-default" target="_blank">www.twogag.com/store-2</a></span>
                    </p>                
                </div>
            <div class="page"></div>
            <?php include('../bottom.php');?>
        </div>
        <script type="text/javascript" src="../googleanalytics.js" ></script>
    </body>
</html>