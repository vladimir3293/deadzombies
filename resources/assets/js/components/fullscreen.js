/* iPanel */
var iPanel = {
    gameItem: '<li>' +
    '<a rel="nofollow" target="_blank" href="{url}">' +
    '<img data-lazy="{avatar}">' +
    '<div>{name}</div>' +
    '<span>{category}</span>' +
    '</a>' +
    '</li>',
    gameItemFavorites: '<li>' +
    '<span onclick="iPanel.delete_favorite(\'{md5}\')" class="remove" title="РЈР±СЂР°С‚СЊ РёР· Р·Р°РєР»Р°РґРѕРє">вњ•</span>' +
    '<a rel="nofollow" target="_blank" href="{url}">' +
    '<img data-lazy="{avatar}">' +
    '<div class="desc">{name}</div>' +
    '<span>{category}</span>' +
    '</a>' +
    '</li>'
};

var search = '<div class="typeahead__container ip-search">' +
    '                <div class="typeahead__field">' +
    '                    <span class="typeahead__query" style="display:none">' +
    '                        <input class="js-typeahead-country_v1" name="country_v1[query]" type="search" placeholder="РџРѕРёСЃРє" autocomplete="off">' +
    '                    </span>' +
    '                    <span class="typeahead__button">' +
    '                        <span class="glyphicon glyphicon-search" type="submit">' +
    '                        </span>' +
    '                    </span>' +
    '                </div>' +
    '            </div>';
if (window.location.hostname != 'iplayer.org') {
    search = '';
}
iPanel.$form =
    '<noindex><div class="iplayer-wrapper">' +
    '<div class="ip-left" style="margin-right: 30px;">' +
    '<a class="ip-logo" rel="nofollow" target="_blank" href="//iplayer.org"><img src="//iplayer.org/panel/images/logo.png"/></a>' +
    '</div>' +
    search +
    //'<div style="display:inline-block"><script type="text/javascript" src="//yastatic.net/share/share.js" charset="utf-8"></script><div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="small" data-yashareQuickServices="vkontakte,facebook,twitter,odnoklassniki,moimir" data-yashareTheme="counter"></div></div>'+
    '<div class="ip-right">' +
    '<a class="ip-enter" href="javascript://" onclick="iPLogin.show_tab(\'login\')">Р’С…РѕРґ</a>' +
    '<span class="ip-block "><span class="notify notify-all">0</span><a rel="nofollow" target="_blank" class="ip-user" href=""></a>' +
    '<div class="ip-dropdown ip-dropdown-profile">' +
    '<ul class="ip-menu">' +
    '<li>' +
    '<a rel="nofollow" target="_blank" href="//iplayer.org/user/profile">РџСЂРѕС„РёР»СЊ</a>' +
    '</li>' +
    /*'<li>'+
     '<a rel="nofollow" target="_blank" href="//iplayer.org/user/friends/search"><span class="notify notify-friends">0</span>Р”СЂСѓР·СЊСЏ</a>'+
     '</li>'+*/
    '<li>' +
    '<a rel="nofollow" target="_blank" href="//iplayer.org/games">РРіСЂС‹</a>' +
    '</li>' +
    /*'<li>'+
     '<a rel="nofollow" target="_blank" href="//iplayer.org/user/groups"><span class="notify notify-groups">0</span>Р“СЂСѓРїРїС‹</a>'+
     '</li>'+	*/
    '<li>' +
    '<a rel="nofollow" target="_blank" href="//iplayer.org/messages"><span class="notify notify-unread">0</span>РЎРѕРѕР±С‰РµРЅРёСЏ</a>' +
    '</li>' +
    '<li class="ip-menu-sep"></li>' +
    '<li>' +
    '<a href="javascript://" onclick="iPanel.logout()">Р’С‹С…РѕРґ</a>' +
    '</li>' +
    '</ul>' +
    '</div> </span>' +
    '<span class="ip-block">' +
    '<div>РСЃС‚РѕСЂРёСЏ</div>' +
    '<div class="ip-dropdown">' +
    '<ul class="ip-list ip-played"></ul>' +
    '</div> </span>' +
    '<span class="ip-sep">&nbsp;</span>' +
    '<span class="ip-block"> <div class="iplayer-btn-favorites">Р·Р°РєР»Р°РґРєРё</div>' +
    '<div class="ip-dropdown">' +
    '<ul class="ip-list ip-fav"></ul>' +
    '</div> </span>' +
    '<span class="ip-block ip-icon ip-icon-fav">&nbsp;</span>' +
    '<span class="ip-block ip-icon ip-icon-fav-active" style="display: none;">&nbsp;</span>' +
    '<span class="ip-block ip-icon ip-icon-fullscreen">&nbsp;</span>' +
    '</div>' +
    '<div class="clear"></div>' +
    '<div id="ipoverlay">&nbsp;</div>' +
    '<div class="iplayer-login shadow r5 unselectable" id="ip-login">' +
    '</div>' +
    '</div></noindex>';

iPanel.getUrlVar = function (key) {
    var scripts = document.getElementsByTagName('script');
    var index = scripts.length - 1;
    var myScript = scripts[index];
    var result = new RegExp(key + "=([^&]*)", "i").exec(myScript.src);
    var data = result && unescape(result[1]) || "";
    return data;
}
if (iPanel.getUrlVar('cont') == 'html') {
    console.log('html');
} else {
    jQuery('#iplayer-panel').html(iPanel.$form);
}
iPanel.$userIsLogin = iPanel.getUrlVar('user');
iPanel.$panel = jQuery('#iplayer-panel');
iPanel.$add_button = iPanel.$panel.find('.ip-icon-fav');
iPanel.$remove_button = iPanel.$panel.find('.ip-icon-fav-active');
iPanel.$fullscreen_button = iPanel.$panel.find('.ip-icon-fullscreen');
iPanel.searchInitDone = false;
$(window).on("message", function (e) {
    console.log(e)
    if (e.originalEvent.origin == "//iplayer.org" || e.originalEvent.origin == "http://iplayer.org") {
        var data = e.originalEvent.data;
        eval(data) // Alerts "this is a message"
    }

});

iPanel.searchInit = function () {
    if (iPanel.searchInitDone) return;
    console.log('init search ...');
    $.getScript('//iplayer.org/media/js/typeahead/jquery.typeahead.js', function () {
        $.typeahead({
            input: '.js-typeahead-country_v1',
            order: "desc",
            source: {
                games: {
                    display: "srcstr",
                    ajax: {
                        type: "GET",
                        url: "//iplayer.org/games/json"
                    }
                }
            },
            callback: {
                onInit: function (node) {
                    console.log('Typeahead Initiated on ' + node.selector);
                },
                onClickAfter: function (node, a, item, event) {

                    event.preventDefault();
                    window.open('//iplayer.org/game/' + item.url_game);
                    $(node.selector).val('');

                }
            },
            selector: {
                item: 'item',
                list: 'games-list'
            },
            cancelButton: false,
            display: ["name"],
            correlativeTemplate: true,
            minLength: 1,
            maxItem: 12,
            template: '<img width="120" height="90" src="{{avatar}}">' +
            '<div class="item-title">{{name}}</div>',
            // groupTemplate: "<div class=\"games-list\">{{ group }}</div>",
        });
    });
    iPanel.searchInitDone = true;
}

