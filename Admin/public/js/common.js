function datepickerInit(type) {
    var now = new Date();
    var year = now.getFullYear();
    var startYeah = year - 5;
    var endYear = year + 5;
    $.datepicker.setDefaults({
        showOn: 'both',
        buttonImage: '/image/calendar.gif',
        buttonImageOnly: true,
        showOtherMonths: true,
        dateFormat: type == 2 ? 'yy-mm' : 'yy-mm-dd',
        speed: 'fast',
        yearRange: startYeah + ':' + endYear
    });
}

function loadingStart() {
    $('#loading').show();
}

function loadingStop() {
    $('#loading').hide();
}

function ajaxLoading() {
    $.ajaxPrefilter(function (options) {
        options.global = true;
    });
    $(document).ajaxStart(function () {
        loadingStart();
    }).ajaxStop(function () {
        loadingStop();
    });
}

function formConfirm(type) {
    if (type == 'save') {
        return confirm('确定要保存当前内容吗？');
    }

    return false;
}

function delConfirm(id, type) {
    if (type == 'question') {
        var msg = '确定要删除该问答吗？';
        var uri = '/demo/del';
        var data = {id: id};
    } else {
        return;
    }

    if (!confirm(msg)) {
        return;
    }

    $.getJSON(uri, data, function (json) {
        if (json.msg) {
            alert(json.msg);
        }

        if (json.status) {
            window.location.reload();
        }
    });
}

function pagingChange() {
    document.search_form.submit();
}

function searchReset() {
    var form = $('form[name=search_form]');
    var uri = '?';

    form.find('input[type=hidden]').each(function () {
        uri += $(this).attr('name') + '=' + $(this).val() + '&';
    });

    window.location.href = uri;
}

function upload(uri, data, func) {
    $.upload({
        url: uri,
        fileName: 'file',
        params: data,
        dataType: 'json',
        onSend: function () {
            return true;
        },
        onComplate: function (json) {
            func(json);
            loadingStop();
        }
    });
}

function uploadSortable(slc) {
    if (slc.find('.delete').length > 0) {
        slc.find('.upload_list').sortable('destroy');
        slc.find('.upload_list').sortable().bind('sortupdate', function () {});
    }
}

function uploadDeletable(slc, msg, uri, data) {
    slc.find('.upload_add span').html(slc.find('.delete').length);
    slc.find('.delete').each(function () {
        $(this).unbind('click');
        $(this).click(function () {
            if (confirm(msg)) {
                var item = $(this).parent(0);

                if (uri && data) {
                    loadingStart();
                    data.fid = item.attr('fid');

                    $.getJSON(uri, data, function (json) {
                        loadingStop();

                        if (json.status) {
                            item.remove();

                            if (slc.hasClass('upload_single')) {
                                slc.find('.upload_add').show();
                            } else {
                                slc.find('.upload_add span').html(slc.find('.delete').length);
                            }
                        } else {
                            alert(json.msg);
                        }
                    });
                } else {
                    item.remove();

                    if (slc.hasClass('upload_single')) {
                        slc.find('.upload_add').show();
                    } else {
                        slc.find('.upload_add span').html(slc.find('.delete').length);
                    }
                }
            }
        });
    });
}

function order(uri) {
    window.location.href = uri;
}


$(function () {
    var $this = $(this);
    $this.on("click", "form input[name=complete]", function (e) {
        var $this = $(this);
        if (!$this.data("form")) {
            $this.data("form", $this.closest("form"));
        }
        var $form = $this.data("form");
        if ($form[0]) {
            e.preventDefault();
            layer.confirm('是否确认保存？', {
                btn: ['确定', '取消'], //按钮
                icon: 3,
            }, function () {
                $form.append('<input type="hidden" value="1" name="complete"/>').submit();
            });
        }
    }).on("click", ".rayu_html_iframe", function (e) {
        e.preventDefault();
        var title = this.title;
        layer.open({
            type: 2,
            shade: 0,
            maxmin: true,
            area: ['80%', '88%'],
            title: title ? title : '&nbsp;',
            content: this.href,
        });
    })
})

function iframeAuto(height) {
    $('.layui-layer-iframe').height((height + $('.layui-layer-title').height()));
    $('.layui-layer').find('iframe').css({height: height});
    var h = ($(window).height() - $('.layui-layer').height()) / 2;
    $('.layui-layer').css({top: h,height:'auto'});
}