
{{-- resources/views/emails/recoveryPassword.blade.php --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Recovery Password</title>
    <!-- Agrega estos enlaces para Bootstrap 5 CSS -->
    <!-- vite[('resources/js/app.js')] -->
</head>
<body>

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Recovery Password</div>

                <div class="card-body">
                    <form method="POST" action="http://localhost:8000/api/forgetPassword" enctype="multipart/form-data">
                        
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="mb-3">
                            <label for="email" class="form-label">E-Mail Address</label>
                            <input id="email" type="email" class="form-control" name="email" value="" required autocomplete="email" autofocus>
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Recovery Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
