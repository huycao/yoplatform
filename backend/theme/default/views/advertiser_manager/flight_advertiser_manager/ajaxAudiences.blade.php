 @if(sizeof($audiences)>0)
 <div class="col-md-2">
    <select name="operator" class="form-control" style="width:100px">
        <option value="in" {{($operator == 'in') ? 'selected':''}}>Target</option>
        <option value="not in" {{($operator == 'not in') ? 'selected':''}}>Untarget</option>
    </select>
</div>
<div class="col-md-1">with audience</div>
<div class="col-md-8">
    <select name="audience_id" class="form-control" style="width:200px">
        @foreach($audiences as $audience)
            <option value="{{ $audience->audience_id }}" {{($audience->audience_id == $audience_id) ? 'selected':''}} >{{$audience->name}}</option>
        @endforeach
    </select> 
</div>
@else
<div class="col-md-2">
   
</div>

<div class="col-md-8">
    No data
</div>
@endif