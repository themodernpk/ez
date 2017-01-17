
    <div class="row">



        <div class="col-sm-12">
            <div class="form-group">
                <label class="col-md-3 col-sm-4 control-label" for="user">T&C for:</label>
                <div class="col-md-9 col-sm-8">
                    <select class="form-control" name="tnc_for" id="tnc_for" required>

                            <option value="seeker">Seeker</option>
                            <option value="provider">Provider</option>

                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">Condition:</label>
                <div class="col-md-9">
                    {{ Form::textarea('conditions', null, array('class' => 'form-control ',
                    'placeholder' => 'Condition', 'required')) }}
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Heading:</label>
                <div class="col-md-9">
                    {{ Form::text('heading', null, array('class' => 'form-control ',
                    'placeholder' => 'Heading', 'required')) }}
                </div>
            </div>

        </div>


    </div>