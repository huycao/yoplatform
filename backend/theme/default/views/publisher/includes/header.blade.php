<div class="wrapper-nav">
<nav id="navbar-top" class="navbar navbar-default blue-gradient" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ URL::Route('PublisherDashboard') }}">Yomedia</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="container">

            <div class="row">
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav nav-pills">

                        <li class="{{ isMenuActive('PublisherDashboard') }}">
                            <a href="{{ URL::Route('PublisherDashboard') }}">Dashboard</a>
                        </li>

                        <li class="{{ isMenuActive('ReportPublisherShowList') }}">
                            <a href="{{URL::Route('ReportPublisherShowList')}}">Report</a>
                        </li>

                        <li class="{{ isMenuActive('ToolsPublisherRequestPayment') }}">
                            <a href="{{URL::Route('ToolsPublisherRequestPayment')}}">Payment</a>
                        </li>
 
                        <li class="{{ isMenuActive('ToolsPublisherProfile') }}">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Tools <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li class="{{ isMenuActive('ToolsPublisherProfile') }}"><a href="{{URL::Route('ToolsPublisherProfile')}}">My Account</a></li>
                            </ul>
                        </li>
                       
                        <li>
                            <a href="{{ URL::Route('PublisherLogout') }}">Logout</a>
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