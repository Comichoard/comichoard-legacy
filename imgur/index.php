<?php
    $server = $_SERVER['HTTP_HOST'];
    if($server=='localhost') $server.='/comichoard';
    $url = 'http://'.$server.'/imgur/imgur.php?';
    $source = 'imgur';
    
    if(isset($_GET['strip']))
        $url .= 'strip='.$_GET['strip'].'&';
 
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    $display = explode('!znavfu',$result);

    $metadata = explode('<div class="card">',$display[1]);
    $metadata2 = explode('</div>' , $metadata[1]);
    $imgsrc = explode('src="',$metadata2[0]);
    $imgsrc2 = explode('"',$imgsrc[1]);
    if(isset($_GET['strip']))   {
        $strip=$_GET['strip'];
        $metadata = explode('<div class="card">',$display[1]);

        $metadata2 = explode('</div>' , $metadata[1]);
        $imgsrc = explode('src="',$metadata2[0]);
        $imgsrc2 = explode('"',$imgsrc[1]);

        $title = explode('alt="',$metadata[1]);
        $title2 = explode('"',$title[1]);
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>imgur - Comic Hoard</title>
        <?php
            if(isset($_GET['strip']))   {
                echo '<meta property="og:title" content="'.$title2[0].'"/>
                    <meta property="og:url" content="http://'.$_SERVER['HTTP_HOST'].'/imgur/?strip='.$strip.'"/>
                    <meta property="og:description" content="Comic Hoard is a platform to read webcomics easily. XKCD, Cyanide & Happiness, Garfield, JL8 and many more..."/>
                    <meta property="og:image" content="'.$imgsrc2[0].'"/>';
            }
            else   {
                echo '<meta property="og:title" content="imgur"/>
                    <meta property="og:url" content="http://'.$_SERVER['HTTP_HOST'].'/imgur"/>
                    <meta property="og:description" content="Comic Hoard is a platform to read webcomics easily. XKCD, Cyanide & Happiness, Garfield, Jl8 and many more..."/>
                    <meta property="og:image" content="'.$imgsrc2[0].'"/>';
            }
        ?>
        <?php include('../head.php');?>
        <style>img{margin:10px}.modal-body{text-align:center}.modal-body>img{max-width:95%}.modal-body>p{text-align:left}</style>
    </head>
    <body>
        <?php include('../modalselect.php');?>
        <div id="viewer" class="panel panel-default">
            <div class="px"></div>
            <div id="top" class="panel-heading">
                <a id="gohome" class="btn btn-default btn-lg" href="http://comichoard.com">
                    Comic Hoard
                </a>
                <a id="gotofb" class="btn btn-default btn-lg" href="https://facebook.com/comichoard" target="_blank">
                    <i class="fa fa-facebook"></i>
                </a>
                <a id="gototwitter" class="btn btn-default btn-lg" href="https://twitter.com/ComicHoard" target="_blank">
                    <i class="fa fa-twitter"></i>
                </a>
                <button id="comicselect-btn" class="btn btn-default btn-lg" data-toggle="modal" data-target="#comicselect">
                    Select Comic To Read
                </button>
            </div>
            <style>.modal-content{border-radius:0;-o-border-radius:0;-moz-border-radius:0;-webkit-border-radius:0}.modal-header{font-size:12px;font-weight:300}</style>
            <div id="preview" class="modal">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <span><p class="modal-title">Use arrow keys to change image</p></span>
                    <span class="pull-right"><a type="button" class="" data-dismiss="modal" style="cursor:pointer">Close</a></span>
                  </div>
                  <div class="modal-body">
                  </div>
                </div>
              </div>
            </div>
            <div class="panel-body">
                <?php
                    if($source != '')
                        echo $display[1];

                ?>
                <div id="scrolldown">NEXT<p class="glyphicon glyphicon-chevron-down"></p></div>
<div id="loadmsg" class="jumbotron">Stay Calm and Wait for More</div>
            </div>
            <div id="footer" class="footer">Help your friends see how awesome imgur is too. <a href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fcomichoard.com%2Fimgur" class="btn btn-default begsuccess btn-sm" target="_blank">Share imgur</i></a></div>
        </div>

        <input id="next" type="hidden" value="<?php echo $display[0];?>">
        <input id="source" type="hidden" value="<?php echo $source;?>">
        <input id="website" type="hidden" value="<?php echo $_SERVER['HTTP_HOST'];?>">
        <input id="sort" type="hidden" value="<?php echo $_GET['sort'];?>">
        <script>
            var next = $("#next").val();
            var sort = $("#sort").val();
            var source = $("#source").val();
            var website = $("#website").val();
            var flag = 0;

            $(document).unbind('click');
            $(document).on('click','.card>img',function(event) {
                $('#preview').modal('show')
                $('#preview>.modal-dialog>.modal-content>.modal-body').html('<p>'+$(this).attr('title')+'</p><img src="'+$(this).attr('src').split('b.').join('.')+'">');
                $('.curImg').removeClass('curImg');
                $(this).addClass('curImg');

            });
            $(document).on('keydown',function(event) {
                if (event.keyCode == 37) { 
                    var changeTo = $('.curImg').prev();        
                    if(changeTo.length>0)   {
                        $('.curImg').removeClass('curImg');
                        $(changeTo).addClass('curImg');
                    }
                }
                if (event.keyCode == 39) { 
                    var changeTo = $('.curImg').next();        
                    if(changeTo.length>0)   {
                        $('.curImg').removeClass('curImg');
                        $(changeTo).addClass('curImg');
                    }
                }
                try  {
                    $('#preview>.modal-dialog>.modal-content>.modal-body').html('<p>'+$('.curImg').attr('title')+'</p><img src="'+$('.curImg').attr('src').split('b.').join('.')+'">');
                }
                catch(error) {
                    ;
                }
            });
		</script>
        <script type="text/javascript" src="../googleanalytics.js" ></script>
    </body>
</html>