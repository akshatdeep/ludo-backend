@include('header_script')
@include('header_bar')
@include('side_bar')
@include('flash-message')
<body id="app-container" class="menu-default show-spinner">
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Banner</h1>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="#">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ url('banner/list') }}">Banner</a>
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
                         <h5 class="mb-4">@if($action == 0) Create @else Edit @endif Banner</h5> 
                             @if($action == 1)
                                <form class="form-horizontal" id="edit_banner_form" method="post" action="{{ route('bannerUpdate',$banner->id) }}" enctype="multipart/form-data">
                            @else
                                <form class="form-horizontal" id="banner_form" method="post" action="{{ route('bannerSave') }}" enctype="multipart/form-data">
                            @endif
                            @csrf
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Banner Image </label>
                                    <div class="col-md-9">
                                        <input  name="image" type="file" class="form-control" value="{{ isset($banner->image) ? $banner->menu_image : old('image') }}">
                                        @if($action == 1)                                       
                                            <img width="100" src="{{ asset( 'banner/images/' . $banner->image) }}" alt="{{$banner->image}}" class="img-thumbnail uploaded_image m-t-20"/>
                                        @endif
                                        @error('image')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
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
   
    $("#banner_form").validate({ 
        rules: {
            category: {
                required: true,
            },
            image: {
                required: true,                
            }                     
        }  
    });
    $("#edit_banner_form").validate({ 
        rules: {
            category: {
                required: true,
            },
            // image: {
            //     required: true,                
            // }                     
        }  
    });
    </script>