@include('header_script')
@include('header_bar')
@include('side_bar')
@include('flash-message')
<body id="app-container" class="menu-default show-spinner">
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Wallet</h1>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="#">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ url('wallet/withdraw/list') }}">Wallet</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Modify</li>
                        </ol>
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-body">   
                         <h5 class="mb-4">Change Wallet Amount</h5>                             
                               
                                <form class="form-horizontal" id="wallet_form" method="post" action="{{ route('modifyPlayerWallet') }}">                            
                                @csrf
                                <div class="form-group row">
                                   <div class="col-sm-6">
                                    <label>Choose Player</label>
                                    <select name="player_id" id="selector" class="form-control select2-single">         
                                    <option value=""> Select User </option>                          
                                    @foreach($players as $p)
                                        <option value="{{$p->user_id}}">{{$p->user->email}}</option>
                                    @endforeach
                                    </select>

                                </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-12 col-xs-6 mb-9">
                                    <div class="form-group mb-8">
                                            <label>Wallet Amount</label>                                 
                                            <input type="text" class="form-control" readonly id="amount"  >                                                                                
                                        </div>
                                    </div>
                                </div>  
                                   <div class="form-group row">
                                    <div class="col-12 col-xs-6 mb-9">
                                    <div class="form-group mb-8">
                                            <label>Bonus Wallet Amount</label>                                 
                                            <input type="text" class="form-control" readonly id="bonusamount"  >                                                                                
                                        </div>
                                    </div>
                                </div> 
                                <div class="form-group row">
                                    <div class="col-12 col-xs-6 mb-9">
                                        <div class="row mb-8 errorprinttype">
                                            <div class="col-4 col-xs-4 mb-4">
                                                <label>Transcation Type</label>
                                            </div>      
                                            <div class="col-2 col-xs-2 mb-2">
                                                <input class="form-check-input" type="radio" name="type" id="credit" value="credit">
                                                <label class="form-check-label" for="credit">
                                                    Credit
                                                </label>
                                            </div>                           
                                            <div class="col-2 col-xs-2 mb-2">
                                                <input class="form-check-input" type="radio" name="type" id="debit" value="debit">
                                                <label class="form-check-label" for="debit">
                                                    Debit
                                                </label>
                                            </div>                                                                                                       
                                        </div>
                                    </div>
                                </div>  
                                <div class="form-group row">
                                    <div class="col-12 col-xs-6 mb-9">
                                        <div class="row mb-8 errorprintwallet_type" >
                                            <div class="col-4 col-xs-4 mb-4">
                                                <label>Wallet Type</label>
                                            </div>      
                                            <div class="col-2 col-xs-2 mb-2">
                                                <input class="form-check-input" type="radio" name="wallet_type" id="bonus_balance" value="bonus_balance">
                                                <label class="form-check-label" for="bonus_balance">
                                                    Bonus
                                                </label>
                                            </div>                           
                                            <div class="col-2 col-xs-2 mb-2">
                                                <input class="form-check-input" type="radio" name="wallet_type" id="winning_balance" value="winning_balance">
                                                <label class="form-check-label" for="winning_balance">
                                                    Win
                                                </label>
                                            </div>                                                                                                       
                                            <div class="col-2 col-xs-2 mb-2">
                                                <input class="form-check-input" type="radio" name="wallet_type" id="play_balance" value="play_balance">
                                                <label class="form-check-label" for="play_balance">
                                                    Play
                                                </label>
                                            </div>                                                                                                       
                                        </div>
                                    </div>
                                </div>  
                                <div class="form-group row">
                                    <div class="col-12 col-xs-6 mb-9">
                                    <div class="form-group mb-8">
                                            <label>Add Amount</label>                                 
                                            <input type="text" class="form-control"  name="coupon_amount" >                                                                                
                                        </div>
                                    </div>
                                </div>  
                                 <div class="form-group row">
                                    <div class="col-12 col-xs-6 mb-9">
                                    <div class="form-group mb-8">
                                            <label>Notes</label>                                 
                                            <input type="text" class="form-control"  name="notes" >                                                                                
                                        </div>
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
        </div> 
    </main>                            
</body>         
@include('footer')
<script src="{{asset('js/jquery.validate.js')}}"></script>
<script> 

    $('#wallet_form').validate({ 
        rules: {
            player_id: {
                required: true,
            },
            coupon_amount:{
                required:true
            },
            type:{
                required:true
            },
            wallet_type:{
                required:true
            }
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "type") {
                error.insertAfter(".errorprinttype");
            } else if (element.attr("name") == "wallet_type") {
                error.insertAfter(".errorprintwallet_type");
            } else {
                error.insertAfter(element);
            }
        }
          
    });


  $("#my_slider").slider({ 
      min: 1,
      max : 10000,
      slide: function(event, ui) {       
            $("#my_display").html(ui.value); 
            $('#amount').val(ui.value);
            } 
    }); 
    

 $('#selector').on('change',function(){
     var playerId=$(this).val();
     var sliderVal =  $("#amount").val;
     
    $.ajax({
            url:'/wallet/show/'+playerId,
            dataType: 'JSON',
            type:'get',
            cache:true,
            data: {
              id: playerId
            },
            success:  function (response) {           
            $( "#my_slider" ).slider( "option", "value", response.current_amount );
            $("#my_display").html(response.current_amount);
            $('#amount').val(response.current_amount);
            },
    });  
         $.ajax({
            url:'/bonuswallet/show/'+playerId,
            dataType: 'JSON',
            type:'get',
            cache:true,
            data: {
              id: playerId
            },
            success:  function (response) {           
            $( "#my_slider" ).slider( "option", "value", response.current_amount );
            $("#my_display").html(response.current_amount);
            $('#bonusamount').val(response.current_amount);
            },
    });  
        });
</script>
