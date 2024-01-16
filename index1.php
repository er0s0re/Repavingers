<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register Page</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
  <div class="container">
    <div class="row justify-content-center mt-5">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Register</h4>
          </div>
          <div class="card-body">
            <form method="POST" action="register1.php">
              <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Enter your name">
              </div>
              <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Enter your address">
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
              </div>
              <div class="mb-3">
                <label for="telepon" class="form-label">Telepon</label>
                <input type="text" class="form-control" id="telepon" name="telepon" placeholder="Enter your phone number">
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
              </div>
              <button type="submit" class="btn btn-primary" name="register">Register</button>
            </form>
          </div>
          <div class="card-footer">
            <p>Already have an account? <a href="index.php">Login</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Include Google Places API script -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD0AF8_ulU9b6sFPjwZhUNtm9pN_owjWUU&libraries=places"></script>
  <script>
    // Initialize the Google Places Autocomplete
    function initializeAutocomplete() {
      var input = document.getElementById('alamat');
      var autocomplete = new google.maps.places.Autocomplete(input);
    }

    // Trigger autocomplete initialization when the page loads
    google.maps.event.addDomListener(window, 'load', initializeAutocomplete);
  </script>
</body>

</html>
