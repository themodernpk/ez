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

            <div class="form-group col-sm-3">
                <h4>Verification</h4>
                <label for="sel1">Select Status:</label>
                <select class="form-control" id="sel1" name="action">
                    <option selected disabled>Choose here</option>
                    <option value ="false">Reject</option>
                    <option value ="true">Verify</option>
                    <option value ="resend">Image not clear</option>
                </select>
            </div>

            <div class="form-group col-sm-3">
                <h4>Rating</h4>
                <label for="sel1">Select rating:</label>
                <select class="form-control" id="sel1" name="rating">
                    <option selected disabled>Choose here</option>
                    <option value ="1">1</option>
                    <option value ="1.5">1.5</option>
                    <option value ="2">2</option>
                    <option value ="2.5">2.5</option>
                    <option value ="3">3</option>
                    <option value ="3.5">3.5</option>
                    <option value ="4">4</option>
                    <option value ="4.5">4.5</option>
                    <option value ="5">5</option>
                </select>
            </div>

            <div class="form-group col-sm-4">
                <h4>Profession Level</h4>
                <label for="sel1">Select level:</label>
                <select class="form-control" id="sel1" name="profession_level">
                    <option selected disabled>Choose here</option>
                    <option value ="Basic">Basic</option>
                    <option value ="Professional">Professional</option>
                    <option value ="Advance">Advance</option>
                </select>
            </div>

        </div>


    </div>