@include('header_script')
@include('header_bar')
@include('side_bar')
@include('flash-message')
<body id="app-container" class="menu-default show-spinner">
  <main>
    <div class="container-fluid">
      <div class="row">
          <div class="col-12">
              <h1>Player Report</h1>
              <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                  <ol class="breadcrumb pt-0">
                      <li class="breadcrumb-item">
                          <a href="#">Home</a>
                      </li>
                      <li class="breadcrumb-item">
                          <a href="{{ url('tournament/list') }}">Report</a>
                      </li>
                      <li class="breadcrumb-item active" aria-current="page">Banned Player Details</li>
                  </ol>
              </nav>
              <div class="separator mb-5"></div>
          </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-body">
              <h5 class="mb-4">Banned Players List</h5>
                <table class="table table-bordered table-hover table-striped" cellspacing="0" id="player_report">
                    <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>Refer Code</th>
                        <th>Join Code</th>
                        <th>Participate</th>
                        <th>2 Wins</th>
                        <th>4 Wins</th>
                        <th>Total Win</th>
                        <th>Total Lose</th>
                        <th>Loaded Amount</th>
                        <th>Withdraw Amount</th>
                        <th>Wallet Balance</th>
                        <th>Bonus Wallet</th>
                        <th>No. Load</th>
                        <th>No. withdraw</th>                                           
                    </tr>
                    </thead>
                    <tbody>
                     @foreach($playerDetails as $p)
                    <tr class="gradeA">
                      <td>{{$count++}}</td>
                      <td>{{$p->first_name}}</td>
                      <td>{{$p->refer_code}}</td>
                      <td>{{$p->join_code}}</td>
                      <td>{{$p->no_of_participate}}</td>
                      <td>{{$p->no_of_2win}}</td>
                      <td>{{$p->no_of_4win}}</td>
                      <td>{{$p->no_of_total_win}}</td>
                      <td>{{$p->no_of_loose}}</td>
                      <td>{{$p->wallet_id->total_amt_load}}</td>
                      <td>{{$p->wallet_id->total_amt_withdraw}}</td>
                      <td>{{$p->wallet_id->current_amount}}</td>
                      <td>{{$p->bonus_wallet_id->current_amount}}</td>
                      <td>{{$p->wallet_id->no_of_load}}</td>
                      <td>{{$p->wallet_id->no_of_withdraw}}</td>  
                    </tr>
                    @endforeach
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
$(document).ready(function () {
    var table = $('#player_report').DataTable({        
        responsive: true,
       // scrollX: true,
        dom: 'Blfrtip',
        buttons: ['copy', 'excel', 'pdf']
      });
      table.buttons().container()
    .appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );

});
</script>
