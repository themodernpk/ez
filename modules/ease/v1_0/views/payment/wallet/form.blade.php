
    <div class="row">



        <div class="col-sm-12">
            <div class="form-group">
                <label class="col-md-3 control-label">User:</label>
                <div class="col-md-9">
                    {{ Form::text('ease_user_id', null, array('class' => 'form-control ',
                    'placeholder' => 'User', 'required')) }}
                </div>
                <label class="col-md-3 control-label">Action:</label>
                <div class="col-md-9">
                    {{ Form::text('action', null, array('class' => 'form-control ',
                    'placeholder' => 'Action', 'required')) }}
                </div>
                <label class="col-md-3 control-label">Payment Type:</label>
                <div class="col-md-9">
                    {{ Form::text('payment_type', null, array('class' => 'form-control ',
                    'placeholder' => 'Payment By', 'required')) }}
                </div>
                <label class="col-md-3 control-label">Amount:</label>
                <div class="col-md-9">
                    {{ Form::text('amount', null, array('class' => 'form-control ',
                    'placeholder' => 'Amount', 'required')) }}
                </div>
                <label class="col-md-3 control-label">Performed At:</label>
                <div class="col-md-9">
                    {{ Form::text('performed_at', null, array('class' => 'form-control ',
                    'placeholder' => 'Payment At', 'required')) }}
                </div>
                <label class="col-md-3 control-label">Status:</label>
                <div class="col-md-9">
                    {{ Form::text('status', null, array('class' => 'form-control ',
                    'placeholder' => 'Status', 'required')) }}
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