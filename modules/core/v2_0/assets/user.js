(function ($) {



    //-------------------------------------------------------
    $("#createFrom").submit(function (e) {
        e.preventDefault();
        var data = $(this).serialize();
        var url = $(this).attr('action');
        var debug = true;
        var that = $(this).find('.loader');
        Common.showSpinner(that);
        if ($(this).parsley().isValid() == false) {
            Common.hideSpinner(that);
            return false;
        }
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            context: this,
            error: function (xhr, ajaxOptions, thrownError) {
                Common.ajaxErrorHandler(xhr, ajaxOptions, thrownError, that, debug);
            },
            success: function (response) {
                Common.ajaxSuccessHandler(response, that, debug);
                Common.hideSpinner(that);
                var object = JSON.parse(response);
                if (object.status == "success") {
                    location.reload();
                }
            }
        });
    });
    //-------------------------------------------------------
    $(".viewItem").click(function (e) {
        e.preventDefault();
        var modalID = $(this).attr('data-target');
        var pk = $(this).attr('data-pk');
        var url = $(this).attr('data-href');
        $(modalID + " .modalLoader").show();
        var debug = true;
        var that = $(this);
        $(modalID + " .modalLoader").show();
        $(modalID + " .row").html("");
        $.ajax({
            type: "POST",
            url: url,
            data: "id=" + pk,
            context: this,
            error: function (xhr, ajaxOptions, thrownError) {
                Common.ajaxErrorHandler(xhr, ajaxOptions, thrownError, that, debug);
            },
            success: function (response) {
                response = Common.ajaxSuccessHandler(response, that, debug, false);
                object = JSON.parse(response);
                console.log(object.html);
                if (object.status == "success") {
                    $(modalID + " .row").html(object.html);
                    $(modalID + " .modalLoader").hide();
                }
            }
        });
    });
    //-------------------------------------------------------
    $(".updateItem").click(function (e) {
        e.preventDefault();
        var modalID = $(this).attr('data-target');
        var pk = $(this).attr('data-pk');
        var url = $(this).attr('data-href');
        $(modalID + " form")[0].reset();
        $(modalID + " .modalLoader").show();
        var debug = true;
        var that = $(this);
        $(modalID + " .modalLoader").show();
        $.ajax({
            type: "POST",
            url: url,
            data: "id=" + pk,
            context: this,
            error: function (xhr, ajaxOptions, thrownError) {
                Common.ajaxErrorHandler(xhr, ajaxOptions, thrownError, that, debug);
            },
            success: function (response) {
                console.log(response);
                response = Common.ajaxSuccessHandler(response, that, debug, false);
                object = JSON.parse(response);
                if (object.status == "success") {
                    $.each(object.data, function (key, value) {
                        if (key == 'active') {
                            return;
                        }
                        if (key == "group_id") {
                            $(modalID + " select[name=" + key + "]").val(value);
                            $(modalID + " select[name=" + key + "]").combobox("refresh");
                        } else {
                            $(modalID + " input[name=" + key + "]").val(value);
                        }
                    });
                    var $enableCheck = $(modalID + " input[name=active]");
                    $enableCheck.filter('[value=' + object.data.active + ']').prop('checked', true);
                    $(modalID + " .modalLoader").hide();
                }
            }
        });
    });
    //-------------------------------------------------------
    $("#formUpdate").submit(function (e) {
        e.preventDefault();
        var data = $(this).serialize();
        var url = $(this).attr('action');
        var debug = true;
        var that = $(this).find('.loader');
        Common.showSpinner(that);
        if ($(this).parsley().isValid() == false) {
            Common.hideSpinner(that);
            return false;
        }
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            context: this,
            error: function (xhr, ajaxOptions, thrownError) {
                Common.ajaxErrorHandler(xhr, ajaxOptions, thrownError, that, debug);
            },
            success: function (response) {
                Common.ajaxSuccessHandler(response, that, debug);
            }
        });
    });
    //-------------------------------------------------------
    //-------------------------------------------------------
    //-------------------------------------------------------
})(jQuery);// end of jquery