@include('header_script')
@include('header_bar')
@include('side_bar')
@include('flash-message')
<body id="app-container" class="menu-default show-spinner">
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Players</h1>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="#">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ url('player/list') }}">Player</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>
                        </ol>
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="mb-4">Edit Player Detail</h5>                            
                            <form class="needs-validation mb-5" novalidate id="edit_player_form" method="post" action="{{ route('player.update',$player->id) }}">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">First Name </label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="first_name" placeholder="First Name" autocomplete="off" value="{{$player->first_name}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Last Name </label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="last_name" placeholder="Last Name" autocomplete="off" value="{{$player->last_name}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Matches Played </label>
                                    <div class="col-md-9">
                                        <input type="text" id="matchesPlayed" class="form-control" name="no_of_participate" placeholder="Matches Played" autocomplete="off" value="{{$player->no_of_participate}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Matches won </label>
                                    <div class="col-md-9">
                                        <input type="text" id="matchesWon" class="form-control" name="no_of_total_win" placeholder="Matches won" autocomplete="off" value="{{$player->no_of_total_win}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Matches Lost </label>
                                    <div class="col-md-9">
                                        <input type="text" id="matchesLost" class="form-control" name="no_of_loose" placeholder="Matches Lost" autocomplete="off" value="{{$player->no_of_loose}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">2 Player Matches Won </label>
                                    <div class="col-md-9">
                                        <input type="text" id="2matchesWon" class="form-control" name="no_of_2win" placeholder="2 Player Matches Won" autocomplete="off" value="{{$player->no_of_2win}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">4 Player Matches Won</label>
                                    <div class="col-md-9">
                                        <input type="text" id="4matchesWon" class="form-control" name="no_of_4win" placeholder="4 Player Matches Won" autocomplete="off" value="{{$player->no_of_4win}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Device </label>
                                    <div class="col-md-9">
                                        <input type="text" id="deviceType"class="form-control" name="device_type" placeholder="Device" autocomplete="off" value="{{$player->device_type}}">
                                    </div>
                                </div>                                    
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Banned user</label>
                                    <div class="col-md-9">
                                    <div class="radio-custom radio-default radio-inline">
                                        <input type="radio" id="yes" name="banned" value="1" <?php if($player->banned == '1'){echo "checked";}?> />
                                        <label for="yes">Yes</label>
                                    </div>
                                    <div class="radio-custom radio-default radio-inline">
                                        <input type="radio" id="no" name="banned" value="0" <?php if($player->banned == '0'){echo "checked";}?> />
                                        <label for="no">No</label>
                                    </div>
                                    </div>
                                </div> 
                                <div class="form-group row">
                                    <div class="col-md-9">
                                    <button type="submit" id="update" class="btn btn-primary">Update </button>                                   
                                    </div>
                                </div>
                                </form>
                        </div>
                    </div>                
                </div>                        
            </div>  
    </main>                            
</body>            
@include('footer');            
<script src="{{asset('js/jquery.validate.js')}}"></script>
<script>        
    $('#edit_player_form').validate({ 
        rules: {
            first_name: {
                required: true,
            },
            last_name: {
                required: true,
            },
            no_of_participate: {
                required: true,
                number: true
            },
            no_of_total_win: {
                required: true,
                number: true
            },           
            no_of_loose: {
                required: true,
                number: true
            },
            no_of_2win: {
                required: true,
                number: true
            },
            no_of_4win: {
                required: true,
                number: true
            },
            banned: {
                required: true,
            },
            device_type: {
                required: true,
            },           
        }  
    });
    $( "#matchesWon" ).keyup(function() {
        var won = $('#matchesWon').val();
        var played = $('#matchesPlayed').val();
        if(won > played){        
        $("#matchesWon").parent().after("<div class='validation1' id='errmessage' style='color:red;margin-bottom: 20px;'>Matches won cannot be more than matches played</div>");
        $('#errmessage').fadeOut(2700,function(){
            $( ".validation1" ).remove();
        });
     }  
  });
  $('#update').click(function(event){
    var matches4p = $('#4matchesWon').val();
    var lost = $('#matchesLost').val();
    var matches2p = $('#2matchesWon').val();
    var won = $('#matchesWon').val();
    var played = $('#matchesPlayed').val();
    if( matches4p != null && lost != null && matches2p != null ){
        if((parseInt(won) + parseInt(lost))!= parseInt(played)){        
            $("#matchesLost").parent().after("<div class='validation' id='errmessage' style='color:red;margin-bottom: 20px;'>Match Lost Count mismatch with Matches Played !! , Please enter proper value!!</div>");
            $("#matchesWon").parent().after("<div class='validation' id='errmessage' style='color:red;margin-bottom: 20px;'>Match Won Count mismatch with Matches Played !! , Please enter proper value!!</div>");
            
            $('#errmessage').fadeOut(2700,function(){
             $( ".validation" ).remove();
            });
            event.preventDefault();
        }
    }
    if(parseInt(matches2p) + parseInt(matches4p) != parseInt(won)){              
          $("#4matchesWon").parent().after("<div class='validation2' id='errmessage2' style='color:red;margin-bottom: 20px;'>Match Count mismatch with Matches won !! , Please enter proper value!!</div>");
          $("#2matchesWon").parent().after("<div class='validation2' id='errmessage2' style='color:red;margin-bottom: 20px;'>Match Count mismatch with Matches won !! , Please enter proper value!!</div>");
         
          $('#errmessage2').fadeOut(2700,function(){
                 $(".validation2" ).remove();
          });
          event.preventDefault();
      }    
  });


</script>            
            
            
            