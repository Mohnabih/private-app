<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" value="{{ csrf_token() }}" />
    <title>Take Me Date</title>
    <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet" />
 <!-- plugins:css -->
    <link rel="stylesheet" href="{{ URL::asset('dash_assets/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('dash_assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('dash_assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('dash_assets/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ URL::asset('dash_assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('dash_assets/js/select.dataTables.min.css') }}">
    <!-- End plugin css for this page -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200&display=swap" rel="stylesheet">

    <!-- inject:css -->
    <link rel="stylesheet" href="{{ URL::asset('dash_assets/css/vertical-layout-light/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ URL::asset('dash_assets/images/logo3.png') }}" />
    <style>
            .content-wrapper {
    background-image: url(/dash_assets/images/vv1.jpg);
    background-size: cover;
    padding: 2.375rem 2.375rem;
    width: 100%;
    -webkit-flex-grow: 1;
    flex-grow: 1;
    height: auto;
    margin: 0;
    color: #f4fbff;
}
.auth .auth-form-light {
    background: #212529c7;
    border-radius: 38px;
}
    </style>
</head>
<body>
    <div class="container-scroller" >
        <div class="container-fluid page-body-wrapper full-page-wrapper">
          <div class="content-wrapper d-flex align-items-center auth px-0">
            <div class="row w-100 mx-0">
              <div class="col-lg-4 mx-auto">
                <div class="auth-form-light py-5 px-4 px-sm-5">

                  <div class="brand-logo text-center">
                    <!-- <img style="width:100px !important" src="" alt="logo"> -->
                    <h3>LOGO</h3>
                    <h4>TAKE ME DATE</h4>
                </div>
                  <form  class="pt-3" id="form_save">
                    <div class="form-group">
                        <label class="f2" for="username">Phone</label>
                      <input required name="phone" type="text" class="form-control form-control-lg"  >
                    </div>

                    <div class="form-group">
                        <label class="f2" for="Password"> Password </label>
                      <input required name="password" type="password" class="form-control form-control-lg"  >
                    </div>
                    <div class="mt-3">
                        <div class="text-center p-3" id='loader' style='display: none;'>
                                <div class="spinner-grow text-primary" role="status">
                                 <span class="sr-only">Loading...</span>
                                </div>
                                <div class="spinner-grow text-secondary" role="status">
                                 <span class="sr-only">Loading...</span>
                                </div>
                                <div class="spinner-grow text-success" role="status">
                                 <span class="sr-only">Loading...</span>
                                </div>
                                <div class="spinner-grow text-danger" role="status">
                                 <span class="sr-only">Loading...</span>
                                </div>
                      </div>
                      <p style="color: white" id="save_errlist"></p>
                      <button id="login" type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">login </button>
                    </div>


                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
      </div>
      <!-- container-scroller -->

 <script src="{{ URL::asset('dash_assets/vendors/js/vendor.bundle.base.js') }}"></script>
 <script src="{{ URL::asset('dash_assets/js/off-canvas.js') }}"></script>
 <script src="{{ URL::asset('dash_assets/js/hoverable-collapse.js') }}"></script>
 <script src="{{ URL::asset('dash_assets/js/template.js') }}"></script>
 <script src="{{ URL::asset('dash_assets/js/settings.js') }}"></script>
 <script src="{{ URL::asset('dash_assets/js/todolist.js') }}"></script>
 <script src="{{ URL::asset('dash_assets/vendors/chart.js/Chart.min.js') }} "></script>
 <script src="{{ URL::asset('dash_assets/js/chart.js') }} "></script>
 <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
</body>
</html>
<script>
    $(document).on('click','#login', function (e) {
              e.preventDefault();
              var formdata=new FormData($('#form_save')[0]);
              $.ajaxSetup({
                     headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                       });

              $.ajax({
                  type: "POST",
                  enctype:'multipart/form-data',
                  url:"api/admin/v1/loginAdmin",
                  data: formdata,
                  dataType: "json",
                   processData: false,
                   contentType: false,
                   cache:false,
                   beforeSend:function(){
                       $('#loader').show();
                   },

                   success:function(response){
                       console.log(response.data.token);
                       if(response.status==200){
                        $('#loader').hide();
                       $('#save_errlist').html('');
                       $("#save_errlist").removeClass('alert alert-danger');
                        $('#save_errlist').addClass('alert alert-success');
                        $('#save_errlist').text('login successfully');
                        setTimeout(() => {
                            $('#save_errlist').html('');
                            $("#save_errlist").removeClass('alert alert-danger');
                        }, 2000);
                        window.location.href = "/cities";

                       }
                   },
                  error: function (response){
                    console.log(response.message);
                   if(response.status==400){
                       $('#loader').hide();
                       $('#save_errlist').html('');
                        $('#save_errlist').addClass('alert alert-danger');
                        $('#save_errlist').text('Invalid Phone or Password');
                        console.log(response.message);
                        setTimeout(() => {
                            $('#save_errlist').html('');
                            $("#save_errlist").removeClass('alert alert-danger');
                        }, 2000);
                   }
               },

              });

          });
</script>
