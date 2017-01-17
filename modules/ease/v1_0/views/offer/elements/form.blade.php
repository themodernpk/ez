
    <div class="row">



        <div class="col-sm-12">
            <div class="form-group">
                <label class="col-md-3 control-label">Offer:</label>
                <div class="col-md-9">
                    {{ Form::textarea('offer', null, array('class' => 'form-control ',
                    'placeholder' => 'Offer Description', 'required')) }}
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 col-sm-4 control-label" for="user">Offer for the Service:</label>
                <div class="col-md-9 col-sm-8">
                    <select class="form-control" name="offer_for" id="offer_for" required>
                        <?php $services = EaseService::all();  ?>
                        @foreach($services as $service)
                            <option value="{{$service->id}}">{{$service->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        </div>


    </div>