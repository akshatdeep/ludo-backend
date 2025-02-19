@include('header_script')
@include('header_bar')
@include('side_bar')
@include('flash-message')
<body id="app-container" class="menu-default show-spinner">
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Version Control</h1>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="#">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ url('version_control/list') }}">Version Control</a>
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
                            <h5 class="mb-4">Edit Version Control Detail</h5>                            
                            <form class="needs-validation mb-5" novalidate id="version_control_form" method="post" action="{{ route('version_control.store') }}">
                                @csrf
                                <input value="{{$data->id}}" type="hidden" name="id" >
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Version Control </label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="version_control" placeholder="Version Control" autocomplete="off" value="{{$data->version_control}}">
                                    </div>
                                </div> 
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">App Link </label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="app_link" placeholder="App Link" autocomplete="off" value="{{$data->app_link}}">
                                    </div>
                                </div> 

                                <div class="form-group row">
                                    <div class="col-md-9">
                                    <button type="submit" id="update" class="btn btn-primary">Update </button>                                   
                                    </div>
                                </div>
                                </form>
                        </div>
                    </div>                
                </div>                        
            </div>  
    </main>                            
</body>            
@include('footer');            
<script src="{{asset('js/jquery.validate.js')}}"></script>
<script>        
    $('#version_control_form').validate({ 
        rules: {
            version_control: {required: true},
            app_link: {required: true, url:true},
        }  
    });

  $('#update').click(function(event){
    var formData = new FormData(this);
    if (!$('#version_control_form').valid()) {
        return true;
    }
    $.ajax({
        type: 'post',
        headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
        url:  base_url + '/version_control/store',
        data: $('#version_control_form').serialize(),
        success: function (response) {
            $('#version_id').val('');
            $('#version_control').val('');
            $('#app_link').val('');
            return false;
        },
        error: function (jqXHR, textStatus, errorThrown) {
            var myArr = JSON.parse(jqXHR.responseText);
            return false;
        },
    });   
  });


</script>            
            
            
            