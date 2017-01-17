@extends('core::layout.backend')

@section('page_specific_head')
    <link href="<?php echo asset_path(); ?>/plugins/switchery/switchery.min.css" rel="stylesheet"/>
@stop

@section('content')

    <!-- begin page-header -->
    <h1 class="page-header">{{$title}} @if(isset($data->input->show)) - {{ucwords($data->input->show)}} @endif</h1>
    <!-- end page-header -->

    <!--modal-->
    @include($data->view."elements.create")
    @include($data->view."elements.view")
    @include($data->view."elements.update")
    <!--/modal-->

    <!--content-->
    {{HtmlHelper::panel(array('title' => "List"))}}
    {{ Form::open(array('route' => $data->prefix.'-bulk-action', 'class' =>'form', 'method' =>'POST')) }}
    <div class="row">
        @include($data->view."elements.search")

        @include($data->view."elements.buttons")
    </div>

    <hr/>
    <div class="row">
        <table class="table table-bordered table-striped">
            <tr>
                <th width="20">#</th>
                <th>Name</th>
                <th>Description</th>
                <th>Icon</th>
                <th>Icon Circle</th>
                <th>Unit</th>
                <th width="30"></th>
                @if(Permission::check($data->prefix.'-update'))
                    <th width="80">Enable</th>
                    <th width="120">Actions</th>
                    <th width="20"><input id="selectall" type="checkbox"/></th>
                @endif
            </tr>

            @foreach($data->list as $item)
                {{View::make($data->view.'elements.index-item')->with('item', $item)->with('data', $data)->render()}}
            @endforeach
        </table>
        <?php
        $get = Input::get();
        echo $data->list->appends($get)->links();
        ?>
    </div>


    {{Form::close()}}

    {{HtmlHelper::panelClose()}}


    <!--/content-->


@stop

