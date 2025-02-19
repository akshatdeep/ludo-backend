@include('header_script')
<div class="card card-page">
    <div class="card-body">
        <h4 class="text-muted text-center m-t-20">{{ __('Owner Reset Password') }}</h4>
        @if (Session::has('status'))
        <div class="alert alert-success m-t-30" role="alert">
            {{ session('status') }}
        </div>
        @endif
        <form method="POST" action="{{ route('owner.password.update') }}">
            @csrf
            <input type="hidden" name="token" class="form-control" value="{{ $token }}">
            <div class="row m-t-40">
                <div class="col-md-12">
                    <label for="email" class="control-label strong">{{ __('E-Mail Address') }}</label>
                    <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" autocomplete="email" autofocus>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row m-t-20">
                <div class="col-md-12">
                    <label for="password" class="control-label strong">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row m-t-20">
                <div class="col-md-12">
                    <label for="password-confirm" class="control-label strong">{{ __('Confirm Password') }}</label>
                    <input id="password-confirm" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" autocomplete="new-password">
                    @error('password_confirmation')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row m-t-40">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary btn-md btn-block strong">
                        {{ __('Reset Password') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
