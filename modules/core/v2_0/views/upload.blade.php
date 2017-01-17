@extends('core::layout.core')
@section('page_specific_head')

    <!--file upload-->
    <link href="<?php echo asset_path(); ?>/plugins/jquery-file-upload/css/jquery.fileupload.css" rel="stylesheet"/>
    <link href="<?php echo asset_path(); ?>/plugins/jquery-file-upload/css/jquery.fileupload-ui.css" rel="stylesheet"/>
    <!--file upload-->

    @stop


    @section('content')

            <!-- begin page-header -->
    <h1 class="page-header">{{$title}}</h1>
    <!-- end page-header -->

    <!-- begin row -->
    <div class="row">

        <!-- begin col-10 -->
        <div class="col-md-12">


            <!-- begin panel -->
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default"
                           data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning"
                           data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger"
                           data-click="panel-remove"><i class="fa fa-times"></i></a>

                    </div>
                    <h4 class="panel-title">File Upload</h4>
                </div>


                <div class="panel-body">

                    <form>

                        <!--file upload-->
                        <div class="row">

                            <div class="col-sm-12">

                                <div class="btn-group">
                            <span class="btn btn-primary btn-sm fileinput-button">
                                            <i class="fa fa-plus"></i>
                                            <span>Add files...</span>
                                            <input type="file" id="fileupload" name="files[]" multiple="">
                            </span>
                                    <button type="submit" class="btn btn-success btn-sm uploadButton">
                                        <i class="fa fa-upload"></i>
                                        <span>Start upload</span>
                                    </button>
                                </div>

                                <ul class="tobeUploaded"></ul>

                                <div id="progress" class="progress progressContainer hide  progress-striped active"
                                     style="height: 5px; margin-top: 2px;">
                                    <div class="showProgress progress-bar progress-bar-success"
                                         style="width: 0%;"></div>
                                </div>

                            </div>
                        </div>
                        <!--/file upload-->


                        <hr/>

                        <div class="row">

                            <input type="submit" class="btn btn-primary formTest" value="Form Test"/>

                        </div>

                    </form>


                </div>
                <!-- end panel -->
            </div>
            <!-- end col-10 -->
        </div>
        <!-- end row -->
    </div>


@stop

@section('page_specific_foot')
    <!--file upload-->
    <script src="<?php echo asset_path(); ?>/plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js"></script>
    <script src="<?php echo asset_path(); ?>/plugins/jquery-file-upload/js/jquery.iframe-transport.js"></script>
    <script src="<?php echo asset_path(); ?>/plugins/jquery-file-upload/js/jquery.fileupload.js"></script>
    <script>
        $(function () {
            var filList;
            $('#fileupload').fileupload({
                url: "{{URL::route('uploadFile')}}",
                dataType: 'json',
                add: function (e, data) {
                    var filename = data.files[0].name;
                    filenameID = filename.replace(/[^a-z0-9\s]/gi, '').replace(/[_.\s]/g, '-');

                    if ($.inArray(filename, filList) !== -1) {
                        alert("Filename already exist");
                        return false;
                    }
                    filList = [filename];

                    var li = "<li " + "id='" + filenameID + "' >" + filename
                            + " <button class='btn btn-danger btn-icon btn-circle btn-xs fileDelete'>"
                            + "<i class='fa fa-times'></i> </button>"
                            + "</li>";

                    $(".tobeUploaded").append(li);
                    //on click to upload
                    data.context = $('.uploadButton').click(function () {
                        $('.progressContainer').removeClass('hide');
                        data.context = $('.uploadButton').text('Uploading...');
                        var uploadResponse = data.submit()
                                .error(function (uploadResponse, textStatus, errorThrown) {
                                    alert("Error: " + textStatus + " | " + errorThrown);
                                    return false;
                                });
                    });
                },
                progressall: function (e, data) {

                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('.showProgress').css('width', progress + '%');
                },
                done: function (e, data) {

                    var filename = data.files[0].name;
                    var filenameID = filename.replace(/[^a-z0-9\s]/gi, '').replace(/[_.\s]/g, '-');

                    $.each(data.result.files, function (index, file) {

                        var currentFileName = $('#' + filenameID).text();
                        var hyperlink = "<a target='_blank' href='" + file.url + "'>"
                                + currentFileName + "</a> "
                                + " <button class='btn btn-danger btn-icon btn-circle btn-xs fileDelete'>"
                                + "<i class='fa fa-times'></i> </button>"
                                + "<input type='hidden' name='uploadedFiles["+filename+"]' value='" + file.url + "' /> ";

                        $('#' + filenameID).html(hyperlink);
                    });

                    $(".uploadButton").html("<i class='fa fa-upload'></i> " +
                            "<span>Start upload</span>");

                    $('.progressContainer').addClass('hide');
                    $('.showProgress').css('width', '0%');


                },
            });


            $('.tobeUploaded').on("click", ".fileDelete", function () {
                $(this).closest("li").remove();
                return false;
            });

        });
    </script>
    <!--/file upload-->

    <script>
        $(document).ready(function () {

            $(".formTest").click(function () {
                var formdata = $('form').serialize();
                alert(formdata);
                console.log(formdata);
                return false;

            });

        });
    </script>

@stop