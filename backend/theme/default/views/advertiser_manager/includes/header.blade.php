<div class="wrapper-nav">
<nav id="navbar-top" class="navbar navbar-default blue-gradient" role="navigation">
    <!-- <div class="container"> -->
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ URL::Route('AdvertiserManagerDashboard') }}">Yomedia</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="container">
            <div class="row">
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav nav-pills">
                        <li class="{{ isMenuActive('AdvertiserManagerDashboard') }}">
                            <a href="{{ URL::Route('AdvertiserManagerDashboard') }}">Dashboard</a>
                        </li>
                        <li class="{{ isMenuActive('CampaignAdvertiserManagerShowList') }}">
                            <a href="{{ URL::Route('CampaignAdvertiserManagerShowList') }}">Campaign</a>
                        </li>
                        <li class="{{ isMenuActive('FlightAdvertiserManagerShowList') }}">
                            <a href="{{ URL::Route('FlightAdvertiserManagerShowList') }}">Flight</a>
                        </li>
                        <li class="{{ isMenuActive('ConversionAdvertiserManagerShowList') }}">
                            <a href="{{ URL::Route('ConversionAdvertiserManagerShowList', 'all') }}">Conversion</a>
                        </li>
                        <li class="{{ isMenuActive('AdAdvertiserManagerShowList') }}">
                            <a href="{{ URL::Route('AdAdvertiserManagerShowList') }}">Ad</a>
                        </li>
                        <li class="{{ isMenuActive('PublisherAdvertiserManagerShowList') }}">
                            <a href="{{ URL::Route('PublisherAdvertiserManagerShowList') }}">Publisher</a>
                        </li>
                        <li class="{{ isMenuActive('ToolAdvertiserManagerShowTool') }}">
                            <a href="{{ URL::Route('ToolAdvertiserManagerShowTool') }}">Tool</a>
                        </li>
                        <li>
                            <a href="{{ URL::Route('AdvertiserManagerLogout') }}">Logout</a>
                        </li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        <li id="loading" style="display: none;"><img src="{{$assetURL}}img/loading.gif"></li>
                    </ul>            
                </div>
            </div>
        </div>
        <!-- /.navbar-collapse -->
    <!-- </div> -->
    <!-- /.container-fluid -->
</nav>
</div>