@include('header_script')
@include('header_bar')
@include('side_bar')
@include('flash-message')
<body id="app-container" class="menu-default show-spinner">
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Boat Control</h1>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="#">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ url('boat_control/list') }}">Boat Control</a>
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
                            <h5 class="mb-4">Edit Boat Control Detail</h5>                            
                            <form class="needs-validation mb-5" novalidate id="boat_control_form" method="post" action="{{ route('boat_control.store') }}">
                                @csrf
                                <input value="{{$data->id}}" type="hidden" name="id" >
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Boat Status</label>
                                    <div class="col-md-9">
                                    <div class="radio-custom radio-default radio-inline">
                                        <input type="radio" id="boat_status_on" name="boat_status" value="1" {{ isset($data->boat_complexity) && $data->boat_complexity == '1' ? 'checked' : '' }}/>
                                        <label for="boat_status_on">On</label>
                                    </div>
                                    <div class="radio-custom radio-default radio-inline">
                                        <input type="radio" id="boat_status_off" name="boat_status" value="0" {{ isset($data->boat_complexity) && $data->boat_complexity == '0' ? 'checked' : '' }} />
                                        <label for="boat_status_off">Off</label>
                                    </div>
                                    </div>
                                </div> 
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Boat Complexity </label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="boat_complexity" placeholder="Boat Complexity " autocomplete="off" value="{{$data->boat_complexity}}">
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
    $('#boat_control_form').validate({ 
        rules: {
            boat_status: {required: true},
            boat_complexity: {required: true, number:true},
        }  
    });

  $('#update').click(function(event){
    var formData = new FormData(this);
    if (!$('#boat_control_form').valid()) {
        return true;
    }
    $.ajax({
        type: 'post',
        headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
        url:  base_url + '/boat_control/store',
        data: $('#boat_control_form').serialize(),
        success: function (response) {
            $('#boat_id').val('');
            $('#boat_complexity').val('');
            $('#boat_status_on').attr('checked', false);
            $('#boat_status_off').attr('checked', false);
            $('#addBoatControl').modal('hide');
            var oTable = $('#boat_control_list').dataTable();
            oTable.fnDraw(false);
            return false;
        },
        error: function (jqXHR, textStatus, errorThrown) {
            var myArr = JSON.parse(jqXHR.responseText);
            return false;
        },
    });   
  });


</script>            
            
            
            