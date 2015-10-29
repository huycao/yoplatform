<nav id="navbar-top" class="navbar navbar-default nav-publisher" role="navigation">
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
        <?php
            $action=Request::segment(4);           
            $param1=Request::segment(5);

        ?>
        <div class="container">
        <div class="row">
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav nav-pills">                
                <li class="{{ isMenuActive('ApprovePublisherManagerShowList',$action,'active',$param1) }}">
                    <a href="{{URL::Route('ApprovePublisherManagerShowList')}}">{{trans('backend::publisher/text.publisher')}}</a>
                </li>
                <li class="{{ isMenuActive('ApproveReportPublisherManagerShowList',$action,'active',$param1) }}">
                    <a href="{{URL::Route('ApproveReportPublisherManagerShowList')}}">{{trans('backend::publisher/text.report')}}</a>
                </li>
                <li class="{{($action=='payment-request' || $action == 'payment-request-detail')?'active':''}}">
                    <a href="{{URL::to(Route('ApproveToolsPublisherManagerPaymentRequest',['request']))}}">Payment</a>
                </li>
                @if(($action!='payment-request' && $action != 'payment-request-detail'))
                    <li class="{{ isMenuActive('ApproveToolsPublisherManagerShowList',$action,'active',$param1) }}">
                @else
                    <li>
                @endif
                    <a href="{{URL::Route('ApproveToolsPublisherManagerShowList')}}">{{trans('backend::publisher/text.tools')}}</a>
                </li>
                 <li class="{{ isMenuActive('','ApproveToolsPublisherManagerProfile','active',$param1) }}">
                    <a href="{{URL::Route('ApproveToolsPublisherManagerProfile')}}">{{trans('backend::publisher/text.my_account')}}</a>
                </li>
                <li>
                    <a href="{{ URL::Route('PublisherManagerLogout') }}">{{trans('backend::publisher/text.logout')}}</a>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li id="loading" style="display: none;"><img src="{{$assetURL}}img/loading-publisher.gif"></li>
            </ul>            
        </div>
        </div>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>