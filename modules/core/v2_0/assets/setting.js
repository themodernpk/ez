

function addRow(tableID)
{
    var table=document.getElementById(tableID);
    var rowCount=table.rows.length;
    var row =table.insertRow(rowCount);
    var colCount=table.rows[0].cells.length;
    var html ='<td><input type="checkbox"></td><td><input type="text" name="'+rowCount+'[key]" class="form-control" data-parsley-required="true" ></td><td><input type="text" name="'+rowCount+'[group]" class="form-control" data-parsley-required="true"></td><td><input type="text" name="'+rowCount+'[label]" class="form-control" data-parsley-required="true"></td><td><input type="text" name="'+rowCount+'[value]" class="form-control" data-parsley-required="true"></td>';

    $('#dataTable tr:last').append(html);

}
function deleteRow(tableID)
{
    try
    {
        var table=document.getElementById(tableID);
        var rowCount=table.rows.length;
        for(var i=0;i<rowCount;i++){
            var row=table.rows[i];
            var chkbox=row.cells[0].childNodes[0];
            if(null!=chkbox&&true==chkbox.checked)
            {
                if(rowCount<=1)
                {
                    alert("Cannot delete all the rows.");
                    break;
                }
                table.deleteRow(i);rowCount--;i--;
            }
        }
    }
    catch(e)
    {
        alert(e);
    }
}


    (function($) {

        $('#create_setting').submit(function (e) {
            e.preventDefault();

            var href  =   $('#href').val();
            var input_data    =   $( this ).serialize();
            $.ajax({
                type: "POST",
                url: href,
                data: input_data,
                error: function (request, status, error) {

                },
                beforeSend: function () {
                    $(".pace").removeClass('pace-inactive');
                },
                success: function (response) {
                   
                    var object = JSON.parse(response);

                    if (object.status == "failed") {

                        console.log( object.error );
                        $.each(object.error, function() {

                            $.gritter.add({
                                title: '<label class="btn btn-xs btn-icon btn-circle btn-danger"><i class="fa fa-times"></i></label> ' + object.error,
                                sticky: false,
                            });
                         });
                       
                    }
                   
                   else if (object.status == "success") {

                            $.gritter.add({
                                title: '<label class="btn btn-xs btn-icon btn-circle btn-success"><i class="fa fa-check"></i></label>Settings Added Succesfully',
                                sticky: false,
                            });
                        location.reload();

                        }
                     $(".pace").addClass('pace-inactive');
                   }

            });
            return false;
        });
    })(jQuery);

(function($) {

    $('#general_setting').submit(function (e) {
        e.preventDefault();

        var general_href  =   $('#general_href').val();
        var inputdata    =   $( this ).serialize();
        //alert(inputdata);
        $.ajax({
            type: "POST",
            url: general_href,
            data: inputdata,
            error: function (request, status, error) {
                /*console.log(request);
                console.log(status);
                console.log(error);*/
            },

            success: function (res1) {
               // alert(res1);
                var object = JSON.parse(res1);
                if (object.status == "failed") {

                    //console.log( object.errors.name );
                    $.each(object.error, function() {

                        $.gritter.add({
                            title: '<label class="btn btn-xs btn-icon btn-circle btn-danger"><i class="fa fa-times"></i></label> ' + object.error,
                            sticky: false,
                        });

                    });
                }
                else if (object.status == "warning") {

                    //console.log( object.errors.name );
                    $.each(object.errors, function() {

                        $.gritter.add({
                            title: '<label class="btn btn-xs btn-icon btn-circle btn-danger"><i class="fa fa-times"></i></label> ' + object.errors.key,
                            sticky: false,
                        });

                    });
                }
                else if (object.status == "success") {

                    $.gritter.add({
                        title: '<label class="btn btn-xs btn-icon btn-circle btn-success"><i class="fa fa-check"></i></label>Settings Added Succesfully',
                        sticky: false,
                    });
                    location.reload();
                }
                $(".pace").addClass('pace-inactive');
            }


        });
        return false;
    });
})(jQuery);


(function($) {

    $('#smtp_setting').submit(function (e) {
        e.preventDefault();

        var smtp_href  =   $('#smtp_href').val();
        var smtpdata    =   $( this ).serialize();
        $.ajax({
            type: "POST",
            url: smtp_href,
            data: smtpdata,
            error: function (request, status, error) {
                console.log(request);
                console.log(status);
                console.log(error);
            },

            success: function (res) {
                var object = JSON.parse(res);
                if (object.status == "failed") {

                    //console.log( object.errors.name );
                    $.each(object.error, function() {

                        $.gritter.add({
                            title: '<label class="btn btn-xs btn-icon btn-circle btn-danger"><i class="fa fa-times"></i></label> ' + object.error,
                            sticky: false,
                        });

                    });
                }
                else if (object.status == "warning") {

                    //console.log( object.errors.name );
                    $.each(object.errors, function() {

                        $.gritter.add({
                            title: '<label class="btn btn-xs btn-icon btn-circle btn-danger"><i class="fa fa-times"></i></label> ' + object.errors.key,
                            sticky: false,
                        });

                    });
                }
                else if (object.status == "success") {

                    $.gritter.add({
                        title: '<label class="btn btn-xs btn-icon btn-circle btn-success"><i class="fa fa-check"></i></label>Settings Added Succesfully',
                        sticky: false,
                    });
                   location.reload();
                }
                $(".pace").addClass('pace-inactive');
            }

        });
        return false;
    });
})(jQuery);


