@if ($block_name == 'row_edit')

<!--### Editing Single Row-->

<script type="text/javascript"> 
    $( document ).ready(function() {
        $('.editable').editable({
            type: 'text',
            url: "<?php echo URL::route('ajax_edit'); ?>",
            success: function(response) 
            { 
                if(response == "failed")
                {
                    $.gritter.add({
                    title: '<label class="btn btn-xs btn-icon btn-circle btn-danger"><i class="fa fa-times"></i></label>  Undefined Error',
                    sticky: false,
                    });
                    $(this).attr('checked','checked');
                }

                if(response == "success")
                {
                    $.gritter.add({
                    title: '<label class="btn btn-xs btn-icon btn-circle btn-success"><i class="fa fa-check"></i></label>  Edited Successfully',
                    sticky: false,
                    });
                }
            	$(".pace").addClass('pace-inactive');
            }
        }); 
    }); 
</script>

@endif