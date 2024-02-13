<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHQMM :: Administrative Panel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            max-width: 400px;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 40px;
        }
        .login-container h2 {
            font-family: math ;
            margin-bottom: 30px;
            text-align: center;
        }
        .form-control {
            border-radius: 20px;
        }
        .login-btn {
            border-radius: 20px;
            font-weight: 600;
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .login-btn:hover {
            background-color: #004080;
            border-color: #004080;
        }
        .logo-container {
            text-align: center;
            margin-bottom: 20px;
        }

    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo-container">
            <img src="{{asset('admin-assets/img/login.png')}}" alt="Logo" class="logo-img" style="max-width: 60px;">
        </div>
        <h2>Administrative Panel</h2>
        <form action="{{route('admin.authenticate')}}" method="post">
            @csrf
            <div class="form-group">
                <input type="number" name="mobile" id="mobile" class="form-control" placeholder="Mobile Number">
            </div>
            <div class="form-group">
                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
            </div>
            <button type="submit" class="btn btn-primary btn-block login-btn">Login</button>
            <br>
        </form>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
