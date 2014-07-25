<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Comic Hoard</title>
        <meta property="og:title" content="Comic Hoard"/>
        <meta property="og:url" content="http://comichoard.com"/>
        <meta property="og:description" content="Comic Hoard is a platform to read webcomics easily. XKCD, Cyanide &amp; Happiness, Garfield, JL8 and many more..."/>
        <meta property="og:image" content="http://comichoard.com/favicon.png"/>
        <meta name="google-site-verification" content="xlNcZc8ArGnPwoG6k_ttQ7TROqAmNWMahmzX2_DxgsM" />
        <link rel="icon" type="image/png" href="favicon.png">
        <meta name="description" content="Comic Hoard - The Webcomic Library" />
        <meta name="keywords" content="webcomic,comic,hoard,xkcd,maximumble,cyanide and happiness,channelate,jl8" />
        <link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css" rel="stylesheet">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,700,600,300,800" rel="stylesheet" type="text/css">
        <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/cdstyle.css?v=25" />
        <link rel="stylesheet" type="text/css" href="css/default.css?v=25" />
        <script type="text/javascript" src="js/jquery.dropdown.js"></script>
        <script src="js/modernizr.custom.63321.js"></script>
    </head>
    <body>
        <?php include('../../modalselect.php');?>
        <div id="viewer" class="panel panel-default">
            <div class="px"></div>
            <div id="top" class="panel-heading">
                <a id="gohome" class="btn btn-default btn-lg" href="http://comichoard.com">
                    Comic Hoard
                </a>
                <a id="gotofb" class="btn btn-default btn-lg" href="https://facebook.com/comichoard" target="_blank">
                    <i class="fa fa-facebook"></i>
                </a>
                <a id="fbpage" href="http://facebook.com/comichoard" class="btn btn-default btn-lg" target="_blank">
                    <i class="fa fa-facebook-square"></i> /comichoard
                </a>
            </div>
            <div class="panel-body">
                <div class="jumbotron" style="margin-top:200px">
                    For Doubts and suggestions : support@comichoard.tk<br><br>
                    We also hang around our facebook page all the time : 
                    <a href="http://facebook.com/comichoard" class="btn btn-default" target="_blank">
                        Artists go here
                    </a><br><br>
                    Other stuff coming soon.
                </div>
                <div id="footer" class="jumbotron">
                    <a id="sharer" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fcomichoard.com" class="btn btn-default" target="_blank">Share website on facebook</i></a>
                </div>
            </div>
        </div>
        <script>
            if ($('.px').css('opacity') == '1') {
                $('#gohome').html('CH');
            }
		</script>
        
        <script type="text/javascript" src="googleanalytics.js" ></script>
    </body>
</html>
