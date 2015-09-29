<div class="row">
	<div class="col-sm-12">
		<div class="show-success" style="display:none;">        
            <div role="alert" class="alert alert-success fade in">
              <button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>         
              <p class="text-success">{{{trans("backend::publisher/text.success")}}}</p>
            </div>
        </div>
	
		<div class="box-body">
			@if(count($items) > 0)
				<ol class="sortable">
				@foreach( $items as $value )			
				    <li id="sort-{{{$value->id}}}" class="alert alert-warning" role="alert" style="padding: 6px;margin-bottom: 5px;"><div>{{{$value->flight->name}}}</div></li>			
				@endforeach
				</ol>
			@else
				{{trans("backend::publisher/text.no_data")}}
			@endif
	    </div>
	    
	</div>
</div>



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
