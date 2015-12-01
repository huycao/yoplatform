
<div class="box mb12">
<table class="table table-striped table-hover table-condensed">
    <colgroup>
        <col width="5%">
        <col width="25%">
        <col width="25%">
        <col width="25%">
        <col width="10%">
        <col width="10%">
    </colgroup> 
    <thead>
        <tr>
            <th></th>
            <th>Name</th>
            <th>All</th>
            <th>Description</th>
            <th>Last Editor</th>
            <th>Update</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        <?php if( count($lists) ){ ?>
            <?php foreach( $lists as $item ){ ?>
            <tr role="row" id="{{ $item->id }}" class="ui-widget-content jqgrow ui-row-ltr">
                <td style="text-align:center;width: 25px;">
                    <input role="checkbox" class='cbox' type='checkbox'>
                </td>
                <td>{{ $item->name}}</td>
                <td> {{ $item->pfcount }} </td>
                <td>{{ $item->description }}</td>                               
                <td>{{ $item->last_editor }}</td> 
                <td>{{ date('d/m/Y', strtotime($item->audience_update)) }}</td> 
                <td>
                    <div>
                        <ul class="fontawesome-icon-list fa-hover list-inline">
                            <li>
                                <a class="btn btn-default btn-sm" title="" href="{{ URL::Route($moduleRoutePrefix.'ShowUpdateAudience',$item->audience_id) }}" data-original-title="Edit">
                                    <i class="fa fa-pencil-square-o"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
            <?php } ?>
        <?php }else{ ?>
            <tr>
                <td class="no-data" colspan="7">{{trans("text.no_data")}}</td>
            </tr>
        <?php } ?>
    </tbody>
</table>
</div>
