
    <div class="row">



        <div class="col-sm-12">
            <div class="form-group">
                <label class="col-md-3 control-label">Name:</label>
                <div class="col-md-9">
                    {{ Form::text('name', null, array('class' => 'form-control ',
                    'placeholder' => 'Name', 'required')) }}
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label class="col-md-3 control-label">Nationality:</label>
                <div class="col-md-9">
                    {{ Form::text('nationality', null, array('class' => 'form-control ',
                    'placeholder' => 'Nationality', 'required')) }}
                </div>
            </div>
        </div>

    </div>
