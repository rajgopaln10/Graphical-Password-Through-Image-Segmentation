<?php
if(isset($_POST['submit'])){
  //get user image from the folder based on user email and chceck if the user forget code is null
    include ('dbconnect.php');
    $userEmail=$_POST['email'];
    $sql = "SELECT id,email,forget_code FROM users WHERE forget_code IS NULL AND email='".$_POST['email']."' LIMIT 1";
    $res = mysqli_query($db, $sql); 
    $row= mysqli_fetch_array($res);
    $userID= $row['id'];
    if(!$userID){
      $msg='Email not exist';
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

    <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
    <link href="assets/css/style.css" rel="stylesheet" >

    <title>Graphical Authentication</title>
    <style>
      .ui-sortable img{
        width: 19%;
      }
    </style>
  </head>
  <body class=' registration'>

    <div class="container">

      <h3 class="text-center mt-5">Welcome to Graphical Authentication System</h3>
        <div class="row mt-3">
            <div class="col-md-4 offset-md-4 mt-5">
              <div class="card shadow-lg">
                
                <div class="card-body">
                <h3 class="text-center">Login </h3>
                  <form action="" class="mt-5" method="post">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="email" class="form-control"  name="email"  id="exampleInputEmail1" >
                    </div>
                    <div class="d-grid gap-2">
                    <button type="submit" name="submit" class="btn btn-success">Login</button>
                    </div>
                    
                    
                </form>
                <br>
                <p class="text-center">Don't have an account? <a href="user_registration.php" class="btn btn-link"> <strong>Register here</strong></a> </p>
                </div>
              </div>
                
            </div>
        </div> 
        <div class='mt-3' >
          <?php
          if(isset($msg))
          echo '<h5 class="text-center text-danger">'.$msg.'</h5>';
           ?>
        </div>
        <!-- end email submit -->
        <?php if(isset($userID)){ ?>
        <div class="card shadow-lg mt-5">
                <div class="card-body">
        <div class="row ">
            <div class="col-md-7 offset-md-3 mt-5" id="items">
              
                <?php
                
echo '<p><strong>Rearrange to its original image to login </strong></p>';
                //show the image
                $dirname = "image_passwords/".$userID;
                //get all the image of this folder
                $myfiles = array_diff(scandir($dirname), array('.', '..')); 
                $i=0;
                foreach($myfiles as $image) {
                    $i++;
                    echo '<img data-id="'.strtok($image, '.').'" style="margin:2px" src="'.$dirname.'/'.$image.'" />';
                    // if($i%5==0)
                    //     echo '<br/>';
                     }
                    
                ?>
                </div>
              </div>
              <div class="row ">
            <div class="col-md-7 offset-md-3 mt-5" >
              <div class="text-center mt-5">
          <div id="attempt" ></div>
          <button class="btn btn-primary btn-lg mt-2 w-100" id="submit" style="display:none"> Submit</button> 
          <h3 ><div class='authRes'></div></h3>
        </div>
            </div>
        </div>
        </div>
            </div>
            <?php } ?>
            <!-- end card -->
        
        
        <!-- end image password submit -->
    </div>
<br><br><br>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <script type="text/javascript" src="http://www.pureexample.com/js/lib/jquery.ui.touch-punch.min.js"></script>


    <script>
$(function () {
  var counter=0;
  var ct=0;
 var idsInOrder =[]
 //sortable function 
	$("#items").sortable({    
		start: function (event, ui) {
			ui.item.toggleClass("highlight");
		},
    // when a sortable drop action happens 
		stop: function (event, ui) {
			ui.item.toggleClass("highlight");
       idsInOrder = $("#items").sortable('toArray', {
      attribute: 'data-id'
    });
    ct=counter
    $("#submit").show();
    //after sorting when submit button clicked
    $( "#submit" ).click(function() {
      counter=ct+1;  
         
      // check if the order is correct
      var isSorted = true;
      for(var j = 0 ; j < idsInOrder.length - 1 ; j++){
          if(parseInt(idsInOrder[j]) > parseInt(idsInOrder[j+1])) {
              isSorted = false;
              //break the loop if the order is not correct and set isSorted to false
              break;
          }
      }
      // end order check
      //set max attemp to 3
      if(counter<3){        
      if(isSorted==true){
        $('.authRes').html('Authentication success');
        $('#attempt').html(''); 
        // after success move to success page
        setTimeout(function(){
          window.location.replace("success.php");
        }, 2000) 
      }else{
        $('.authRes').html('Authentication Failed');           
      }
    }else{
      //if max attemp reached update database and set a forget code for this user using ajax post request
      $("#submit").hide();
      $('#attempt').html(''); 
             $.ajax({
                  type: "POST",
                  url: 'enable_password_reset.php',
                  data: {userID:'<?= $userID;?>',userEmail:'<?= $userEmail;?>'},
                  success: function(response)
                  {
                      var jsonData = JSON.parse(response);
                      console.log(jsonData.email)
                      if (jsonData.success == "1")
                      {
                        $('.authRes').html('Maximum attempt reached. Check your email to reset image password');
                      }
                      else
                      {
                        $('.authRes').html('Maximum attempt reached and DB reset password query failed');
                      }
                }
            });
            //end ajax post
    }
      $('#attempt').html('Attempt remaining : '+(3-counter)); 
    });
		}
	});
    
	$("#items").disableSelection();
  
});
</script>
  </body>
</html>