<div class="sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li class="active">
                <a href="#"><i class="fa fa-location-arrow"></i> Quick link<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{URL::Route('ConversionAdvertiserManagerShowCreate', Request::segment(4))}}">New Conversion</a>
                    </li>
                    <li>
                        <a href="{{URL::Route('ConversionAdvertiserManagerShowList', Request::segment(4))}}">View Conversion</a>
                    </li>
                    <li>
                        <a href="{{URL::Route('ConversionAdvertiserManagerShowUpdate', [Request::segment(4), Request::segment(6)])}}">Edit Conversion</a>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
</div>
