<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Home</title>
    <style type="text/css">
        body {
            background-color: #f8f9fa;
        }

        img.avatar {
            width: 40%;
            border-radius: 50%
        }
    </style>
  </head>
  <body>

    <div class= "p-4">
        <h1 class= "display-5 fw-bold">Hi,{{ Auth::user()->name }}</h1>
        <hr>

        <p>Dashboard</p>
        <p>Login Success.</p>
        <a href="{{ route("logout")}}" class="btn btn-success py-2 w-10">Logout</a>
    </div>
        

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>