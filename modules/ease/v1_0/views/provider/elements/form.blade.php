<?php
$output_file='/public/css/rating.css';
?>
<link rel="stylesheet" href="{{ URL::asset($output_file) }}" />
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label class="col-md-3 control-label">Name:</label>
                <div class="col-md-9">
                    {{ Form::text('name', null, array('class' => 'form-control ',
                    'placeholder' => 'Name', 'required'))}}
                </div>
            </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Mobile:</label>
                    <div class="col-md-9">
                        {{ Form::text('mobile', null, array('class' => 'form-control ',
                        'placeholder' => 'mobile', 'required'))}}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Pending Commission:</label>
                    <div class="col-md-9">
                        {{ Form::text('pending_commission', null, array('class' => 'form-control ',
                        'placeholder' => 'Pending Commission', 'required')) }}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Amount withdrew:</label>
                    <div class="col-md-9">
                        {{ Form::text('amount_withdrew', null, array('class' => 'form-control ',
                        'placeholder' => 'Amount Withdrew', 'required')) }}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Commission Paid To Company:</label>
                    <div class="col-md-9">
                        {{ Form::text('commission_paid_to_company', null, array('class' => 'form-control ',
                        'placeholder' => 'Commission Paid To Company', 'required')) }}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Is Available:</label>
                    <div class="col-md-9">
                        {{ Form::text('is_available', null, array('class' => 'form-control ',
                        'placeholder' => 'Is Available', 'required')) }}
                    </div>
                </div>


            <div class="form-group">
                <label class="col-md-3 col-sm-4 control-label">Verification Status:</label>

                <div class="col-md-9 col-sm-8">
                    <div class="radio">
                        <input type="radio" name="action" value="true" checked>Verify<br>
                        <input type="radio" name="action" value="false">Reject<br>
                        <input type="radio" name="action" value="resend">image not clear<br>
                    </div>
                </div>

            </div>

        </div>


    </div>