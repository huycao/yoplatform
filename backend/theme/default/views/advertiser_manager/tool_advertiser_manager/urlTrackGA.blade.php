
<a href="/control-panel/advertiser-manager/tool/create-new-url-track" class="btn btn-default btn-sm mb12">Add More</a>
 @if(Session::get("message")!="")
    <div class="alert alert-success fade in">
        {{ Session::get("message")}}
    </div>
@endif
<div class="box">

    <table class="table table-striped table-hover table-condensed has-child">
        <thead>
            <tr>
               <th>URL</th>
               <th>Amount</th>
               <th>Active</th>
               <th>Run</th>
                <th><a href="javascript:;">Action</a></th>
            </tr>
        </thead>

        <tbody>

            @if(sizeof($lists) > 0)
                @foreach($lists as $item)
                <tr>
                    <td>{{ $item->url }}</td>
                    <td>{{ $item->amount }}</td>
                    <td>{{ ($item->active == 1) ? 'active' : 'inactive' }}</td>
                    <td>{{ $item->run }}</td>
                    <td>
                        <a href="/control-panel/advertiser-manager/tool/edit-url-track/{{ $item->id }}" class="btn btn-default btn-sm">
                        <span class="glyphicon glyphicon-pencil"></span> Edit
                    </a>
                    <a href="javascript:;" onclick="deleteTrackURL({{ $item->id }})" class="btn btn-default btn-sm">
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
</div>
<script type="text/javascript">
   function deleteTrackURL(id){
        $.ajax({
            type:'post',
            url:'/control-panel/advertiser-manager/tool/delete-url-track',
            data:{'id':id},
            success: function(data){
                alert('Delete Successfull');
                window.location.reload();
            }
        })
   }
</script>