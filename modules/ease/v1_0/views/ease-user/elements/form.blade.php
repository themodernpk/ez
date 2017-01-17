
    <div class="row">



        <div class="col-sm-12">
            <div class="form-group">
                <label class="col-md-3 control-label">Rating:</label>
                <div class="col-md-9">
                    {{ Form::text('rating', null, array('class' => 'form-control ',
                    'placeholder' => 'Rating', 'required')) }}
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">gender:</label>
                <div class="col-md-9">
                    {{ Form::text('gender', null, array('class' => 'form-control ',
                    'placeholder' => 'gender', 'required')) }}
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">wallet:</label>
                <div class="col-md-9">
                    {{ Form::text('wallet', null, array('class' => 'form-control ',
                    'placeholder' => 'wallet', 'required')) }}
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">nationaliry:</label>
                <div class="col-md-9">
                    {{ Form::text('nationality', null, array('class' => 'form-control ',
                    'placeholder' => 'nationality', 'required')) }}
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">number of reviews:</label>
                <div class="col-md-9">
                    {{ Form::text('number_of_reviews', null, array('class' => 'form-control ',
                    'placeholder' => 'number of reviews', 'required')) }}
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">national iqama id:</label>
                <div class="col-md-9">
                    {{ Form::text('national_iqama_id', null, array('class' => 'form-control ',
                    'placeholder' => 'national iqama id', 'required')) }}
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">is verified:</label>
                <div class="col-md-9">
                    {{ Form::text('verified', null, array('class' => 'form-control ',
                    'placeholder' => 'is verified', 'required')) }}
                </div>
            </div>


        </div>


    </div>
