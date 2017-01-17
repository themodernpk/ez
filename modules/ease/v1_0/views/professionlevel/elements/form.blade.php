
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label class="col-md-3 control-label">Name:</label>
                <div class="col-md-9">
                    {{ Form::text('name', null, array('class' => 'form-control ',
                    'placeholder' => 'Name', 'required')) }}
                </div>
                <label class="col-md-3 control-label">Base Price:</label>
                <div class="col-md-9">
                    {{ Form::text('base_price', null, array('class' => 'form-control ',
                    'placeholder' => 'Base Price', 'required')) }}
                </div>
                <div class="form-group">
                    <label class="col-md-3 col-sm-4 control-label" for="user">Select Country:</label>
                    <div class="col-md-9 col-sm-8">
                        <select class="form-control" name="country_id" id="for_service" required>
                            <?php $countries = EaseCountry::all();  ?>
                            @foreach($countries as $country)
                                <option value="{{$country->id}}">{{$country->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-md-3 col-sm-4 control-label" for="user">Profession level for the Service:</label>
                    <div class="col-md-9 col-sm-8">
                        <select class="form-control" name="service_id" id="for_service" required>
                            <?php $services = EaseService::all();  ?>
                            @foreach($services as $service)
                                <option value="{{$service->id}}">{{$service->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>



            </div>

            <div class="form-group">
                <label class="col-md-3 col-sm-4 control-label">Choose Unit:</label>
                <div class="col-md-9 col-sm-8">
                    <div class="radio">
                        <label>
                            <input type="radio" name="units" value="time" data-parsley-required>
                            Time
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="units" value="session" data-parsley-required >
                            Session
                        </label>
                    </div>
                </div>
        </div>

        </div>


    </div>