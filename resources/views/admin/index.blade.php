<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

  <link rel="stylesheet" href="{{ asset('css/leaflet.css') }}">
  <link rel="stylesheet" href="{{ asset('css/easy-button.css') }}">
  <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/flatpickr.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/main.css') }}">
  <script src="{{ asset('js/leaflet.js') }}"></script>
  <script src="{{ asset('js/easy-button.js') }}"></script>
  <script src="{{ asset('js/sweetalert2.min.js') }}"></script>
  <script src="{{ asset('js/flatpickr.js') }}"></script>
  {{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.11.1/dist/cdn.min.js"></script> --}}
  <script>
    function turn_overlay(state) {
      state === true ? document.getElementById('loading-overlay').style.display = 'flex' : document.getElementById(
        'loading-overlay').style.display = 'none';
    }

    function delete_sawah(id) {
      Swal.fire({
        text: 'Yakin ingin menghapus?',
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Batalkan'
      }).then((result) => {
        if (!result.value) return;

        turn_overlay(true);
        $.ajax({
          url: "{{ URL::to('/web-api/sawah/delete') }}/" + id,
          type: 'GET',
          cache: false,
          //   data: {
          //     id: id,
          //   },
          error: function(err) {
            console.log('Error deleting data', err);
          },
          success: function(response) {
            Swal.fire({
              icon: 'success',
              text: 'Lahan berhasil dihapus',
              toast: true,
              position: 'top',
              showConfirmButton: false,
              timer: 4000,
            });

            location.reload();
          }
        }).done(() => {
          turn_overlay(false);
        });
      })
    }

    function get_detail(id) {
      turn_overlay(true);
      return $.ajax({
        url: "{{ URL::to('/web-api/sawah/get') }}/" + id,
        type: 'GET',
        error: function(err) {
          Swal.fire({
            title: 'Terjadi kesalahan',
            icon: 'error',
            toast: true
          });
          console.log('Error sending data', err);
        },
        success: function(response) {
          if (response.code === 200) {
            console.log("sukses");
            detail = response.data;
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Terjadi kesalahan',
              text: response.message,
              toast: true,
              position: 'top',
              showConfirmButton: false,
              timer: 4000,
            });
            console.log('Error', response);
          }
        }
      }).done(() => {
        turn_overlay(false);
      });
    }

    async function show_form(id) {
      get_detail(id).then(async () => {
        const {
          value: formValues,
          dismiss
        } = await Swal.fire({
          title: 'Isi Informasi Lahan',
          html: `
          <div id="field-form">
            <table>
              <tr>
                <th>Pemilik</th>
                <td><input required type="text" id="owner-name" class="swal2-input" placeholder="Pemilik" value="${detail.owner}"></td>
              </tr>
              <tr>
                <th>Tanaman</th>
                <td><input required type="text" id="crop" class="swal2-input" placeholder="Tanaman" value="${detail.crop}"></td>
              </tr>
              <tr>
                <th>Dusun</th>
                <td><input required type="text" id="hamlet" class="swal2-input" placeholder="Dusun" value="${detail.hamlet}"></td>
              </tr>
              <tr>
                <th>Tanggal Tanam</th>
                <td><input required type="text" id="planting-date" class="swal2-input datepickr" placeholder="Tanggal Tanam" value="${detail.planting_date}"></td>
              </tr>
            </table>
          </div>
          `,
          focusConfirm: false,
          confirmButtonText: 'Simpan',
          confirmButtonColor: '#0c0',
          allowOutsideClick: false,
          allowEscapeKey: false,
          allowEnterKey: false,
          showCancelButton: true,
          cancelButtonText: 'Batalkan',
          onOpen: () => {
            flatpickr(".datepickr", {});
          },
          preConfirm: () => {
            let v = {
              ownerName: document.getElementById('owner-name').value,
              crop: document.getElementById('crop').value,
              hamlet: document.getElementById('hamlet').value,
              plantingDate: document.getElementById('planting-date').value,
            }

            // check empty value
            for (let [, val] of Object.entries(v)) {
              if (val === '') {
                Swal.showValidationMessage(`Harap isi semua input yang ada`);
              }
            }

            if (!v.plantingDate.match(
                /([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))/i)) {
              Swal.showValidationMessage(`Format tanggal salah`);
            }

            v.id = id;
            return v;
          }
        });

        return formValues;
      }).then((data) => {
        if (data !== undefined) {
          sendUpdate(data);
        }
      });
    }

    function sendUpdate(data) {
      turn_overlay(true);
      $.ajax({
        url: "{{ URL::to('/web-api/sawah/update') }}",
        type: 'POST',
        cache: false,
        data: {
          id: data.id,
          owner: data.ownerName,
          crop: data.crop,
          hamlet: data.hamlet,
          planting_date: data.plantingDate,
        },
        error: function(err) {
          Swal.fire({
            title: 'Terjadi kesalahan',
            icon: 'error',
            toast: true
          });
          console.log('Error sending data', err);
        },
        success: function(response) {
          if (response.code === 200) {
            Swal.fire({
              icon: 'success',
              text: 'Lahan berhasil disimpan',
              toast: true,
              position: 'top',
              showConfirmButton: false,
              timer: 4000,
            });
            location.reload();
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Terjadi kesalahan',
              text: response.message,
              toast: true,
              position: 'top',
              showConfirmButton: false,
              timer: 4000,
            });
            console.log('Error in response', response);
          }
        }
      }).done(() => {
        turn_overlay(false);
      });
    }
  </script>

  <title>SI Pertanian Dago, Bandung</title>
