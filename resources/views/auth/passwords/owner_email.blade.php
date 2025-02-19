@include('header_script')
<body class="background show-spinner">
    <div class="fixed-background"></div>
    <main>
        <div class="container">
            <div class="row h-100">
                <div class="col-12 col-md-10 mx-auto my-auto">
                    <div class="card auth-card">
                        <div class="position-relative image-side ">
                            <p class=" text-white h2">MAGIC IS IN THE DETAILS</p>
                            <p class="white mb-0">
                                Please use your e-mail to reset your password.
                                <br>If you are not a member, please
                                <a href="#" class="white">register</a>.
                            </p>
                        </div>
                        <div class="form-side">
                            <a href="Dashboard.Default.html">
                                <span class="logo-single"></span>
                            </a>
                            <h6 class="mb-4">Forgot Password</h6>
                            @if (Session::has('status'))
                            <div class="alert alert-success m-t-30" role="alert">
                                {{ session('status') }}
                            </div>
                            @endif
                            <form class="form-horizontal" id="forgot_password_form" method="POST" action="{{ route('owner.password.email') }}">
                                @csrf
                                @if(Session::has('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong class="px-2">{{session()->get('error')}}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                @elseif(Session::has('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong class="px-2">{{session()->get('success')}}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                @endif
                                <div class="row m-t-20">
                                    <div class="col-md-12">
                                        <label class="control-label strong">{{ __('E-Mail Address') }}</label>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row"><p></p></div>
                                    <div class="col-md-12 m-t-30">
                                        <button type="submit" class="btn btn-primary btn-md btn-block waves-effect waves-light strong"> {{ __('Send Password Reset Link') }}</button>
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
<script>         
    $('#forgot_password_form').validate({ 
        rules: {           
            email: {
                required: true,
                email: true
            }                  
        }  
    });
</script> 