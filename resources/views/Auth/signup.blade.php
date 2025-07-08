<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="css/login.css" rel="stylesheet">
    <title>Sign Up</title>
  </head>
  <body>

    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-10 col-lg-7">
          <div class="card card-gradient p-4 shadow rounded-4">
            <h3 class="text-center mb-4 customFont">Sign Up</h3>


            <form action="{{ route('auth.register') }}" method="POST">
              @csrf

              {{-- Name --}}
              <div class="mb-3">
                <label for="Name" class="form-label">Full Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="Name" name="name" value="{{ old('name') }}" required>
                @error('name')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>

              {{-- Email --}}
              <div class="mb-3">
                <label for="Email" class="form-label">Email address</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="Email" name="email" value="{{ old('email') }}" required>
                @error('email')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>

              {{-- Password --}}
              <div class="mb-3">
                <label for="Password" class="form-label">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="Password" name="password" required>
                @error('password')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>

              {{-- Address --}}
              <div class="mb-3">
                <label for="Address" class="form-label">Address</label>
                <input type="text" class="form-control @error('address') is-invalid @enderror" id="Address" name="address" value="{{ old('address') }}" required>
                @error('address')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>

              <button type="submit" class="btn btn-light w-100 mt-2">Register</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
