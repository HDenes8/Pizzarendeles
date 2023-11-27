<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="shortcut icon" href="images/pizza-1.jpg" type="image/x-icon">
    <title>Restorante Pizzázó</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nothing+You+Could+Do" rel="stylesheet">

    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">

    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/ionicons.min.css">

    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">

    
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
      .dropdown{
        background-color:transparent;
        border:none;
        color:white;
        width: 200px;
        margin-bottom:20px;
        padding:5px;
        border-radius:8px
      }
      .dropdown:focus{
        background-color:black;
        color:gold;
        border-radius:8px
      }
    </style>
  </head>
  <body>
  	<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container">
	      <a class="navbar-brand" href="index.html"><span class="flaticon-pizza-1 mr-1"></span>Restoranto<br><small></small></a>
	      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="oi oi-menu"></span> Menü
	      </button>
	      <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav ml-auto">
	          <li class="nav-item"><a href="index.html" class="nav-link">Kezdőlap</a></li>
	          <li class="nav-item"><a href="menu.html" class="nav-link">Menü</a></li>
	          <li class="nav-item"><a href="services.html" class="nav-link">Szolgáltatások</a></li>
	          <li class="nav-item"><a href="about.html" class="nav-link">Rólunk</a></li>
	          <li class="nav-item"><a href="contact.html" class="nav-link">Kapcsolat</a></li>
            <li class="nav-item active"><a href="order.php" class="nav-link">Rendelés</a></li>
	        </ul>
	      </div>
		  </div>
	  </nav>
    <!-- END nav -->

    <section class="home-slider owl-carousel img" style="background-image: url(images/bg_1.jpg);">

      <div class="slider-item" style="background-image: url(images/bg_3.jpg);">
      	<div class="overlay"></div>
        <div class="container">
          <div class="row slider-text justify-content-center align-items-center">

            <div class="col-md-7 col-sm-12 text-center ftco-animate">
            	<h1 class="mb-3 mt-5 bread">Rendeld meg kedvenc pizzád</h1>
	            <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Kezdőlap</a></span> <span>Rendelés</span></p>
            </div>

          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section contact-section">
      <div class="container mt-5">
        <div class="row block-9">
					<div class="col-md-1"></div>
          <div class="col-md-6 ftco-animate">
            <form action="order.php" method="post" class="contact-form">
              <p style="font-size: xx-large;">RENDELÉSI LAP</p>
            	<div class="row">
            		<div class="col-md-7">
                  <p>Válassz pizzát:</p>
                  <?php
                      include("connection.php");
                      $sql = "SELECT nev FROM aktualis_pizzak";
                      $result = $conn->prepare($sql);
                      $result->execute();
                      echo "<select name='pizza' class='dropdown'>";
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                          $nev_value = $row['nev'];
                          echo "<option value='$nev_value'>$nev_value</option>";
                        }
                      echo "</select>";
                    ?>
                    <p>Méret:</p>
                    <?php
                      include("connection.php");
                      $sql = "SELECT * FROM meret_tabla";
                      $result = $conn->prepare($sql);
                      $result->execute();
                      echo "<select name='meret' class='dropdown'>";
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                          $meret_value = $row['meret'];
                          $ar = $row['ar'];
                          echo "<option value='$meret_value'>$meret_value cm - $ar Ft</option>";
                        }
                      echo "</select>";
                    ?>
                    <p>Mennyiség:</p>
                    <select name="mennyiseg" class="dropdown">
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <option value="6">6</option>
                      <option value="7">7</option>
                      <option value="8">8</option>
                    </select>
	                <div class="form-group">
	                  <input type="text" name="cim" class="form-control" placeholder="Szallítási címed" required maxlength="150">
	                </div>
                  <div class="form-group">
                    <input type="text" name="tel_szam" class="form-control" placeholder="Telefonszámod (pl:06201234567)" required maxlength="11">
                  </div>
                 
                  
                    
                    
                  
                  <div class="form-group" style="border-radius:5px">
                    <input type="submit" name="megrendel" value="Megrendelés" class="btn btn-primary py-3 px-5">
                  </div>
                  <?php
                    include("connection.php");
                    include("api.php");
                    if (isset($_POST['megrendel'])) {
                      $pizza=$_POST['pizza'];
                      $feltet;
                      $meret=$_POST['meret'];
                      $ar;
                      $mennyiseg=intval($_POST['mennyiseg']);
                      $rendeles_ideje = date("Y-m-d H:i:s");
                      $kiszallitas_ideje;
                      $cim=$_POST['cim'];
                      $tel_szam=$_POST['tel_szam'];

                      //PIZZÁHOZ TARTOZÓ FELTÉT (AZÉRT KELL HÁTHA IDŐ KÖZBEN MEGVÁTOZIK MÁS FELTÉTRE A PIZZA ÉS LÁSSUK HOGY MILYEN FELTÉTTEL RENDELTE ANNO A FASZOS)
                      $sql = "SELECT feltet FROM aktualis_pizzak WHERE nev='$pizza'";
                      $result = $conn->prepare($sql);
                      $result->execute();
                      $row = $result->fetch(PDO::FETCH_ASSOC);
                      $feltet = $row['feltet'];

                      $datum = new DateTime($rendeles_ideje);
                      // Az érkezés este 10 után van, a várható kiszállítás másnap reggel 8
                      if ($datum->format('H') >= 22) {
                        $datum = $datum->modify('tomorrow')->setTime(8, 0, 0);
                        $kiszallitas_ideje = $datum->format('Y-m-d-H-i-s');

                      }else {
                        // Az érkezés este 10 előtt van, a várható kiszállítás az érkezéstől számított 1 óra
                        $datum = $datum->modify('+1 hour');
                        $kiszallitas_ideje = $datum->format('Y-m-d-H-i-s');
                      }

                      //MEGKERESSÜK HOGY A KIVÁLASZTOTT MÉRETNEK MENNYI AZ ÁRA
                      $sql = "SELECT ar FROM meret_tabla WHERE meret='$meret'";
                      $result = $conn->prepare($sql);
                      $result->execute();
                      $row = $result->fetch(PDO::FETCH_ASSOC);
                      $egy_ar = $row['ar'];
                      //MAJD MEGSZOROZZUK A MENNYISÉGGEL
                      $ar = $egy_ar * $mennyiseg;

                      try {
                        $rendeles = new Rendeles($pizza, $feltet, $meret, $ar, $mennyiseg, $rendeles_ideje, $cim, $tel_szam, "nem ismert", $kiszallitas_ideje, "beérkezett");
                        $rendeles->rendeles_leadas();
                        echo "<script>alert('Sikeres rendelés!')</script>";
                      } catch (\Throwable $th) {
                        echo "Hiba történt: " . $th->getMessage();
                      }
                    }
                  ?>
                  
                </div>
            </form>
            <p>Ha a megrendelésed 22 óra után érkezik be hozzánk akkor sajnos azt csak másnap reggel tudjuk neked kivinni, 22 óra előtt viszont egy órán belül (általában 30 percen belül) élvezheted a megrendelt pizzád!</p>
          </div>
        </div>
      </div>
    </section>

    <div id="map"></div>
    

    <footer class="ftco-footer ftco-section img">
    	<div class="overlay"></div>
      <div class="container">
        <div class="row mb-5">
          <div class="col-lg-4 col-md-6 mb-5 mb-md-5">
            <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Rólunk</h2>
              <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
              <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
                <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
              </ul>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 mb-5 mb-md-5">
             <div class="ftco-footer-widget mb-4 ml-md-4">
              <h2 class="ftco-heading-2">Szolg.</h2>
              <ul class="list-unstyled">
                <li><a href="#" class="py-2 d-block">Cooked</a></li>
                <li><a href="#" class="py-2 d-block">Deliver</a></li>
                <li><a href="#" class="py-2 d-block">Quality Foods</a></li>
                <li><a href="#" class="py-2 d-block">Mixed</a></li>
              </ul>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 mb-5 mb-md-5">
            <div class="ftco-footer-widget mb-4">
            	<h2 class="ftco-heading-2">Van kérdésed?</h2>
            	<div class="block-23 mb-3">
	              <ul>
	                <li><span class="icon icon-map-marker"></span><span class="text">5286 Pécs, Mimóza utca 36.</span></li>
	                <li><a href="#"><span class="icon icon-phone"></span><span class="text">+36 (70) 123 7890</span></a></li>
	                <li><a href="#"><span class="icon icon-envelope"></span><span class="text">info@restorante.com</span></a></li>
	              </ul>
	            </div>
            </div>
          </div>
        </div>
        
      </div>
    </footer>
    
  

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>


  <script src="js/jquery.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/jquery.waypoints.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/jquery.animateNumber.min.js"></script>
  <script src="js/bootstrap-datepicker.js"></script>
  <script src="js/jquery.timepicker.min.js"></script>
  <script src="js/scrollax.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="js/google-map.js"></script>
  <script src="js/main.js"></script>
    
  </body>
</html>