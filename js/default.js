(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=659591854119619&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

$(document).on('click','#resume',function() {
    if ($("#resume").attr('data-del') == 'yes') {
        flag = 1;
        $.post("pos.php", {
            source: source,
            getpos: "1"
        }, function (e) {
            next = e.split("<!--")[0];
            var retain = $(".panel-body div:first-child").html();
            $(".panel-body").empty();
            $(".panel-body").append('<div class="jumbotron cdesc">'+retain+'</div>');
            $(".panel-body").append('<div id="scrolldown">NEXT<p class="glyphicon glyphicon-chevron-down"></p></div><div id="loadmsg" class="jumbotron">Stay Calm and Wait for More</div>');
            
            $.post(source+".php/?comic=" + next, function (e) {
                next = e.split("!znavfu")[0];
                e = e.split("!znavfu")[1];
                e = e.split("<!--")[0];
                if (e.split("script").length == 1)
                    $("#scrolldown").before(e);
            });
            flag = 0;
        });
    }
});

$(document).ready(function()    {
    setTimeout(function(){
        $('#footer').toggle();    
    },1);
});

$(document).on('click','.card>img',function (event) {
    var srclink = source;
    var strp = $(this).parent().children('.details').children('.fb-like').attr('data-href');
    if (source == 'feed') {
        srclink = $(this).parent().attr('data-comic');
    }
    window.location.href = strp;
});

$(document).ready(function()    {
    if ($('.px').css('opacity') == '1') {
        $('#gohome').html('CH');
    }    
});

function savepos(e, t) {
    $.post("pos.php", {
        source: e,
        position: t
    });
    $(".card").each(function () {
        if ($(this).html() == "") {
            $(this).remove()
        }
    })
}

function addnext()  {
    flag = 1;
    if(!scrollFlag) {
        setTimeout(addnext,1000);
    }
    $.post(source+".php?comic=" + next, function (e) {
        next = e.split("!znavfu")[0];
        e = e.split("!znavfu")[1];
        e = e.split("<!--")[0];
        if(e.indexOf('src')>-1) {
            var sameflag=1;
            var cursrc='';
            try {
                cursrc = (e.split('src="')[1]).split('"')[0];
            }
            catch(error)   {
                cursrc = (e.split("src='")[1]).split("'")[0];    
            }
            $('img').each(function() {
                 if($(this).attr('src')==cursrc)
                    sameflag=0;
            });
            if (e.split("script").length == 1 && sameflag==1)   {
                $("#scrolldown").before(e);
                FB.XFBML.parse();
            }
        }
        flag = 0;
    });
    savepos(source, next);
}

$(window).scroll(function () {
    if ($(window).scrollTop() + $(window).height() > $(document).height() - 1000 && flag == 0) {
        addnext();        
    }
});

$(document).on('change','#comicdateselect',function(event) {
    var retain = $(".panel-body div:first-child").html();
    $(".panel-body").empty();
    $(".panel-body").append('<div class="jumbotron cdesc">'+retain+'</div>');
    $(".panel-body").append('<div id="scrolldown">NEXT<p class="glyphicon glyphicon-chevron-down"></p></div><div id="loadmsg" class="jumbotron">Stay Calm and Wait for More</div>');
    $.post(source+".php?comic=" + btoa($(this).val()), function (e) {
        next = e.split("!znavfu")[0];
        e = e.split("!znavfu")[1];
        e = e.split("<!--")[0];
        if (e.split("script").length == 1)
            $("#scrolldown").before(e);
    });
});

$(document).on('keydown','#comicnumselect',function(event) {
    if(event.which == 13)   {
        var retain = $(".panel-body div:first-child").html();
        $(".panel-body").empty();
        $(".panel-body").append('<div class="jumbotron cdesc">'+retain+'</div>');
        $(".panel-body").append('<div id="scrolldown">NEXT<p class="glyphicon glyphicon-chevron-down"></p></div><div id="loadmsg" class="jumbotron">Stay Calm and Wait for More</div>');
        $.post(source+".php?comic="+btoa($(this).val())+"&sort="+sort, function (e) {
            next = e.split("!znavfu")[0];
            e = e.split("!znavfu")[1];
            e = e.split("<!--")[0];
            if (e.split("script").length == 1)
                $("#scrolldown").before(e);
        });
    }
});

var scrollFlag=1;
$(document).on('click','#scrolldown',function()   {
    if(scrollFlag)    {
        scrollFlag=0;
        var currentScroll='';
        try {
            currentScroll=$("body").scrollTop();
        }
        catch(error)    {
            currentScroll=$("html").scrollTop();
        }
        $("body,html").animate({ scrollTop: currentScroll+400 }, 500,function() {
            scrollFlag=1;
        });
    }
});