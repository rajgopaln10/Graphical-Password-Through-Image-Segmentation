<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="assets/css/style.css" rel="stylesheet" >

    <title>User Registration with image password</title>
  </head>
  <body class='registration'>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-4 offset-md-4 mt-5">
                <div class="card shadow-lg">
                    <div class="card-body">
                <h3 class="text-center">Register </h3>
                <form class="mt-5" action="imageprocess.php" method="post" action="" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="fullName" class="form-label">Full Name</label>
                        <input type="text" class="form-control" name="fullName" id="fullName" require >
                    </div>
                    <div class="mb-3">
                        <label for="emailAddress" class="form-label">Email address</label>
                        <input type="email" class="form-control" name="emailAddress" id="emailAddress" require >
                    </div>
                    <div class="mb-3">
                        <label for="imagePassword" class="form-label">Image password</label>
                        <input type="file" class="form-control" name="imagePassword" id="imagePassword" require >
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success" name="submit">Register</button>
                    </div>
                    
                </form>
                <br>
                <p class="text-center">Already have an account? <a href="index.php" class="btn btn-link"> <strong>Login here</strong></a> </p>
                
            </div>
            </div>
            </div>
        </div>
    </div>

    

    
  </body>
</html>