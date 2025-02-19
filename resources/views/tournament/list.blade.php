@include('header_script')
@include('header_bar')
@include('side_bar')
@include('flash-message')
<body id="app-container" class="menu-default show-spinner">
  <main>
    <div class="container-fluid">
      <div class="row">
          <div class="col-12">
              <h1>Tournaments</h1>
              <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                  <ol class="breadcrumb pt-0">
                      <li class="breadcrumb-item">
                          <a href="#">Home</a>
                      </li>
                      <li class="breadcrumb-item">
                          <a href="{{ url('tournament/list') }}">Tournament</a>
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
              <h5 class="mb-4">Tournaments List</h5>
                <table class="table table-hover table-striped w-full" id="tournament_list">
                    <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Tournament Name</th>
                        <th>Bet Amount</th>                        
                        <th>No Players</th>
                        <th>Tournament Interval</th>
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
    var table = $("#tournament_list").DataTable({
        pagingType: "simple_numbers",
        processing: true,
        serverSide: true,
        responsive: true,
        buttons: [ 'copy', 'excel', 'pdf' ],
        language: {
            processing: '<div class="cirle_loader"><div id="loading">Loading...</div></div>'
        },
        ajax: base_url + "/tournament/list",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'tournament_name', name: 'tournament_name' },
            { data: 'bet_amount', name: 'bet_amount' },            
            { data: 'no_players', name: 'no_players' },
            { data: 'tournament_interval', name: 'tournament_interval' },
            { data: 'action', name: 'action', orderable: false, searchable: false },

        ]
    });
    table.buttons().container()
        .appendTo( '#tournament_list_wrapper .col-md-6:eq(0)' );

    $(document).on('click', '.deleteTournament', function () {
        var deleteLoyaltyId = $(this).attr("id");
        if (confirm("Are you sure want to delete ?")) {
            $.ajax({
                url: base_url + "/tournament/delete/" + deleteLoyaltyId,
                type: 'DELETE',
                data: 'json',
                success: function (data) {
                    
                },
            });
        }
    });
});
</script>