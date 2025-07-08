<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/login.css" rel="stylesheet">
    <title>@yield('title', config('app.name'). "-Forgot Password")</title>
</head>
<body>

  <div class="card card-gradient p-4 shadow rounded-4" style="width: 100%; max-width: 600px;">
    <h4 class="text-center mb-4 customFont">Forgot Password</h4>

    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @elseif (session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <form action="{{ route('sendOtp') }}" method="POST">
      @csrf
      <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input 
          type="email" 
          name="email" 
          class="form-control" 
          id="email" 
          placeholder="Enter your email"
          required
        >
        @error('email')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>

      <button type="submit" class="btn btn-light w-100">Send OTP</button>
    </form>
  </div>

</body>

</html>
