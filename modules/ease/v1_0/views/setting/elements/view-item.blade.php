<div class="col-md-12">
    <table class="table table-bordered table-striped table-condensed">
        @foreach($data as $key => $value )
            <?php
            if ($key == 'created_by' && is_object($value)) {
                $value = $value->name;
            } else if ($key == 'modified_by' && is_object($value)) {
                $value = $value->name;
            } else if ($key == 'deleted_by' && is_object($value)) {
                $value = $value->name;
            }
            ?>
            <tr>
                <th>{{$key}}</th>
                <td>{{$value}}</td>
            </tr>
        @endforeach
    </table>
</div>