iPanel.searchClick = function () {

    $('#iplayer-panel .typeahead__query').toggle(200, function () {
        $('.js-typeahead-country_v1').focus();
    });
    iPanel.searchInit();
}

iPanel.init = function () {
    console.log('init iPanel');
    iPLogin.init();
    $('.ip-block').hover(function () {
        $(this).find('.ip-dropdown img').each(function (k, v) {
            var lazy = $(v).attr('data-lazy');
            if (lazy) {
                $(v).attr('src', lazy).removeAttr('data-lazy');
            }
        })
    })
    $('.typeahead__button .glyphicon').on('click', iPanel.searchClick);

    if (iPanel.$userIsLogin == 'login') {
        console.log('user_is_login');
    } else {
        iEngine.api('update', {}, 'iPanel.updatePanel');
    }
    iEngine.api('complete', {}, 'iPanel.complete');


    $(document).on("keydown", "#login", function (e) {
        if (e.keyCode == 13) {
            iPLogin.login();
        }
    });

    $(document).on("keydown", "#restorPassSendEmail", function (e) {
        if (e.keyCode == 13) {
            iPLogin.forgot();
        }
    });

    $(document).on("keydown", "#reg", function (e) {
        if (e.keyCode == 13) {
            iPLogin.register();
        }
    });
    this.iframemode = (window != window.top);
    //this.iframemode = false;
    this.playTime = 30;
    this.inited = true
    this.logged = false;
    this.currentGameSeconds = 0;
    this.startTime = new Date();
    _this = this;

    if (this.iframemode) {
        jQuery('#iplayer-panel').hide();
        parent.postMessage('iPanel.setGame("' + iPanel.getGame() + '")', '*');// РїРµСЂРµРґР°РµРј РёРіСЂСѓ РІС‹С€Рµ
        parent.postMessage('iPanel.setSubId("' + iPanel.getSubId() + '")', '*');// РїРµСЂРµРґР°РµРј sub_id РІС‹С€Рµ
    }

    this.swfStore = new SwfStore({
        namespace: 'iplayer',
        swf_url: iEngine.URLS.media() + 'swf/storage.swf',

        onready: function () {

            iPanel.swfStoreInited = true;

            var games = iPanel.get_cookie('games');
            //console.log(games);
            iPanel.fillBookmarks();
            if (games && ( typeof (games) == 'array' || typeof (games) == 'object') && document.iGAME) {
                for (var i = 0; i < games.length; i++) {
                    if (document.iGAME.md5 == games[i]['md5']) {
                        iPanel.$add_button.hide();
                        iPanel.$remove_button.show();
                        $('.add_to_fav').hide();
                        $('.remove_to_fav').show();
                        break;
                    }
                }
            }


            iPanel.totalSeconds = iPanel.get_flash_cookie('iengine_total_seconds');

            if (!iPanel.totalSeconds || isNaN(iPanel.totalSeconds) || iPanel.totalSeconds == 'NaN') {
                iPanel.totalSeconds = 0;
            }

            if (document.iGAME) {

                ifvisible.setIdleDuration(3600);
                ifvisible.onEvery(1, iPanel.collectTotalTime);
                ifvisible.wakeup(function () {
                    //console.log('wakeup');
                    //var endTime = new Date();
                    //var timeSpent = (endTime - _this.startTime)/1000 - _this.currentGameSeconds;
                    //if((timeSpent) > (60*60)){
                    //    window.location.reload();
                    //}
                    //console.log([timeSpent]);
                });
                jQuery(window).unload(iPanel.saveTotalTime);

            }

            /* iEngine.api('flash::sync', {
             flash_id : iEngine.get_user_id()
             }, 'iPanel.flashSuccess');*/

            if (iPanel.mode != 'hidden') {
                iPanel.loadGames();
            }
            $(window).trigger("iPanel.storageReady");
            iPanel.local_storage_sync();
        }
    });
    $(window).trigger("iPanel.complete");
}


iPanel.collectTotalTime = function () {
    if (typeof (document.iGAME) == 'undefined')
        return;

    iPanel.totalSeconds++;
    iPanel.currentGameSeconds++;
}

iPanel.saveTotalTime = function () {
    if (iPanel.totalSeconds > 0) {
        iPanel.set_flash_cookie('iengine_total_seconds', iPanel.totalSeconds);
    }

    if (document.iGAME) {
        iPanel.addPlayedGame();
    }
    //iPanel.sync(false);
}

iPanel.complete = function () {
    //console.log('complete');
    iPanel.updateBookmarkTitle();
}


iPanel.loadGames = function () {
    return;
    data = {}
    data.crc32 = iPanel.get_flash_cookie('crc32');
    data.flash_id = iEngine.get_user_id();
    $.ajax({
        url: "//iplayer.org:3001/load",
        data: data,
        type: 'post',
        xhrFields: {
            withCredentials: true
        },
        crossDomain: true
    }).done(function (data) {
        if (data.error) {
            console.log(data.error);
        } else {
            if (data.history) {
                iPanel.set_flash_cookie('played_games', data.history);
            }
            if (data.favourites) {
                iPanel.set_flash_cookie('games', data.favourites);
            }
            if (data.crc32) {
                iPanel.set_flash_cookie('crc32', data.crc32);
            }
            iPanel.fillBookmarks();
            iPanel.updateBookmarkTitle();
        }
    })
}


iPanel.sync = function (async) {
    //return;
    //if(!a) return;
    async = true;
    if (iPanel.mode == 'hidden') {
        return;
    }

    if (typeof (JSON.stringify) != 'function') {
        // something old
        return;
    }


    iPanel.lastSync = iPanel.get_flash_cookie('iengine_last_sync');

    if (!iPanel.lastSync || isNaN(iPanel.lastSync) || iPanel.lastSync == 'NaN') {
        iPanel.lastSync = 0;
    }

    var tstamp = iEngine.unixtime();

    /*if( iPanel.lastSync > 0 && tstamp + iPanel.syncTimeout >= iPanel.lastSync )
     return;*/

    var syncObj = [];

    var favorites = iPanel.get_list('favorites').reverse();
    var history = iPanel.get_list('played');

    var data = {
        history: history,
        favorites: favorites
    };
    var tmp = '';
    for (var key in data) {
        if (!data[key] || ( typeof (data[key]) != 'array' && typeof (data[key]) != 'object')) {
            data[key] = new Array;
        }
        ;
        if (data[key].length) {
            for (idx = 0; idx < data[key].length; idx++) {
                //if(data[key][idx]['md5']){
                tmp += data[key][idx]['md5'];
                // }
            }
        }
    }

    oldCRC32 = iPanel.get_flash_cookie('crc32');
    data.crc32 = crc32(tmp);
    if (parseInt(data.crc32) == oldCRC32) {
        console.log('old crc');
        return;
    }
    //console.log(data)
    iPanel.set_flash_cookie('crc32', data.crc32);

    data.flash_id = iEngine.get_user_id();


    history = history.reverse().slice(0, 50);

    iAPI('/ipanel/set/bookmarks', {data: favorites}, null, 'post');
    iAPI('/ipanel/set/history', {data: history}, null, 'post');
    return;

    /*if( !games.length )
     return;
     for( var i = 0; i < games.length; i++)
     {
     if( typeof(games[i].last_sync) == 'undefined' )
     {
     games[i].last_sync = 0;
     }

     if( typeof(games[i].played_time) == 'undefined' )
     {
     games[i].played_time = 0;
     }

     if( typeof(games[i].last_sync_value) == 'undefined' )
     {
     games[i].last_sync_value = 0;
     }

     if( games[i].played_time == 0 || games[i].last_sync_value == games[i].played_time )
     {
     continue;
     }

     if( games[i].last_sync > 0 && tstamp + iPanel.syncTimeout >= games[i].last_sync )
     {
     continue;
     }

     if( games[i].played_time < iPanel.playTime)
     {
     continue;
     }

     syncObj.push({  md5: games[i].md5,
     played_time: games[i].played_time,
     last_sync: games[i].last_sync,
     avatar: games[i].avatar,
     url: games[i].url,
     category: games[i].category,
     name: games[i].name
     });
     }*/

    //if( !syncObj.length )
    //   return;

    //iEngine.api('sync::sync', { user: iEngine.get_user_id(), games: JSON.stringify(syncObj)}, 'iPanel.syncSuccess');

}


