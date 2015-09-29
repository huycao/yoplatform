@if(!empty($provinceLists))
    @foreach($provinceLists as $province)
    	<?php  $region = "{$province->country_code}:{$province->region}"; ?>
        <option  value="{{$region}}">{{ $province->region }} @if(isset($province->country_name))({{$province->country_name}})@endif</option>                                                
    @endforeach
@endif