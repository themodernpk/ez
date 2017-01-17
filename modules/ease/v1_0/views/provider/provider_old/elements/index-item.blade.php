<tr>
    <td>{{$item->name}}</td>
    <td>{{$item->mobile}}</td>
    <td>{{$item->pending_commission}}</td>
    <td>{{$item->amount_withdrew}}</td>
    <td>{{$item->commission_paid_to_company}}</td>
    @if($item->verified)
        <td>Verified</td>
        @endif
    @if(!$item->verified)
        <td>Not Verified</td>
    @endif
    <td>{{$item->gender}}</td>
    <td>{{$item->rating}}</td>
    <td>{{$item->wallet}}</td>
    <td>{{$item->national_iqama_id}}</td>
    @if(isset($item->document_name))
        <td>
            <a target="_blank" href="{{$item->national_id}}">
                <img width="50px" height="50px" src="{{$item->national_id}}" alt="" />
            </a>
        </td>
    @endif
    @if(!(isset($item->document_name)))
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