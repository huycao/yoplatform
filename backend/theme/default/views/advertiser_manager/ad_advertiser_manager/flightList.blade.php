<table class="table table-responsive table-condensed table-bordered table-hover tableList">
    <thead>
        <tr class="bg-primary">
            <th>Name</th>
            
            <th>Action</th>
        </tr>
    </thead>
    <tbody>

        @if( !empty($flightAdList) )
            @foreach( $flightAdList as $flightAd )
                <tr> 
                    
                    <td>{{$flightAd->flightinfo->name}}</td> 
                    <td> 
                        <a href="javascript:;" onclick="Ad.delete({{$flightAd->id}})" class="btn btn-default btn-sm">
                            <span class="fa fa-trash-o"></span> Del
                        </a>
                    </td>
                </tr>
            @endforeach
        @endif

    </tbody>
</table>