<?php
//user comes here when they click on the link they get on email for resetting password
// the image reset process done on imageprocess.php page

if(isset($_GET['code'])){
  // get user id and code from url variable 
    $code=$_GET['code'];
    $uid=$_GET['uid'];    
}
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="assets/css/style.css" rel="stylesheet" >
    <title>Reset Password</title>
  </head>
  <body class="registration">
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-4 offset-md-4 mt-5">
              <div class="card shadow-lg">
                <div class="card-body">
                  <h3>Reset image password</h3>
                  <form class="mt-5" action="imageprocess.php" method="post" action="" enctype="multipart/form-data">                    
                      <div class="mb-3">
                          <label for="imagePassword" class="form-label">Image password</label>
                          <input type="hidden" name="uid" value="<?= $uid ?>">
                          <input type="file" class="form-control" name="imagePassword" id="imagePassword" require >
                      </div>                    
                      <button type="submit" class="btn btn-primary w-100" name="reset">Reset Password</button>
                  </form>
                </div>
              </div>
                
            </div>
        </div>
    </div>
    
  </body>
</html>