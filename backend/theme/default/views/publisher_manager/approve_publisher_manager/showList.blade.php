<form class="filter-form " role="form">
<div class="filter-wrapper">
		<fieldset>
			
			<div class="row">
			    <div class="col-xs-12">
					<button type="button" class="btn btn-primary btn-sm btn-filter pull-left" data-toggle="collapse" data-target="#filter">{{trans('backend::publisher/text.filter')}}</button>
					<a href="{{URL::to(Route('ApprovePublisherManagerShowCreate'))}}" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-file"></span> {{trans('backend::publisher/text.add_new_publisher')}}</a>
			    </div>
			</div>
			<hr>
			<div id="filter" class="collapse">
				<div class="row">
					<div class="col-sm-12">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label for="status">{{trans('backend::publisher/text.country')}}</label>
									<select name="s-country" id="s-country" class="form-control">
										<option value="">{{trans('backend::publisher/text.choose')}}</option>
										@foreach($itemCountry as $item)
										<option value="{{$item->id}}">{{$item->country_name}}</option>
										@endforeach
									</select>					    	
								</div>
								
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="status">{{trans('backend::publisher/text.category')}}</label>
									<select name="s-category" id="s-category" class="form-control">
										<option value="">{{trans('backend::publisher/text.choose')}}</option>
										@foreach($itemCate as $item)
										<option value="{{$item->id}}">{{$item->name}}</option>
										@endforeach								
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="row">
							<div class="col-sm-2 filter-radio">
								<div class="form-group">
									<input type="radio" checked name="type-name" value="company"> {{trans('backend::publisher/text.company')}}
									<input type="radio" name="type-name" value="email"> {{trans('backend::publisher/text.email')}}
								</div>
							</div>
							<div class="col-sm-10">
								<div class="form-group">
									<label>{{trans('backend::publisher/text.keyword')}}</label>
									<input type="text" class="form-control" name="keyword" placeholder="{{trans('backend::publisher/text.keyword')}}">			
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
				    		<button type="submit" class="btn btn-primary filter-button">{{trans('backend::publisher/text.submit')}}</button>
						</div>
					</div>	
			    </div>
			</div>
		</fieldset>

	
</div>



<div class="row">
    <div class="col-xs-12">

		<div class="bts-tabs">
		    <ul role="tablist" class="nav nav-tabs filter-status" id="myTab">
		        <li class="active" data-id="0"><a data-toggle="tab" role="tab" href=".tab-content"><strong>{{trans('backend::publisher/text.pending')}}</strong></a></li>
		        <li class="" data-id="3"><a data-toggle="tab" role="tab" href=".tab-content"><strong>{{trans('backend::publisher/text.approved')}}</strong></a></li>				     
		        <li class="" data-id="2"><a data-toggle="tab" role="tab" href=".tab-content"><strong>{{trans('backend::publisher/text.disapproved')}}</strong></a></li>
		        <li class="" data-id="-1"><a data-toggle="tab" role="tab" href=".tab-content"><strong>{{trans('backend::publisher/text.all')}}</strong></a></li>				     
		        <li class="" data-id="1"><a data-toggle="tab" role="tab" href=".tab-content"><strong>{{trans('backend::publisher/text.archived')}}</strong></a></li>				     
		    </ul>
		    <input type="hidden" name="status" id="status" value="0"/>
		    <div class="tab-content" id="myTabContent">
		        <div class="wrap-table">
			
				</div>				      
		    </div>
		</div>
				
    </div>
</div>
</form>
<script type="text/javascript">
	$().ready(function(){
		pagination.init({
			url : "{{{ $defaultURL }}}get-list",
			defaultField : "{{{ $defaultField }}}",
			defaultOrder : "{{{ $defaultOrder }}}"
		});
	});
</script>