@section('page_specific_foot')
    <!--highlight search-->
    @if(isset($data->input->q))
        <script>
            $("body").highlight("{{$data->input->q}}");
        </script>
    @endif
    <!--highlight search-->
    <script src="<?php echo asset_path(); ?>/plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js"></script>
    <script src="<?php echo asset_path(); ?>/plugins/jquery-file-upload/js/jquery.iframe-transport.js"></script>
    <script src="<?php echo asset_path(); ?>/plugins/jquery-file-upload/js/jquery.fileupload.js"></script>
    <script src="<?php echo asset_path(); ?>/plugins/switchery/switchery.min.js"></script>
    <script src="<?php echo asset_path(); ?>/js/form-slider-switcher.demo.min.js"></script>
    <script>
        $(document).ready(function () {
            FormSliderSwitcher.init();
        });
    </script>
        <script>
            $(function () {
                var filList;
                $('#fileupload').fileupload({
                    url: "{{URL::route('uploadFile')}}",
                    dataType: 'json',
                    add: function (e, data) {

                    },
                    progressall: function (e, data) {
                        var progress = parseInt(data.loaded / data.total * 100, 10);
                        $('.showProgress').css('width', progress + '%');
                    },
                    done: function (e, data)
                    {
                        e.preventDefault();
                        var filename = data.files[0].name;
                        var filenameID = filename.replace(/[^a-z0-9\s]/gi, '').replace(/[_.\s]/g, '-');
                        $.each(data.result.files, function (index, file) {
                            var currentFileName = $('#' + filenameID).text();
                            var hyperlink = "<a target='_blank' href='" + file.url + "'>"
                                    + currentFileName + "</a> "
                                    + " <button class='btn btn-danger btn-icon btn-circle btn-xs fileDelete'>"
                                    + "<i class='fa fa-times'></i> </button>"
                                    + "<input type='hidden' name='icon_url' value='" + file.url + "' /> ";
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

                jQuery('#fileupload').bind('fileuploadadd', function (e, data) {
                    //console.log("outside "+dealSize);
                    var reader = new FileReader();

                    reader.readAsDataURL(data.files[0]);
                    reader.data = data;
                    reader.file = data.files[0];

                    reader.onload = function (_file) {
                        //console.log(this.data);

                        var image = new Image();

                        image.src = _file.target.result;              // url.createObjectURL(file);
                        image.file = this.file;
                        image.data = this.data;
                        image.onload = function () {
                            //console.log(this.data);
                            var w = this.width,
                                    h = this.height,
                                    n = this.file.name;

                            //console.log("You selected "+dealSize);
                            /*
                             * profile image-165*165
                             * */

                            if ( w != 1140 && h != 400 ) {
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
                                $('.progressContainer').removeClass('hide');
                                data.context = $('.uploadButton').text('Uploading...');
                                var uploadResponse = data.submit()
                                        .error(function (uploadResponse, textStatus, errorThrown) {
                                            alert("Error: " + textStatus + " | " + errorThrown);
                                            return false;
                                        });
                            }
                            else{
                                alert('The following pic has incorrect dimensions: '+n+'! Should be exactly 1140x400!');
                                reader.data.files.pop();
                            }
                        };
                        image.onerror = function () {
                            alert("Please select a valid image file (jpg and png are allowed)");
                        };
                        // will run later, than the load! => no use
                    };

                    // will run later, than the image.load! => no use

                });
            });
        </script>

        {{--to upload second image--}}
        <script>
            $(function () {
                var fillList;
                $('#fileuploadtwo').fileupload({
                    url: "{{URL::route('uploadFile')}}",
                    dataType: 'json',
                    add: function (e, data) {

                    },
                    progressall: function (e, data) {
                        var progress = parseInt(data.loaded / data.total * 100, 10);
                        $('.showProgress').css('width', progress + '%');
                    },
                    done: function (e, data)
                    {
                        e.preventDefault();
                        var filename = data.files[0].name;
                        var filenameID = filename.replace(/[^a-z0-9\s]/gi, '').replace(/[_.\s]/g, '-');
                        $.each(data.result.files, function (index, file) {
                            var currentFileName = $('#' + filenameID).text();
                            var hyperlink = "<a target='_blank' href='" + file.url + "'>"
                                    + currentFileName + "</a> "
                                    + " <button class='btn btn-danger btn-icon btn-circle btn-xs fileDelete'>"
                                    + "<i class='fa fa-times'></i> </button>"
                                    + "<input type='hidden' name='icon_url_circle' value='" + file.url + "' /> ";
                            $('#' + filenameID).html(hyperlink);
                        });
                        $(".uploadButton").html("<i class='fa fa-upload'></i> " +
                                "<span>Start upload</span>");
                        $('.progressContainer').addClass('hide');
                        $('.showProgress').css('width', '0%');
                    },
                });
                $('.tobeUpload').on("click", ".fileDelete", function () {
                    $(this).closest("li").remove();
                    return false;
                });

                jQuery('#fileuploadtwo').bind('fileuploadadd', function (e, data) {
                    //console.log("outside "+dealSize);
                    var reader = new FileReader();

                    reader.readAsDataURL(data.files[0]);
                    reader.data = data;
                    reader.file = data.files[0];

                    reader.onload = function (_file) {
                        //console.log(this.data);

                        var image = new Image();

                        image.src = _file.target.result;              // url.createObjectURL(file);
                        image.file = this.file;
                        image.data = this.data;
                        image.onload = function () {
                            //console.log(this.data);
                            var w = this.width,
                                    h = this.height,
                                    n = this.file.name;

                            //console.log("You selected "+dealSize);
                            /*
                             * profile image-165*165
                             * */

                            if ( w != 1140 && h != 400 ) {
                                var filename = data.files[0].name;
                                filenameID = filename.replace(/[^a-z0-9\s]/gi, '').replace(/[_.\s]/g, '-');
                                if ($.inArray(filename, fillList) !== -1) {
                                    alert("Filename already exist");
                                    return false;
                                }
                                fillList = [filename];
                                var li = "<li " + "id='" + filenameID + "' >" + filename
                                        + " <button class='btn btn-danger btn-icon btn-circle btn-xs fileDelete'>"
                                        + "<i class='fa fa-times'></i> </button>"
                                        + "</li>";
                                $(".tobeUpload").append(li);
                                //on click to upload
                                $('.progressContainer').removeClass('hide');
                                data.context = $('.uploadButton').text('Uploading...');
                                var uploadResponse = data.submit()
                                        .error(function (uploadResponse, textStatus, errorThrown) {
                                            alert("Error: " + textStatus + " | " + errorThrown);
                                            return false;
                                        });
                            }
                            else{
                                alert('The following pic has incorrect dimensions: '+n+'! Should be exactly 1140x400!');
                                reader.data.files.pop();
                            }
                        };
                        image.onerror = function () {
                            alert("Please select a valid image file (jpg and png are allowed)");
                        };
                        // will run later, than the load! => no use
                    };

                    // will run later, than the image.load! => no use

                });
            });
        </script>
    <script src="<?php echo asset_path('ease'); ?>/service.js"></script>
@stop