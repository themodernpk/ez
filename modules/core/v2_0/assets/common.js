$(document).find("a[id^='delete_']").live('click', function () {
    var delete_id = this.id.split('_')[1];
    var exception = $(this).attr("data-exception");
    var href = $(this).attr("data-href");
    //alert(href);
    var parent = $(this).parent().parent();
    if (exception == true) {
        $.gritter.add({
            title: 'Action cannot be performed over "Admin".',
            sticky: false,
        });
        $(this).attr('checked', 'checked');
    }
    else {
        var id = delete_id;
        var table = $('#table').val();
        $.ajax({
            type: "POST",
            data: 'action=delete &id=' + id + '&table=' + table,
            url: href,
            beforeSend: function () {
                $(".pace").removeClass('pace-inactive');
            },
            success: function (response) {
                var object = JSON.parse(response);
                if (object.status == "failed") {
                    object.errors.forEach(function (entry) {
                        $.gritter.add({
                            title: '<label class="btn btn-xs btn-icon btn-circle btn-danger"><i class="fa fa-times"></i></label> ' + object.errors,
                            sticky: false,
                        });
                    });
                }
                if (object.status == "success") {
                    object.data.forEach(function (entry) {
                        $.gritter.add({
                            title: '<label class="btn btn-xs btn-icon btn-circle btn-success"><i class="fa fa-check"></i></label> ' + object.data,
                            sticky: false,
                        });
                    });
                    parent.fadeOut('slow', function () {
                        $(this).remove();
                    });
                }
                $(".pace").addClass('pace-inactive');
            }
        });
    }
    return false;
});
$('.markRead').click(function () {
    var href = $(this).data('href');
    $(this).children('i').addClass('fa-spin');
    $(this).children('i').removeClass('fa-bell-o');
    $(this).children('i').addClass('fa-spinner');
    console.log(href);
    $.ajax({
        type: "POST",
        url: href,
        context: this,
        success: function (response) {
            object = JSON.parse(response);
            console.log(response);
            if (object.status == "success")
            {
                $(this).children('i').removeClass('fa-spin');
                $(this).children('i').removeClass('fa-spinner');
                $(this).children('i').addClass('fa-check');
                $('.num_noti').text(0);
                $(this).after(object.data.html);
            }
        }
    });
});
/* Jquery Common Function */
//-----------------------------------------------------------------
(function ($) {
    $('.BSswitch').on('change', function () {
        var pk = $(this).attr('data-pk');
        var checked = $(this).attr('checked');
        var url = $(this).attr('data-href');
        var debug = true;
        var that = $(this);
        if (checked == "checked") {
            var newVal = 1;
        } else {
            var newVal = 0;
        }
        $.ajax({
            type: "POST",
            url: url,
            data: "pk=" + pk + "&value=" + newVal,
            context: this,
            error: function (xhr, ajaxOptions, thrownError) {
                Common.ajaxErrorHandler(xhr, ajaxOptions, thrownError, that, debug);
            },
            success: function (response) {
                response = Common.ajaxSuccessHandler(response, that, debug, false);
                object = JSON.parse(response);
                if (object.status == "success") {
                    $(this).val(newVal);
                }
            }
        });
    });
    //------------------------------------------------------
    $('.ajaxDelete').click(function () {
        var pk = $(this).attr('data-pk');
        var url = $(this).attr('data-href');
        var debug = true;
        var that = $(this);
        Common.showSpinner(that);
        $.ajax({
            type: "POST",
            url: url,
            data: "pk=" + pk,
            context: this,
            error: function (xhr, ajaxOptions, thrownError) {
                Common.ajaxErrorHandler(xhr, ajaxOptions, thrownError, that, debug);
            },
            success: function (response) {
                response = Common.ajaxSuccessHandler(response, that, debug);
                object = JSON.parse(response);
                if (object.status == "success") {
                    $(this).closest('tr').fadeOut();
                }
            }
        });
    });
    //------------------------------------------------------
    $('#selectall').click(function () {
        var current_state = $(this).is(":checked");
        if (current_state) {
            $(".idCheckbox").each(function () {
                $(this).attr("checked", true);
            });
        } else {
            $(".idCheckbox").each(function () {
                $(this).attr("checked", false);
            });
        }
    });
    // DeActivate the parent if parent is not selected
    $('.idCheckbox').click(function () {
        if (!$(this).is(":checked")) {
            $('#selectall').attr("checked", false);
        }
    });
    //------------------------------------------------------
    //------------------------------------------------------
    //------------------------------------------------------
})(jQuery);// end of jquery
//-----------------------------------------------------------------
//------------------------------------------------------written by Pradeep
(function ($) {


    /*
     * Following function will keep sidebar
     * minified for 7 days if not expanded again
     */
    $(document).on("click", "[data-click=sidebar-minify]", function () {
        var checkStatus = $(this).attr('data-minified');
        if (checkStatus == 'true') {
            //if class exist means, sidebar is minified
            $.removeCookie('data-minified-cookie');
            $(this).attr('data-minified', false);
        } else {
            $(this).attr('data-minified', true);
            $.cookie('data-minified-cookie', 'true', {expires: 7});
        }
    });
    var checkStatus = $.cookie('data-minified-cookie');
    if (checkStatus == 'true') {
        $('[data-click=sidebar-minify]').attr('data-minified', true);
        var a = "page-sidebar-minified",
            t = "#page-container";
        $(t).hasClass(a) ? ($(t).removeClass(a), $(t).hasClass("page-sidebar-fixed") && generateSlimScroll($('#sidebar [data-scrollbar="true"]'))) : ($(t).addClass(a), $(t).hasClass("page-sidebar-fixed") && ($('#sidebar [data-scrollbar="true"]').slimScroll({
            destroy: !0
        }), $('#sidebar [data-scrollbar="true"]').removeAttr("style")), $("#sidebar [data-scrollbar=true]").trigger("mouseover")), $(window).trigger("resize")
    }
    //------------------------------------------------------
    /*
     * Ajax Gritter Notifications
     */
    (function () {
        var url = $('.markRead').attr('data-href-realtime');
        $.ajax({
            type: "POST",
            url: url,
            context: this,
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr + " | " + ajaxOptions + " | " + thrownError);
            },
            success: function (response) {
                try {
                    object = JSON.parse(response);
                    var document_title = document.title;
                    var arr = document_title.split('# ');
                    var count = Object.keys(object.data.list).length
                    if (count != '0') {
                        if (arr[1]) {
                            document.title = "(" + count + ") # " + arr[1];
                        } else {
                            document.title = "(" + count + ") # " + document_title;
                        }
                        $(".markRead").find(".num_noti").text(count);
                    }
                    $.each(object.data.list, function (key, item) {
                        var title = "";
                        var text = "";
                        if (item.icon) {
                            title += "<i class='" + item.icon + "'></i> ";
                        }
                        title += item.content;
                        if (item.link) {
                            text += "For more details <a class='text-white' target='_blank' href='" + item.link + "'>click here</a>";
                        }
                        $.gritter.add({
                            title: title,
                            text: text,
                            sticky: false,
                            position: ''
                        });
                    });
                } catch (e) {
                    var errors = [e.message];
                    $.each(errors, function (key, value) {
                        Common.showGritter(value, 'btn-danger', 'fa-times');
                    });
                }
            }
        });
        setTimeout(arguments.callee, 15000);
    })();
    //------------------------------------------------------
    //------------------------------------------------------
    Common =
    {
        //----------------------------------------------------------
        ajaxErrorHandler: function (xhr, ajaxOptions, thrownError, that, debug) {
            debug = typeof debug !== 'undefined' ? debug : false;
            var response = {};
            that.find('i').removeClass('fa-spinner').removeClass('fa-spin');
            var log_message = "status = " + xhr.status + " | Message = " + xhr.responseText + " |  Error=" + thrownError;
            var message = "status = " + xhr.status + " |  Error=" + thrownError + " | Check console for more details";
            if (debug == true) {
                console.log(log_message);
            }
            var errors = [message];
            $.each(errors, function (key, value) {
                Common.showGritter(value, 'btn-danger', 'fa-times');
            });
            response.status = "failed";
            response.errors = errors;
            return response;
        },
        //----------------------------------------------------------
        ajaxSuccessHandler: function (response, that, debug, successGritter) {
            debug = typeof debug !== 'undefined' ? debug : false;
            successGritter = typeof successGritter !== 'undefined' ? successGritter : true;
            if (debug == true) {
                console.log("response=");
                console.log(response);
                console.log("response end here");
            }
            that.find('i').removeClass('fa-spinner').removeClass('fa-spin');
            var object = null;
            try {
                object = JSON.parse(response);
                if (debug == true) {
                    console.log(object);
                }
                if (object.status == 'failed') {
                    $.each(object.errors, function (key, value) {
                        Common.showGritter(value, 'btn-danger', 'fa-times');
                    });
                } else if (object.status == 'success') {
                    if (successGritter == true) {
                        Common.showGritter("Processed Successfully", 'btn-success', 'fa-check');
                    }
                }
                return response;
            } catch (e) {
                var errors = ["Response is not in json format. Check console for more details"];
                $.each(errors, function (key, value) {
                    Common.showGritter(value, 'btn-danger', 'fa-times');
                });
                response.status = "failed";
                response.errors = errors;
                return response;
            }
        },
        //---------------------------------------------------
        showGritter: function (message, btnClass, faClass) {
            btnClass = typeof btnClass !== 'undefined' ? btnClass : null;
            faClass = typeof faClass !== 'undefined' ? faClass : null;
            var title = "";
            if (btnClass != null && faClass != null) {
                title += '<label class="btn btn-xs btn-icon btn-circle ' + btnClass + '">';
                title += '<i class="fa ' + faClass + '"></i>';
                title += '</label> ';
            }
            title += message;
            $.gritter.add({
                title: title,
                sticky: false,
            });
        },
        //---------------------------------------------------
        showSpinner: function (that) {
            that.find('i').addClass('fa').addClass('fa-spinner').addClass('fa-spin');
        },
        //---------------------------------------------------
        hideSpinner: function (that) {
            that.find('i').removeClass('fa-spinner').removeClass('fa-spin');
        },
        //---------------------------------------------------
        count: function (object) {
            var count = 0;
            for (var item in object) {
                if (item.hasOwnProperty(item)) {
                    count++;
                }
            }
            return count;
        },
        //---------------------------------------------------
    };// end of class
})(jQuery);// end of jquery




