<table class="table table-responsive table-condensed table-bordered table-hover tableList" style="margin-bottom:0px; margin-top:20px">
    <thead>  
      
        <tr class="bg-primary">
            <th>Ad Format</th>
            <th>CPM</th>            
            <th>CPC</th>            
            <th>CPD</th>            
            <th>CPA</th>            
            <th>CPA(%)</th>            
            <th>Action</th>
        </tr>

        @if( !empty($lists) )
            @foreach( $lists as $item )
            <tr> 
                <td>{{ $item->adFormat->name }}</td> 
                <td>{{ $item->cpm }}</td> 
                <td>{{ $item->cpc }}</td> 
                <td>{{ $item->cpd }}</td> 
                <td>{{ $item->cpa }}</td> 
                <td>{{ $item->cpa_percent }}</td> 
                <td> 
                    <a href="javascript:;" onclick="costApp.loadModal({{$item->publisher_site_id}}, {{$item->ad_format_id}}, {{$item->id}})" class="btn btn-default btn-sm">
                        <span class="glyphicon glyphicon-pencil"></span> Edit
                    </a>
                </td>
            </tr>
            @endforeach
        @endif

    </thead>
</table>