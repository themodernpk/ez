
<div class="row">



    <div class="col-sm-12">
        <div class="form-group">
            <label class="col-md-3 control-label">Seeker:</label>
            <div class="col-md-9">
                {{ Form::text('ease_seeker_id', null, array('class' => 'form-control ',
                'placeholder' => 'Seeker', 'required')) }}
            </div>
            <label class="col-md-3 control-label">Amount:</label>
            <div class="col-md-9">
                {{ Form::text('amount', null, array('class' => 'form-control ',
                'placeholder' => 'Amount', 'required')) }}
            </div>

            <label class="col-md-3 control-label">Payment Through:</label>
            <div class="col-md-9">
                {{ Form::text('payment_through', null, array('class' => 'form-control ',
                'placeholder' => 'Payment Through', 'required')) }}
            </div>
            <label class="col-md-3 control-label">Service Request:</label>
            <div class="col-md-9">
                {{ Form::text('ease_service_request_id', null, array('class' => 'form-control ',
                'placeholder' => 'Ease Service Request Id', 'required')) }}
            </div>
            <label class="col-md-3 control-label">Status:</label>
            <div class="col-md-9">
                {{ Form::text('status', null, array('class' => 'form-control ',
                'placeholder' => 'Status', 'required')) }}
            </div>
            <label class="col-md-3 control-label">Performed At:</label>
            <div class="col-md-9">
                {{ Form::text('performed_at', null, array('class' => 'form-control ',
                'placeholder' => 'Performed At', 'required')) }}
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