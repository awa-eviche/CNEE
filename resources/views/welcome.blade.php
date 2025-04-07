<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Basic Page Needs
================================================== -->
  <meta charset="utf-8">
  <title>Convention Nationale  Etat Employeur</title>

  <!-- Mobile Specific Metas
================================================== -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Construction Html5 Template">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">

  <!-- Favicon
================================================== -->
  <link rel="icon" type="image/png" href="images/faviconcnee.png">

  <!-- CSS
================================================== -->
  <!-- Bootstrap -->
  <link rel="stylesheet" href="plugins/bootstrap/bootstrap.min.css">
  <!-- FontAwesome -->
  <link rel="stylesheet" href="plugins/fontawesome/css/all.min.css">
  <!-- Animation -->
  <link rel="stylesheet" href="plugins/animate-css/animate.css">
  <!-- slick Carousel -->
  <link rel="stylesheet" href="plugins/slick/slick.css">
  <link rel="stylesheet" href="plugins/slick/slick-theme.css">
  <!-- Colorbox -->
  <link rel="stylesheet" href="plugins/colorbox/colorbox.css">
  <!-- Template styles-->
  <link rel="stylesheet" href="css/style.css">

</head>
<body>
  <div class="body-inner">

    <div id="top-bar" class="top-bar">
        <div class="container">
          <div class="row">
              <div class="col-lg-8 col-md-8">
                <ul class="top-info text-center text-md-left">
                    <li><i class="fas fa-map-marker-alt"></i> <p class="info-text"> Sphere ministérielle, arrondissement 2, bâtiment C, 1er étage, Diamniadio -Dakar</p>
                    </li>
                </ul>
              </div>
              <!--/ Top info end -->
  
              <div class="col-lg-4 col-md-4 top-social text-center text-md-right">
                <ul class="list-unstyled">
                    <li>
                      <a title="Facebook" href="https://facebook.com/">
                          <span class="social-icon"><i class="fab fa-facebook-f"></i></span>
                      </a>
                      <a title="Twitter" href="https://twitter.com/">
                          <span class="social-icon"><i class="fab fa-twitter"></i></span>
                      </a>
                      <a title="Instagram" href="https://instagram.com/">
                          <span class="social-icon"><i class="fab fa-instagram"></i></span>
                      </a>

                    </li>
                </ul>
              </div>
              <!--/ Top social end -->
          </div>
          <!--/ Content row end -->
        </div>
        <!--/ Container end -->
    </div>
    <!--/ Topbar end -->
<!-- Header start -->
<header id="header" class="header-one">
  <div class="bg-white">
    <div class="container">
      <div class="logo-area">
          <div class="row align-items-center">
            <div class="logo col-lg-3 text-center text-lg-left mb-3 mb-md-5 mb-lg-0">
                <a class="d-block" href="/">
                  <img loading="lazy" width="1000px"src="images/banniere.png" alt="Constra">
                </a>
            </div><!-- logo end -->
  
            <div class="col-lg-9 header-right">
                <ul class="top-info-box">
                  <li>
                    <div class="info-box">
                      <div class="info-box-content">
                          <p class="info-box-title">Téléphone</p>
                          <p class="info-box-subtitle"><a href=""> (+221)338657109</a></p>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="info-box">
                      <div class="info-box-content">
                          <p class="info-box-title">Adresse Mail</p>
                          <p class="info-box-subtitle"><a href="mailto:de@gmail.com">direction.emploi@formation.gouv.sn</a></p>
                      </div>
                    </div>
                  </li>
                  <li class="last">
                    <div class="info-box last">
                      <div class="info-box-content">
                          <p class="info-box-title">Horaire de travail</p>
                          <p class="info-box-subtitle">LUNDI-VENDREDI:8H-17H</p>
                      </div>
                    </div>
                  </li>
                 
                </ul>
               

            </div><!-- header right end -->
          </div><!-- logo area end -->
  
      </div><!-- Row end -->
    </div><!-- Container end -->
  </div>
  @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
  <div class="site-navigation">
    <div class="container">
        <div class="row">
          <div class="col-lg-12">
              <!--  -->
          </div>
          <!--/ Col end -->
        </div>
        <!--/ Row end -->

        <div class="nav-search">
          <span id="search"><i class="fa fa-search"></i></span>
        </div><!-- Search end -->

        <div class="search-block" style="display: none;">
          <label for="search-field" class="w-100 mb-0">
            <input type="text" class="form-control" id="search-field" placeholder="Type what you want and enter">
          </label>
          <span class="search-close">&times;</span>
        </div><!-- Site search end -->
    </div>
    <!--/ Container end -->

  </div>
  <!--/ Navigation end -->
</header>
<!--/ Header end -->

<div class="banner-carousel banner-carousel-1 mb-0">
  <div class="banner-carousel-item" style="background-image:url(images/COUVERTURE.png)">
    <div class="slider-content">
        <div class="container h-100">
          <div class="row align-items-center h-100">
              <div class="col-md-12 text-center">
                <h2 class="slide-title" style="font-weight:bold;"data-class="animated fadeInDown" data-timeout="300">Convention Nationale Etat Employeur(CNEE)</h2>
                <h3 class="slide-sub-title">Direction de l'emploi</h3>
                <p>
                    <a href="files/projet de modele de demande d'adhésion.pdf" class="slider btn btn-primary">Modéle de demande</a>
                    <a href="{{route('entreprise.create')}}" class="slider btn btn-primary border">Adherer à la CNEE</a>
                    <a href="/login" class="slider btn btn-primary ">Se connecter</a>
                </p>
              </div>
          </div>
        </div>
    </div>
  </div>


  </div>

