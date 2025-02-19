@include('header_script')
@include('flash-message')
    <div class="fixed-background"></div>
     <main>
        <div class="container">
            <!-- <div class="row h-100">
                <div class="col-12 col-md-10 mx-auto my-auto"> -->
                <div class="row">
                <div class="col-12 col-md-10">
                    <div class="card auth-card">
                        <div class="position-relative image-side ">

                            <p class=" text-white h2">MAGIC IS IN THE DETAILS</p>

                            <p class="white mb-0">
                                Please use your credentials to login.
                                <br>If you are not a member, please
                                <a href="#" class="white">register</a>.
                            </p>
                        </div>
                        <div class="form-side">
                            <a href="#">
                                <span class="logo-single"></span>
                            </a>
                            <h6 class="mb-4">Login</h6>
                            <form id="login_form" method="POST" action="{{ url('loginpost') }}">
                             @csrf
                                <label class="form-group has-float-label mb-4">
                                    <input class="form-control @error('email') is-invalid @enderror" type="text" name="email" placeholder="Email" value="{{ old('email') }}" />
                                     @error(('email'))
                                    <span>E-mail</span>
                                     @enderror
                                </label>

                                <label class="form-group has-float-label mb-4">
                                    <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" placeholder="Password" />
                                    @error(('password'))
                                    <span>Password</span>
                                    @enderror
                                </label>
                                <div class="d-flex justify-content-between align-items-center">
                                   @if (Route::has('owner.password.request'))
                                    <a href="{{ route('owner.password.request') }}">Forget password?</a>
                                     @endif
                                    <button class="btn btn-primary btn-lg btn-shadow" type="submit">LOGIN</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@include('footer');
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
