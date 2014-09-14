var comiclist= new Array();
var hideHeader=0,saveHeader=0;
$(document).ready(function()    {
    loadlist();
    if(firstcomic!='' && firstcomic!==undefined)    {
        loadstrip(JSON.parse(atob(firstcomic)));
    }
    addnext();
});
var next='';
var first=1;

function loadlist() {
    $('.thumb-main').append('<br><br><div class="thumb-container"></div>');
    $.post('/api/comiclist', function (data) {
        comiclist=JSON.parse(data);
        for(var key in comiclist)    {
            addToList(key,comiclist[key]);
        }
    });
    function addToList(code,name)  {
        try {
            $('.thumb-container').append('<a class="btn btn-default" href="http://comichoard.com/'+code+'">'+name+'</a>');
            $('#comic-select-menu>.content').append('<a class="btn btn-default" href="http://comichoard.com/'+code+'">'+name+'</a>');
            $('#comic-select-menu-mobile>.content').append('<a class="btn btn-default" href="http://comichoard.com/'+code+'">'+name+'</a>');
        }
        catch(err)  {}
        $('.modal-body').append('<a class="btn btn-default" href="http://comichoard.com/'+code+'">'+name+'</a>');
    }
}



(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=659591854119619&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");

$(document).on('click','.card>img',function (event) {
    var srclink = source;
    var strp = $(this).parent().children('.details').children('.fb-like').attr('data-href');
    if (source == 'feed') {
        srclink = $(this).parent().attr('data-comic');
    }
    window.location.href = strp;
});

function savepos(e, t) {
    $.post("pos.php", {
        source: e,
        position: t
    });
}

function loadstrip(obj)    {
    var card='';
    if(obj.desc!==undefined)    {
        if(source!='feed')
            card='<div class="card"><img src="'+obj.image+'" alt="'+obj.desc+'" title="'+obj.desc+'"><div class="details"><span>'+obj.desc+'</span><span class="fb-like" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true" data-href="'+obj.link+'"></span><a href="https://twitter.com/share" data-url="'+obj.link+'" data-text="Check out '+obj.comic+' : '+obj.desc+' @ComicHoard" class="twitter-share-button" data-lang="en"></a></div></div>';
        else
            card='<div class="card"><img src="'+obj.image+'" alt="'+obj.desc+'" title="'+obj.desc+'"><div class="details"><span>'+obj.comic+' : '+obj.desc+'</span><span class="fb-like" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true" data-href="'+obj.link+'"></span><a href="https://twitter.com/share" data-url="'+obj.link+'" data-text="Check out '+obj.comic+' : '+obj.desc+' @ComicHoard" class="twitter-share-button" data-lang="en"></a></div></div>';
        next=obj.next;
        $(".page").append(card);
        try {
            FB.XFBML.parse();
            twttr.widgets.load();
        }
        catch(error)    {}
    }
}

function addnext()  {
    flag = 1;
    $.post(source+".php?next="+next+'&sort='+sort, function (data) {
        var obj=JSON.parse(data);
        loadstrip(obj);
        flag=0;
    });
    savepos(source, next);
}

$(document).on('change','#comicdateselect',function(event) {
    $(".page").empty();flag=1;
    $.post(source+".php?next="+btoa($(this).val())+'&sort='+sort, function (data) {
        var obj=JSON.parse(data);
        loadstrip(obj);
        flag=0;
    });
});

$(document).on('keydown','#comicnumselect',function(event) {
    if(event.which == 13)   {
        $(".page").empty();flag=1;
        $.post(source+".php?next="+btoa($(this).val())+'&sort='+sort, function (data) {
            var obj=JSON.parse(data);
            loadstrip(obj);
            flag=0;
        });
    }
});

$(document).on('click','#comic-select-btn',function()   {
    if($(this).hasClass('closed'))  {
        $(this).html('<i class="fa fa-chevron-up"></i>');
        $('#comic-select-menu').animate({top:'0%'},400);
        $('#top').animate({top:'12%'},400);
        $(this).removeClass('closed');
        $(this).addClass('open');
    }
    else if($(this).hasClass('open'))  {
        $(this).html('Select Comic To Read');
        $('#comic-select-menu').animate({top:'-12%'},400);
        $('#top').animate({top:'0%'},400);
        $(this).removeClass('open');
        $(this).addClass('closed');
    }
});

$(document).on('click','#comic-tap-btn',function()   {
    if($(this).hasClass('closed'))  {
        $('#comic-select-menu-mobile').animate({left:'0%'},400);
        $(this).removeClass('closed');
        $(this).addClass('open');
    }
    else if($(this).hasClass('open'))  {
        $('#comic-select-menu-mobile').animate({left:'-70%'},400);
        $(this).removeClass('open');
        $(this).addClass('closed');
    }
});

var dig;
var howMuchDig=3000;
$(document).on('click','#scrolldown>.fa-play',function()   {
    $(this).animate({opacity:0},300,function()  {
        $(this).replaceWith('<i class="fa fa-pause"></i>');
        $(this).animate({opacity:1},300);
    });
    dig=setInterval(digDown,90000);
    digDown();
});

$(document).on('click','#scrolldown>.fa-pause',function()   {
    $(this).animate({opacity:0},300,function()  {
        $(this).replaceWith('<i class="fa fa-play"></i>');
        $(this).animate({opacity:1},300);
    });
    $("body,html").stop();
    clearInterval(dig);
});

$(document).on('click','#scrolldown>.fa-backward',function()   {
    $("body,html").stop();
    clearInterval(dig);
    if(howMuchDig>1000)
        howMuchDig-=1000;
    dig=setInterval(digDown,90000);
    digDown();
});

$(document).on('click','#scrolldown>.fa-forward',function()   {
    $("body,html").stop();
    clearInterval(dig);
    if(howMuchDig<30000)
        howMuchDig+=1000;
    dig=setInterval(digDown,90000);
    digDown();
});

function digDown()  {
    var currentScroll='';
    try {
        currentScroll=$("body").scrollTop();
    }
    catch(error)    {
        currentScroll=$("html").scrollTop();
    }
    $("body,html").animate({ scrollTop: currentScroll+howMuchDig }, 90000, "linear");
}

$(document).on('click','#resume',function() {
    if ($("#resume").attr('data-del') == 'yes') {
        flag = 1;
        $.post("pos.php", {source: source, getpos: "1"}, function (e) {
            next = e.split("<!--")[0];
            $(".page").empty();
            $.post(source+".php?next="+next+'&sort='+sort, function (data) {
                var obj=JSON.parse(data);
                loadstrip(obj);
                flag=0;
            });
        });
    }
});

$(window).scroll(function () {
    if ($(window).scrollTop() + $(window).height() > $(document).height() - 1000 && flag == 0) {
        addnext();
    }
    if($(window).scrollTop()>hideHeader && $(window).scrollTop()>200)    {
        if(hideHeader-saveHeader>200 && $(window).scrollTop()>200 && $('#top').css('top')=="0px")   {
            $('#top').animate({top:'-10%'},400);
            saveHeader=hideHeader;
        }
    }
    else    {
        $('#top').animate({top:'0%'},400);
        saveHeader=hideHeader;
    }
    hideHeader=$(window).scrollTop();
});
