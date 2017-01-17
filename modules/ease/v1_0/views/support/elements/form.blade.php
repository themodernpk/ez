
    <div class="row">



        <div class="col-sm-12">
            <div class="form-group">
                <label class="col-md-3 control-label">Ease User Id:</label>
                <div class="col-md-9">
                    {{ Form::text('ease_user_id', null, array('class' => 'form-control ',
                    'placeholder' => 'Ease User Id', 'required')) }}
                </div>
                <label class="col-md-3 control-label">UserName:</label>
                <div class="col-md-9">
                    {{ Form::text('username', null, array('class' => 'form-control ',
                    'placeholder' => 'UserName', 'required')) }}
                </div>
                <label class="col-md-3 control-label">Message:</label>
                <div class="col-md-9">
                    {{ Form::text('message', null, array('class' => 'form-control ',
                    'placeholder' => 'Message', 'required')) }}
                </div>

                <label class="col-md-3 control-label">Sent On:</label>
                <div class="col-md-9">
                    {{ Form::text('sent_on', null, array('class' => 'form-control ',
                    'placeholder' => 'Sent On', 'required')) }}
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