@include('header_script')
@include('header_bar')
@include('side_bar')
@include('flash-message')
<body id="app-container" class="menu-default show-spinner">
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Notification</h1>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="#">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ url('player/list') }}">Player</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Send Notification</li>
                        </ol>
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-body">   
                         <h5 class="mb-4">Send Notification</h5>                             
                               
                                <form class="form-horizontal" id="notification_form" enctype="multipart/form-data" method="post" action="{{ route('notification.sending') }}">                            
                                @csrf

                                <div class="form-group row">
                                    <div class="col-12 col-xs-6 mb-9">
                                    <div class="form-group mb-8">
                                            <label>Notification Title</label>                                 
                                            <input type="text" class="form-control" name="title" id="title"  >                                                                                
                                        </div>
                                    </div>
                                </div>  
                                <div class="form-group row">
                                    <div class="col-12 col-xs-6 mb-9">
                                    <div class="form-group mb-8">
                                            <label>Notification Message</label>                                 
                                            <textarea  class="form-control" name="message" id="message"></textarea>                                                                              
                                        </div>
                                    </div>
                                </div> 
                                <div class="form-group row">
                                    <div class="col-12 col-xs-6 mb-9">
                                    <div class="form-group mb-8">
                                            <label>Send Image</label>                                 
                                            <input type="file" class="form-control" name="notification_image" id="notification_image"  >                                                                                     
                                        </div>
                                    </div>
                                </div>  
                                <div class="form-group row">
                                    <div class="col-md-9">
                                    <button type="submit" class="btn btn-primary">Submit </button>
                                    <button type="reset" class="btn btn-default btn-outline">Reset</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                    </div>                
                </div>                        
            </div> 
        </div> 
    </main>                            
</body>         
@include('footer')
<script src="{{asset('js/jquery.validate.js')}}"></script>
<script> 

    $('#notification_form').validate({ 
        rules: {
            title: {
                required: true,
            },
            message:{
                required:true
            },
        }          
    });


</script>
