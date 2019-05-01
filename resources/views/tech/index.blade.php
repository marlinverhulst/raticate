<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="csrf-token" content="{{ csrf_token()}}">

  <title>Raticate- Technician</title>
  


  <!-- Custom fonts for this template-->
  <link href="admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">
    
  <!-- Custom styles for this template-->
  <link href="admin/css/sb-admin-2.min.css" rel="stylesheet">
  <script src="{{ asset('js/app.js') }}" defer></script>
  <link rel="stylesheet" type="text/css" href="{{ url('/css/costom.css') }}" />
  
  
  

  
  
  

</head>

<body id="page-top">
  
    
        <header>
           
            <div class="row navbar navbar-dark bg-dark shadow-sm mb-3">
                <div class="container d-flex justify-content-between">
                    <a href="#" class="navbar-brand d-flex align-items-center">
                        <strong>Raticate</strong>
                    </a>
                    <div class="dropdown show">
                        <button class="navbar-toggler " type="button" data-toggle="dropdown" id="MenuDropDownButton"
                            aria-haspopup="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon float-right"></span>
                        </button>
                        <!-- dropdown for menu-->
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="MenuDropDownButton">
                            
                            <a class="dropdown-item" href="#"><div class="float-left mr-4"><i class="fas fa-book-open"></i></div> Help </a>
                            
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href={{ route('logout') }} onclick="event.preventDefault();
                            document.getElementById('teclogout-form').submit();"><div class="float-left mr-4"><i class="fas fa-sign-out-alt"></i></div> Log-out </a>
                            
                              <form id="teclogout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                 @csrf
                              </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--end of the menubar-->
        </header>

        <!-- start of visitdates components -->
        
        <div id="app">
            <visit-component></visit-component>
           

    
    
    
    
    
        </div> <!-- end of app -->
        
        
    

</body>

</html>