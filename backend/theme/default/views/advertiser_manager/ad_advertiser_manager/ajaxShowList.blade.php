<div class="admin-pagination mb12">
    {{$lists->links()}}
    <div class="clearfix"></div>
</div>
<div class="box mb12">
<table class="table table-striped table-hover table-condensed">
    <colgroup>
        <col width="25%">
        <col width="25%">
        <col width="25%">
        <col width="25%">
    </colgroup> 
    <thead>
        <tr>
            <th>Ad Name</th>
            <th>Flight</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        <?php if( count($lists) ){ ?>
            <?php foreach( $lists as $item ){ ?>
            <tr>
                <td><a href="{{URL::Route($moduleRoutePrefix.'ShowView',$item->id) }}">({{$item->id}}) {{$item->name or "-" }}</a></td>
                <td>{{$item->flight->name or "-"}}</td>
                <td>
                    <div>
                        <ul class="fontawesome-icon-list fa-hover list-inline">
                            <li>
                                <a class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Edit" href="{{ URL::Route($moduleRoutePrefix.'ShowUpdate',$item->id) }}">
                                    <i class="fa fa-pencil-square-o"></i>
                                </a>
                            </li>
                            <li>
                                <a class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="View" href="{{ URL::Route($moduleRoutePrefix.'ShowView',$item->id) }}">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </li>
                            <li>
                                <a class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Clone" href="{{ URL::Route($moduleRoutePrefix.'ShowClone',$item->id) }}">
                                    <i class="fa fa-clipboard"></i>
                                </a>
                            </li>
                            <li>
                                <a class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Preview" target="_blank" href="{{ URL::Route($moduleRoutePrefix.'ShowPreview',$item->id) }}">
                                    <i class="fa fa-desktop"></i>
                                </a>
                            </li>
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


