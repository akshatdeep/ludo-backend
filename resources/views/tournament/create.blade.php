@include('header_script')
@include('header_bar')
@include('side_bar')
@include('flash-message')
<body id="app-container" class="menu-default show-spinner">
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Tournament</h1>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="#">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ url('tournament/list') }}">Tournament</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@if($action == 0) Create @else Edit @endif</li>
                        </ol>
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="mb-4">@if($action == 0) Create @else Edit @endif Tournament</h5>  
                            @if($action == 1)
                                <form class="form-horizontal" id="edit_tournamnet_form" method="post" action="{{ route('tournamentUpdate',$tournament->id) }}">
                            @else
                                <form class="form-horizontal" id="tournamnet_form" method="post" action="{{ route('tournamentSave') }}">
                            @endif
                            @csrf
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Tournament Name: </label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="tournament_name" placeholder="Tournament Name" autocomplete="off" value="{{ old('tournament_name') ?  old('tournament_name') : $tournament->tournament_name  }}">
                                        @error('tournament_name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Bet Amount: </label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="bet_amount" placeholder="Bet Amount" autocomplete="off" value="{{ old('bet_amount') ?  old('bet_amount') : $tournament->bet_amount  }}">
                                        {{-- <span class="input-group-text bg-primary text-white b-0"><i class="mdi mdi-currency-usd"></i></span> --}}
                                        @error('bet_amount')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Commission: </label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="commission" placeholder="Commission" autocomplete="off" value="{{ old('commission') ?  old('commission') : $tournament->commission  }}">
                                        @error('commission')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Players: </label>
                                    <div class="col-md-9">
                                        <select name="no_players" class="form-control player_select" id="{{($action == 1)? 'edit_branch_id' : ''}}">
                                            <option value="0" {{ ($action == 0)? 'selected' : (old('no_players') ? 'selected': ( ($tournament->no_players == '0') ? 'selected' : '' )) }}>Select the No Players</option>
                                            <option value="2" {{ old('no_players') ? 'selected': ( ($tournament->no_players == '2') ? 'selected' : '' ) }}> 2 Player</option>
                                            <option value="4" {{ old('no_players') ? 'selected': ( ($tournament->no_players == '4') ? 'selected' : '' ) }}> 4 Player</option>
                                        </select>
                                        @error('commission')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="form-group row two_win hide">
                                    <label class="col-md-3 col-form-label" style="float: left;">Winning Amount: </label>
                                    <div class="col-md-9" style="float: left;margin-bottom: 15px;">
                                        <input type="text" class="form-control" name="two_player_winning" placeholder="Winning Amount" autocomplete="off" value="{{ old('two_player_winning') ?  old('two_player_winning') : $tournament->two_player_winning  }}">
                                        @error('two_player_winning')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row four_win hide">
                                    <label class="col-md-3 col-form-label" style="float: left;">Winners Count: </label>
                                    <div class="col-md-9" style="float: left;margin-bottom: 15px;">
                                        <select name="no_of_winners" class="form-control winner_count" id="{{($action == 1)? 'edit_branch_id' : ''}}">
                                            <option value="0" {{ ($action == 0)? 'selected' : (old('no_of_winners') ? 'selected': ( ($tournament->no_of_winners == '0') ? 'selected' : '' )) }}> Please Select Winner</option>
                                            <option value="1" {{ old('no_of_winners') ? 'selected': ( ($tournament->no_of_winners == '1') ? 'selected' : '' ) }}> 1 Winner</option>
                                            <option value="2" {{ old('no_of_winners') ? 'selected': ( ($tournament->no_of_winners == '2') ? 'selected' : '' ) }}> 2 Winners</option>
                                            <option value="3" {{ old('no_of_winners') ? 'selected': ( ($tournament->no_of_winners == '3') ? 'selected' : '' ) }}> 3 Winners</option>
                                        </select>
                                        @error('commission')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row four_win_count four_win_1 hide">
                                    <label class="col-md-3 col-form-label" style="float: left;">Winning Amount 1st: </label>
                                    <div class="col-md-9" style="float: left;margin-bottom: 15px;">
                                        <input type="text" class="form-control" name="four_player_winning_1" placeholder="Winning Amount" autocomplete="off" value="{{ old('four_player_winning_1') ?  old('four_player_winning_1') : $tournament->four_player_winning_1  }}">
                                        @error('four_player_winning_1')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row four_win_count four_win_2 hide">
                                    <label class="col-md-3 col-form-label" style="float: left;">Winning Amount 2nd: </label>
                                    <div class="col-md-9" style="float: left;margin-bottom: 15px;">
                                        <input type="text" class="form-control" name="four_player_winning_2" placeholder="Winning Amount" autocomplete="off" value="{{ old('four_player_winning_2') ?  old('four_player_winning_2') : $tournament->four_player_winning_2  }}">
                                        @error('four_player_winning_2')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row four_win_count four_win_3 hide">
                                    <label class="col-md-3 col-form-label" style="float: left;">Winning Amount 3rd: </label>
                                    <div class="col-md-9" style="float: left;margin-bottom: 15px;">
                                        <input type="text" class="form-control" name="four_player_winning_3" placeholder="Winning Amount" autocomplete="off" value="{{ old('four_player_winning_3') ?  old('four_player_winning_3') : $tournament->four_player_winning_3  }}">
                                        @error('four_player_winning_3')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Tournament Time: </label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="tournament_interval" placeholder="Tournament Interval" autocomplete="off" value="{{ old('tournament_interval') ?  old('tournament_interval') : $tournament->tournament_interval  }}">
                                        @error('tournament_interval')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Tournament Status: </label>
                                    <div class="col-md-9">
                                        <input type="checkbox" name="status" class="status" value="1" {{ ($action == 1)? (($tournament->status == "1")? 'checked' : '') : 'checked'}}>
                                        
                                        @error('status')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-9">
                                    <button type="submit" class="btn btn-primary">Submit </button>
                                    <button type="reset" class="btn btn-default btn-outline">Reset</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>                
                </div>                        
            </div>  
    </main>                            
</body>         

@include('footer')
<script src="{{asset('js/jquery.validate.js')}}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>  

</head>
<style>
.hide{
    display:none;
}
</style>
<script>  
    jQuery(document).ready( function () {
        $('.player_select').change(function(){
            player_count = $(this).val()
            if(player_count == 2){
                $('.two_win').show()
                $('.four_win').hide()
                $('.four_win_count').hide();
            }
            if(player_count == 4){
                $('.four_win').show()
                $('.two_win').hide()
                
            }
        });
        $('.winner_count').change(function(){
            winner_count = $(this).val()
            $('.four_win_count').hide();
            for(i=1;i<=winner_count;i++ ){
                class_name = '.four_win_'+i;
                $(class_name).show();
            }
        });
    }); 
    $("#tournamnet_form").validate({ 
        rules: {
            tournament_name: {
                required: true,
            },
            bet_amount: {
                required: true,
                number: true
            },
            // commission: {
            //     required: true,
            //     number: true
            // },
            no_players: {
                required: true,                
            },           
            tournament_interval: {
                required: true,
                number: true
            }, 
        }  
    });

    $("#edit_tournamnet_form").validate({ 
        rules: {
            tournament_name: {
                required: true,
            },
            bet_amount: {
                required: true,
                number: true
            },
            // commission: {
            //     required: true,
            //     number: true
            // },
            no_players: {
                required: true,                
            },           
            tournament_interval: {
                required: true,
                number: true
            }, 
        }  
    });
    </script>
    