<div class="col-md-4 col-sm-12 m-b-5">
    <div class="input-group">
        <input type="text" class="form-control input-sm" name="q" value="{{Input::get('q')}}" placeholder="Search" />
                    <span class="input-group-btn">
                        <button class="btn btn-success btn-sm" name="action" value="search" type="submit">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                        @if(isset($data->input->q))
                            <a href="{{URL::route($data->prefix."-index")}}" class="btn btn-sm btn-inverse"><i class="fa fa-times"></i></a>
                        @endif
                    </span>
    </div>
</div>

