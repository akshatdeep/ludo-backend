@include('header_script')
@include('header_bar')
@include('side_bar')
@include('flash-message')
<body id="app-container" class="menu-default show-spinner">
  <main>
    <div class="container-fluid">
      <div class="row">
          <div class="col-12">
              <h1>Players</h1>
              <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                  <ol class="breadcrumb pt-0">
                      <li class="breadcrumb-item">
                          <a href="#">Home</a>
                      </li>
                      <li class="breadcrumb-item">
                          <a href="{{ url('player/list') }}">Player</a>
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
              <h5 class="mb-4">Players List</h5>
              <table class="table table-bordered table-hover table-striped" cellspacing="0" id="playersList">
                  <thead>
                    <tr>
                      <th>Sno</th>
                      <th>Player ID</th>                      
                      <th>Name</th>
                      <th>Email</th>
                      <th>Mobile Number</th>  
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>            
                  @foreach($players as $p)
                    <tr class="gradeA">
                      <td>{{$count++}}</td>
                      <td>{{$p->user_id}}</td>
                      <td>{{$p->first_name}}</td>
                      <td>{{ optional($p->user)->email ?? 'N/A' }}</td>
                      <td>{{ optional($p->user)->mobile_no ?? 'N/A' }}</td>                     
                      <td class="actions">
                        <a href="{{ url('/player/edit/'.$p->id) }}" 
                          data-toggle="tooltip" data-original-title="Edit"><i class="iconsmind-Pencil" aria-hidden="true"></i></a>
                        <a href="{{ url('/player/delete/'.$p->id) }}" 
                          data-toggle="tooltip" data-original-title="Remove"><i class="simple-icon-trash" aria-hidden="true"></i></a>
                        <button class="view view_details" data-id="{{$p->id}}" data-toggle="modal" data-original-title="View Full details"><i class="iconsmind-Preview" aria-hidden="true"></i></button>
                      </td>                      
                    </tr>
                    @endforeach
                  </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
       <div class="modal fade bd-example-modal-lg" id="modal_box" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title">Player Details</h5>
                             
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                          <div class="modal-body">
                              
                          </div>
                      </div>
                  </div>
              </div>
        </div>
    </div> 
  </main>
</body>
@include('footer')  
<style>

img {
  border-radius: 50%;
}
.center{
  margin: auto;
  width: 20%;   
  text-align: center;
}
.center-text{
  text-align: center;
  width: fit-content;
  padding-left: 15px;
  font-size: 20px;
}

</style>
  <script>
    $(document).ready(function() {
     var table = $('#playersList').DataTable({
        responsive: true,
         dom: 'Blfrtip',
        buttons: [
        'copy', 'excel', 'pdf']     
      });      
      // table.buttons().container()
       //.appendTo( '#playersList_wrapper .col-md-6:eq(0)' );

       table.buttons().container()
    .appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );

      
      $('#modal_box').hide();
    
      $(document).on("click",".view_details",function() {  // $('.view').on("click",function(){
          var id= $(this).attr("data-id");

          $.ajax({
            url:'/get/player/view',
            dataType: 'JSON',
            type:'get',
            cache:true,
            data: {
              id: id
            },
            success:  function (response) {
            //  console.log(response);
             // $('#container').append('<img src="' + result[0].file_name + '" />');
                $('.modal-body').html(response);           
            $('#modal_box').modal('show');
            },
    });
      });
    
    
     });

  
  </script>