@include('header_script')
@include('header_bar')
@include('side_bar')
@include('flash-message')
<body id="app-container" class="menu-default show-spinner">
  <main>
    <div class="container-fluid">
      <div class="row">
          <div class="col-12">
              <h1>Withdraw History</h1>
              <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                  <ol class="breadcrumb pt-0">
                      <li class="breadcrumb-item">
                          <a href="#">Home</a>
                      </li>
                      <li class="breadcrumb-item">
                          <a href="{{ url('report/players') }}">Player Report</a>
                      </li>
                      <li class="breadcrumb-item active" aria-current="page">Withdraw History</li>
                  </ol>
              </nav>
              <div class="separator mb-5"></div>
          </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-body">
              <h5 class="mb-4">withdraw History</h5>
                <div class="form-group row">
                    <div class="col-md-4">
                        <label class="col-md-6 col-form-label">Total Loaded Amount: </label>
                        <div class="col-md-6">{{ $wallet->total_amt_load }}</div>
                    </div>
                    <div class="col-md-4">
                        <label class="col-md-6 col-form-label">Total Withdraw Amount: </label>
                        <div class="col-md-6">{{ $wallet->total_amt_withdraw }}</div>
                    </div>
                    <div class="col-md-4">
                        <label class="col-md-6 col-form-label">Wallet Balance: </label>
                        <div class="col-md-6">{{ $wallet->current_amount }}</div>
                    </div>
                    
                </div>

                <table class="table table-hover table-striped w-full" id="withdraw_history">
                    <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Amount</th>
                        <th>Transcation Date</th>
                        <th>Type</th>
                        <th>Use Of</th>
                        <th>Wallet Type</th>
                    </tr>
                    </thead>                    
                    <tbody>                  
                    </tbody>
                </table>
              </div>
            </div>
        </div>
      </div>
    </div> 
  </main>
</body> 
@include('footer')
<script>
 base_url = "{{ url('/') }}";
 var _token = $('input[name="_token"]').val();
 var id = "{{ request()->route()->parameter('id') }}";
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }); 
         
    var table =  $("#withdraw_history").DataTable({
        responsive: true,
        pagingType: "simple_numbers",
        processing: true,
        serverSide: true,
        language: {
            processing: '<div class="cirle_loader"><div id="loading">Loading...</div></div>'
        },        
        buttons: [ 'copy', 'excel', 'pdf' ],
        // ajax: {
        //     "url": base_url + "/report/players",
        //     "type": "GET"
        // },
        ajax: base_url + "/report/players/withdraw/"+id,
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'amount', name: 'amount' },
            { data: 'trans_date', name: 'trans_date' },
            { data: 'type', name: 'type' },
            { data: 'use_of', name: 'use_of' },
            { data: 'wallet_type', name: 'wallet_type' }
        ]
    });
    table.buttons().container()
        .appendTo('#withdraw_history_wrapper .col-md-6:eq(0)');
});
</script>