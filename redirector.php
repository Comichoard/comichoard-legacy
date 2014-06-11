
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Comic Hoard</title>
        <meta property="og:title" content="Comic Hoard"/>
                <meta property="og:url" content="http://comichoard.com"/>
                <meta property="og:description" content="Comic Hoard is a platform to read webcomics easily. XKCD, Cyanide &amp; Happiness, Garfield, JL8 and many more..."/>
                <meta property="og:image" content="http://comichoard.com/favicon.png"/>
        <link rel="icon" type="image/png" href="favicon.png">
        <link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css" rel="stylesheet">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,700,600,300,800" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="css/default.css?v=25" />
        <style>#loadmsg{font-size:60px;margin-top:200px}</style>
    </head>
    <body>
        <div id="viewer" class="panel panel-default">
            <div class="px"></div>
            <div id="top" class="panel-heading">
                <a id="gohome" class="btn btn-default btn-lg" href="http://comichoard.com">
                    Comic Hoard
                </a>
                <a id="gotofb" class="btn btn-default btn-lg" href="https://facebook.com/comichoard" target="_blank">
                    <i class="fa fa-facebook"></i>
                </a>
            </div>
            <div class="panel-body">
                <div id="loadmsg" class="jumbotron">
                    We moved to comichoard.com !<br>
                    <button id="go" class="btn btn-default btn-lg">Go to new site!</button>
                </div>
            </div>
        </div>
        <script>
            $('#go').click(function()   {
                window.location.href = window.location.href.split('.tk').join('.com');
            });
        </script>
    </body>
</html>