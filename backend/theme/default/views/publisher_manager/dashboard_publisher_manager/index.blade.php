<!-- chart -->
{{ HTML::style("{$assetURL}css/chart/morris-0.5.1.css") }}
{{ HTML::script("{$assetURL}js/chart/raphael-min.js") }}
{{ HTML::script("{$assetURL}js/chart/morris-0.5.1.min.js") }}

<script type="text/javascript">
$(function(){		
	Morris.Area({
	  element: 'show-chart-area',
	  data: [
	    { y: '2006', a: 40},
	    { y: '2007', a: 75},
	    { y: '2008', a: 50},
	    { y: '2009', a: 75},
	    { y: '2010', a: 50},
	    { y: '2011', a: 75},
	    { y: '2012', a: 100}
	  ],
	  xkey: 'y',
	  ykeys: ['a'],
	  resize : true,
	  labels: ['Series A']
	});

	//bieu do bar
	Morris.Bar({
        element: 'show-chart-bar',
        data: [{
            device: 'iPhone',
            geekbench: 136
        }, {
            device: 'iPhone 3G',
            geekbench: 137
        }, {
            device: 'iPhone 3GS',
            geekbench: 275
        }, {
            device: 'iPhone 4',
            geekbench: 380
        }, {
            device: 'iPhone 4S',
            geekbench: 655
        }, {
            device: 'iPhone 5',
            geekbench: 1571
        }],
        xkey: 'device',
        ykeys: ['geekbench'],
        labels: ['Geekbench'],
        barRatio: 0.4,
        xLabelAngle: 35,
        hideHover: 'auto',
        resize: true
    });

	var flag=false;
	if(flag==false){
		$("#loading").show();
		$.post('{{ URL::Route("PublisherManagershowListDashboard") }}', {
	    	param1: 'value1'
	    }, function(data) {
	    	/*optional stuff to do after success */
	    	if(data){
	    		flag=true;
	    		$("#loading").hide();
	    		$(".show-table-dash").html(data);
	    	}
	    }); 
	}
       
});

</script>

<div class="row header-dashboard">
	<div class="col-sm-12">
		<div class="alert alert-info">
			Setup your own <span class="badge">Aternate Ad</span> to maximize the earnings.
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-4">
		<div class="box-dash">
			<p>Today's Earnings</p>
			<div class="price text-right"><strong>9,989.54</strong> <ins>đ</ins></div>
		</div>
	</div>
	<div class="col-sm-4">
		<div class="box-dash">
			<p>Earnings This Month</p>
			<div class="price text-right"><strong>3,899,349.23</strong> <ins>đ</ins></div>
		</div>
	</div>
	<div class="col-sm-4">
		<div class="box-dash">
			<p>Earnings Last Month</p>
			<div class="price text-right"><strong>12,649,919.11</strong> <ins>đ</ins></div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-6">
		<div class="text-title"><p class="text-center">Earnings Performance for past 30 days</p></div>		
		<div id="show-chart-area"></div>	
	</div>	
	<div class="col-sm-6">
		<div class="text-title"><p class="text-center">Earnings Performance for past 3 months</p></div>
		<div id="show-chart-bar"></div>	
	</div>
</div>
<div class="row">	
	<div class="col-sm-12">
		<h3 class="h3-title">Todays Earnings</h3>
		<div class="show-table-dash">
			
		</div>
	</div>
</div>