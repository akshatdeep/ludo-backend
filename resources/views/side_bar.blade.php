    <div class="sidebar">
        <div class="main-menu">
            <div class="scroll">
                <ul class="list-unstyled">
                    <li class="active">
                    <a href="{{route('admin.dashboard')}}">
                            <i class="iconsmind-Shop-4"></i>
                            <span>Dashboards</span>
                        </a>
                    </li>
                    <li>
                        <a href="#layouts">
                            <i class="iconsmind-Digital-Drawing"></i> Players
                        </a>
                    </li>
                    <li>
                        <a href="#applications">
                            <i class="iconsmind-Air-Balloon"></i> Tournaments
                        </a>
                    </li>
                    <li>
                        <a href="#ui">
                            <i class="iconsmind-Pantone"></i> Banners
                        </a>
                    </li>
                    <li>
                        <a href="#landingPage">
                            <i class="iconsmind-Space-Needle"></i> Wallet
                        </a>
                    </li>
                    <li>
                        <a href="#menu">
                            <i class="iconsmind-Three-ArrowFork"></i> Support
                        </a>
                    </li>
                    <li>
                        <a href="#report">
                            <i class="simple-icon-pie-chart"></i> Reports
                        </a>
                    </li>
                    
                </ul>
            </div>
        </div>

        <div class="sub-menu">
            <div class="scroll">
                

                <ul class="list-unstyled" data-link="layouts">
                    <li>
                        <a href="{{url('/player/list')}}">
                            <i class="simple-icon-credit-card"></i> Players List
                        </a>
                    </li>
                   
                </ul>
                <ul class="list-unstyled" data-link="applications">
                    <li>
                        <a href="{{url('/tournament/list')}}">
                            <i class="simple-icon-picture"></i> Tournaments List
                        </a>
                    </li>
                    <li>
                        <a href="{{url('/tournament/create')}}">
                            <i class="simple-icon-check"></i> Create Tournament
                        </a>
                    </li>
                </ul>
                <ul class="list-unstyled" data-link="ui">
                    <li>
                        <a href="{{url('/banner/list')}}">
                            <i class="simple-icon-bell"></i> Banners List
                        </a>
                    </li>
                    <li>
                        <a href="{{url('/banner/create')}}">
                            <i class="simple-icon-badge"></i> Create Banner
                        </a>
                    </li>
                </ul>
                <ul class="list-unstyled" data-link="landingPage">
                    <li>
                        <a href="{{url('/wallet/withdraw/list')}}">
                            <i class="simple-icon-docs"></i> Withdraw List
                        </a>
                    </li>
                    <li>
                        <a href="{{url('/wallet/showPage')}}">
                            <i class="simple-icon-docs"></i> Add / Deduct Amount
                        </a>
                    </li>
                </ul>

                <ul class="list-unstyled" data-link="menu">
                    <li>
                        <a href="{{url('/support/request/list')}}">
                            <i class="simple-icon-control-pause"></i> Support List
                        </a>
                    </li>
                    <li>
                        <a href="{{url('/boat_control/list')}}">
                            <i class="simple-icon-control-pause"></i> Boat Control
                        </a>
                    </li>
                    <li>
                        <a  href="{{url('/version_control/list')}}">
                            <i class="simple-icon-control-pause"></i> Version Control
                        </a>
                    </li>
                </ul>
                <ul class="list-unstyled" data-link="report">
                    <li>
                        <a href="{{url('/report/players')}}">
                            <i class="simple-icon-control-pause"></i> Player Detail Report
                        </a>
                    </li>
                    <li>
                        <a href="{{url('/report/bannedPlayers')}}">
                            <i class="simple-icon-control-pause"></i> Banned Players Report
                        </a>
                    </li>
                    <li>
                        <a href="{{route('report.support')}}">
                            <i class="simple-icon-control-pause"></i> Supports
                        </a>
                    </li>
                     <li>
                        <a href="{{route('report.activity')}}">
                            <i class="simple-icon-control-pause"></i> All Transactions
                        </a>
                    </li>
                     <li>
                        <a href="{{route('report.recharge')}}">
                            <i class="simple-icon-control-pause"></i> Recharge Transactions
                        </a>
                    </li>
                    <li>
                        <a href="{{route('report.approvedwithdraw')}}">
                            <i class="simple-icon-control-pause"></i> Approved Withdraw
                        </a>
                    </li>
                    <li>
                        <a href="{{route('report.rejectedwithdraw')}}">
                            <i class="simple-icon-control-pause"></i> Rejected Withdraw
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