iPanel.getAllFlashData = function () {
    this.swfStore = new SwfStore({
        namespace: 'iplayer',
        swf_url: iEngine.URLS.media() + 'swf/storage.swf',

        onready: function () {
            iPanel.swfStoreInited = true;

            var games = iPanel.get_cookie('games');
            //console.log(games);
            iPanel.fillBookmarks();
            if (games && ( typeof (games) == 'array' || typeof (games) == 'object') && document.iGAME) {
                for (var i = 0; i < games.length; i++) {
                    if (document.iGAME.md5 == games[i]['md5']) {
                        iPanel.$add_button.hide();
                        iPanel.$remove_button.show();
                        $('.add_to_fav').hide();
                        $('.remove_to_fav').show();
                        break;
                    }
                }
            }


            iPanel.totalSeconds = iPanel.get_flash_cookie('iengine_total_seconds');

            if (!iPanel.totalSeconds || isNaN(iPanel.totalSeconds) || iPanel.totalSeconds == 'NaN') {
                iPanel.totalSeconds = 0;
            }

            if (document.iGAME) {
                //jQuery(window).unload(iPanel.saveTotalTime);
                //setInterval(iPanel.collectTotalTime, 1000);
            }

            /*iEngine.api('flash::sync', {
             flash_id : iEngine.get_user_id()
             }, 'iPanel.flashSuccess');*/

            if (iPanel.mode != 'hidden') {
                //iPanel.sync();
            }
        }
    });
    iPanel.updateBookmarkTitle();
}

iPanel.addScript = function (src, callback) {
    var s = document.createElement('script');
    s.setAttribute('src', src);
    s.onload = callback;
    document.body.appendChild(s);
}

iPanel.updatePanel = function (data) {

    if (typeof (data) == 'undefined') {
        return;
    }

    if (typeof (data.response) == 'undefined') {
        console.log(data);
    }

    this.user = data.response.user;

    if (data.response.logged) {
        this.logged = true;

        $(window).bind("iPanel.ping", function () {

            //if(window.location.hostname=='iplayer.org' && iPanel.currentGameSeconds>0 && iPanel.getGame()) {
            //iPanel.socket.emit('ping', JSON.stringify({game:iPanel.getGame(), sub_id: iPanel.getSubId(), time: iPanel.currentGameSeconds, start: Math.floor(iPanel.startTime.getTime() / 1000)}));
            //}

            $.ajax({
                url: "//iplayer.org/daemon/evt/ping",
                jsonp: "callback",
                dataType: "jsonp",
                data: {
                    game: iPanel.getGame(),
                    sub_id: iPanel.getSubId(),
                    time: iPanel.currentGameSeconds,
                    start: Math.floor(iPanel.startTime.getTime() / 1000)
                },
                success: function (response) {
                    notice = JSON.parse(response);
                    return;
                    //console.log( response ); // server response
                    var total = 0;
                    for (var i in notice) {
                        if (i != 'unread') continue;
                        var value = parseInt(notice[i]);
                        total += value;
                        if (value > 0) {
                            jQuery('.notify-' + i).show().html(value);
                        } else {
                            jQuery('.notify-' + i).hide()
                        }
                    }
                    if (total > 0) {
                        jQuery('.notify-all').show().html(total);
                    } else {
                        jQuery('.notify-all').hide();
                    }
                }
            });
        });

        this.addScript('//iplayer.org/panel/socket.io-1.2.0.js', function () {
            /*iPanel.socket  = io('//iplayer.org:3010/');
             iPanel.socket.on('notice', function(msg){
             var notice = JSON.parse(msg);
             var total = 0;
             for(var i in notice){
             if(i!='unread') continue;
             var value = parseInt(notice[i]);
             total+=value;
             if(value>0){
             jQuery('.notify-'+i).show().html(value);
             }else{
             jQuery('.notify-'+i).hide()
             }
             }
             if(total>0){
             jQuery('.notify-all').show().html(total);
             }else{
             jQuery('.notify-all').hide();
             }
             });*/
            setInterval(function () {
                $(window).trigger("iPanel.ping");
            }, 90 * 1000);
            $(window).trigger("iPanel.ping");
        });

        if (iPanel.iframemode) {
            return;
        }

        if (typeof (iPLogin.redirectUrl) != 'undefined' && typeof (iPLogin.redirectUrlWhenUserIsLogin) != 'undefined') {
            window.location.href = iPLogin.redirectUrl;
        }
        $.ajax({
            type: 'GET',
            url: '//api.iplayer.org/account/setOnline',
            dataType: 'json',
            xhrFields: {
                withCredentials: true
            }
        });
        jQuery('.ip-user').show();
        jQuery('.ip-enter').hide()
        var username = this.user.nickname;
        if (this.user.name && this.user.surname) username = this.user.name + ' ' + this.user.surname;

        var img = iEngine.URLS.root() + 'panel/images/avatar.png';
        if (this.user.avatar != null) {
            //img = this.user.avatar;
            if (this.user.avatar.indexOf('http://') == -1) {
                img = iEngine.URLS.root() + 'uploads/avatar/' + this.user.avatar;
            } else {
                //img = iEngine.URLS.root()+'uploads/avatar/'+this.user.avatar;
                img = this.user.avatar;
            }

        }
        jQuery('.ip-user').html('<img src="' + img + '"><span>' + username + '&nbsp;</span>').attr('href', '//iplayer.org/id' + this.user._id);

        $(window).trigger("iPanel.update", [this.logged, username, img, this.user]);

    } else {
        jQuery('.ip-user').hide();
        jQuery('.ip-enter').show();
        $(window).trigger("iPanel.update", [this.logged]);
    }
    //console.log(data);
    return;
}


iPanel.logout = function (stayOnPage) {

    jQuery.ajax({
        url: iEngine.URLS.root() + 'auth/logout?panel=1',
        type: 'GET',
        dataType: iEngine.dataType,
        crossDomain: true,
        xhrFields: {
            withCredentials: true
        },
        success: function (response) {
            if (!stayOnPage) {
                window.location.reload();
            } else {
                iEngine.api('update', {}, 'iPanel.updatePanel');
            }
        }
    });
    return false;
}


