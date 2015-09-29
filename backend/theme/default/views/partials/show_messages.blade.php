@if( !empty($message) )
<div class="row">
    <div class="col-xs-12">
    	<div class="message-success">{{$message}}</div>
    </div>
</div>
@endif

@if( Session::has('success') )
<div class="row">
    <div class="col-md-12">
            <div class="message-success">{{Session::get('success')}}</div>
    </div>
</div>
@endif

@if( !empty($error) )
<div class="row">
    <div class="col-xs-12">
    	<div class="errors-list">{{$error}}</div>
    </div>
</div>
@endif

@if( !empty($errors) && get_class($errors) == 'Illuminate\Support\MessageBag'  )
<div class="row">
    <div class="col-xs-12">
		@if($errors->has())
			<ul class="errors-list">
			    @foreach ($errors->all() as $error)
			    <li>{{ $error }}</li>
			    @endforeach
		    </ul>
		@endif
    </div>
</div>
@endif