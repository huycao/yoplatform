<table class="table table-responsive table-striped table-hover table-condensed table-bordered tableList">
    <thead>
        <tr class="bg-primary">
            <th>Id</th>
            <th>Name</th>
            <th>Weight</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @if( !empty($lists) )
            @foreach( $lists as $item )
                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->weight}}</td>
                    <td>
                        <a href="javascript:;" onclick="modalApp.loadModal({{$item->id}})" class="btn btn-default btn-sm">
                            <span class="glyphicon glyphicon-pencil"></span> Edit
                        </a>
                        <a href="javascript:;" onclick="modalApp.delete({{$item->id}})" class="btn btn-default btn-sm">
                            <span class="fa fa-trash-o"></span> Del
                        </a>
                    </td>
                </tr>
            @endforeach
        @else
        <tr>
            <td colspan="5">No data</td>
        </tr>
        @endif

    </tbody>


</table>