<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

  <link rel="stylesheet" href="{{ asset('css/leaflet.css'); }}">
  <link rel="stylesheet" href="{{ asset('css/easy-button.css'); }}">
  <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css'); }}">
  <link rel="stylesheet" href="{{ asset('css/flatpickr.min.css'); }}">
  <link rel="stylesheet" href="{{ asset('css/main.css'); }}">
  <script src="{{ asset('js/leaflet.js'); }}"></script>
  <script src="{{ asset('js/easy-button.js'); }}"></script>
  <script src="{{ asset('js/sweetalert2.min.js'); }}"></script>
  <script src="{{ asset('js/flatpickr.js'); }}"></script>

  <title>SI Pertanian Dago, Bandung</title>
</head>
<body>
  <header id="header-banner" class="text-center mx-auto my-0 bg-darkgreen">
    <h1 class="font-weight-normal text-white py-3">Sistem Informasi Pertanian Kel. Dago, Kota Bandung</h1>
  </header>

  <main id="map-container" class="container-fluid p-0" style="margin-top: -0.5rem">
    <div id="mapid"></div>
  </main>

  <footer class="text-muted text-center p-2">
    <div class="container">
    <p>Kec. Coblong, Kel. Dago, Kota Bandung</p>
      <p>KOMAWAN5 2023</p>
    </div>
  </footer>

  <script src="{{ asset('js/jquery-3.4.1.min.js'); }}"></script>
  <script src="{{ asset('js/popper.min.js'); }}"></script>
  <script src="{{ asset('js/bootstrap.min.js'); }}"></script>
  <script src="{{ asset('js/user.js'); }}"></script>
</body>
</html>
