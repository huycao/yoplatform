<div class="wrapper-nav">
<nav id="navbar-top" class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ URL::Route('AdminDashboard') }}">Yomedia</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="container">
        <div class="row">
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav nav-pills">
                <li class="{{isMenuActive('AdminDashboard')}}">
                    <a href="{{ URL::Route('AdminDashboard') }}">Dashboard</a>
                </li>
                <li class="{{isMenuActive('UserAdminShowList')}}">
                    <a href="{{ URL::Route('UserAdminShowList') }}">User</a>
                </li>
                <li class="{{isMenuActive('UserGroupAdminShowList')}}">
                    <a href="{{ URL::Route('UserGroupAdminShowList') }}">Group</a>
                </li>
                <li class="{{isMenuActive('AdFormatAdminShowList')}}">
                    <a href="{{ URL::Route('AdFormatAdminShowList') }}">Ad Format</a>
                </li>
                <li class="{{isMenuActive('ModulesAdminShowList')}}">
                    <a href="{{ URL::Route('ModulesAdminShowList') }}">Modules</a>
                </li>
                <li>
                    <a href="{{ URL::Route('AdminLogout') }}">Logout</a>
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