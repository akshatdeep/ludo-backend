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
                <h5 class="mb-4">Version Control List</h5>       
                <table class="table table-hover table-striped w-full" id="version_control_list">
                    <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Version Control</th>
                        <th>App Link</th>
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
    <!-- <div class="modal fade bs-addVersionControl" id="addVersionControl" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0)" id="version_control_form" name="version_control_form">
                        @csrf
                        <input id="version_id" type="hidden" name="id" >
                        <div class="row">                        
                            <div class="form-group col-md-12">
                                <label>Version Control</label>
                                <input id="version_control" type="text" required class="form-control" name="version_control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label>App Link</label>
                                <input id="app_link" type="url" required class="form-control" name="app_link" />
                            </div>
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
    var table = $("#version_control_list").DataTable({
        pagingType: "simple_numbers",
        processing: true,
        serverSide: true,
        responsive: true,
        buttons: [ 'copy', 'excel', 'pdf' ],
        language: {
            processing: '<div class="cirle_loader"><div id="loading">Loading...</div></div>'
        },
        ajax: base_url + "/version_control/list",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'version_control', name: 'version_control' },
            { data: 'app_link', name: 'app_link' },
            { data: 'action', name: 'action', orderable: false, searchable: false },

        ]
    });
    $("#version_control_form").validate();
    $("#version_control_form").removeAttr("novalidate");
    $("form[name='version_control_form']").validate({
            rules: {
                'version_control': {required: true},
                'app_link': {required: true},
            },
            submitHandler: function(form) {
                form.submit();
            }
    });
});

$("#version_control_form").submit(function (event) {
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
            $('#addVersionControl').modal('hide');
            var oTable = $('#version_control_list').dataTable();
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
    $("form[name='version_control_form']").trigger("reset");
    $('.modal-title').text('Add Version Control Details');
    $('#submit_btn').text('Add');
    $('#version_id').val('');
    $('#version_control').val('');
    $('#app_link').val('');
    $('#addVersionControl').modal('show');
}
function editRow(id){    
    $.ajax({
        type: 'get',
        headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
        url: base_url + '/version_control/edit/' + id ,
        success: function (response) {
            if (response) {
                $("form[name='version_control_form']").trigger("reset");
                $('.modal-title').text('Edit Version Control Details');
                $('#submit_btn').text('Update');
                $('#version_id').val(response.id);
                $('#version_control').val(response.version_control);
                $('#app_link').val(response.app_link);
                $('#addVersionControl').modal('show');
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
        url: base_url + '/version_control/delete/' + id ,
        success: function (data) {
            var oTable = $('#version_control_list').dataTable();
            oTable.fnDraw(false);
            return false;
        },
        error: function (error) {
            return false;
        }
    });
}  
</script>