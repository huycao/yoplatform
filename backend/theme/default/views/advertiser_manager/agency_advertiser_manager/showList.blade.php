<div class="box mb12">

	<div class="head">
		<a href="javascript:;" class="btn-filter" data-toggle="collapse" data-target="#filter"><i class="fa fa-chevron-circle-down"></i> Filter</a>
	</div>

	<div id="filter" class="collapse content">
		<form class="filter-form form-horizontal" id="filter" role="form">
			<div class="filter-wrapper">
				<div class="row">
					<div class="col-xs-6">
						<div class="form-group form-group-sm">
						    <label for="status" class="col-xs-2 control-label">{{trans('text.status')}}</label>
						    <div class="col-xs-10">
								<select name="status" class="form-control">
									<option value="">Select Status</option>
									<option value="1">{{trans('text.active')}}</option>
									<option value="0">{{trans('text.unactive')}}</option>
								</select>					    
							</div>
						</div>
						<div class="form-group form-group-sm">
						    <label for="name" class="col-xs-2 control-label">{{trans('text.name')}}</label>
						    <div class="col-xs-10">
								<input type="text" class="form-control" id="name" name="name">
							</div>
						</div>
					</div>
					<div class="col-xs-6">
						<div class="form-group form-group-sm">	
						    <label for="status" class="col-xs-2 control-label">{{trans('text.country')}}</label>
						    <div class="col-xs-10">
							{{ 
		                        Form::select(
		                            'country_id', 
		                            $listCountry, 
		                            "", 
		                            array('class'=>'form-control','id'=>'country')
		                        ) 
		                    }}								
							</div>
						</div>				
					</div>			
				</div>
				<div class="row">
					<div class="col-xs-6">
			    		<button type="submit" class="btn btn-default btn-sm filter-button">Search</button>
					</div>
			    </div>
			</div>
		</form>
	</div>
</div>

<a href="{{URL::Route($moduleRoutePrefix.'ShowCreate')}}" class="btn btn-default btn-sm mb12">Add More</a>

@include('partials.show_list')