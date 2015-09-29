<table class="table table-responsive table-condensed table-bordered table-hover tableList" style="margin-bottom:0px; margin-top:20px">
    <thead>    
        <tr class="bg-primary">
            <th width="50%">Name</th>
            <th width="25%">Publisher Cost</th>            
            <th width="25%">Action</th>
        </tr>
    </thead>
</table>
@if( !empty($listFlightWebsite) )
    <ol class="sortable">
    @foreach( $listFlightWebsite as $flightWebsite )
        <li id="sort-{{{$flightWebsite->id}}}">
            <div>
            <table class="table table-responsive table-condensed table-bordered table-hover tableList">
                <tr> 
                    <td width="50%">{{$flightWebsite->flight->name}} - {{ $flightWebsite->flight->ad->name }}</td> 
                    <td width="25%">{{$flightWebsite->publisher_base_cost}}</td> 
                    <td width="25%"> 
                        <a href="javascript:;" onclick="Ad.loadModal({{$flightWebsite->id}}, {{$flightWebsite->website_id}}, {{$flightWebsite->flight_id}}, '{{$flightWebsite->flight->name}}')" class="btn btn-default btn-sm">
                            <span class="glyphicon glyphicon-pencil"></span> Edit
                        </a>
                    </td>
                </tr>
            </table>
            </div>
        </li>
    @endforeach
    </ol>
@endif

{{ HTML::script("{$assetURL}js/jquery-ui.min.js") }}
{{ HTML::script("{$assetURL}js/jquery.mjs.nestedSortable.js") }}

<script type="text/javascript">
    
    $(document).ready(function(){

        $('ol.sortable').nestedSortable({
            forcePlaceholderSize: true,
            handle: 'div',
            items: 'li',
            opacity: .6,
            placeholder: 'placeholder',
            tolerance: 'pointer',
            toleranceElement: '> div',
            maxLevels: 1,
        });

    });

</script>