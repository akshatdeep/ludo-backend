@include('header_script')
@include('header_bar')
@include('side_bar')
@include('flash-message')
<body id="app-container" class="menu-default show-spinner">
  <main>
    <div class="container-fluid">
      <div class="row">
          <div class="col-12">
              <h1>Support</h1>
              <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                  <ol class="breadcrumb pt-0">
                      <li class="breadcrumb-item">
                          <a href="#">Home</a>
                      </li>
                      <li class="breadcrumb-item">
                          <a href="{{ url('support/request/list') }}">Withdraw</a>
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
              <h5 class="mb-4">Support List</h5>
                <table class="table table-hover table-striped w-full" id="request_list">
                    <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Player Name</th>
                        <th>Player Phone</th>
                        <th>Email Id</th>
                        <th>Subject</th>
                        <th>Message</th>                        
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                   @foreach($supportRequest as $p)
                    <tr class="gradeA">
                      <td>{{$count++}}</td>
                      <td>{{$p->player_name}}</td>
                      <td>{{$p->player_phone}}</td>
                      <td>{{$p->email_id}}</td>
                      <td>{{$p->subject}}</td>
                      <td>{{$p->message}}</td>  
                      <td>@if($p->status == '1')<div class="btn-group"><button type="button"  class="status btn btn-success">Open</button></div>@else<div class="btn-group"><button type="button"  class="status btn btn-danger">Closed</button></div>@endif</td>
                      </tr>
                      @endforeach
                    </tbody>
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
   
    var table = $("#request_list").DataTable({
        responsive: true,
       // scrollX: true,
        dom: 'Blfrtip',
        buttons: ['copy', 'excel', 'pdf']
      });
      table.buttons().container()
    .appendTo( $('.col-sm-6:eq(0)', table.table().container()));
   
});
</script>