<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html>
<head>
    <title>誉狼网络科技</title>
    <link rel="stylesheet" href="/Public/Admin/js/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/Public/Admin/css/font-awesome.min.css">
    <link rel="stylesheet" href="/Public/Admin/css/index.css">
    <link rel="stylesheet" href="/Public/Admin/css/skins/_all-skins.css">
</head>
<body class="hold-transition skin-blue sidebar-mini" style="overflow:hidden;">
    <div id="ajax-loader" style="cursor: progress; position: fixed; top: -50%; left: -50%; width: 200%; height: 200%; background: #fff; z-index: 10000; overflow: hidden;">
        <img src="/Public/Admin/images/ajax-loader.gif" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; margin: auto;" />
    </div>
    <div class="wrapper">
        <!--头部信息-->
        <header class="main-header">
            <a href="#" target="_blank" class="logo">
                <span class="logo-mini">LR</span>
                <span class="logo-lg"><strong>誉狼网络科技</strong></span>
            </a>
            <nav class="navbar navbar-static-top">
                <a class="sidebar-toggle">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="/Public/Admin/images/user2-160x160.jpg" class="user-image" alt="User Image">
                                <span class="hidden-xs">administrator</span>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a class="menuItem" data-id="userInfo" href="/SystemManage/User/Info"><i class="fa fa-user"></i>个人信息</a></li>
                                <li><a href="javascript:void();"><i class="fa fa-trash-o"></i>清空缓存</a></li>
                                <!--<li><a href="javascript:void();"><i class="fa fa-paint-brush"></i>皮肤设置</a></li>-->
                                <li class="divider"></li>
                                <li><a href="~/Login/OutLogin"><i class="ace-icon fa fa-power-off"></i>安全退出</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!--左边导航-->
        <div class="main-sidebar">
            <div class="sidebar">
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="/Public/Admin/images/user2-160x160.jpg" class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info">
                        <p>administrator</p>
                        <a><i class="fa fa-circle text-success"></i>在线</a>
                    </div>
                </div>
                <form action="#" method="get" class="sidebar-form">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                            <a class="btn btn-flat"><i class="fa fa-search"></i></a>
                        </span>
                    </div>
                </form>
                <ul class="sidebar-menu" id="sidebar-menu">
                    <!--<li class="header">导航菜单</li>-->
                </ul>
            </div>
        </div>
        <!--中间内容-->
        <div id="content-wrapper" class="content-wrapper">
            <div class="content-tabs">
                <button class="roll-nav roll-left tabLeft" id="back">
                
                    <i class="fa fa-backward"></i></a>
                </button>
                <nav class="page-tabs menuTabs">
                    <div class="page-tabs-content" style="margin-left: 0px;">
                        <a href="javascript:;" class="menuTab active" data-id="/Home/Default">欢迎首页</a>
                    </div>
                </nav>
                <button class="roll-nav roll-right tabRight" id="go">
                    <i class="fa fa-forward" style="margin-left: 3px;"></i>
                </button>
                <div class="btn-group roll-nav roll-right">
                    <button class="dropdown tabClose" data-toggle="dropdown">
                        页签操作<i class="fa fa-caret-down" style="padding-left: 3px;"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><a class="tabReload" href="javascript:void();">刷新当前</a></li>
                        <li><a class="tabCloseCurrent" href="javascript:void();">关闭当前</a></li>
                        <li><a class="tabCloseAll" href="javascript:void();">全部关闭</a></li>
                        <li><a class="tabCloseOther" href="javascript:void();">除此之外全部关闭</a></li>
                    </ul>
                </div>
                <button class="roll-nav roll-right fullscreen"><i class="fa fa-arrows-alt"></i></button>
            </div>
            <div class="content-iframe" style="overflow: hidden;">
                <div class="mainContent" id="content-main" style="margin: 10px; margin-bottom: 0px; padding: 0;">
                    <iframe class="LRADMS_iframe" width="100%" height="100%" src="<?php echo U('Index/main')?>" frameborder="0" data-id="main.html"></iframe>
                </div>
            </div>
        </div>
    </div>
    <script src="/Public/Admin/js/jquery/jQuery-2.2.0.min.js"></script>
    <script src="/Public/Admin/js/bootstrap/js/bootstrap.min.js"></script>
    <script>
    (function ($) {
        $.learuntab = {
            requestFullScreen: function () {
                var de = document.documentElement;
                if (de.requestFullscreen) {
                    de.requestFullscreen();
                } else if (de.mozRequestFullScreen) {
                    de.mozRequestFullScreen();
                } else if (de.webkitRequestFullScreen) {
                    de.webkitRequestFullScreen();
                }
            },
            exitFullscreen: function () {
                var de = document;
                if (de.exitFullscreen) {
                    de.exitFullscreen();
                } else if (de.mozCancelFullScreen) {
                    de.mozCancelFullScreen();
                } else if (de.webkitCancelFullScreen) {
                    de.webkitCancelFullScreen();
                }
            },
            refreshTab: function () {
                var currentId = $('.page-tabs-content').find('.active').attr('data-id');
                var target = $('.LRADMS_iframe[data-id="' + currentId + '"]');
                var url = target.attr('src');
                //$.loading(true);
                target.attr('src', url).load(function () {
                    //$.loading(false);
                });
            },
            activeTab: function () {
                var currentId = $(this).data('id');
                if (!$(this).hasClass('active')) {
                    $('.mainContent .LRADMS_iframe').each(function () {
                        if ($(this).data('id') == currentId) {
                            $(this).show().siblings('.LRADMS_iframe').hide();
                            return false;
                        }
                    });
                    $(this).addClass('active').siblings('.menuTab').removeClass('active');
                    $.learuntab.scrollToTab(this);
                }
            },
            closeOtherTabs: function () {
                $('.page-tabs-content').children("[data-id]").find('.fa-remove').parents('a').not(".active").each(function () {
                    $('.LRADMS_iframe[data-id="' + $(this).data('id') + '"]').remove();
                    $(this).remove();
                });
                $('.page-tabs-content').css("margin-left", "0");
            },
            closeTab: function () {
                var closeTabId = $(this).parents('.menuTab').data('id');
                var currentWidth = $(this).parents('.menuTab').width();
                if ($(this).parents('.menuTab').hasClass('active')) {
                    if ($(this).parents('.menuTab').next('.menuTab').size()) {
                        var activeId = $(this).parents('.menuTab').next('.menuTab:eq(0)').data('id');
                        $(this).parents('.menuTab').next('.menuTab:eq(0)').addClass('active');

                        $('.mainContent .LRADMS_iframe').each(function () {
                            if ($(this).data('id') == activeId) {
                                $(this).show().siblings('.LRADMS_iframe').hide();
                                return false;
                            }
                        });
                        var marginLeftVal = parseInt($('.page-tabs-content').css('margin-left'));
                        if (marginLeftVal < 0) {
                            $('.page-tabs-content').animate({
                                marginLeft: (marginLeftVal + currentWidth) + 'px'
                            }, "fast");
                        }
                        $(this).parents('.menuTab').remove();
                        $('.mainContent .LRADMS_iframe').each(function () {
                            if ($(this).data('id') == closeTabId) {
                                $(this).remove();
                                return false;
                            }
                        });
                    }
                    if ($(this).parents('.menuTab').prev('.menuTab').size()) {
                        var activeId = $(this).parents('.menuTab').prev('.menuTab:last').data('id');
                        $(this).parents('.menuTab').prev('.menuTab:last').addClass('active');
                        $('.mainContent .LRADMS_iframe').each(function () {
                            if ($(this).data('id') == activeId) {
                                $(this).show().siblings('.LRADMS_iframe').hide();
                                return false;
                            }
                        });
                        $(this).parents('.menuTab').remove();
                        $('.mainContent .LRADMS_iframe').each(function () {
                            if ($(this).data('id') == closeTabId) {
                                $(this).remove();
                                return false;
                            }
                        });
                    }
                }
                else {
                    $(this).parents('.menuTab').remove();
                    $('.mainContent .LRADMS_iframe').each(function () {
                        if ($(this).data('id') == closeTabId) {
                            $(this).remove();
                            return false;
                        }
                    });
                    $.learuntab.scrollToTab($('.menuTab.active'));
                }
                return false;
            },
            addTab: function () {
                $(".navbar-custom-menu>ul>li.open").removeClass("open");
                var dataId = $(this).attr('data-id');
                if (dataId != "") {
                    //top.$.cookie('nfine_currentmoduleid', dataId, { path: "/" });
                }
                var dataUrl = $(this).attr('href');
                var menuName = $.trim($(this).text());
                var flag = true;
                if (dataUrl == undefined || $.trim(dataUrl).length == 0) {
                    return false;
                }
                $('.menuTab').each(function () {
                    if ($(this).data('id') == dataUrl) {
                        if (!$(this).hasClass('active')) {
                            $(this).addClass('active').siblings('.menuTab').removeClass('active');
                            $.learuntab.scrollToTab(this);
                            $('.mainContent .LRADMS_iframe').each(function () {
                                if ($(this).data('id') == dataUrl) {
                                    $(this).show().siblings('.LRADMS_iframe').hide();
                                    return false;
                                }
                            });
                        }
                        flag = false;
                        return false;
                    }
                });
                if (flag) {
                    var str = '<a href="javascript:;" class="active menuTab" data-id="' + dataUrl + '">' + menuName + ' <i class="fa fa-remove"></i></a>';
                    $('.menuTab').removeClass('active');
                    var str1 = '<iframe class="LRADMS_iframe" id="iframe' + dataId + '" name="iframe' + dataId + '"  width="100%" height="100%" src="' + dataUrl + '" frameborder="0" data-id="' + dataUrl + '" seamless></iframe>';
                    $('.mainContent').find('iframe.LRADMS_iframe').hide();
                    $('.mainContent').append(str1);
                    //$.loading(true);
                    $('.mainContent iframe:visible').load(function () {
                        //$.loading(false);
                    });
                    $('.menuTabs .page-tabs-content').append(str);
                    $.learuntab.scrollToTab($('.menuTab.active'));
                }
                return false;
            },
            scrollTabRight: function () {
                var marginLeftVal = Math.abs(parseInt($('.page-tabs-content').css('margin-left')));
                var tabOuterWidth = $.learuntab.calSumWidth($(".content-tabs").children().not(".menuTabs"));
                var visibleWidth = $(".content-tabs").outerWidth(true) - tabOuterWidth;
                var scrollVal = 0;
                if ($(".page-tabs-content").width() < visibleWidth) {
                    return false;
                } else {
                    var tabElement = $(".menuTab:first");
                    var offsetVal = 0;
                    while ((offsetVal + $(tabElement).outerWidth(true)) <= marginLeftVal) {
                        offsetVal += $(tabElement).outerWidth(true);
                        tabElement = $(tabElement).next();
                    }
                    offsetVal = 0;
                    while ((offsetVal + $(tabElement).outerWidth(true)) < (visibleWidth) && tabElement.length > 0) {
                        offsetVal += $(tabElement).outerWidth(true);
                        tabElement = $(tabElement).next();
                    }
                    scrollVal = $.learuntab.calSumWidth($(tabElement).prevAll());
                    if (scrollVal > 0) {
                        $('.page-tabs-content').animate({
                            marginLeft: 0 - scrollVal + 'px'
                        }, "fast");
                    }
                }
            },
            scrollTabLeft: function () {
                var marginLeftVal = Math.abs(parseInt($('.page-tabs-content').css('margin-left')));
                var tabOuterWidth = $.learuntab.calSumWidth($(".content-tabs").children().not(".menuTabs"));
                var visibleWidth = $(".content-tabs").outerWidth(true) - tabOuterWidth;
                var scrollVal = 0;
                if ($(".page-tabs-content").width() < visibleWidth) {
                    return false;
                } else {
                    var tabElement = $(".menuTab:first");
                    var offsetVal = 0;
                    while ((offsetVal + $(tabElement).outerWidth(true)) <= marginLeftVal) {
                        offsetVal += $(tabElement).outerWidth(true);
                        tabElement = $(tabElement).next();
                    }
                    offsetVal = 0;
                    if ($.learuntab.calSumWidth($(tabElement).prevAll()) > visibleWidth) {
                        while ((offsetVal + $(tabElement).outerWidth(true)) < (visibleWidth) && tabElement.length > 0) {
                            offsetVal += $(tabElement).outerWidth(true);
                            tabElement = $(tabElement).prev();
                        }
                        scrollVal = $.learuntab.calSumWidth($(tabElement).prevAll());
                    }
                }
                $('.page-tabs-content').animate({
                    marginLeft: 0 - scrollVal + 'px'
                }, "fast");
            },
            scrollToTab: function (element) {
                var marginLeftVal = $.learuntab.calSumWidth($(element).prevAll()), marginRightVal = $.learuntab.calSumWidth($(element).nextAll());
                var tabOuterWidth = $.learuntab.calSumWidth($(".content-tabs").children().not(".menuTabs"));
                var visibleWidth = $(".content-tabs").outerWidth(true) - tabOuterWidth;
                var scrollVal = 0;
                if ($(".page-tabs-content").outerWidth() < visibleWidth) {
                    scrollVal = 0;
                } else if (marginRightVal <= (visibleWidth - $(element).outerWidth(true) - $(element).next().outerWidth(true))) {
                    if ((visibleWidth - $(element).next().outerWidth(true)) > marginRightVal) {
                        scrollVal = marginLeftVal;
                        var tabElement = element;
                        while ((scrollVal - $(tabElement).outerWidth()) > ($(".page-tabs-content").outerWidth() - visibleWidth)) {
                            scrollVal -= $(tabElement).prev().outerWidth();
                            tabElement = $(tabElement).prev();
                        }
                    }
                } else if (marginLeftVal > (visibleWidth - $(element).outerWidth(true) - $(element).prev().outerWidth(true))) {
                    scrollVal = marginLeftVal - $(element).prev().outerWidth(true);
                }
                $('.page-tabs-content').animate({
                    marginLeft: 0 - scrollVal + 'px'
                }, "fast");
            },
            calSumWidth: function (element) {
                var width = 0;
                $(element).each(function () {
                    width += $(this).outerWidth(true);
                });
                return width;
            },
            init: function () {
                $('.menuItem').on('click', $.learuntab.addTab);
                $('.menuTabs').on('click', '.menuTab i', $.learuntab.closeTab);
                $('.menuTabs').on('click', '.menuTab', $.learuntab.activeTab);
                $('.tabLeft').on('click', $.learuntab.scrollTabLeft);
                $('.tabRight').on('click', $.learuntab.scrollTabRight);
                $('.tabReload').on('click', $.learuntab.refreshTab);
                $('.tabCloseCurrent').on('click', function () {
                    $('.page-tabs-content').find('.active i').trigger("click");
                });
                $('.tabCloseAll').on('click', function () {
                    $('.page-tabs-content').children("[data-id]").find('.fa-remove').each(function () {
                        $('.LRADMS_iframe[data-id="' + $(this).data('id') + '"]').remove();
                        $(this).parents('a').remove();
                    });
                    $('.page-tabs-content').children("[data-id]:first").each(function () {
                        $('.LRADMS_iframe[data-id="' + $(this).data('id') + '"]').show();
                        $(this).addClass("active");
                    });
                    $('.page-tabs-content').css("margin-left", "0");
                });
                $('.tabCloseOther').on('click', $.learuntab.closeOtherTabs);
                $('.fullscreen').on('click', function () {
                    if (!$(this).attr('fullscreen')) {
                        $(this).attr('fullscreen', 'true');
                        $.learuntab.requestFullScreen();
                    } else {
                        $(this).removeAttr('fullscreen')
                        $.learuntab.exitFullscreen();
                    }
                });
            }
        };
        $.learunindex = {
            load: function () {
                $("body").removeClass("hold-transition")
                $("#content-wrapper").find('.mainContent').height($(window).height() - 100);
                $(window).resize(function (e) {
                    $("#content-wrapper").find('.mainContent').height($(window).height() - 100);
                });
                $(".sidebar-toggle").click(function () {
                    if (!$("body").hasClass("sidebar-collapse")) {
                        $("body").addClass("sidebar-collapse");
                    } else {
                        $("body").removeClass("sidebar-collapse");
                    }
                })
                $(window).load(function () {
                    window.setTimeout(function () {
                        $('#ajax-loader').fadeOut();
                    }, 300);
                });
            },
            jsonWhere: function (data, action) {
                if (action == null) return;
                var reval = new Array();
                $(data).each(function (i, v) {
                    if (action(v)) {
                        reval.push(v);
                    }
                })
                return reval;
            },
            loadMenu: function () {
                var data = [
                    <?php foreach($buttonList as $v){?>        
                    { "F_ModuleId": "<?php echo $v['id']?>", "F_ParentId": "0",  "F_FullName": "<?php echo $v['privilege_name']?>", "F_Icon": "fa fa-coffee", "F_UrlAddress": null },
                   		 <?php foreach($v['child'] as $v1){ ?>
                    		{ "F_ModuleId": "2", "F_ParentId": "<?php echo $v1['parent_id']?>",  "F_FullName": "<?php echo $v1['privilege_name']?>", "F_Icon": "fa fa-book", "F_UrlAddress": "<?php echo U($v1['privilege_url'])?>" },
                    	<?php  } ?>
                    <?php  } ?>
                    ];

                var _html = "";
                $.each(data, function (i) {
                    var row = data[i];
                    if (row.F_ParentId == "0") {
                        if (i == 0) {
                            _html += '<li class="treeview active">';
                        } else {
                            _html += '<li class="treeview">';
                        }
                        _html += '<a href="#">'
                        _html += '<i class="' + row.F_Icon + '"></i><span>' + row.F_FullName + '</span><i class="fa fa-angle-left pull-right"></i>'
                        _html += '</a>'
                        var childNodes = $.learunindex.jsonWhere(data, function (v) { return v.F_ParentId == row.F_ModuleId });
                        if (childNodes.length > 0) {
                            _html += '<ul class="treeview-menu">';
                            $.each(childNodes, function (i) {
                                var subrow = childNodes[i];
                                var subchildNodes = $.learunindex.jsonWhere(data, function (v) { return v.F_ParentId == subrow.F_ModuleId });
                                _html += '<li>';
                                if (subchildNodes.length > 0) {
                                    _html += '<a href="#"><i class="' + subrow.F_Icon + '"></i>' + subrow.F_FullName + '';
                                    _html += '<i class="fa fa-angle-left pull-right"></i></a>';
                                    _html += '<ul class="treeview-menu">';
                                    $.each(subchildNodes, function (i) {
                                        var subchildNodesrow = subchildNodes[i];
                                        _html += '<li><a class="menuItem" data-id="' + subrow.F_ModuleId + '" href="' + subrow.F_UrlAddress + '"><i class="' + subchildNodesrow.F_Icon + '"></i>' + subchildNodesrow.F_FullName + '</a></li>';
                                    });
                                    _html += '</ul>';

                                } else {
                                    _html += '<a class="menuItem" data-id="' + subrow.F_ModuleId + '" href="' + subrow.F_UrlAddress + '"><i class="' + subrow.F_Icon + '"></i>' + subrow.F_FullName + '</a>';
                                }
                                _html += '</li>';
                            });
                            _html += '</ul>';
                        }
                        _html += '</li>'
                    }
                });
                $("#sidebar-menu").append(_html);
                $("#sidebar-menu li a").click(function () {
                    var d = $(this), e = d.next();
                    if (e.is(".treeview-menu") && e.is(":visible")) {
                        e.slideUp(500, function () {
                            e.removeClass("menu-open")
                        }),
                        e.parent("li").removeClass("active")
                    } else if (e.is(".treeview-menu") && !e.is(":visible")) {
                        var f = d.parents("ul").first(),
                        g = f.find("ul:visible").slideUp(500);
                        g.removeClass("menu-open");
                        var h = d.parent("li");
                        e.slideDown(500, function () {
                            e.addClass("menu-open"),
                            f.find("li.active").removeClass("active"),
                            h.addClass("active");

                            var _height1 = $(window).height() - $("#sidebar-menu >li.active").position().top - 41;
                            var _height2 = $("#sidebar-menu li > ul.menu-open").height() + 10
                            if (_height2 > _height1) {
                                $("#sidebar-menu >li > ul.menu-open").css({
                                    overflow: "auto",
                                    height: _height1
                                })
                            }
                        })
                    }
                    e.is(".treeview-menu");
                });
            }
        };
        $(function () {
            $.learunindex.load();
            $.learunindex.loadMenu();
            $.learuntab.init();
        });
    })(jQuery);
    
    $("#back").click(function(){
    	history.go(-1);
    });
    
    $("#go").click(function(){
    	history.go(1);
    });
    
    </script>
</body>
</html>