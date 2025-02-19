@include('header_script')

<div class="card card-pages">
    <div class="card-body col-4" style="margin: 0 auto;border: 1px solid #667afa;border-radius: 5px;">
        <div class="text-center m-t-0 m-b-15">
            <img src="{{asset('images/logo.png')}}" alt="" height="60">
        </div>
        <h4 class="text-muted text-center m-t-0">Sign In</h4>
        <form class="form-horizontal m-t-20" id="login_form" method="POST" action="{{ url('loginpost') }}">
            @csrf
            @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-danger') }}"><strong>{{ Session::get('message') }}</strong></p>
            @endif

            <div class="form-group m-t-20">
                <div class="col-12">
                    <input class="form-control @error('email') is-invalid @enderror" type="text" name="email" placeholder="Email" value="{{ old('email') }}">
                    @error(('email'))
                    <span class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group m-t-20">
                <div class="col-12">
                    <input class="form-control  @error('password') is-invalid @enderror" type="password" name="password" placeholder="Password">
                    @error(('password'))
                    <span class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <div class="col-12 m-t-30">
                    <div class="checkbox checkbox-primary mx-1">
                        <input id="remember_me" type="checkbox" name="remember_me" {{ old('remember_me') ? 'checked' : '' }}>
                        <label for="remember_me" class="control-label strong">Remember me</label>
                    </div>
                </div>
            </div>

            <div class="form-group text-center m-t-20">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-block"><strong>Sign In</strong></button>
                </div>
            </div>
        </form>
        <div class="form-group row m-t-30 m-b-0">
            <div class="col-md-12">
                <div class="float-left">
                    @if (Route::has('owner.password.request'))
                        <a class="btn btn-link" href="{{ route('owner.password.request') }}">
                            <b> {{ __('Forgot Your Password?') }}</b>
                        </a>
                    @endif
                </div>
                <div class=" float-right">
                </div>
            </div>
        </div>
       
    </div>
</div>
@include('footer_login')
<script src="{{asset('js/jquery.validate.js')}}"></script>
<script>        
    $('#login_form').validate({ 
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
				minlength : 8
            },
                   
        }  
    });
</script>