$.fn.isMouseLeaveOrEnter = function (e) {
    var handler = $(this)[0];
    var reltg = e.relatedTarget ? e.relatedTarget : e.type == 'mouseout' ? e.toElement : e.fromElement;
    while (reltg && reltg != handler) {
        reltg = reltg.parentNode;
    }
    return (reltg != handler);
}
var $ajax_obj = null;
$(document).ready(function () {
    $(document).ajaxStart(function () {
        if ($ajax_obj != null) {
            $ajax_obj.html('<div class="rayu_loading"></div>');
        }
    }).ajaxStop(function () {
        $ajax_obj = null;
    });
    $help_sub_ul = $("#help_sub_ul");
    $("#header").on("mouseover", "#help_ul>li>a", function (e) {
        var $this = $(this);
        if ($this.isMouseLeaveOrEnter(e)) {
            $help_sub_ul.stop(true).slideDown();
        }
    }).on("mouseout", "#help_ul", function (e) {
        var $this = $(this);
        if ($this.isMouseLeaveOrEnter(e)) {
            $help_sub_ul.stop(true).slideUp();
        }
    });
    var $main_scoll = $('#main_scoll');
    $.fn.main_load = function () {
        var $this = $(this);
        $ajax_obj = $main_scoll;
        var con = $this.attr('con');
        var act = $this.attr('act');
        $main_scoll.load('/api/load', {c: con, a: act}, function () {
            main_scoll = new IScroll('#main_scoll', {
                mouseWheel: true,
                preventDefault: false,
            });
            $("#main").find(".handle_hide").hide();
        });
    }
    $('#menu').on({
        mouseover: function (e) {
            var $this = $(this);
            if ($this.isMouseLeaveOrEnter(e)) {
                $this.animate({marginLeft: '6px'});
            }
        }, mouseout: function (e) {
            var $this = $(this);
            if ($this.isMouseLeaveOrEnter(e)) {
                $this.animate({marginLeft: '0'});
            }
        }, click: function () {
            var $this = $(this);
            $this.main_load();
            $this.addClass('active').closest('.submenu').prev().addClass('active').parent().siblings('li').find('a.active').removeClass('active');
            $this.parent().siblings('li').find('a.active').removeClass('active');
        }
    }, '.submenu>li>a').on('click', '#menu_ul>li>a', function () {
        var $this = $(this);
        if (!$this.parent().hasClass("hasChildUl")) {
            return false;
        }
        var $ul = $this.next();
        if (!$ul.hasClass("open")) {
            $ul.parent().siblings('li').find('ul.open').stop(true).removeClass("open").slideUp(function () {
                menu_scoll.refresh();
            });
            $ul.stop(true).addClass("open").slideDown(function () {
                menu_scoll.refresh();
            });
        } else {
            $ul.stop(true).removeClass("open").slideUp(function () {
                menu_scoll.refresh();
            });
        }
    }).find("#menu_ul>li>a.active").next(".submenu").addClass("open").show(0, function () {
        menu_scoll = new IScroll('#menu_scoll', {
            mouseWheel: true,
        });
        $(this).find("a.active").main_load();
    });
    window.onresize = function () {
        menu_scoll.refresh();
        main_scoll.refresh();
    }
    var x = 10, y = 20;
    $("#main").on({
        "mouseover": function (e) {
            this.myTitle = this.title;
            this.title = "";
            var tooltip = "<div id='tooltip'>" + this.myTitle + "<\/div>";
            $("body").append(tooltip);
            $("#tooltip").css({
                "top": (e.pageY + y) + "px",
                "left": (e.pageX + x) + "px"
            }).show("fast");
        }, "mouseout": function (e) {
            this.title = this.myTitle;
            $("#tooltip").remove();
        }, "mousemove": function (e) {
            $("#tooltip").css({
                "top": (e.pageY + y) + "px",
                "left": (e.pageX + x) + "px"
            });
        }
    }, ".tooltip").on('click', '#parameter>a', function () {
        var $this = $(this),
                $p_header_li = $(".p_header_li"),
                p_hearder_length = $p_header_li.length,
                rel = this.rel,
                rowspan = $("#parameter").prop("rowspan");
        if (rel == "open") {
            $p_header_li.stop(true).fadeOut(function () {
                $("#main").find(".handle_hide").hide();
                $this.text("显示HEADER").prop("rel", "close").parent().prop("rowspan", rowspan - p_hearder_length);
                main_scoll.refresh();
            });
        } else {
            $("#main").find(".handle_hide").show();
            $this.text("隐藏HEADER").prop("rel", "open").parent().prop("rowspan", rowspan + p_hearder_length);
            $p_header_li.stop(true).fadeIn(function () {
                main_scoll.refresh();
            });
        }
    });
});