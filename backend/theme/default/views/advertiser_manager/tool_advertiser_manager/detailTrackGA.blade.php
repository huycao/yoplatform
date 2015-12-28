 
 <form class="filter-form form-horizontal" id="filter" role="form" action="/control-panel/advertiser-manager/tool/detail-url-track/{{ $id }}">
     <div class="row">
        <div class="col-sm-9">
            <div class="form-group">
                <label class="col-md-2" style="margin-top:10px">Choose Date</label>
                <div class="col-md-6">
                    <div class="input-daterange input-group" id="datepicker">
                        <input type="text" class="form-control" name="start" id="start_date" value="{{Input::get('start', '')}}"/>
                        <span class="input-group-addon">to</span>
                        <input type="text" class="form-control" name="end" id="end_date" value="{{Input::get('end', '')}}"/>
                    </div>
                </div>
                <div class="col-md-4"  style="margin-top:5px"><input type="submit" value="Filter"/></div>
        </div>
    </div>
    </div>
</form>


<div class="box">
    <table class="table table-striped table-hover table-condensed has-child">
        <thead>
            <tr>
               <th>Date</th>               
               <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @if(sizeof($lists) > 0)
                @foreach($lists as $item)
                <tr>
                    <td width="300px">{{ $item['date'] }}</td>
                    <td>{{ $item['total'] }}</td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="2">No data</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
<script type="text/javascript">

    $().ready(function(){
        $('.input-daterange').datepicker({ format: 'dd-mm-yyyy'});
    })
</script>