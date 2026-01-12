<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Login</title>
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

   <div class="h-100 d-flex align-items-center justify-content-center" style="height: 100vh!important;">
        <main class=" form-sigin m-auto bg-body-tertiary p-5 " style="width: 60vh!important;">
            <div class="text-center mb-3">
                <img src="https://www.w3schools.com/howto/img_avatar2.png" alt="avatar" class="avatar">

            </div>
            <form action="{{route('login.authenticate')}}" method="post" enctype="multipart/form-data">
                @csrf
                <h1>Login</h1>

                <div class="form-floating mb-3">
                    <input type = "email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder='email'>
                   
                    @error('email')
                    <div class="message mb-2 text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input type = "password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder='Password'>
                    
                    @error('password')
                    <div class="message mb-2 text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-success w-100 py-2">Sign in</button>
                
            </form>
        </main>

    </div> 
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  </body>
</html>