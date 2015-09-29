<!-- chart -->
{{ HTML::script("{$assetURL}js/chart/highcharts.js") }}

<!-- datepicker -->
{{ HTML::style("{$assetURL}css/datepicker/datepicker3.css") }}
{{ HTML::script("{$assetURL}js/datepicker/bootstrap-datepicker.js") }}
 
<script type="text/javascript">
$(function(){

	//chart area
		var options = {
	        chart: {
	            renderTo: 'show-chart-area',
	            type: 'area'
	        },
	        title: {
	            text: ''
	        },
	        subtitle: {
	            text: 'Source: <a href="">' +'yomedia.vn</a>'
	        },
	        xAxis: {
	            categories: [],
	        },
	        yAxis: {
	        	title: {
	                text: '{{trans("backend::publisher/text.revenue")}}'
	            },
	           	min : 0
	        },
	        tooltip: {
	            pointFormat: '{series.name} <b>{point.y:,.0f}</b>'
	        },
	        credits: {
		      	enabled: false
		  	},
	        series: [{}]
	    };
	
	//get report
	var report = {
		property : {
			dataForm		: "#form-report",
			btnShowReport 	: "#btn-show-report",
			inputDateForm	: "#date-from-hidden",
			inputDateTo 	: "#date-to-hidden",
			btnExportPDF	: "#btn-export-pdf",
			btnExportExcel  : "#btn-export-excel",		
			flagExportPdf   : 1,
			flagExportExcel : 2,
		},
		init: function(obj){
			$.extend(true, this.property, obj);
			this.property.dataForm 		= $(this.property.dataForm);
			this.property.btnShowReport = $(this.property.btnShowReport);
			this.property.inputDateTo	= $(this.property.inputDateTo);
			this.property.inputDateForm = $(this.property.inputDateForm);
			this.property.btnExportPDF 	= $(this.property.btnExportPDF);
			this.property.btnExportExcel = $(this.property.btnExportExcel);

			this.getEvent();
			this.getReport();
		},
		getEvent : function(){
			var that = this;
			//show report
			this.property.btnShowReport.click(function(event) {
				validate=that.validateReport();
				if(validate==false) return;
				$("#flag-export").val(0);
				that.getReport();
			});
			//export Excel
			this.property.btnExportExcel.click(function(event) {
				validate=that.validateReport();
				if(validate==false) return;
				$("#flag-export").val(that.property.flagExportExcel);
				that.getExport();
			});

			//export pdf
			this.property.btnExportPDF.click(function(event) {
				validate=that.validateReport();
				if(validate==false) return;
				$("#flag-export").val(that.property.flagExportPdf);
				that.getExport();
			});
		},
		validateReport : function(){
			var that=this;
			dateFrom=that.property.inputDateForm.val();
			dateTo=that.property.inputDateTo.val();
			if(dateFrom==""){
				alert("{{trans('backend::publisher/text.date_from_requied')}}");
				return false;
			}
			if(dateTo==""){
				alert("{{trans('backend::publisher/text.date_to_requied')}}");
				return false;
			}
			
			dateFrom=that.fromatDate(that.dateReplace(dateFrom));
			dateTo=that.fromatDate(that.dateReplace(dateTo));
			
			if(Date.parse(dateFrom) > Date.parse(dateTo)){
				alert("{{trans('backend::publisher/text.date_from_larger_date_to')}}");
				return false;	
			}
		},
		dateReplace : function(date){
			date=date.replace('-',',');
			date=date.replace('-',',');
			return date;
		},
		fromatDate : function(date){
			return new Date(date);
		},
		getReport : function(){
			var that = this;	    		
			var flag=false;
			if(flag==false){
				$("#loading").show();
				$.post("{{ URL::to(Route($moduleRoutePrefix.'GetReport')) }}",
					that.property.dataForm.serialize()
				,function(data){
					$("#loading").hide();
					flag=true;
					if(data.status==1){
						//chart area
						options.series 				= data.series;
						options.xAxis.categories 	= data.xAxis;
						options.title.text 			= data.titleText;
		        		var chart = new Highcharts.Chart(options);

		        		//show html table
		        		$(".wrap-table").html(data.htmlTable);
		        		
		        	}else{
		        		$("#show-chart-area").html('{{trans("backend::publisher/text.no_data")}}');
		        		$(".wrap-table").html('{{trans("backend::publisher/text.no_data")}}');
		        	}
				},'JSON');
			}
		},
		getExport : function(){
			var that = this;	    		
			var flag=false;
			if(flag==false){
				$("#loading").show();
				url="{{ URL::to(Route($moduleRoutePrefix.'GetExport')) }}";
				$.post(url,
					that.property.dataForm.serialize()
				,function(data){
					$("#loading").hide();
					flag=true;
					if(data==1) location.href='{{ URL::to(Route("ExportExcelPublishergetExportExcel")) }}';
					else if(data==2) location.href='{{ URL::to(Route($moduleRoutePrefix."getExportPDF")) }}';
					else alert('{{trans("backend::publisher/text.alert_export")}}');
					
				},'JSON');
			}
		}
		////////
	}

	//get report
	report.init();
////////////////		
    $('#date-from-hidden').datepicker({
	    format: "dd-M-yyyy",
	    multidate: false,
	    forceParse: false,
	    autoclose: true,
	    todayHighlight: true	    
	});
	$("#date-to-hidden").datepicker({
	    format: "dd-M-yyyy",
	    multidate: false,
	    forceParse: false,
	    autoclose: true,
	    todayHighlight: true	    
	});
	
	
    $(".custome-zone").click(function(event) {
    	/* Act on the event */
    	var vl=$(this).val();    	
    	if(vl==1){    		
    		$(".show-custome-zone").removeClass('hidden');
    		$(".show-custome-zone").addClass('show');	
    	}else{
    		$(".show-custome-zone").addClass('hidden');
    		$(".show-custome-zone").removeClass('show');	
    	}    	
    });

    $(".ul-zone-all li a").click(function(event) {
    	/* Act on the event */
    	$(this).parent().find("ul").toggle('300');
    });
    $(".ul-zone-all li input").click(function(event) {
    	/* Act on the event */
    	if($(this).is(':checked')){
    		$(this).parent().find('ul li input').each(function(index, el) {
	    		$(this).prop('checked', true);
	    	});
    	}else{
    		$(this).parent().find('ul li input').each(function(index, el) {
	    		$(this).prop('checked', false);
	    	});
    	}
    	
    });
     $(".ul-zone-all li ul li input").click(function(event) {
    	/* Act on the event */
    	if($(this).is(':checked')){
    		$(this).parent().parent().parent().find('.parent_input').each(function(index, el) {
	    		$(this).prop('checked', true);
	    	});
    	}else{
    		$(this).parent().parent().parent().find('.parent_input').each(function(index, el) {
	    		$(this).prop('checked', false);
	    	});
    	}
    	
    });
    //click
    $(".dropdown-menu li a").click(function(event) {
    	/* Act on the event */
    	var aText=$(this).html();
    	var vl =$(this).attr('data-id');
    	$(this).parent().parent().parent().find('#dropdown-earning').html(aText);
    	$(this).parent().parent().parent().find('#dropdown-cost_type').html(aText);

    	$(this).parent().parent().parent().find('#show-earnings').val(vl);
    	$(this).parent().parent().parent().find('#show-cost-type').val(vl);
    });
});

