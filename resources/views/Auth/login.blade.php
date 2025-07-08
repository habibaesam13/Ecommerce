<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="css/login.css" rel="stylesheet">
  <title>Login</title>
</head>

<body>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10 col-lg-7">
        <div class="card card-gradient p-4 shadow rounded-4">
          <h3 class="text-center mb-4 customFont">Login</h3>
          <form action="{{ route('auth.login') }}" method="POST">
            @csrf
            <div class="mb-3">
              <label for="Email" class="form-label">Email address</label>
              <input type="email" class="form-control" id="Email" name="email" required>
              <div id="emailHelp" class="form-text text-light">We'll never share your email.</div>
            </div>
            <div class="mb-3">
              <label for="Password" class="form-label">Password</label>
              <input type="password" class="form-control" id="Password" name="password" required>
            </div>
            <button type="submit" class="btn btn-light w-100 mt-2">Login</button>
            <div class="text-center mt-3">
              <a href="{{ route('password.forget') }}" class="text-light">Forgot Password?</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>