</head>

<body>
  <header id="header-banner" class="text-center mx-auto my-0 bg-darkgreen">
    <h1 class="font-weight-normal text-white py-3">Sistem Informasi Pertanian Kel. Dago, Kota Bandung</h1>
  </header>
  <main id="map-container" class="container-fluid p-0" style="margin-top: -0.5rem">
    <div id="tab1">
      <div id="mapid"></div>
    </div>
    <div id="tab2" style="display: none">
      <button onclick="switchTab()" class="btn-primary" style="margin: 1rem">Kembali ke Peta</button>
      <div id="loading-overlay" class="h-100 w-100 position-absolute justify-content-center align-items-center"
        style="display: flex; background-color: rgba(0, 0, 0, 0.4)">
        <div class="spinner-grow text-primary" role="status">
          <span class="sr-only">Loading...</span>
        </div>
      </div>
      <h1>Daftar Petak Sawah <span class="text-muted">Kelurahan Dago, Bandung</span></h1>
      <table class="table table-bordered table-responsive">
        <tr>
          <th>No.</th>
          <th>Pemilik</th>
          <th>Dusun</th>
          <th>Tanaman</th>
          <th>Tanggal</th>
          <th>Action</th>
        </tr>
        <?php $no = 1; foreach($all_sawah as $sawah): ?>
        <tr>
          <td><?= $no ?></td>
          <td id="<?= 'td-owner-' . $sawah->id ?>"><?= $sawah->owner ?></td>
          <td id="<?= 'td-hamlet-' . $sawah->id ?>"><?= $sawah->hamlet ?></td>
          <td id="<?= 'td-crop-' . $sawah->id ?>"><?= $sawah->crop ?></td>
          <td id="<?= 'td-plantingdate-' . $sawah->id ?>"><?= $sawah->planting_date ?></td>
          <td>
            <button class="btn btn-sm btn-outline-secondary" onclick="show_form(<?= $sawah->id ?>)"><i
                class="fa fa-pen"></i></button>
            <button class="btn btn-sm btn-outline-danger" onclick="delete_sawah(<?= $sawah->id ?>)"><i
                class="fa fa-times"></i></button>
          </td>
        </tr>
        <?php $no++; endforeach; ?>
      </table>
    </div>
  </main>

  <footer id="footer" class="text-muted text-center p-2">
    <div class="container">
      <p>Kec. Coblong, Kel. Dago, Kota Bandung</p>
      <p>KOMAWAN5 2023</p>
    </div>
  </footer>

  <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
  <script src="{{ asset('js/popper.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/main_gis.js') }}"></script>
  <script>
    document.getElementById('loading-overlay').style.display = 'none';
  </script>
</body>

</html>
