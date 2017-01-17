<tr>
    <td>{{$item->name}}</td>
    <td>{{$item->mobile}}</td>
    @if((isset($item->email)))
        <td>{{$item->email}}</td>
    @endif
    @if(!(isset($item->email)))
        <td>{{$item->email}}</td>
    @endif
    @if($item->verified=="true")
        <td>verified</td>
    @endif
    @if($item->verified=="false")
        <td>Not Verified</td>
    @endif
    @if($item->verified=="resend")
        <td>Image not clear</td>
    @endif
    <td>{{$item->cancelletion_amount}}</td>
    <td>{{$item->gender}}</td>
    <td>{{$item->rating}}</td>
    <td>{{$item->wallet}}</td>
    <td>{{$item->national_iqama_id}}</td>
    @if(isset($item->national_id))
        <td>
            <a target="_blank" href="{{$item->national_id}}">
                <img width="50px" height="50px" src="{{$item->national_id}}" alt="" />
            </a>
        </td>
    @endif
    @if(!(isset($item->national_id)))
        <td>no documents</td>
    @endif
    @if(isset($item->profile))
        <td>
            <a target="_blank" href="{{$item->profile}}">
                <img width="50px" height="50px" src="{{$item->profile}}" alt="" />
            </a>
        </td>
    @endif
    @if(!isset($item->profile))
        <td>no profile</td>
    @endif
    <td>
        <span data-toggle="tooltip" data-placement="top" data-original-title="View">
                        <a class="btn btn-sm btn-icon btn-circle btn-info viewItem"
                           data-toggle="modal"
                           data-pk="{{$item->id}}"
                           data-href="{{URL::route($data->prefix.'-read',
                           array('id' => $item->_id, 'format' => 'json'))}}"
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