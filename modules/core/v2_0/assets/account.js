(function($) {



    //-------------------------------------------------------
    $("#updateFrom").submit(function(e)
    {
        e.preventDefault();
        var data = $( this).serialize();
        var url = $( this ).attr('action');
        var debug = true;
        var that = $(this).find('.loader');
        Common.showSpinner(that);
        if ( $(this).parsley().isValid() == false )
        {
            Common.hideSpinner(that);
            return false;
        }

        $.ajax({
            type: "POST",
            url: url,
            data: data,
            context: this,
            error: function (xhr, ajaxOptions, thrownError)
            {
                Common.ajaxErrorHandler(xhr, ajaxOptions, thrownError, that, debug);
            },
            success: function (response)
            {
                Common.ajaxSuccessHandler(response, that, debug);
                Common.hideSpinner(that);

                var object = JSON.parse(response);

                if(object.status == "success")
                {
                    location.reload();
                }
            }

        });

    });
    //-------------------------------------------------------

    //-------------------------------------------------------
    //-------------------------------------------------------

    //-------------------------------------------------------


})(jQuery);// end of jquery