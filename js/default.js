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
            $(".panel-body").append('<div id="loadmsg" class="jumbotron">Stay Calm and Wait for More</div>');
            
            $.post(source+".php/?comic=" + next, function (e) {
                next = e.split("!znavfu")[0];
                e = e.split("!znavfu")[1];
                e = e.split("<!--")[0];
                if (e.split("script").length == 1)
                    $("#loadmsg").before(e);
            });
            flag = 0;
        });
    }
});

setTimeout(function(){
    $('#footer').toggle();    
},10000);

$(document).on('click','.s',function (event) {
    var srclink = source;
    console.log(source);
    if (source == 'feed') {
        srclink = $(this).parent().parent().attr('data-comic');
    }
    window.open('https://www.facebook.com/sharer/sharer.php?u='+'http://' + $('#website').val() + '/'+srclink+'/?strip='+$(this).attr('data-share'));
});

if ($('.px').css('opacity') == '1') {
    $('#gohome').html('CH');
}

function savepos(e, t) {
    $.post("pos.php", {
        source: e,
        position: t
    });
    $(".well").each(function () {
        if ($(this).html() == "") {
            $(this).remove()
        }
    })
}

$(window).scroll(function () {
    if ($(window).scrollTop() + $(window).height() > $(document).height() - 2000 && flag == 0) {
        flag = 1;
        $.post(source+".php?comic=" + next, function (e) {
            next = e.split("!znavfu")[0];
            e = e.split("!znavfu")[1];
            e = e.split("<!--")[0];
            if (e.split("script").length == 1)
                $("#loadmsg").before(e);
            flag = 0;
        });
        savepos(source, next);
    }
});

$(document).on('change','#comicdateselect',function(event) {
    var retain = $(".panel-body div:first-child").html();
    $(".panel-body").empty();
    $(".panel-body").append('<div class="jumbotron cdesc">'+retain+'</div>');
    $(".panel-body").append('<div id="loadmsg" class="jumbotron">Stay Calm and Wait for More</div>');
    $.post(source+".php?comic=" + btoa($(this).val()), function (e) {
        next = e.split("!znavfu")[0];
        e = e.split("!znavfu")[1];
        e = e.split("<!--")[0];
        if (e.split("script").length == 1)
            $("#loadmsg").before(e);
    });
});

$(document).on('keydown','#comicnumselect',function(event) {
    if(event.which == 13)   {
        var retain = $(".panel-body div:first-child").html();
        $(".panel-body").empty();
        $(".panel-body").append('<div class="jumbotron cdesc">'+retain+'</div>');
        $(".panel-body").append('<div id="loadmsg" class="jumbotron">Stay Calm and Wait for More</div>');
        $.post(source+".php?comic="+btoa($(this).val())+"&sort="+sort, function (e) {
            next = e.split("!znavfu")[0];
            e = e.split("!znavfu")[1];
            e = e.split("<!--")[0];
            if (e.split("script").length == 1)
                $("#loadmsg").before(e);
        });
    }
});