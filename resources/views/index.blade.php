@include('header_script')
@include('header_bar')
@include('side_bar')
@include('flash-message')

<body id="app-container" class="menu-default show-spinner">
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Dashboard</h1>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="#">Home</a>
                            </li>
                        </ol>
                    </nav>
                    <div class="separator mb-5"></div>
                </div>

                <div class="col-lg-12 col-xl-6">
                    <div class="icon-cards-row">
                        <div class="owl-container">
                            <div class="owl-carousel dashboard-numbers">
                                <a href="#" class="card">
                                    <div class="card-body text-center">
                                        <i class="iconsmind-User"></i>
                                        <p class="card-text mb-0"><b>Total Players</b></p>
                                        <p class="lead text-center">{{ count($players) }}</p>
                                    </div>
                                </a>

                                <a href="#" class="card">
                                    <div class="card-body text-center">
                                        <i class="iconsmind-Basket-Coins"></i>
                                        <p class="card-text mb-0"><b>Today's New Players</b></p>
                                        <p class="lead text-center">3</p>
                                    </div>
                                </a>

                                <a href="#" class="card">
                                    <div class="card-body text-center">
                                        <i class="iconsmind-Arrow-Refresh"></i>
                                        <p class="card-text mb-0"><b>Income</b></p>
                                        <p class="lead text-center">{{ $gross_income }}</p>
                                    </div>
                                </a>

                                <a href="#" class="card">
                                    <div class="card-body text-center">
                                        <i class="iconsmind-Mail-Read"></i>
                                        <p class="card-text mb-0"><b>Net Income</b></p>
                                        <p class="lead text-center">{{ $net_income }}</p>
                                    </div>
                                </a>

                                <a href="#" class="card">
                                    <div class="card-body text-center">
                                        <i class="iconsmind-Mail-Read"></i>
                                        <p class="card-text mb-0"><b>Number of Tournaments</b></p>
                                        <p class="lead text-center">{{ count($tournments) }}</p>
                                    </div>
                                </a>

                                <a href="#" class="card">
                                    <div class="card-body text-center">
                                        <i class="iconsmind-Mail-Read"></i>
                                        <p class="card-text mb-0"><b>Withdraw Requests</b></p>
                                        <p class="lead text-center">{{ $withdraw_request }}</p>
                                    </div>
                                </a>

                                <a href="#" class="card">
                                    <div class="card-body text-center">
                                        <i class="iconsmind-Mail-Read"></i>
                                        <p class="card-text mb-0"><b>Support Requests</b></p>
                                        <p class="lead text-center">{{ $support }}</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Tournaments</h5>
                                    <div class="scroll dashboard-list-with-user">
                                        @foreach ($tournments as $tournament)
                                            <div class="d-flex flex-row mb-3 pb-3 border-bottom">
                                                <a href="#">
                                                    <img src="{{ asset('img/no_image.png') }}" alt="Profile Picture"
                                                        class="img-thumbnail border-0 rounded-circle list-thumbnail align-self-center xsmall" />
                                                </a>
                                                <div class="pl-3 pr-2">
                                                    <a href="#">
                                                        <p class="font-weight-medium mb-0">
                                                            {{ $tournament->tournament_name }}
                                                        </p>
                                                        <p class="text-muted mb-0 text-small">
                                                            {{ \Carbon\Carbon::parse($tournament->created_at)->format('F j, Y') }}
                                                        </p>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-lg-12 mb-4">
                    <div class="card">
                        <div class="position-absolute card-top-buttons">
                            <button class="btn btn-header-light icon-button">
                                <i class="simple-icon-refresh"></i>
                            </button>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title">Recent Players</h5>
                            <div class="scroll dashboard-list-with-thumbs">
                                @foreach ($latest_players as $player)
                                    <div class="d-flex flex-row mb-3">
                                        <a class="d-block position-relative" href="#">
                                            <img src="{{ $player->player_details['profile_image'] ? asset('/player/images/' . $player->player_details['profile_image']) : asset('img/no_image.png') }}"
                                                alt="Player Image" class="list-thumbnail border-0" />
                                            <span
                                                class="badge badge-pill badge-theme-2 position-absolute badge-top-right">NEW</span>
                                        </a>
                                        <div class="pl-3 pt-2 pr-2 pb-2">
                                            <a href="#">
                                                <p class="list-item-heading">{{ $player->first_name }}
                                                    {{ $player->last_name }}
                                                </p>
                                                <div class="pr-4 d-none d-sm-block">
                                                    <p class="text-muted mb-1 text-small">
                                                        PlayerID: {{ optional($player->player_details)->user_id ?? 'N/A' }}
                                                    </p>
                                                    <p class="text-muted mb-1 text-small">
                                                        Refer Code:
                                                        {{ optional($player->player_details)->refer_code ?? 'N/A' }}
                                                    </p>

                                                </div>
                                                <div class="text-primary text-small font-weight-medium d-none d-sm-block">
                                                    {{ \Carbon\Carbon::parse($player->created_at)->format('F j, Y') }}
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

@include('footer')

<style>
    img {
        border-radius: 50% !important;
    }
</style>