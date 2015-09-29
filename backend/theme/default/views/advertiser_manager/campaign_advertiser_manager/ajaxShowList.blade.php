<div class="admin-pagination mb12">
	{{$lists->links()}}
	<div class="clearfix"></div>
</div>
<div class="box mb12">
<table class="table table-striped table-hover table-condensed">
	<colgroup>
		<col width="27%">
		<col width="15%">
		<col width="12%">
		<col width="12%">
		<col width="13%">
		<col width="21%">
	</colgroup>	
    <thead>
		<tr>
			@include('partials.show_field')
			<th><a href="javascript:;">Action</a></th>
		</tr>
    </thead>

	<tbody>
		<?php if( count($lists) ){ ?>
			<?php foreach( $lists as $item ){ ?>
			<tr>
				<td><a href="{{ URL::Route($moduleRoutePrefix.'ShowView',$item['id']) }}">({{$item['id']}}) {{$item->name}}</a></td>
				<td>{{$item->advertiser->name}}</td>
				<td>{{ date('d-m-Y', strtotime($item->start_date)) }}</td>
				<td>{{ date('d-m-Y', strtotime($item->end_date)) }}</td>
				<td>{{$item->sale->username}}</td>
				<td>
					<div class="">
						<ul class="fontawesome-icon-list fa-hover list-inline">
							<li>
								<a class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Edit" href="{{ URL::Route($moduleRoutePrefix.'ShowUpdate',$item['id']) }}">
									<i class="fa fa-pencil-square-o"></i>
								</a>
							</li>
							<li>
								<a class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="View" href="{{ URL::Route($moduleRoutePrefix.'ShowView',$item['id']) }}">
									<i class="fa fa-eye"></i>
								</a>
							</li>
							<li>
								<a class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Report" href="{{ URL::Route($moduleRoutePrefix.'ShowReport',$item['id']) }}">
									<i class="fa fa-area-chart"></i>
								</a>							
							</li>
							<li>
								<a class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Report Conversion" href="{{ URL::Route($moduleRoutePrefix.'ShowReportConversion',$item['id']) }}">
									<i class="fa fa-bar-chart"></i>
								</a>							
							</li>
							<li>
								<a class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Preview Campaign" href="javascript:;" onclick="Preview.getPreview('campaign', {{$item['id']}})">
									<i class="fa fa-desktop"></i>
								</a>							
							</li>
							<li>
								<a class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Conversion" href="{{ URL::Route('ConversionAdvertiserManagerShowList',$item['id']) }}">
									<i class="fa fa-circle-o-notch"></i>
								</a>							
							</li>
						</ul>
					</div>
				</td>				
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

	$(function () {
		$('[data-toggle="tooltip"]').tooltip();
	});

</script>


