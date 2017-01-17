
    <div class="row">



        <div class="col-sm-12">
            <div class="form-group">
                <label class="col-md-3 control-label">Ease Provider Id:</label>
                <div class="col-md-9">
                    {{ Form::text('ease_provider_id', null, array('class' => 'form-control ',
                    'placeholder' => 'Ease Provider Id', 'required')) }}
                </div>
                <label class="col-md-3 control-label">Subject:</label>
                <div class="col-md-9">
                    {{ Form::text('subject', null, array('class' => 'form-control ',
                    'placeholder' => 'Subject', 'required')) }}
                </div>
                <label class="col-md-3 control-label">Comment:</label>
                <div class="col-md-9">
                    {{ Form::text('comment', null, array('class' => 'form-control ',
                    'placeholder' => 'Comment', 'required')) }}
                </div>
                <label class="col-md-3 control-label">Ease Service Request Id:</label>
                <div class="col-md-9">
                    {{ Form::text('ease_service_request_id', null, array('class' => 'form-control ',
                    'placeholder' => 'Ease Service Request Id', 'required')) }}
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 col-sm-4 control-label">Choose Status:</label>

                <div class="col-md-9 col-sm-8">
                    <div class="radio">
                        <label>
                            <input type="radio" name="enable" value="1" data-parsley-required>
                            Active
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="enable" value="0" data-parsley-required >
                            Deactive
                        </label>
                    </div>
                </div>

        </div>

        </div>


    </div>