iPanel.fillBookmarks = function () {

    this.fillGames('favorites', '.ip-fav');
    this.fillGames('played', '.ip-played');

}

iPanel.fillGames = function (type, outElem) {
    var template = this.gameItem;
    if (type == 'favorites') {
        template = this.gameItemFavorites;
    }
    games = this.get_list(type);
    var sortGames = [];
    if (games.length > 0) {
        var j = 0;
        for (var i = games.length - 1; i >= 0; i--) {
            //console.log(games[i]);
            sortGames[j] = games[i];
            j++;
        }
    }
    games = sortGames;
    //console.log(sortGames);
    var res = '';
    var n = 20;
    for (var i in games) {
        n--;
        if (n < 0 && type == "played") continue;
        //console.log(games[i].avatar);
        /*if(games[i].avatar.indexOf('jpeg') && games[i].avatar.indexOf('jpg')==-1 && games[i].avatar.indexOf('png')==-1 && games[i].avatar.indexOf('gif')==-1){
         games[i].avatar='//iplayer.org/panel/images/avatar.png';
         } */
        res += this.render(template, games[i]);
        if (i < games.length - 1) {
            res += '<li class="ip-menu-sep"></li>';
        }
    }
    jQuery(outElem).html(res);
}

iPanel.render = function (tpl, data) {
    for (var i in data) {
        tpl = tpl.replace('{' + i + '}', data[i]);
    }
    return tpl;
}

iPanel.flashSuccess = function () {
}

iPanel.get_cookie = function (name) {
    var value = this.get_flash_cookie(name);

    /**
     if(!value || value == '')
     value = this.get_browser_cookie(name);
     **/

    if (!value || value == '')
        return null;

    return value;
}


iPanel.set_flash_cookie = function (name, value) {
    if (typeof (value) != "string") {
        try {
            value = JSON.stringify(value);
        } catch (e) {
            return false;
        }
    }

    if (this.swfStoreInited) {
        this.swfStore.set(name, value);

    }
}


iPanel.set_cookie = function (name, value) {
    try {
        value = JSON.stringify(value);
    } catch (e) {
        return false;
    }

    if (this.swfStoreInited) {
        this.swfStore.set(name, value);
    }

    /** this.set_browser_cookie(name, value, 365); **/

    return true;
}

iPanel.get_flash_cookie = function (name) {
    if (!this.swfStoreInited)
        return null;

    var value = this.swfStore.get(name);

    try {
        if (value == null)
            return null;

        value = JSON.parse(value);
        return value;
    } catch (e) {
    }
    ;

    return value;
}

iPanel.get_browser_cookie = function (name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ')
            c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) {
            return c.substring(nameEQ.length, c.length);
        }
    }
    return null;
}


iPanel.set_browser_cookie = function (cookieName, cookieValue, nDays) {
    var today = new Date();
    var expire = new Date();
    if (nDays == null || nDays == 0)
        nDays = 1;
    expire.setTime(today.getTime() + 3600000 * 24 * nDays);
    document.cookie = cookieName + "=" + encodeURIComponent(cookieValue) + ";expires=" + expire.toGMTString();
}


iPanel.local_storage_sync = function () {
    if (!iPanel.supports_html5_storage()) return;
    var bookmarks = this.get_flash_cookie('games'); // bookmarks
    var history = this.get_flash_cookie('played_games'); // history
    localStorage.setItem("bookmarks", JSON.stringify(bookmarks));
    localStorage.setItem("history", JSON.stringify(history));
    console.log('sync ... ok');
}

iPanel.supports_html5_storage = function () {
    try {
        return 'localStorage' in window && window['localStorage'] !== null;
    } catch (e) {
        return false;
    }
}


iPanel.get_list = function (to) {
    // if (!document.iGAME) {
    //   return;
    // }
    if (typeof (to) == 'undefined') {
        return []
    }

    switch (to) {
        case 'favorites':
            var games = this.get_flash_cookie('games');
            break;

        case 'played':
            var games = this.get_flash_cookie('played_games');
            break;
    }

    if (!games || ( typeof (games) != 'array' && typeof (games) != 'object')) {
        games = new Array;
    }
    ;
    if (games && ( typeof (games) == 'array' || typeof (games) == 'object')) {
        var chkGames = new Array;
        /** run some security checks **/
        for (var i = 0; i < games.length; i++) {
            var record_ok = true;

            if (games[i].avatar.indexOf('http://') == -1 && games[i].avatar.length > 0) {
                games[i].avatar = '//iplayer.org' + games[i].avatar;
            }

            for (field in games[i]) {
                var v = games[i][field];
                v = this.xss_clean(v, field);
                games[i][field] = v;
            }

            if (games[i].md5 != '' && games[i].name != '' && games[i].url != '') {
                chkGames.push(games[i]);
            }
        }

        games = chkGames;

    }

    return games;
}


iPanel.get_favorites = function () {
    var games = iPanel.get_cookie('games');

    if (games && ( typeof(games) == 'array' || typeof(games) == 'object')) {
        for (var i = 0; i < games.length; i++) {
            var record_ok = true;

            for (field in games[i]) {
                var v = games[i][field];
                v = iPanel.xss_clean(v, field);
                games[i][field] = v;
            }
        }
    }
    else {
        games = new Array;
    }
    //console.log(games);
    return games;
}

iPanel.add_current = function (to) {
    if (typeof (to) == 'undefined') {
        to = 'favorites';
    } else {
        to = 'played';
    }
    switch (to) {
        case 'favorites':
            if (!document.iGAME) {
                return iPanel.add_browser_favorite();
            } else {
                var url = document.location.href;
                if (typeof(document.iGAME.url) != 'undefined') {
                    if (document.iGAME.url != '') {
                        url = document.iGAME.url;
                    }
                }
                this.add_to_favorites(document.iGAME.md5, document.iGAME.name, document.iGAME.image, url, document.iGAME.category);
            }
            break;
        case 'played':
            if (document.iGAME) {
                this.addPlayedGame();
            } else {
                return;
            }
            break;
    }
    this.sync();
}

iPanel.addPlayedGame = function () {

    console.log(iPanel.swfStoreInited);
    if (!iPanel.swfStoreInited || !document.iGAME)
        return;

    var games = iPanel.get_flash_cookie('played_games');
    console.log(games);

    if (!games || ( typeof(games) != 'array' && typeof(games) != 'object')) {
        games = new Array;
    }
    ;

    var game_found = false;
    var game_found_position = null;

    for (var i = 0; i < games.length; i++) {
        if (games[i].md5 == document.iGAME.md5) {
            game_found = true;
            game_found_position = i;
            break;
        }
    }

    if (game_found) {

        if (typeof(games[i].played_time) == 'undefined') {
            games[i].played_time = 0;
        }
        if (typeof(games[i].played_times) == 'undefined') {
            games[i].played_times = 0;
        }

        games[i].played_time = games[i].played_time + iPanel.currentGameSeconds;
        games[i].played_times++;
        iPanel.currentGameSeconds = 0;
        array_move(games, game_found_position, games.length - 1);
        iPanel.set_flash_cookie('played_games', games);
        console.log('found');
        return;
    }

    if (iPanel.currentGameSeconds < iPanel.playTime)
        return;

    games[games.length] = {
        md5: document.iGAME.md5,
        url: document.location.href,
        name: document.iGAME.name,
        category: document.iGAME.category,
        avatar: document.iGAME.image,
        played_time: iPanel.currentGameSeconds,
        last_sync: 0,
        last_sync_value: 0
    };

    iPanel.currentGameSeconds = 0;
    iPanel.set_flash_cookie('played_games', games);
    console.log('add');
}


