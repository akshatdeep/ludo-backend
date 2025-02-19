@include('header_script')
@include('header_bar')
@include('side_bar')
@include('flash-message')
<body id="app-container" class="menu-default show-spinner">
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>User Settings</h1>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="#">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="">Settings</a>
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
                            <div class="row">  
                                <div class="col-sm-6">                          
                                    <label class="col-md-3 example-title"><b> Select Action </b></label>                               
                                        <select class="form-control select2-single" id="selector">
                                            <option value="1">Change Profile Data</option>
                                            <option value="2">Change Password</option> 
                                            <option value="3">Change Logo </option> 
                                            <option value="4">Change App Name </option>                    
                                        </select>
                                </div>
                            </div>
                            <div class="row">
                            <p></p>
                            </div>
                            <div class="row"> 
                                <div class="col-md-12 col-lg-8" id="profile_form"> 
                                    <h5 class="mb-4">Edit Profile</h5> 
                                    <form class="form-horizontal" id="edit_user_form" method="post" action="{{ route('user.update',$user->id) }}" >
                                    @csrf
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">First Name </label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="first_name" placeholder="First Name" autocomplete="off" value="{{$user->first_name}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Email ID </label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="email" placeholder="Email ID" autocomplete="off" value="{{$user->email}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Mobile Number </label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="mobile_no" placeholder="Mobile Number" autocomplete="off" value="{{$user->mobile_no}}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-9">
                                            <button type="submit" id="update" class="btn btn-primary">Update </button>                                   
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-12 col-lg-8" id="password_form">
                                    <h4 class="example-title">Change Password</h4>  
                                    <form class="form-horizontal" id="change_password_form" method="post" action="{{ route('user.updatePassword',$user->id) }}">
                                    @csrf
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">New Password </label>
                                            <div class="col-md-9">
                                                <input type="password" class="form-control" name="password" id="password" placeholder="New Password" autocomplete="off" value="">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Confirm Password</label>
                                            <div class="col-md-9">
                                                <input type="password" class="form-control" name="cnf_password" placeholder="Confirm Password" autocomplete="off" value="">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-9">
                                            <button type="submit" id="update2" class="btn btn-primary">Update </button>                                   
                                            </div>
                                        </div>
                                    </form>
                        
                                </div> 
                                <div class="col-md-12 col-lg-8" id="logo_form">
                                    <h4 class="example-title">Change Logo</h4> 
                                    <form class="form-horizontal" id="change_logo_form" method="post" action="{{ route('user.updateLogo') }}" enctype="multipart/form-data">
                                     @csrf
                                        {{-- <div class="dropzone" >
                                        <input type="hidden" name="image" accept="image/gif, image/jpeg, image/png" value="">
                                        </div>            --}}
                                       
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Logo </label>
                                            <div class="col-lg-9">                                                        
                                                <div class="col-lg-4">
                                                    <input type="file" class="form-control" id="logo_image" name="image" accept="image/gif, image/jpeg, image/png" value="" onchange="previewimg(this);">
                                                </div>
                                                <div class="col-lg-5">
                                                    <img id="preview" src="{{asset('img/logo.jpg')}}" height="100px;" width="100px;" style="float:right;" accept="image/gif, image/jpeg, image/png" value="" >
                                                    <input type="hidden" name="hid_logoimg" id="hid_logoimg" value="">
                                                </div>                                                
                                            </div>
                                        </div>                                                    
                                        <div class="form-group row">
                                            <div class="col-md-9">
                                            <button type="submit" id="update3" class="btn btn-primary">Update </button>                                   
                                            </div>
                                        </div>
                                    </form>
                                </div> 
                                <div class="col-md-12 col-lg-8" id="app_form">                   
                                    <h4 class="example-title">Change Application Name</h4>    
                                    <form class="form-horizontal" id="change_app_name_form" method="post" action="{{ route('user.updateAppName') }}">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Application Name </label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="app_name" placeholder="App Name" autocomplete="off" value="">
                                        </div>
                                    </div>                                                     
                                    <div class="form-group row">
                                        <div class="col-md-9">
                                        <button type="submit" id="update4" class="btn btn-primary">Update </button>                                   
                                        </div>
                                    </div>
                                    </form> 
                                </div> 
                            </div>
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
    $("#profile_form").show();
    $("#password_form").hide();
    $("#logo_form").hide();
    $("#app_form").hide();
    
    $('#edit_user_form').validate({ 
        rules: {
            first_name: {
                required: true,
            },
            email: {
                required: true,
                email: true
            },
            mobile_no: {
                required: true,
                number: true,
                minlength:10,
                maxlength:10,
            },
                     
        }  
    });
    $('#change_password_form').validate({ 
        rules: {
            password : {
                    required: true,
					minlength : 8
				},
				cnf_password : {
                    required: true,
					minlength : 8,
					equalTo : "#password"
				},     
        }  
    });
    
    $('#selector').on('change',function(){
        if( $(this).val()==="2"){
            $("#password_form").show();
            $("#profile_form").hide();
            $("#logo_form").hide();
            $("#app_form").hide();            
        }
        else if( $(this).val()==="3"){
            $("#logo_form").show();
            $("#password_form").hide();
            $("#profile_form").hide();
            $("#app_form").hide();
        }
        else if( $(this).val()==="4"){           
            $("#app_form").show();
            $("#logo_form").hide();
            $("#password_form").hide();
            $("#profile_form").hide();            
        }
        else{
            $("#logo_form").hide();
            $("#password_form").hide();
            $("#profile_form").show();
            $("#app_form").hide();
        }
});
//logo image
    function previewimg(input)
    {
        if (input.files && input.files[0])
        {
            var reader = new FileReader();
            reader.onload = function (e)
            {
                $('#preview').attr('src', e.target.result);
                $('#hid_logoimg').attr('value', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    </script>