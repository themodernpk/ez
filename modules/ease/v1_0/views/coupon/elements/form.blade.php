
    <div class="row">



        <div class="col-sm-12">
            <div class="form-group">
                <label class="col-md-3 control-label">Coupon Code:</label>
                <div class="col-md-9">
                    {{ Form::text('coupon_code', null, array('class' => 'form-control ',
                    'placeholder' => 'Coupon Code', 'required')) }}
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Discount Type</label>
                <div class="col-md-9 col-sm-8">
                    <select class="form-control" name="discount_type" id="discount_type" required>
                        <option value="percentage">Percentage</option>
                        <option value="fixed-amount">Fixed Amount</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Discount Value:</label>
                <div class="col-md-9">
                    {{ Form::text('discount_value', null, array('class' => 'form-control ',
                    'placeholder' => 'Discount ', 'required')) }}
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Expiry date:</label>
                <div class='col-md-9 input-group date' id='datetimepicker1'>
                    <input type='text' name="exp_date" class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>


        </div>


    </div>