<!-- chart -->

{{ HTML::script("{$assetURL}js/chart/highcharts.js") }}


<script type="text/javascript">
	$(function () {
		//chart line
		var options = {
	        chart: {
	            renderTo: 'show-chart-area',
	            type: 'line'
	        },
	        title: {
	            text: 'Application statistic'
	        },
	        xAxis: {
	            categories: [],
	        },
	        yAxis: {
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
	    //chart pie
		// Radialize the colors
	    Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {
	        return {
	            radialGradient: { cx: 0.5, cy: 0.3, r: 0.7 },
	            stops: [
	                [0, color],
	                [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
	            ]
	        };
	    });
	    var optionPie={
	    	chart: {
	    		renderTo: '',
	        	type: 'pie',
	            plotBackgroundColor: null,
	            plotBorderWidth: null,
	            plotShadow: false
	        },
	        title: {
	            text: ''
	        },
	        tooltip: {
	            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
	        },
	        plotOptions: {
	            pie: {
	                allowPointSelect: true,
	                cursor: 'pointer',
	                dataLabels: {
	                    enabled: true,
	                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
	                    style: {
	                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
	                    },
	                    connectorColor: 'silver'
	                }
	            }
	        },
	        credits: {
		      	enabled: false
		  	},
	        series: [{}]
	    }
	    
	    //get ajax report
	    var report = {
	    	property : {
	    		showReportLine  : "#show-chart-area",
	    		displayReport   : "#display-report",
	    		showReport 		: ".show-report",
	    		selectMonthly 	: "#select-monthly",
	    		valueSelectMonthly : "",
	    		showTable		: ".wrap-table",
	    		renderPie       : "app-status",
	    		renderPie2      : "new-publisher",
	    		valueShowReport : 0
	    	},
	    	init : function(obj){
	    		$.extend(true, this.property, obj);
	    		this.property.showReportLine 	= $(this.property.showReportLine);
	    		this.property.displayReport 	= $(this.property.displayReport);
	    		this.property.showReport 		= $(this.property.showReport);
	    		this.property.selectMonthly 	= $(this.property.selectMonthly);
	    		this.property.valueShowReport	= this.property.showReport.val();
	    		this.property.valueSelectMonthly= this.property.selectMonthly.val();
	    		this.property.showTable			= $(this.property.showTable);
	    		this.property.renderPie 		= this.property.renderPie;
	    		this.property.renderPie2 		= this.property.renderPie2;

	    		this.addEvent();
	    		this.getReport();
	    	},
	    	addEvent : function(){
	    		var that = this;
	    		this.property.displayReport.click(function(e) {
	    			e.preventDefault();
	    			that.property.showReport.each(function(){
	    				if($(this).is(":checked")){
	    					val = $(this).val();
	    				}
	    			});
	    			that.property.valueShowReport=val;

	    			if(that.property.valueShowReport !=1){
	    				that.property.valueSelectMonthly = that.property.selectMonthly.val();
	    				if(that.property.valueSelectMonthly == ""){
	    					alert('Please choose show monthly');
	    					return false;
	    				}
	    			}
	    			that.getReport();
	    			
	    		});
	    	},
	    	getReport : function(){
	    		var that = this;	    		
    			var flag=false;
				if(flag==false){
					$("#loading").show();
					$.post("{{URL::to(Route('ApproveReportPublisherManagerGetReport'))}}",{
						flagreport : that.property.valueShowReport,
						monthly    : that.property.selectMonthly.val()
					},function(data){
						$("#loading").hide();
						flag=true;
						if(data.status==1){
							//chart line
							options.series 				= data.series;
							options.xAxis.categories 	= data.xAxis;
			        		var chart = new Highcharts.Chart(options);
			        		//chart pie
			        		optionPie.series 			= data.chartpie;
			        		optionPie.chart.renderTo	= that.property.renderPie;
			        		optionPie.title.text 		= data.textPie;
			        		var chartPie= new Highcharts.Chart(optionPie);
			        		//chart pie 2
			        		optionPie.series 			= data.chartpie2;
			        		optionPie.chart.renderTo 	= that.property.renderPie2;
			        		optionPie.title.text 		= data.textPie2;
			        		var chartPie2= new Highcharts.Chart(optionPie);
			        		//show approved
			        		that.property.showTable.html(data.htmlApprove);
			        	}else{
			        		that.property.showReportLine.html('{{trans("backend::publisher/text.no_data")}}');
			        		$("#"+that.property.renderPie).html('{{trans("backend::publisher/text.no_data")}}');
			        		$("#"+that.property.renderPie2).html('{{trans("backend::publisher/text.no_data")}}');
			        		that.property.showTable.html('{{trans("backend::publisher/text.no_data")}}');
			        	}
					},'JSON');
				}
	    	}
	    }

	    // get report
	    report.init();
		
});
</script>

<form class="filter-form form-horizontal" role="form">


<div class="row">
	<div class="col-sm-12">
		<div class="row">
			<div class="col-sm-4">
				<h3 class="title-view-publisher text-uppercase">Application statistic</h3>
			</div>	
			<div class="col-sm-8">
				<div class="pull-right">
					<input type="radio" checked name="show-report" class="show-report" value="1"> Show all (Last 12 Month before {{$monthDate}})
					<input type="radio" name="show-report" class="show-report" value="2"> Show Monthly
					<?php $M=getMonthBefore() ?>
					<select name="select-monthly" id="select-monthly" >
						<option value="">Choose...</option>
						@foreach($M as $key=>$value)
						<option value="{{$key}}">{{$value}}</option>
						@endforeach
					</select>
					
					<button type="button" id="display-report" class="btn btn-primary">Display Report</button>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>	
	<div class="col-sm-12">				
		<div id="show-chart-area" style="display:block;height:100%;width:100%;"></div>
	</div>
	<div class="clearfix"></div>
	<div class="col-sm-6">
		<h3 class="title-view-publisher text-uppercase">Application status</h3>
		<div id="app-status"></div>
	</div>
	<div class="col-sm-6">
		<h3 class="title-view-publisher text-uppercase">New publisher</h3>
		<div id="new-publisher"></div>
	</div>
</div>

</form>
<div class="row">
	<div class="col-sm-6">
		<h3 class="title-view-publisher text-uppercase">Approvers</h3>
		<div class="tab-content" id="myTabContent">
	        <div class="wrap-table">
		
			</div>				      
	    </div>
	</div>
</div>
<!-- <script type="text/javascript">
	$().ready(function(){
		pagination.init({
			url : "{{{ $defaultURL }}}get-list",
			defaultField : "{{{ $defaultField }}}",
			defaultOrder : "{{{ $defaultOrder }}}"
		});
	});
</script> -->