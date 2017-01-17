
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label class="col-md-3 control-label">Name:</label>
                <div class="col-md-9">
                    {{ Form::text('name', null, array('class' => 'form-control ',
                    'placeholder' => 'Name', 'required'))}}
                </div>
                <label class="col-md-3 control-label">Mobile:</label>
                <div class="col-md-9">
                    {{ Form::text('mobile', null, array('class' => 'form-control ',
                    'placeholder' => 'mobile', 'required'))}}
                </div>

                <label class="col-md-3 control-label">Pending Commission:</label>
                <div class="col-md-9">
                    {{ Form::text('pending_commission', null, array('class' => 'form-control ',
                    'placeholder' => 'Pending Commission', 'required')) }}
                </div>
                <label class="col-md-3 control-label">Amount withdrew:</label>
                <div class="col-md-9">
                    {{ Form::text('amount_withdrew', null, array('class' => 'form-control ',
                    'placeholder' => 'Amount Withdrew', 'required')) }}
                </div>
                <label class="col-md-3 control-label">Commission Paid To Company:</label>
                <div class="col-md-9">
                    {{ Form::text('commission_paid_to_company', null, array('class' => 'form-control ',
                    'placeholder' => 'Commission Paid To Company', 'required')) }}
                </div>
                <label class="col-md-3 control-label">Is Available:</label>
                <div class="col-md-9">
                    {{ Form::text('is_available', null, array('class' => 'form-control ',
                    'placeholder' => 'Is Available', 'required')) }}
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 col-sm-4 control-label">Verified:</label>
                <div class="col-md-9 col-sm-8">
                    <div class="radio">
                        <label>
                            <input type="radio" name="verified" value="true" data-parsley-required>
                            verify
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="verified" value="false" data-parsley-required >
                            reject
                        </label>
                    </div>
                </div>
        </div>

        </div>


    </div>