<div class="box mb12">
	<div class="head">
		<a href="javascript:;" class="btn-filter" data-toggle="collapse" data-target="#filter">Filter</a>
	</div>
	<div id="filter" class="collapse content">
		<form class="filter-form form-horizontal" id="filter" role="form">
			<div class="filter-wrapper">
				<div class="row">
					<div class="col-xs-12">
						<table class="table">
							<tr>
								<td width="50%">
									<span class="lbl">{{trans('text.start_date')}}</span>
									<div>
										<input type="text" class="form-control input-sm" id="start_date" name="start_date">
									</div>
								</td>
								<td width="50%">
									<span class="lbl">{{trans('text.end_date')}}</span>
									<div>
										<input type="text" class="form-control input-sm" id="end_date" name="end_date">
									</div>
								</td>
							</tr>						
						</table>
					</div>
			
				</div>
				<div class="row">
					<div class="col-xs-6">
			    		<button type="submit" class="btn btn-sm btn-default filter-button">Search</button>
					</div>
			    </div>
			</div>
		</form>
		<script type="text/javascript">
			$().ready(function(){
				$("#start_date").datepicker({
			        format: 'dd-mm-yyyy'
			    });
				$("#end_date").datepicker({
			        format: 'dd-mm-yyyy'
			    });
			})
		</script>
	</div>
</div>

@include('partials.show_list')