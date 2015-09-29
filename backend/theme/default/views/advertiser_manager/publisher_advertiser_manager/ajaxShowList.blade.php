<div class="admin-pagination mb12">
	{{$lists->links()}}
	<div class="clearfix"></div>
</div>
<div class="box mb12">
<table class="table table-striped table-hover table-condensed">
    <thead>
		<tr>
			@include('partials.show_field')
		</tr>
    </thead>

	<tbody>
		<?php if( count($lists) ){ ?>
			<?php foreach( $lists as $item ){ ?>
			<tr>
				<td><a href="{{ URL::Route($moduleRoutePrefix.'ShowView',$item['id']) }}">({{$item['id']}}) {{$item->company}}</a></td>
				<td>{{$item->site_url}}</td>
				<td><span class="badge badge-info">{{number_format($item->pageview)}}</span></td>
				<td><span class="badge badge-info">{{number_format($item->unique_visitor)}}</span></td>
				<td>{{$item->email}}</td>
				<td>{{$item->statusText}}</td>			
				<td>{{$item->created_at}}</td>
			</tr>
			<?php } ?>
		<?php }else{ ?>
			<tr>
				<td class="no-data" >{{trans("text.no_data")}}</td>
			</tr>
		<?php } ?>
	</tbody>

</table>
</div>
<div class="admin-pagination">
	{{ $lists->links() }}
	<div class="clearfix"></div>
</div>

<script type="text/javascript">
	
	if( $(".no-data").length > 0 ){
		var colspan = $(".tableList th").length;
		$(".no-data").attr("colspan", colspan);
	} 

</script>


