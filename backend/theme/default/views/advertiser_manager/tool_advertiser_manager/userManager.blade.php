<div class="box mb12">

	<div class="head">
		<a href="javascript:;" class="btn-filter" data-toggle="collapse" data-target="#filter"><i class="fa fa-chevron-circle-down"></i> Filter</a>
	</div>

	<div id="filter" class="collapse content">
		<form class="filter-form form-horizontal" id="filter" role="form">
			<div class="filter-wrapper">
				<div class="row">
					<div class="col-xs-6">
						
						<div class="form-group">
						    <label for="name" class="col-xs-3 control-label" style="padding-top:5px;">{{trans('backend::publisher/text.username')}}</label>
						    <div class="col-xs-9">
								<input type="text" class="form-control input-sm" id="username" name="username">
							</div>
						</div>
						<div class="form-group">
						    <label for="name" class="col-xs-3 control-label" style="padding-top:5px;">{{trans(trans('backend::publisher/text.first_name'))}}</label>
						    <div class="col-xs-9">
								<input type="text" class="form-control input-sm" id="first_name" name="first_name">
							</div>
						</div>
						<div class="form-group">
						    <label for="name" class="col-xs-3 control-label" style="padding-top:5px;">{{trans(trans('backend::publisher/text.last_name'))}}</label>
						    <div class="col-xs-9">
								<input type="text" class="form-control input-sm" id="last_name" name="last_name">
							</div>
						</div>
					</div>
					<div class="col-xs-6">
						<div class="form-group">
						    <label for="name" class="col-xs-3 control-label" style="padding-top:5px;">{{trans(trans('backend::publisher/text.email'))}}</label>
						    <div class="col-xs-9">
								<input type="text" class="form-control input-sm" id="email" name="email">
							</div>
						</div>
						<div class="form-group">	
						    <label for="status" class="col-xs-3 control-label" style="padding-top:5px;">{{trans('text.country')}}</label>
						    <div class="col-xs-9">
							{{ 
		                        Form::select(
		                            'country_id', 
		                            $listCountry, 
		                            "", 
		                            array('class'=>'form-control input-sm','id'=>'country')
		                        ) 
		                    }}								
							</div>
						</div>
						
					</div>			
				</div>
				<div class="row">
					<div class="col-xs-6">
			    		<button type="submit" class="btn btn-default filter-button btn-sm">Submit</button>
					</div>
			    </div>
			</div>
		</form>

	</div>
</div>


@include('partials.show_list')