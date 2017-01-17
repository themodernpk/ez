<div class="col-md-12"><table class="table table-bordered table-striped table-condensed"><?php foreach($data as $key => $value )
        {

            if ($key == 'created_by' && is_object($value)) {
                $value = $value->name;
            } else if ($key == 'modified_by' && is_object($value)) {
                $value = $value->name;
            } else if ($key == 'deleted_by' && is_object($value)) {
                $value = $value->name;
            }
            ?><tr><th>{{$key}}</th><td class="wrap" style="max-width:400px;" >{{$value}}</td></tr><?php } ?></table></div>