iPanel.add_browser_favorite = function () {
    var title = document.title;
    var url = document.location.href;
    try {
        // Internet Explorer
        window.external.AddFavorite(url, title);
    } catch (e) {
        try {
            // Mozilla
            window.sidebar.addPanel(title, url, "");
        } catch (e) {
            // Opera
            if (typeof (opera) == "object") {
                a.rel = "sidebar";
                a.title = title;
                a.url = url;
                return true;
            } else {
                // Unknown
                alert('РќР°Р¶РјРёС‚Рµ Ctrl+D С‡С‚РѕР±С‹ РґРѕР±Р°РІРёС‚СЊ СЃС‚СЂР°РЅРёС†Сѓ РІ Р·Р°РєР»Р°РґРєРё');
            }
        }
    }
    return false;
}

iPanel.add_to_favorites = function (md5, name, image_url, url, category) {
    if (!md5 || !name || !image_url || !url)
        return;

    var games = iPanel.get_cookie('games');

    if (!games || ( typeof(games) != 'array' && typeof(games) != 'object')) {
        games = new Array;
    }
    ;

    var game_found = false;
    for (var i = 0; i < games.length; i++) {
        if (games[i].md5 == md5) {
            game_found = true;
            break;
        }
    }
    if (game_found) {
        return;
    }
    games[games.length] = {
        md5: md5,
        url: url,
        name: name,
        category: category,
        avatar: image_url
    };

    iPanel.set_cookie('games', games);

    iPanel.$remove_button.show();
    iPanel.$add_button.hide();

    iPanel.updateBookmarkTitle();
    //iPanel.fillGames('favorites','.ip-fav');

    var games = iPanel.get_cookie('games');


    iPanel.show_add_animation(md5, name, image_url, url, category);


    /*    try {
     _gaq.push(['_trackEvent', 'bookmark', 'bookmark']);
     }*/
    try {
        ga('send', 'event', 'bookmark', 'bookmark');
    }
    catch (e) {
    }
}

iPanel.show_add_animation = function (md5, name, image_url, url, category) {
    $('.ip-fav').parent().show('slow');
    var game = [];
    game['md5'] = md5;
    game['name'] = name;
    game['avatar'] = image_url;
    game['url'] = url;
    game['category'] = category;

    var template = this.gameItemFavorites;
    var html = this.render(template, game);


    var slide = jQuery(html).prependTo('.ip-fav');
    slide.css('opacity', '0');

    slide.animate({opacity: 1,}, 2000);

    setTimeout(function () {
        $('.ip-fav').parent().hide('slow');
    }, 2500);
}

iPanel.delete_favorite = function (md5) {
    //if(!confirm('Р’С‹ РґРµР№СЃС‚РІРёС‚РµР»СЊРЅРѕ С…РѕС‚РёС‚Рµ СѓРґР°Р»РёС‚СЊ С‚РµРєСѓС‰СѓСЋ СЃС‚СЂР°РЅРёС†Сѓ РёР· Р·Р°РєР»Р°РґРѕРє?')){
    //return;
    //}
    if (!document.iGAME && !md5) {
        return;
    }
    md5 = md5 ? md5 : document.iGAME.md5

    var games = iPanel.get_cookie('games');

    if (games && ( typeof(games) == 'array' || typeof(games) == 'object')) {
        var nGames = new Array;
        for (var i = 0; i < games.length; i++) {
            if (md5 != games[i]['md5']) {
                nGames[nGames.length] = games[i];
            }
            else {
                iPanel.$remove_button.hide();
                iPanel.$add_button.show();
            }
        }
        iPanel.set_cookie('games', nGames);
    }
    iPanel.updateBookmarkTitle();
    iPanel.fillGames('favorites', '.ip-fav');
}

iPanel.toggleFull = function () {
    $(window).trigger("iPanel.fullscreen", true);
    var iframe = document.getElementById('iplayer-game');
    if (iframe) {
        var elem = iframe;
    } else {
        var elem = document.body; // Make the body go full screen.
    }
    var isInFullScreen = (elem.fullScreenElement && elem.fullScreenElement !== null) || (elem.mozFullScreen || elem.webkitIsFullScreen);

    if (isInFullScreen) {
        iPanel.cancelFullScreen(document);
    } else {
        iPanel.requestFullScreen(elem);
    }
    return false;
}

iPanel.cancelFullScreen = function (el) {
    $(window).trigger("iPanel.fullscreen", false);
    var requestMethod = el.cancelFullScreen || el.webkitCancelFullScreen || el.mozCancelFullScreen || el.exitFullscreen;
    if (requestMethod) { // cancel full screen.
        requestMethod.call(el);
    } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
        var wscript = new ActiveXObject("WScript.Shell");
        if (wscript !== null) {
            wscript.SendKeys("{F11}");
        }
    }
}

iPanel.requestFullScreen = function (el) {
    // Supports most browsers and their versions.
    var requestMethod = el.requestFullScreen || el.webkitRequestFullScreen || el.mozRequestFullScreen || el.msRequestFullScreen;

    if (requestMethod) { // Native full screen.
        requestMethod.call(el);
    } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
        var wscript = new ActiveXObject("WScript.Shell");
        if (wscript !== null) {
            wscript.SendKeys("{F11}");
        }
    }
    return false
}

iPanel.$add_button.click(function (e) {
    iPanel.add_current();
});

iPanel.$remove_button.click(function (e) {
    iPanel.delete_favorite();
});
iPanel.$fullscreen_button.click(function (e) {
    iPanel.toggleFull();
    iPanel.suppressEvent = true;
});


iPanel.xss_clean = function (value, field) {
    if (field == 'avatar' || field == 'url') {
        var domain = this.parse_url(value, 'PHP_URL_HOST');
        return value;
    }

    if (typeof (value) != 'string' || typeof (value.replace) == 'undefined')
        return value;

    value = value.replace(/[^_a-zA-ZР°-СЏРђ-РЇ0-9С–Р†С—Р‡С”Р„\s]/g, '');

    return value;
}


iPanel.updateBookmarkTitle = function () {
    if (!iPanel.swfStoreInited) {

        setTimeout(iPanel.updateBookmarkTitle, 100);
    } else {
        //console.log(iPanel.get_favorites().length);
        var count = iPanel.get_favorites().length;
        jQuery('.iplayer-btn-favorites').html(count + ' ' + iPanel.declOfNum(count, ['Р·Р°РєР»Р°РґРєР°', 'Р·Р°РєР»Р°РґРєРё', 'Р·Р°РєР»Р°РґРѕРє']) + '');
        iPanel.sync();
    }
}

iPanel.declOfNum = function (number, titles) {
    /*decOfNum(5, ['СЃРµРєСѓРЅРґР°', 'СЃРµРєСѓРЅРґС‹', 'СЃРµРєСѓРЅРґ']) */
    cases = [2, 0, 1, 1, 1, 2];
    return titles[(number % 100 > 4 && number % 100 < 20) ? 2 : cases[(number % 10 < 5) ? number % 10 : 5]];
}


