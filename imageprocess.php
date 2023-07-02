<?php
include ('dbconnect.php');
$loginFlag=true;
//function to slice image into grid
function imageSlice($imgName,$dir,$ext){
//set x y grid (number of image pieces)
    $number_of_grid_x = 5;
    $number_of_grid_y = 5;

//Create a new image from file
if($ext=='png')
    $source = @imagecreatefrompng( $imgName );
else
    $source = @imagecreatefromjpeg( $imgName );
//get width heigh of the uploaded image
$source_width = imagesx( $source );
$source_height = imagesy( $source );

//set the width height based on grid value
$width = $source_width/$number_of_grid_x;
$height = $source_height/$number_of_grid_y;
$i=1;

//loop through number of grid value
for( $col = 0; $col < $source_width / $width; $col++)
{
    for( $row = 0; $row < $source_height / $height; $row++)
    {

        //set file name
        $fn = sprintf( $dir."/%d.jpg", $i );

        //Create a new true color image
        $im = @imagecreatetruecolor( $width, $height );

        //Copy and resize part of an image
        imagecopyresized( $im, $source, 0, 0,
            $row * $width, $col * $height, $width, $height,
            $width, $height );  
        //Output image to file          
        imagejpeg( $im, $fn );
        imagedestroy( $im );
        $i++;
        }
    }
    //after creating grid , remove the original uploaded image as its not needed any more (to save space)
    unlink($imgName);

}
//create new user
if(isset($_POST['submit'])){

    // get user information as post request
    $fullName =$_POST['fullName']; 
    $emailAddress =$_POST['emailAddress']; 

    // user already exist

    $sql = "SELECT id,email,forget_code FROM users WHERE forget_code IS NULL AND email='".$_POST['emailAddress']."' LIMIT 1";
    $res = mysqli_query($db, $sql); 
    $row= mysqli_fetch_array($res);
    $userID= $row['id'];
    if($userID){
      $msg='User already registered with this image';
      $loginFlag=false;
    }else{
        //check if there is any image uploaded and process the image
        if (isset($_FILES['imagePassword'])) {

            // get image name without extension
            $filenameArray = explode(".", $_FILES["imagePassword"]["name"]);
            //set a unique image name to overcome override isse
            $newfilename = round(microtime(true)) . '.' . end($filenameArray);
                
            $tempname = $_FILES["imagePassword"]["tmp_name"]; 
                // query to insert the submitted data
                $sql = "INSERT INTO users (name,email,picture) VALUES ('$fullName','$emailAddress','$newfilename')";
                // function to execute above query
                mysqli_query($db, $sql); 
                //get inserted id to get user id and create directory for this user
                $last_id = mysqli_insert_id($db); 
                $dir='image_passwords/'.$last_id;

                //create directory if there is none for this user
                if( is_dir($dir) === false )
                {
                    mkdir($dir);
                }      
        
                // upload the image to the folder"            
                if (move_uploaded_file($tempname, $dir.'/'.$newfilename)) {
                    imageSlice($dir.'/'.$newfilename,$dir,end($filenameArray));
        
                    $msg = "Account created successfully";
        
                }else{
        
                    $msg = "Failed to upload image";
                }
        }else{
            $msg = "Choose an image";
        }
    }

    
}
//update password image
if(isset($_POST['reset'])){

    if (isset($_FILES['imagePassword'])) {
    $uid=$_POST['uid'];
        $filenameArray = explode(".", $_FILES["imagePassword"]["name"]);
        $newfilename = round(microtime(true)) . '.' . end($filenameArray);
    
        $tempname = $_FILES["imagePassword"]["tmp_name"]; 
            //set the folder where to upload (user id) 
            $dir='image_passwords/'.$uid;
            // upload the image to the "image" folder"        
            if (move_uploaded_file($tempname, $dir.'/'.$newfilename)) {
                imageSlice($dir.'/'.$newfilename,$dir);
    
                $msg = "Updated successfully";
                //update query to set forget code null
                $sql = "UPDATE `users` SET `forget_code` = NULL WHERE `users`.`id` = $uid";
                mysqli_query($db, $sql); 
    
            }else{
    
                $msg = "Failed to upload image";
            }
    }else{
        $msg = "Choose an image";
    }
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

    <title>Graphical Authentication</title>
  </head>
  <body class="registration">
      <div class="container text-center mt-5">
<br> <br> <br>
<div class="card shadow-lg">
    <div class="card-body">
        <h3><?= $msg; ?></h3>
        <?php
        if($loginFlag)
            echo '<a href="index.php" class="btn btn-success">Login</a>';
        else
            echo '<a href="user_registration.php" class="btn btn-success">Register Again</a>';
        ?>

    </div>
</div>

      </div>    
  </body>
</html>