</div>

<section class="call-to-action-box no-padding">
  <div class="container">
    <div class="action-style-box">
        <div class="row align-items-center">
          <div class="col-md-8 text-center text-md-left">
              <div class="call-to-action-text">
                <h3 class="action-title"></h3>
              </div>
          </div><!-- Col end -->
          
          </div><!-- col end -->
        </div><!-- row end -->
    </div><!-- Action style box -->
  </div><!-- Container end -->
</section><!-- Action end -->

<section id="ts-features" class="ts-features" style="block-size: 300px;" >
  <div class="container">
    <div class="row">
        <div class="col-lg-20">
          <div class="ts-intro">
              <h2 class="into-title"style="font-weight: bold;">A propos de Nous</h2>
              <h3 class="into-sub-title" style="text-align: center;">Présentation de la convention</h3>
              <p>Signée en avril 2000, la CNEE constitue un cadre de partenariat efficace
entre l’Etat et le Patronat sénégalais en vue d’assurer une promotion active et régulière de l’emploi.Les différentes parties à la convention sont outre l’Etat, les entreprises à travers les organisations d’employeurs signataires et toutes autres organisations intéressées, notamment celles du secteur informel.La CNEE comporte des actions de promotion de l’emploi qui sont exécutées comme composantes essentielles de la politique nationale de l’emploi.</p>
          </div><!-- Intro box end -->

          <div class="gap-20"></div>

      

          <!--  -->
        </div><!-- Col end -->

        
    </div><!-- Row end -->
  </div><!-- Container end -->
</section><!-- Feature are end -->





<!--/ subscribe end -->



  <footer id="footer" class="footer bg-overlay"  >
    <div class="footer-main">
      <div class="container">
        <div class="row justify-content-between">
          <div class="col-lg-4 col-md-6 footer-widget footer-about">
            <h3 class="widget-title">A propos de nous</h3>
            <img loading="lazy" width="200px" class="footer-logo" src="images/banniere.png" alt="">
            <p>Convention Etat Employeur</p>
            <div class="footer-social">
              <ul>
                <li><a href="https://facebook.com/" aria-label="Facebook"><i
                      class="fab fa-facebook-f"></i></a></li>
                <li><a href="https://twitter.com/" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                </li>
                <li><a href="https://instagram.com/" aria-label="Instagram"><i
                      class="fab fa-instagram"></i></a></li>
              
              </ul>
            </div><!-- Footer social end -->
          </div><!-- Col end -->

          <div class="col-lg-4 col-md-6 footer-widget mt-5 mt-md-0">
            <h3 class="widget-title">Horaire de travail</h3>
            <div class="working-hours">
              La plateforme est acessible 24H/24.
              <br><br> Lundi - Vendrdi: <span class="text-right">08 - 17:00 </span>
              
            </div>
          </div><!-- Col end -->

          <div class="col-lg-3 col-md-6 mt-5 mt-lg-0 footer-widget">
            <h3 class="widget-title">Services</h3>
            <ul class="list-arrow">
              <li><a href="service-single.html">Comptable</a></li>
              <!-- <li><a href="service-single.html">General Contracting</a></li>
              <li><a href="service-single.html">Construction Management</a></li>
              <li><a href="service-single.html">Design and Build</a></li>
              <li><a href="service-single.html">Self-Perform Construction</a></li> -->
            </ul>
          </div><!-- Col end -->
        </div><!-- Row end -->
      </div><!-- Container end -->
    </div><!-- Footer main end -->

    <div class="copyright">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-6">
            <div class="copyright-info text-center text-md-left">
              <span>Copyright &copy;<script>
                  document.write(new Date().getFullYear())
                </script> <a href="">Convention Nationale Etat Employeur</a></span>
            </div>
          </div>

               </div><!-- Row end -->

        <!-- <div id="back-to-top" data-spy="affix" data-offset-top="10" class="back-to-top position-fixed">
          <button class="btn btn-primary" title="Back to Top">
            <i class="fa fa-angle-double-up"></i>
          </button>
        </div> -->

      </div><!-- Container end -->
    </div><!-- Copyright end -->
  </footer><!-- Footer end -->


  <!-- Javascript Files
  ================================================== -->

  <!-- initialize jQuery Library -->
  <script src="/plugins/jQuery/jquery.min.js"></script>
  <!-- Bootstrap jQuery -->
  <script src="/plugins/bootstrap/bootstrap.min.js" defer></script>
  <!-- Slick Carousel -->
  <script src="/plugins/slick/slick.min.js"></script>
  <script src="/plugins/slick/slick-animation.min.js"></script>
  <!-- Color box -->
  <script src="/plugins/colorbox/jquery.colorbox.js"></script>
  <!-- shuffle -->
  <script src="/plugins/shuffle/shuffle.min.js" defer></script>


  <!-- Google Map API Key-->
  <script src="/https://maps.googleapis.com/maps/api/js?key=AIzaSyCcABaamniA6OL5YvYSpB3pFMNrXwXnLwU" defer></script>
  <!-- Google Map Plugin-->
  <script src="/plugins/google-map/map.js" defer></script>

  <!-- Template custom -->
  <script src="/js/script.js"></script>

  </div><!-- Body inner end -->
  </body>

  </html>
