Common =
{

    //----------------------------------------------------------
    ajaxErrorHandler: function(xhr, ajaxOptions, thrownError, that, debug)
    {
        debug = typeof debug !== 'undefined' ? debug : false;

        var response = {};
        that.find('i').removeClass('fa-spinner').removeClass('fa-spin');
        var log_message = "status = "+xhr.status+" | Message = "+ xhr.responseText+" |  Error="+thrownError;
        var message = "status = "+xhr.status+" |  Error="+thrownError+" | Check console for more details";

        if(debug == true) { console.log( log_message); }

        var errors = [message];

        $.each(errors, function(key, value)
        {
            Common.showGritter(value, 'btn-danger', 'fa-times');
        });

        response.status = "failed";
        response.errors = errors;

        return response;
    },
    //----------------------------------------------------------
    ajaxSuccessHandler: function(response, that, debug, successGritter)
    {

        debug = typeof debug !== 'undefined' ? debug : false;
        successGritter = typeof successGritter !== 'undefined' ? successGritter : true;

        if(debug == true)
        {
            console.log("response=");
            console.log( response);
            console.log("response end here");
        }

        that.find('i').removeClass('fa-spinner').removeClass('fa-spin');
        var object = null;

        try{
            object = JSON.parse(response);
            if(debug == true) { console.log(object); }

            if(object.status == 'failed')
            {
                $.each(object.errors, function(key, value)
                {
                    Common.showGritter(value, 'btn-danger', 'fa-times');
                });

            } else if(object.status == 'success')
            {
                if(successGritter == true)
                {
                    Common.showGritter("Processed Successfully", 'btn-success', 'fa-check');
                }
            }

            return response;

        } catch (e)
        {


            var errors = ["Response is not in json format. Check console for more details"];

            $.each(errors, function(key, value)
            {
                Common.showGritter(value, 'btn-danger', 'fa-times');
            });

            response.status = "failed";
            response.errors = errors;
            return response;

        }

    },

    //---------------------------------------------------

    showGritter: function(message, btnClass, faClass)
    {
        btnClass = typeof btnClass !== 'undefined' ? btnClass : null;
        faClass = typeof faClass !== 'undefined' ? faClass : null;

        var title = "";

        if(btnClass != null && faClass != null)
        {
            title += '<label class="btn btn-xs btn-icon btn-circle '+btnClass+'">';
            title += '<i class="fa '+faClass+'"></i>';
            title += '</label> ';
        }

        title += message;
        $.gritter.add({
            title: title,
            sticky: false,
        });

    },
    //---------------------------------------------------
    showSpinner: function(that)
    {
        that.find('i').addClass('fa').addClass('fa-spinner').addClass('fa-spin');

    },
    //---------------------------------------------------
    hideSpinner: function(that)
    {
        that.find('i').removeClass('fa-spinner').removeClass('fa-spin');

    },
    //---------------------------------------------------
    count: function(object)
    {
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

