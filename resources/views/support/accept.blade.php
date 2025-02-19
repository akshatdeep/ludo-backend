@include('header_script')
@include('header_bar')
@include('side_bar')
@include('flash-message')
<body id="app-container" class="menu-default show-spinner">
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Support Request</h1>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="#">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ url('support/request/list') }}">Support</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@if($action == 0) Add @else Edit @endif</li>
                        </ol>
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-body"> 
                             @if($action == 1)
                                <form class="form-horizontal" id="edit_support_request_form" method="post" action="{{ route('supportRequestUpdate',$supportData->id) }}">
                            @else
                            @endif
                            @csrf
                                <div class="form-group row edit_label">
                                    <label class="col-md-3 col-form-label">Player Name: </label>
                                    <div class="col-md-9">
                                        <span>{{ $supportData->player_name }}</span>
                                    </div>
                                </div>
                                <div class="form-group row edit_label">
                                    <label class="col-md-3 col-form-label">Contact Number: </label>
                                    <div class="col-md-9">
                                        <span>{{ $supportData->player_phone }}</span>
                                    </div>
                                </div>
                                
                                <div class="form-group row edit_label">
                                    <label class="col-md-3 col-form-label">Email ID: </label>
                                    <div class="col-md-9">
                                    <span>{{ $supportData->email_id }}</span>
                                    </div>
                                </div>
                                <div class="form-group row edit_label">
                                    <label class="col-md-3 col-form-label">Subject: </label>
                                    <div class="col-md-9">
                                    <span>{{ $supportData->subject }}</span>
                                    </div>
                                </div>
                                <div class="form-group row edit_label">
                                    <label class="col-md-3 col-form-label">Message: </label>
                                    <div class="col-md-9">
                                    <span>{{ $supportData->message ? $supportData->message:'-' }}</span>
                                    </div>
                                </div>
                               
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Reply Message: </label>
                                    <div class="col-md-9">
                                        <textarea class="form-control" name="admin_reply" placeholder="Reply Message">{{ isset($supportData->admin_reply) ? $supportData->admin_reply : old('admin_reply') }}</textarea>

                                        @error('admin_reply')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                                                
                                <div class="form-group row">
                                    <div class="col-md-9">
                                    <input type="hidden" name="player_id" value="{{ $supportData->player_id}}">
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