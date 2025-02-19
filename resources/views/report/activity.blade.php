@include('header_script')
@include('header_bar')
@include('side_bar')
@include('flash-message')
<body id="app-container" class="menu-default show-spinner">
  <main>
    <div class="container-fluid">
      <div class="row">
          <div class="col-12">
              <h1>Transaction History</h1>
              <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                  <ol class="breadcrumb pt-0">
                      <li class="breadcrumb-item">
                          <a href="#">Home</a>
                      </li>
                      <li class="breadcrumb-item">
                          <a href="{{ url('tournament/list') }}">Report</a>
                      </li>
                      <li class="breadcrumb-item active" aria-current="page">All Transaction History</li>
                  </ol>
              </nav>
              <div class="separator mb-5"></div>
          </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-body">
              <h5 class="mb-4">All Transaction History</h5>
                <table class="table table-bordered table-hover table-striped" cellspacing="0" id="player_report">
                    <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Player Id</th>
                         <th>Amount</th>
                        <th>Txn Date/Time</th>
                        <th>Type</th>
                        <th>Txn By</th>
                        <th>Notes</th>
                        <th>Wallet Type</th>                                     
                    </tr>
                    </thead>
                    <tbody>
                     @foreach($supportRequest as $p)
                    <tr class="gradeA">
                      <td>{{$count++}}</td>
                      <td>{{$p->player_id}}</td>
                       <td>{{$p->amount}}</td>
                      <td>{{$p->created_at}}</td>
                      <td>{{$p->type}}</td>
                      <td>{{$p->use_of}}</td>
                      <td>{{$p->notes}}</td>
                       <td>{{$p->wallet_type}}</td>
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
