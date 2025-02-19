@include('header_script') 
@include('header_bar')
@include('side_bar')
@include('flash-message')
<body id="app-container" class="menu-default show-spinner">
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Withdraw Accept</h1>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="#">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ url('wallet/withdraw/list') }}">Withdraw</a>
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
                         <h5 class="mb-4">@if($action == 0) Create @else Edit @endif Withdraw Request</h5>  
                             @if($action == 1)
                            <form class="form-horizontal" id="edit_withdraw_form" method="post" action="{{ route('walletWithdrawUpdate',$transcation->id) }}" enctype="multipart/form-data">
                            @else
                            @endif
                            @csrf
                                <div class="form-group row edit_label">
                                    <label class="col-md-3 col-form-label">Player Name: </label>
                                    <div class="col-md-9">
                                        <span>{{ $transcation->playerId->first_name }}</span>
                                    </div>
                                </div>
                                <div class="form-group row edit_label">
                                    <label class="col-md-3 col-form-label">Wallet Number: </label>
                                    <div class="col-md-9">
                                        <span>{{ $transcation->walletId->wallet_ref_number }}</span>
                                    </div>
                                </div>
                                <div class="form-group row edit_label">
                                    <label class="col-md-3 col-form-label">Wallet Balance: </label>
                                    <div class="col-md-9">
                                        <span>{{ $transcation->walletId->current_amount }}</span>
                                    </div>
                                </div>
                                <div class="form-group row edit_label">
                                    <label class="col-md-3 col-form-label">Withdraw Request Date: </label>
                                    <div class="col-md-9">
                                        <span>{{ $transcation->withdraw_request_date }}</span>
                                    </div>
                                </div>
                                
                                <div class="form-group row edit_label">
                                    <label class="col-md-3 col-form-label">Withdraw Amount: </label>
                                    <div class="col-md-9">
                                    <span>{{ $transcation->amt_withdraw }}</span>
                                    </div>
                                </div>
                                <div class="form-group row edit_label">
                                    <label class="col-md-3 col-form-label">Payement Type: </label>
                                    <div class="col-md-9">
                                    <span>{{ $transcation->payment_type }}</span>
                                    </div>
                                </div>
                                <div class="form-group row edit_label">
                                    <label class="col-md-3 col-form-label">Account Number: </label>
                                    <div class="col-md-9">
                                    <span>{{ $transcation->account_number ? $transcation->account_number:'-' }}</span>
                                    </div>
                                </div>
                                <div class="form-group row edit_label">
                                    <label class="col-md-3 col-form-label">IFSC Code: </label>
                                    <div class="col-md-9">
                                    <span>{{ $transcation->ifsc_code ? $transcation->ifsc_code :'-'}}</span>
                                    </div>
                                </div>
                                <div class="form-group row edit_label">
                                    <label class="col-md-3 col-form-label">Mobile Number: </label>
                                    <div class="col-md-9">
                                    <span>{{ $transcation->mobile_number ? $transcation->mobile_number :'-' }}</span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Transcation Number: </label>
                                    <div class="col-md-9">
                                        <input  name="transcation_number" type="text" class="form-control @error('transcation_number') is-invalid @enderror" value="{{ isset($transcation->transcation_number) ? $transcation->transcation_number : old('transcation_number') }}">
                                       
                                        @error('transcation_number')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Transcation Notes: </label>
                                    <div class="col-md-9">
                                        <textarea class="form-control" name="notes" placeholder="Transcation Notes">{{ isset($transcation->notes) ? $transcation->notes : old('notes') }}</textarea>

                                        @error('notes')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>                                                                
                                <div class="form-group row">
                                    <div class="col-md-9">
                                        <input type="hidden" name="player_id" value="{{ $transcation->player_id}}">
                                        <button type="submit" class="btn btn-primary">Submit</button>
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
<style>
.edit_label{
    margin-bottom: 0px;
}
</style>
@include('footer')