
    <div class="row">



        <div class="col-sm-12">
            <div class="form-group">
                <label class="col-md-3 control-label">Type:</label>
                <div class="col-md-9">
                    {{ Form::text('type', null, array('class' => 'form-control ',
                    'placeholder' => 'Type', 'required')) }}
                </div>
                <label class="col-md-3 control-label">Amount:</label>
                <div class="col-md-9">
                    {{ Form::text('amount', null, array('class' => 'form-control ',
                    'placeholder' => 'Amount', 'required')) }}
                </div>
                <label class="col-md-3 control-label">Payment By:</label>
                <div class="col-md-9">
                    {{ Form::text('payment_by', null, array('class' => 'form-control ',
                    'placeholder' => 'Payment By', 'required')) }}
                </div>
                <label class="col-md-3 control-label">Payment TO:</label>
                <div class="col-md-9">
                    {{ Form::text('payment_to', null, array('class' => 'form-control ',
                    'placeholder' => 'Payment To', 'required')) }}
                </div>
                <label class="col-md-3 control-label">Payment Through:</label>
                <div class="col-md-9">
                    {{ Form::text('payment_through', null, array('class' => 'form-control ',
                    'placeholder' => 'Payment Through', 'required')) }}
                </div>
                <label class="col-md-3 control-label">Ease Service Request Id:</label>
                <div class="col-md-9">
                    {{ Form::text('ease_service_request_id', null, array('class' => 'form-control ',
                    'placeholder' => 'Ease Service Request Id', 'required')) }}
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