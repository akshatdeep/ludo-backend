@include('header_script')
<div class="card card-pages">
    <div class="card-body">
        <h4 class="text-muted text-center m-t-0">Forgot Password</h4>
        <form class="form-horizontal m-t-40" method="POST" action="{{ route('password.email') }}">
            @csrf
            @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <label class="control-label">Email</label>
                    <input type="text" name="email" class="form-control">
                </div>
            </div>

            <div class="form-group m-t-40">
                <div class="row">
                    <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Send Password Reset Link</button>
                </div>
            </div>

        </form>
    </div>

</div>
