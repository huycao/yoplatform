<div class="row mb12">
    <div class="col-sm-4">
        <div class="part">
            <p>Today's Earnings</p>
            <div class="price text-right"><strong><?= number_format($earnToday); ?></strong> <ins>đ</ins></div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="part">
            <p>Earnings This Month</p>
            <div class="price text-right"><strong><?= number_format($earnThisMonth); ?></strong> <ins>đ</ins></div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="part">
            <p>Earnings Last Month</p>
            <div class="price text-right"><strong><?= number_format($earnLastMonth); ?></strong> <ins>đ</ins></div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div id="show-chart-past30" class="box"></div>    
    </div>  
    <div class="col-sm-6">
        <div id="show-chart-past3month" class="box"></div> 
    </div>
</div>

 
<!-- chart -->
{{ HTML::script("{$assetURL}js/chart/highcharts.js") }}

<script type="text/javascript">
    $(function () {
        $('#show-chart-past30').highcharts({
            chart: {
                type: 'area'
            },
            title: {
                text: 'Earnings Performance for past 30 days'
            },
            subtitle: {
                text: 'Source: <a href="">' + 'yomedia.vn</a>'
            },
            xAxis: {
                labels:{align:'center',rotation:300,y:40},
                categories: {{$earnPast30['date']}}
            },
            yAxis: {
                title: {
                    text: 'Earnings (đ)'
                }
            },
            credits: {
                enabled: false
            },
            series: [{
                    name: 'Earnings',
                    data: {{$earnPast30['earn']}}
                }]
        });

    });

    $('#show-chart-past3month').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Earnings Performance for past 3 months'
        },
        xAxis: {
            categories: {{$earnPast3Month['month']}}
        },
        yAxis: {
            title: {
                text: 'Earnings (đ)'
            }
        },
        credits: {
            enabled: false
        },
        series: [{
                name: 'Earnings',
                data: {{$earnPast3Month['earn']}}
            }
        ]
    });


</script> 