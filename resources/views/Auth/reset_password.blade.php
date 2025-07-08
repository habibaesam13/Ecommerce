<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="/css/login.css" rel="stylesheet">
  <title>Reset Password</title>
</head>
<body>

  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card card-gradient p-4 shadow rounded-4" style="max-width: 450px; width: 100%;">
      <h4 class="text-center mb-4 customFont">Reset Password</h4>

      @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
      @endif
      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif

      <form action="{{ route('password.reset') }}" method="POST">
        @csrf

        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" name="email" class="form-control" required>
          @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
          <label for="otp" class="form-label">OTP</label>
          <input type="text" name="otp" class="form-control" required>
          @error('otp') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">New Password</label>
          <input type="password" name="password" class="form-control" required>
          @error('password') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
          <label for="password_confirmation" class="form-label">Confirm Password</label>
          <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-light w-100">Reset Password</button>
      </form>
    </div>
  </div>

</body>
</html>
