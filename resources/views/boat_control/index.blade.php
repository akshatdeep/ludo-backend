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
                      <li class="breadcrumb-item active" aria-current="page">List</li>
                  </ol>
              </nav>
              <div class="separator mb-5"></div>
          </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-body">
                <!-- <div class="row ">
                    <a href="javascript:void(0)" class="btn btn-info ml-3 add_btn float-right mb-3" onclick="createRow()">Add New</a>
                </div> -->
                <h5 class="mb-4">Boat Control List</h5>       
                <table class="table table-hover table-striped w-full" id="boat_control_list">
                    <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Boat Status</th>
                        <th>Boat Complexity</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                  
                    </tbody>
           </div>
            </div>
        </div>
      </div>
    </div> 
    <!-- Add modal -->
    <!-- <div class="modal fade bs-addBoatControl" id="addBoatControl" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0)"  id="boat_control_form" name="boat_control_form">
                        @csrf
                        <input id="boat_id" type="hidden" name="id" >
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>Boat Status</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" value="0" type="radio" name="boat_status" id="boat_status_off" checked>
                                    <label class="form-check-label" for="boat_status_off"> OFF </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" value="1" type="radio" name="boat_status" id="boat_status_on">
                                    <label class="form-check-label" for="boat_status_on"> ON </label>
                                </div>
                            </div>                            
                            <div class="form-group col-md-12">
                                <label>Boat Complexity</label>
                                <input id="boat_complexity" type="text" required class="form-control" name="boat_complexity" />
                            </div
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-md-12">
                                <button type="submit" id="submit_btn" class="btn btn-primary waves-effect waves-light">                                
                                </button>
                                <button type="reset" aria-label="Close" class="btn btn-secondary waves-effect m-l-5">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> -->
    <!-- /.modal -->
  </main>
</body> 

@include('footer')
<script>
 base_url = "{{ url('/') }}";
 var _token = $('input[name="_token"]').val();
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }); 
    var table = $("#boat_control_list").DataTable({
        pagingType: "simple_numbers",
        processing: true,
        serverSide: true,
        responsive: true,
        buttons: [ 'copy', 'excel', 'pdf' ],
        language: {
            processing: '<div class="cirle_loader"><div id="loading">Loading...</div></div>'
        },
        ajax: base_url + "/boat_control/list",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'boat_status', name: 'boat_status' },
            { data: 'boat_complexity', name: 'boat_complexity' },
            { data: 'action', name: 'action', orderable: false, searchable: false },

        ]
    });
    $("#boat_control_form").validate();
    $("#boat_control_form").removeAttr("novalidate");
    $("form[name='boat_control_form']").validate({
            rules: {
                'boat_status': {required: true},
                'boat_complexity': {required: true, number:true},
            },
            submitHandler: function(form) {
                form.submit();
            }
    });
});

$("#boat_control_form").submit(function (event) {
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

function createRow(){    
    $("form[name='boat_control_form']").trigger("reset");
    $('.modal-title').text('Add Boat Control Details');
    $('#submit_btn').text('Add');
    $('#boat_id').val('');
    $('#boat_status_on').attr('checked', false);
    $('#boat_status_off').attr('checked', true);
    $('#boat_complexity').val('');
    $('#addBoatControl').modal('show');
}
function editRow(id){    
    $.ajax({
        type: 'get',
        headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
        url: base_url + '/boat_control/edit/' + id ,
        success: function (response) {
            if (response) {
                $("form[name='boat_control_form']").trigger("reset");
                $('.modal-title').text('Edit Boat Control Details');
                $('#submit_btn').text('Update');
                $('#boat_id').val(response.id);
                $('#boat_complexity').val(response.boat_complexity);
                if(response.boat_status == '1'){
                    $('#boat_status_on').attr('checked', true);
                    $('#boat_status_off').attr('checked', false);
                }else{
                    $('#boat_status_on').attr('checked', false);
                    $('#boat_status_off').attr('checked', true);
                }
                $('#addBoatControl').modal('show');
                return false;
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            return false;
        },
    });
}

function deleteRow(id) {
    $.ajax({
        type: 'get',
        headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
        url: base_url + '/boat_control/delete/' + id ,
        success: function (data) {
            var oTable = $('#boat_control_list').dataTable();
            oTable.fnDraw(false);
            return false;
        },
        error: function (error) {
            return false;
        }
    });
}  
</script>