<tr>
    <td>{{$item->id}}</td>
    <td>{{$item->name}}</td>
    <td>{{$item->slug}}</td>
    <td>
        <span data-toggle="tooltip" data-placement="top" data-original-title="View">
                        <a class="btn btn-sm btn-icon btn-circle btn-info viewItem"
                           data-toggle="modal"
                           data-pk="{{$item->id}}"
                           data-href="{{URL::route($data->prefix.'-read',
                           array('id' => $item->id, 'format' => 'json'))}}"
                           data-target="#ModalView">
                            <i class="fa fa-eye"></i>
                        </a>
                       </span>
    </td>
    @if(Permission::check($data->prefix.'-update'))
        <td>
            @if($item->enable == 1)

                <input type="checkbox" data-render="switchery" class="BSswitch"
                       data-theme="green" checked="checked" data-switchery="true"
                       data-pk="{{$item->id}}"
                       data-href="{{URL::route($data->prefix.'-bulk-action')}}?action=disable&format=json"
                       style="display: none;">
            @else

                <input type="checkbox" data-render="switchery" class="BSswitch"
                       data-theme="green" data-switchery="true"
                       data-pk="{{$item->id}}"
                       data-href="{{URL::route($data->prefix.'-bulk-action')}}?action=enable&format=json"
                       style="display: none;">

            @endif
        </td>
        <td>
            @if(Permission::check($data->prefix.'-update'))
                <span data-toggle="tooltip" data-placement="top" data-original-title="Update">
                                            <a class="btn btn-sm btn-icon btn-circle btn-info updateItem"
                                               data-toggle="modal"
                                               data-pk="{{$item->id}}"
                                               data-href="{{URL::route($data->prefix.'-read',
                                               array('id' => $item->id, 'format' => 'json'))}}"
                                               data-target="#ModalUpdate">
                                                <i class="fa fa-edit"></i>
                                            </a>
                            </span>


            @endif

            @if(Permission::check($data->prefix.'-delete'))
                <span data-toggle="tooltip" data-placement="top" data-original-title="Delete">
                                            <a class="btn btn-sm btn-icon btn-circle btn-danger ajaxDelete"
                                               data-pk="{{$item->id}}"
                                               data-href="{{URL::route($data->prefix.'-bulk-action')}}?action=delete&format=json">
                                                <i class="fa fa-times"></i>
                                            </a>
                                           </span>
            @endif
        </td>


        <td><input class="idCheckbox" type="checkbox" name="id[]" value="{{$item->id}}"/></td>
    @endif
</tr>