iPanel.parse_url = function (str, component) {
    var query, key = ['source', 'scheme', 'authority', 'userInfo', 'user', 'pass', 'host', 'port',
            'relative', 'path', 'directory', 'file', 'query', 'fragment'],
        ini = (this.php_js && this.php_js.ini) || {},
        mode = (ini['phpjs.parse_url.mode'] &&
            ini['phpjs.parse_url.mode'].local_value) || 'php',
        parser = {
            php: /^(?:([^:\/?#]+):)?(?:\/\/()(?:(?:()(?:([^:@]*):?([^:@]*))?@)?([^:\/?#]*)(?::(\d*))?))?()(?:(()(?:(?:[^?#\/]*\/)*)()(?:[^?#]*))(?:\?([^#]*))?(?:#(.*))?)/,
            strict: /^(?:([^:\/?#]+):)?(?:\/\/((?:(([^:@]*):?([^:@]*))?@)?([^:\/?#]*)(?::(\d*))?))?((((?:[^?#\/]*\/)*)([^?#]*))(?:\?([^#]*))?(?:#(.*))?)/,
            loose: /^(?:(?![^:@]+:[^:@\/]*@)([^:\/?#.]+):)?(?:\/\/\/?)?((?:(([^:@]*):?([^:@]*))?@)?([^:\/?#]*)(?::(\d*))?)(((\/(?:[^?#](?![^?#\/]*\.[^?#\/.]+(?:[?#]|$)))*\/?)?([^?#\/]*))(?:\?([^#]*))?(?:#(.*))?)/ // Added one optional slash to post-scheme to catch file:/// (should restrict this)
        };

    var m = parser[mode].exec(str),
        uri = {},
        i = 14;
    while (i--) {
        if (m[i]) {
            uri[key[i]] = m[i];
        }
    }

    if (component) {
        return uri[component.replace('PHP_URL_', '').toLowerCase()];
    }
    if (mode !== 'php') {
        var name = (ini['phpjs.parse_url.queryKey'] &&
            ini['phpjs.parse_url.queryKey'].local_value) || 'queryKey';
        parser = /(?:^|&)([^&=]*)=?([^&]*)/g;
        uri[name] = {};
        query = uri[key[12]] || '';
        query.replace(parser, function ($0, $1, $2) {
            if ($1) {
                uri[name][$1] = $2;
            }
        });
    }
    delete uri.source;
    return uri;
}

iPanel.setSubId = function (sub_id) {
    iPanel.sub_id = sub_id;
}

iPanel.getSubId = function () {
    var a = getParameterByName('sub');
    var b = iPanel.sub_id;
    if (a && a.length > 0) return a;
    if (b && b.length > 0) return b;
    return 'iplayer_site';
}

iPanel.setGame = function (game) {
    iPanel.game = game;
}

iPanel.getGame = function () {
    if (iPanel.game) {
        return iPanel.game;
    } else {
        if (document.iGAME && document.iGAME.slug) {
            return document.iGAME.slug;
        }
        if (getParameterByName('game')) {
            return getParameterByName('game');
        }
    }
    return false;
}

/* iPLogin */
var iPLogin = {};
iPLogin.init = function () {
    this.tab = [];
    this.tab.register = jQuery('#ip-login .register-form');
    this.tab.login = jQuery('#ip-login .login-form');
    this.tab.forgot = jQuery('#ip-login .forgot-form');
    this.tab.forgot_final = jQuery('#ip-login .forgot-form-final');
    this.tab.form_emailconfirm = jQuery('#ip-login .form-emailconfirm');
    this.active_tab = this.tab.login;

    this.error_class = '.error';

    jQuery('#ip-login .close').click(this.close);
    this.window = jQuery('#ip-login');
    this.overlay = jQuery('#ipoverlay');
    this.close();
    if (typeof iPLogin_afterClose == 'function') {
        iPLogin_afterClose();
    }

}


iPLogin.codeCheck = function () {
    iPLogin.loadingStart();
    jQuery.ajax({
        url: iEngine.URLS.root() + 'auth/codeCheck?panel=1',
        type: 'GET',
        dataType: iEngine.dataType,
        crossDomain: true,
        data: {code: jQuery('#acode').val()},
        success: function (response) {
            iPLogin.loadingEnd();
            if (typeof (response.errors) == 'undefined') {
                /*$('.user-enter-email').html(response.form.email);
                 $('.user-enter-email-domain').val(response.form.domain);
                 iPLogin.show_tab('forgot_final');
                 $('.error').hide().html('');*/
                //alert('valid');
                window.location.reload();
            } else {
                $('.error').html(response.errors.check).show();
            }
        }
    });
}


iPLogin.close = function () {
    iPLogin.overlay.hide();
    iPLogin.window.hide();
    $('.error').hide().html('');
    $('body').removeClass('overlay-body');
}

iPLogin.open = function () {
    if (iPanel.iframemode) return;
    iPLogin.window.show();
    iPLogin.overlay.show();
    $('body').addClass('overlay-body');
}

iPLogin.show_login = function () {
    //this.init();
    //console.log('show_login');

}

iPLogin.show_tab = function (tab) {

    //console.log(iPanel.logged);
    //console.log(iPLogin.redirectUrl);
    if (iPanel.iframemode) {
        //window.parent.iPanel.show_tab(tab);
        parent.postMessage('iPLogin.show_tab("' + tab + '")', '*');
        /*$.postMessage(
         "this is a message",
         "*",
         parent
         );*/
        console.log('iframe message')
        return;
    }

    if (iPanel.logged && typeof (iPLogin.redirectUrl) != 'undefined') {
        window.location.href = iPLogin.redirectUrl;
    } else {

        if ($('#ip-login').html() == '') {
            $.ajax({
                url: "//iplayer.org/welcome/panel?r=" + $.now(),
                type: 'GET',
                dataType: iEngine.dataType,
                crossDomain: true,
                async: false,
                success: function (response) {
                    $('#ip-login').html(response.html);
                    iPLogin.init();
                    iPLogin.hideAndSetTab(tab);
                }
            });
        } else {
            iPLogin.hideAndSetTab(tab);
        }

    }
}

iPLogin.hideAndSetTab = function (tab) {
    $('.error').hide().html('');
    for (var i in this.tab) {
        this.tab[i].hide();
        //console.log(iPLogin.redirectUrl);
    }
    if (tab) {
        this.tab[tab].show();
        this.active_tab = this.tab[tab];
        //this.show_error('test '+tab);
    }
    this.open();
    $(window).trigger("iPanel.show_tab_complete");
}

iPLogin.show_tab_notopen = function (tab) {
    $('.error').hide().html('');
    for (var i in this.tab) {
        this.tab[i].hide();
    }
    if (tab) {
        this.tab[tab].show();
        this.active_tab = this.tab[tab];
        //this.show_error('test '+tab);
    }
}

iPLogin.show_error = function (error) {
    this.active_tab.find(this.error_class).html(error);
}

iPLogin.login = function () {
    //console.log(this.active_tab.serialize());
    iPLogin.loadingStart();
    jQuery.ajax({
        url: iEngine.URLS.root() + 'auth/login?panel=1',
        type: 'GET',
        dataType: iEngine.dataType,
        crossDomain: true,
        data: this.active_tab.serialize(),
        success: function (response) {
            iPLogin.loadingEnd();
            if (typeof (response.errors) == 'undefined') {
                if (typeof (iPLogin.redirectUrl) == 'undefined') {
                    //iPLogin.window.hide();
                    iPLogin.close();
                    $('.error').hide().html('');
                    window.postMessage('iplayer-login-success', '*');
                    iEngine.api('update', {}, 'iPanel.updatePanel');
                    window.location.reload();
                } else {
                    location.href = iPLogin.redirectUrl;
                }

            } else {
                $('.error').html(response.errors.username).show();
            }
        }
    });
    return false;
}

iPLogin.register = function () {
    //console.log(this.active_tab.serialize());
    var _source_url = location.href;
    if (_source_url != '') {
        _source_url = '&_source_url=' + encodeURIComponent(_source_url);
    }
    iPLogin.loadingStart();
    jQuery.ajax({
        url: iEngine.URLS.root() + 'auth/register?panel=1&sub_id=' + iPanel.getSubId() + '&game=' + iPanel.getGame(),
        type: 'GET',
        dataType: iEngine.dataType,
        crossDomain: true,
        data: this.active_tab.serialize(),
        success: function (response) {
            iPLogin.loadingEnd();
            if (typeof (response.errors) == 'undefined') {
                if (typeof (iPLogin.redirectUrl) == 'undefined') {
                    iAPI('/stat/event',
                        {
                            sub_id: iPanel.getSubId(),
                            game: iPanel.getGame(),
                            event: 'new_user',
                            event_data: 'email'
                        }, function () {
                            window.location.reload();
                        });

                    iPLogin.close();
                    $('.error').hide().html('');
                    window.postMessage('iplayer-login-success', '*');
                    //e.source.postMessage('registration-finish', '*');
                    iEngine.api('update', {}, 'iPanel.updatePanel');
                } else {
                    location.href = iPLogin.redirectUrl;
                }

            }
            else {
                if (typeof (response.errors.password) != 'undefined') {
                    $('.error').html(response.errors.password).show();
                }
                if (typeof (response.errors.username) != 'undefined') {
                    $('.error').html(response.errors.username).show();
                }
            }
        }
    });
    return false;
}


iPLogin.forgot = function () {
    console.log(this.active_tab);
    iPLogin.loadingStart();
    jQuery.ajax({
        url: iEngine.URLS.root() + 'auth/forgot?panel=1',
        type: 'GET',
        dataType: iEngine.dataType,
        crossDomain: true,
        data: this.active_tab.serialize(),
        success: function (response) {
            iPLogin.loadingEnd();
            if (typeof (response.errors) == 'undefined') {
                $('.user-enter-email').html(response.form.email);
                $('.user-enter-email-domain').val(response.form.domain);
                iPLogin.show_tab('forgot_final');
                $('.error').hide().html('');
            } else {
                $('.error').html(response.errors.username).show();
            }
        }
    });
    return false;
}

iPLogin.loadingStart = function () {
    $('body').css({'cursor': 'wait'});
}

iPLogin.loadingEnd = function () {
    $('body').css({'cursor': 'default'});
}

iPLogin.openmail = function () {
    window.open($('.user-enter-email-domain').val(), '_blank');
}

iPLogin.sendagain = function () {
    iPLogin.show_tab('forgot');
}
iPLogin.entersite = function () {
    iPLogin.show_tab('login');
}


iPLogin.socialLogin = function (url, sub_id, game) {
    if (document.iGAME && document.iGAME.slug) {
        var slug = iPanel.getGame();
        var isub_id = iPanel.getSubId();

        /*iAPI('/stat/event',
         {sub_id:isub_id, game: slug, event: 'socialLogin', event_data: url.replace('//iplayer.org/auth/oauth/','')});*/

    }
    /*if(iPanel.iframemode){
     parent.postMessage('iPLogin.socialLogin("'+url+'", "'+iPanel.getSubId()+'", "'+iPanel.getGame()+'")', '*');
     return;
     }*/

    iPLogin.loadingStart();
    if (typeof (iPLogin.redirectUrl) == 'undefined') {
        iPLogin.redirectUrl = window.location.href;
    }

    window.open(url + '?game=' + iPanel.getGame() + '&sub_id=' + iPanel.getSubId() + '&frame=1&return=' + iPLogin.redirectUrl, 'name', 'width=990,height=630,left=300,top=100,scrollbars=0');
    //location.href = url + '?game='+iPanel.getGame()+'&sub_id='+iPanel.getSubId() +'&return='+iPLogin.redirectUrl;
}


var iPEdit = {};
iPEdit.editAvatar = function () {
    //$.get("/user/profile/editavatar", {}, function(data) {
    //$.fancybox(data, { scrolling:'no' ,tpl: {closeBtn: '<a title="Р—Р°РєСЂС‹С‚СЊ" class="fancybox-item fancybox-close">вњ•</a>' }});
    //});
    $.fancybox('<iframe id="dataFormEdit" src="/user/profile/editavatar" width="450" height="300"></iframe>', {
        scrolling: 'no',
        topRatio: 0.05,
        tpl: {closeBtn: ''}
    });
}

iPEdit.confirmInvite = function (obj, id_group) {
    $(obj).parent().append('<span style="position: absolute;right:0;top:0;">Р’С‹ РІСЃС‚СѓРїРёР»Рё РІ РіСЂСѓРїРїСѓ</span>');
    $(obj).remove();
    $.post("/user/groups/confirminvite", {id_group: id_group}, function (data) {
    });
}

iPEdit.confirmInvitePage = function (obj, id_group) {
    $(obj).parent().html('Р’С‹ РІСЃС‚СѓРїРёР»Рё РІ РіСЂСѓРїРїСѓ');
    $(obj).remove();
    $.post("/user/groups/confirminvite", {id_group: id_group}, function (data) {
    });
}
iPEdit.cencelInvite = function (obj, id_group) {
    if (confirm('Р’С‹ РґРµР№СЃС‚РІРёС‚РµР»СЊРЅРѕ С…РѕС‚РёС‚Рµ РѕС‚РєР»РѕРЅРёС‚СЊ РїСЂРёРіР»Р°С€РµРЅРёРµ?')) {
        $(obj).parent().parent().remove();
        $.post("/user/groups/cencelinvite", {id_group: id_group}, function (data) {
            location.href = location.href;
        });
    }
}

iPEdit.confirmInvitePageRedirect = function (obj, id_group) {
    $(obj).remove();
    $.post("/user/groups/confirminvite", {id_group: id_group}, function (data) {
        location.href = location.href;
    });
}

iPEdit.moveoutFromGroup = function (obj, id_group) {
    $(obj).parent().append('<span>Р’С‹ РІС‹С€Р»Рё РёР· РіСЂСѓРїРїС‹</span>');
    $(obj).remove();
    $.post("/user/groups/moveoutfromgroup", {id_group: id_group}, function (data) {
    });
}
iPEdit.moveoutFromGroupRedirect = function (obj, id_group) {
    $(obj).remove();
    $.post("/user/groups/moveoutfromgroup", {id_group: id_group}, function (data) {
        location.href = location.href;
    });
}
iPEdit.addFriend = function (obj, url) {
    $(obj).parent().html('<span>Р’С‹ РѕС‚РїСЂР°РІРёР»Рё Р·Р°СЏРІРєСѓ РІ РґСЂСѓР·СЊСЏ</span>');
    $(obj).remove();
    $.post(url, {}, function (data) {
    });
}
iPEdit.addFriendInv = function (obj, url) {
    $(obj).parent().html('<span>Р’С‹ РїСЂРёРЅСЏР»Рё РїСЂРёРіР»Р°С€РµРЅРёРµ РІ РґСЂСѓР·СЊСЏ</span>');
    $(obj).remove();
    $.post(url, {}, function (data) {
    });
}
iPEdit.alert = function (mess) {
    $.fancybox(mess, {
        scrolling: 'no',
        tpl: {closeBtn: '<a title="Р—Р°РєСЂС‹С‚СЊ" class="fancybox-item fancybox-close">вњ•</a>'}
    });
}


function iAPI(url, data, cb, type) {
    type = type ? type : 'GET';
    $.ajax({
        type: type,
        data: data,
        url: '//api.iplayer.org' + url,
        dataType: 'json',
        xhrFields: {
            withCredentials: true
        },
        success: cb
    });
}


var makeCRCTable = function () {
    var c;
    var crcTable = [];
    for (var n = 0; n < 256; n++) {
        c = n;
        for (var k = 0; k < 8; k++) {
            c = ((c & 1) ? (0xEDB88320 ^ (c >>> 1)) : (c >>> 1));
        }
        crcTable[n] = c;
    }
    return crcTable;
}

var crc32 = function (str) {
    var crcTable = window.crcTable || (window.crcTable = makeCRCTable());
    var crc = 0 ^ (-1);

    for (var i = 0; i < str.length; i++) {
        crc = (crc >>> 8) ^ crcTable[(crc ^ str.charCodeAt(i)) & 0xFF];
    }

    return (crc ^ (-1)) >>> 0;
};


array_move = function (arr, old_index, new_index) {
    if (new_index >= arr.length) {
        var k = new_index - arr.length;
        while ((k--) + 1) {
            arr.push(undefined);
        }
    }
    arr.splice(new_index, 0, arr.splice(old_index, 1)[0]);
    return arr; // for testing purposes
};

function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}


(function () {
    "use strict";
    var e, t, n, i, r, u, o, f, c, d, s, a, v, l;
    c = {}, n = document, s = !1, a = "active", o = 6e4, u = !1, t = function () {
        var e, t, n, i, r, u;
        return e = function () {
            return (65536 * (1 + Math.random()) | 0).toString(16).substring(1)
        }, r = function () {
            return e() + e() + "-" + e() + "-" + e() + "-" + e() + "-" + e() + e() + e()
        }, u = {}, n = "__ceGUID", t = function (e, t, i) {
            return e[n] = void 0, e[n] || (e[n] = "ifvisible.object.event.identifier"), u[e[n]] || (u[e[n]] = {}), u[e[n]][t] || (u[e[n]][t] = []), u[e[n]][t].push(i)
        }, i = function (e, t, i) {
            var r, o, f, c, d;
            if (e[n] && u[e[n]] && u[e[n]][t]) {
                for (c = u[e[n]][t], d = [], o = 0, f = c.length; f > o; o++)r = c[o], d.push(r(i || {}));
                return d
            }
        }, {add: t, fire: i}
    }(), e = function () {
        var e;
        return e = !1, function (t, n, i) {
            return e || (e = t.addEventListener ? function (e, t, n) {
                    return e.addEventListener(t, n, !1)
                } : t.attachEvent ? function (e, t, n) {
                        return e.attachEvent("on" + t, n, !1)
                    } : function (e, t, n) {
                        return e["on" + t] = n
                    }), e(t, n, i)
        }
    }(), i = function (e, t) {
        var i;
        return n.createEventObject ? e.fireEvent("on" + t, i) : (i = n.createEvent("HTMLEvents"), i.initEvent(t, !0, !0), !e.dispatchEvent(i))
    }, f = function () {
        var e, t, i, r, u;
        for (r = void 0, u = 3, i = n.createElement("div"), e = i.getElementsByTagName("i"), t = function () {
            return i.innerHTML = "<!--[if gt IE " + ++u + "]><i></i><![endif]-->", e[0]
        }; t(););
        return u > 4 ? u : r
    }(), r = !1, l = void 0, "undefined" != typeof n.hidden ? (r = "hidden", l = "visibilitychange") : "undefined" != typeof n.mozHidden ? (r = "mozHidden", l = "mozvisibilitychange") : "undefined" != typeof n.msHidden ? (r = "msHidden", l = "msvisibilitychange") : "undefined" != typeof n.webkitHidden && (r = "webkitHidden", l = "webkitvisibilitychange"), v = function () {
        var t, i;
        return t = !1, i = function () {
            return clearTimeout(t), "active" !== a && c.wakeup(), u = +new Date, t = setTimeout(function () {
                return "active" === a ? c.idle() : void 0
            }, o)
        }, i(), e(n, "mousemove", i), e(n, "keyup", i), e(window, "scroll", i), c.focus(i)
    }, d = function () {
        var t;
        return s ? !0 : (r === !1 ? (t = "blur", 9 > f && (t = "focusout"), e(window, t, function () {
                    return c.blur()
                }), e(window, "focus", function () {
                    return c.focus()
                })) : e(n, l, function () {
                    return n[r] ? c.blur() : c.focus()
                }, !1), s = !0, v())
    }, c = {
        setIdleDuration: function (e) {
            return o = 1e3 * e
        }, getIdleDuration: function () {
            return o
        }, getIdleInfo: function () {
            var e, t;
            return e = +new Date, t = {}, "idle" === a ? (t.isIdle = !0, t.idleFor = e - u, t.timeLeft = 0, t.timeLeftPer = 100) : (t.isIdle = !1, t.idleFor = e - u, t.timeLeft = u + o - e, t.timeLeftPer = (100 - 100 * t.timeLeft / o).toFixed(2)), t
        }, focus: function (e) {
            return "function" == typeof e ? this.on("focus", e) : (a = "active", t.fire(this, "focus"), t.fire(this, "wakeup"), t.fire(this, "statusChanged", {status: a}))
        }, blur: function (e) {
            return "function" == typeof e ? this.on("blur", e) : (a = "hidden", t.fire(this, "blur"), t.fire(this, "idle"), t.fire(this, "statusChanged", {status: a}))
        }, idle: function (e) {
            return "function" == typeof e ? this.on("idle", e) : (a = "idle", t.fire(this, "idle"), t.fire(this, "statusChanged", {status: a}))
        }, wakeup: function (e) {
            return "function" == typeof e ? this.on("wakeup", e) : (a = "active", t.fire(this, "wakeup"), t.fire(this, "statusChanged", {status: a}))
        }, on: function (e, n) {
            return d(), t.add(this, e, n)
        }, onEvery: function (e, t) {
            var n;
            return d(), n = setInterval(function () {
                return "active" === a ? t() : void 0
            }, 1e3 * e), {
                stop: function () {
                    return clearInterval(n)
                }, code: n, callback: t
            }
        }, now: function () {
            return d(), "active" === a
        }
    }, "function" == typeof define && define.amd ? define(function () {
            return c
        }) : window.ifvisible = c
}).call(this);