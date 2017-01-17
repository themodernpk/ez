
    <div class="row">



        <div class="col-sm-12">
            <div class="form-group">
                <label class="col-md-3 control-label">Question:</label>
                <div class="col-md-9">
                    {{ Form::text('question', null, array('class' => 'form-control ',
                    'placeholder' => 'Question', 'required')) }}
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Answer:</label>
                <div class="col-md-9">
                    {{ Form::textarea('answer', null, array('class' => 'form-control ',
                    'placeholder' => 'Answer', 'required')) }}
                </div>
            </div>


        </div>


    </div>