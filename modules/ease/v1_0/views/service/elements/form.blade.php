<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label class="col-md-3 control-label">Name:</label>
            <div class="col-md-9">
                {{ Form::text('name', null, array('class' => 'form-control ',
                'placeholder' => 'Name', 'required')) }}
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">Description:</label>
            <div class="col-md-9">
                {{ Form::text('description', null, array('class' => 'form-control ',
                'placeholder' => 'Description', 'required')) }}
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">Icon:</label>
            <div class="col-md-9">
                <div class="btn-group">
                            <span class="btn btn-primary btn-sm fileinput-button">
                                            <i class="fa fa-plus"></i>
                                            <span>upload picture</span>
                                            <input type="file" id="fileupload">
                            </span>
                </div>
                <ul class="tobeUploaded"></ul>
                <div id="progress" class="progress progressContainer hide  progress-striped active"
                     style="height: 5px; margin-top: 2px;">
                    <div class="showProgress progress-bar progress-bar-success"
                         style="width: 0%;"></div>
                </div>
            </div>
        </div>
        {{--icon url circle--}}
        <div class="form-group">
            <label class="col-md-3 control-label">Icon Circle:</label>
            <div class="col-md-9">
                <div class="btn-group">
                            <span class="btn btn-primary btn-sm fileinput-button">
                                            <i class="fa fa-plus"></i>
                                            <span>upload picture</span>
                                            <input type="file" id="fileuploadtwo">
                            </span>
                </div>
                <ul class="tobeUpload"></ul>
                <div id="progress" class="progress progressContainer hide  progress-striped active"
                     style="height: 5px; margin-top: 2px;">
                    <div class="showProgress progress-bar progress-bar-success"
                         style="width: 0%;"></div>
                </div>
            </div>
        </div>

        <div class="col-md-9 col-sm-8">
            <div class="radio">
                <label>
                    <input type="radio" name="unit" value="session" data-parsley-required>
                    session
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="unit" value="time" data-parsley-required >
                    time
                </label>
            </div>
        </div>
    </div>
</div>
