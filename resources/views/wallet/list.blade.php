@include('header_script')
@include('header_bar')
@include('side_bar')
@include('flash-message')
<body id="app-container" class="menu-default show-spinner">
  <main>
    <div class="container-fluid">
      <div class="row">
          <div class="col-12">
              <h1>Withdraw Request</h1>
              <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                  <ol class="breadcrumb pt-0">
                      <li class="breadcrumb-item">
                          <a href="#">Home</a>
                      </li>
                      <li class="breadcrumb-item">
                          <a href="{{ url('wallet/withdraw/list') }}">Withdraw Request</a>
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
              <h5 class="mb-4">Withdraw Request List</h5>
                <table class="table table-hover table-striped w-full" id="withdraw_list">
                    <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Player ID</th>
                        <th>Player Name</th>
                        <th>Wallet Amount</th>
                        <th>Request Amount</th>
                        <th>Type</th>
                        <th>Acc No</th>
                        <th>Ifsc</th>
                        <th>Paytm No</th>
                        <th>Action</th>
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
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var table = $("#withdraw_list").DataTable({
        pagingType: "simple_numbers",
        processing: true,
        serverSide: true,
        responsive: true,
        dom: 'Blfrtip',
        buttons: [ 'copy', 'excel', 'pdf' ],
        language: {
            processing: '<div class="cirle_loader"><div id="loading">Loading...</div></div>'
        },
        ajax: base_url + "/wallet/withdraw/list",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'player_id', name: 'player_id' },
            { data: 'player_name', name: 'player_name' },
            { data: 'wallet_balance', name: 'wallet_balance' },
            { data: 'amt_withdraw', name: 'amt_withdraw' },
            { data: 'payment_type', name: 'payment_type' },
             { data: 'account_number', name: 'account_number' },
              { data: 'ifsc_code', name: 'ifsc_code' },
               { data: 'mobile_number', name: 'mobile_number' },
            { data: 'action', name: 'action', orderable: false, searchable: false },

        ]
    });
    table.buttons().container()
        
        .appendTo( $('.col-sm-6:eq(0)', table.table().container()));

});
</script>
