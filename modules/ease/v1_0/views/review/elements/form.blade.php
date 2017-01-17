
    <div class="row">



        <div class="col-sm-12">
            <div class="form-group">
                <label class="col-md-3 control-label">Review By:</label>
                <div class="col-md-9">
                    {{ Form::text('review_by', null, array('class' => 'form-control ',
                    'placeholder' => 'Review By', 'required')) }}
                </div>
                <label class="col-md-3 control-label">Review To:</label>
                <div class="col-md-9">
                    {{ Form::text('review_to', null, array('class' => 'form-control ',
                    'placeholder' => 'Review To', 'required')) }}
                </div>
                <label class="col-md-3 control-label">Comment:</label>
                <div class="col-md-9">
                    {{ Form::text('comment', null, array('class' => 'form-control ',
                    'placeholder' => 'Comment', 'required')) }}
                </div>
                <label class="col-md-3 control-label">Comment On:</label>
                <div class="col-md-9">
                    {{ Form::text('comment_on', null, array('class' => 'form-control ',
                    'placeholder' => 'Comment On', 'required')) }}
                </div>
                <label class="col-md-3 control-label">Rating:</label>
                <div class="col-md-9">
                    {{ Form::text('rating', null, array('class' => 'form-control ',
                    'placeholder' => 'Rating', 'required')) }}
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