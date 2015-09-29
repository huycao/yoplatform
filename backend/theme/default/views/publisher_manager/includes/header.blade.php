<div class="wrapper-nav">
<nav id="navbar-top" class="navbar navbar-default blue-gradient" role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ URL::Route('PublisherManagerDashboard') }}">Yomedia</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="container">
        <div class="row">
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav nav-pills">
                <li class="{{ isMenuActive('PublisherManagerDashboard') }}">
                    <a href="{{ URL::Route('PublisherManagerDashboard') }}">Dashboard</a>
                </li>
                <li class="{{ isMenuActive('ApprovePublisherManagerShowList') }}">
                    <a href="{{URL::Route('ApprovePublisherManagerShowList')}}">Publisher</a>
                </li>
                <li class="{{ isMenuActive('ReportPublisherManagerShowList') }}">
                    <a href="{{URL::Route('ReportPublisherManagerShowList')}}">Report</a>
                </li>
                <li class="{{ isMenuActive('CampaignPublisherManagerShowList') }}">
                    <a href="{{URL::Route('CampaignPublisherManagerShowList')}}">Manage Campaign</a>
                </li>
                <li class="{{ isMenuActive('AdZonePublisherManagerShowList') }}">
                    <a href="{{URL::Route('AdZonePublisherManagerShowList')}}">Manage Ad</a>
                </li>
                <li>
                    <a href="#">Payment</a>
                </li>                               
                <li class="">
                    <a href="{{URL::Route('ApprovePublisherManagerProfile')}}">My Account</a>
                </li>
                <li>
                    <a href="#">Support</a>
                </li>
                 <li>
                    <a href="#">Tools</a>
                </li>
                <li>
                    <a href="{{ URL::Route('PublisherManagerLogout') }}">Logout</a>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li id="loading" style="display: none;"><img src="{{$assetURL}}img/loading.gif"></li>
            </ul>            
        </div>
        </div>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>
</div>