</script>
{{ Form::open(['role'=>'form','method'=>'post','id'=>'form-report'])}}
<div class="row">
	<div class="col-sm-12">
		<div class="header-support">
			<div class="pull-right">				
				{{trans('backend::publisher/text.showing')}} 
				<div class="dropdown dropdown-earning-w">
					<a href="javascript:;" id="dropdown-earning" data-toggle="dropdown">{{trans('backend::publisher/text.earnings_e')}}</a>
					<ul class="dropdown-menu" role="menu" aria-labelledby="dropdown-earning">
						<li><a data-id="1" role="menuitem" tabindex="-1" href="javascript:;">{{trans('backend::publisher/text.impressions')}}</a></li>
    					<li><a data-id="2" role="menuitem" tabindex="-1" href="javascript:;">{{trans('backend::publisher/text.clicks')}}</a></li>
    					<li><a data-id="3" role="menuitem" tabindex="-1" href="javascript:;">eCPM</a></li>
    					<li><a data-id="4" role="menuitem" tabindex="-1" href="javascript:;">eCPC</a></li>
    					<li><a data-id="5" role="menuitem" tabindex="-1" href="javascript:;">{{trans('backend::publisher/text.earnings_e')}}</a></li>
					</ul>
					<input type="hidden" name="show-earnings" id="show-earnings" value="5" />
				</div> {{trans('backend::publisher/text.report_for')}} 
				<div class="dropdown dropdown-cost_type-w"> 
					<a href="javascript:;" id="dropdown-cost_type" data-toggle="dropdown">{{trans('backend::publisher/text.all_cost_type')}}</a>
					<ul class="dropdown-menu" role="menu" aria-labelledby="dropdown-cost_type">
						<li><a role="menuitem" tabindex="-1" href="javascript:;">{{trans('backend::publisher/text.all_cost_type')}}</a></li>
    					<li><a data-id="cpm" role="menuitem" tabindex="-1" href="javascript:;">CPM</a></li>
    					<li><a data-id="cpc" role="menuitem" tabindex="-1" href="javascript:;">CPC</a></li>
					</ul>
					<input type="hidden" name="show-cost-type" id="show-cost-type" value="0" />
				</div> 
				{{trans('backend::publisher/text.from')}} <a id="date-from" href="javascript:;"><input type="text" id="date-from-hidden" name="date-from-hidden" value="{{ $dateFrom }}" placeholder=""></a> 
				
				{{trans('backend::publisher/text.to')}} <a id="date-to" href="javascript:;"><input type="text" id="date-to-hidden" name="date-to-hidden" value="{{ $dateTo }}" placeholder=""></a> 				
				<a href="javascript:;" data-toggle="modal" data-target="#modal-show-zone">{{trans('backend::publisher/text.show_all_zone')}}</a>						
				<div class="modal fade" id="modal-show-zone" aria-labledby="#modal-title-zone" tabindex="-1" aria-hidden="true" role="dialog">
					<div class="modal-dialog modal-sm">
						<div class="modal-content">
							<div class="modal-header modal-header-zone">
								<button type="button" class="close" data-dismiss="modal">
									<span aria-hidden="true">&times;</span>
									<span class="sr-only">Close</span>									
								</button>								
							</div>
							<div class="modal-body">
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<input type="radio" id="" @if(!isset($idSite)) checked @endif class="custome-zone" name="flag-zone" value="0">
											{{trans('backend::publisher/text.show_all_zone')}}
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<input type="radio" @if(isset($idSite)) checked @endif id="" class="custome-zone" name="flag-zone" value="1">
											{{trans('backend::publisher/text.custom_zones')}}
										</div>										
									</div>
									<div class="clearfix"></div>

								</div>	
							</div>
							<div class="modal-footer">
        						<button type="button" class="btn btn-primary" data-dismiss="modal">{{trans('backend::publisher/text.done')}}</button>
							</div>
						</div>
					</div>
				</div>
				<input type="hidden" name="flag-export" id="flag-export" value="0">
				<button type="button" class="btn btn-primary" id="btn-show-report">{{trans('backend::publisher/text.display_report')}}</button>
				<button type="button" class="btn btn-default btn-file-pdf" id="btn-export-pdf"><i class="fa fa-file-pdf-o"></i> {{trans('backend::publisher/text.export_PDF')}}</button>
				<button type="button" class="btn btn-default btn-file-excel" id="btn-export-excel"><i class="fa fa-file-excel-o"></i> {{trans('backend::publisher/text.export_EXECL')}}</button>							
			</div>
			<div class="clearfix"></div>
		</div>
	</div>	
	<div class="col-sm-12">		
		<div id="show-chart-area"></div>
	</div>	
</div>
{{ Form::close() }}
<div class="row">
	<div class="col-sm-12">
		<div class="alert alert-info" style="margin:20px 0 0;">{{trans('backend::publisher/text.note_report_publisher')}}</div>
	</div>
</div>


<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-body table-responsive">
		        <div class="wrap-table">
			
				</div>				      
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
</div>
 