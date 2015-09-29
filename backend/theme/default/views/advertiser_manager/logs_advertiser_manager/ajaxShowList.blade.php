<div class="admin-pagination mb12">
    {{$lists->links()}}
    <div class="clearfix"></div>
</div>
<div class="box mb12">
    <table class="table table-striped table-hover table-condensed">
        <thead>
        <tr>
            <th>Module</th>
            <th>Action</th>
            <th>Title action</th>
            <th>Account</th>
            <th>Create at</th>
            <th><a href="javascript:;">Action</a></th>
        </tr>
        </thead>

        <tbody>
        <?php if( count($lists) ){ ?>
        <?php foreach( $lists as $item ){ ?>
        <tr>
            <td>{{$item->module}}</td>
            <td>{{$item->type_task}}</td>
            <td>{{$item->title}}</td>
            <td>{{$item->username}}</td>
            <td>{{$item->created_at}}</td>
            <td>
                <div>
                    <ul class="fontawesome-icon-list fa-hover list-inline">
                        <li>
                            <a class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Delete" href="{{ URL::Route($moduleRoutePrefix.'ShowDelete',$item['id']) }}">
                                <i class="fa fa-trash-o"></i>
                            </a>
                        </li>
                        @if ($item->type_task == 'update' && strlen($item->pre_content) > 0)
                            <li>
                            	<a class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Revert" href="{{ URL::Route($moduleRoutePrefix.'ShowRevert',$item['id']) }}">
                                    <i class="fa fa-undo"></i>
                                </a>
                            </li>
                        @endif

                    </ul>
                </div>
            </td>
        </tr>
        <?php } ?>
        <?php }else{ ?>
        <tr>
            <td class="no-data" >{{trans("text.no_data")}}</td>
        </tr>
        <?php } ?>
        </tbody>

    </table>
</div>

<div class="admin-pagination">
    {{ $lists->links() }}
    <div class="clearfix"></div>
</div>

<script type="text/javascript">

    if( $(".no-data").length > 0 ){
        var colspan = $(".tableList th").length;
        $(".no-data").attr("colspan", colspan);
    }

    $(function () {
		$('[data-toggle="tooltip"]').tooltip();
	});

</script>


