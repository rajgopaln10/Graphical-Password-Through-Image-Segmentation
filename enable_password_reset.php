<?php
//reset image password after three unsuccessfull attemp
if(isset($_POST['userID'])){
    //get user id and email who is trying to reset
    $uID=$_POST['userID'];    
    $userEmail=$_POST['userEmail'];  

    include ('dbconnect.php');
    //generate a unique id (current microtime) for reset image password 
    $t=time();

    $sql = "UPDATE `users` SET `forget_code` = $t WHERE `users`.`id` = $uID";
    //update database with the unique id as forget code for specific user
    $res = mysqli_query($db, $sql); 

    //set what to send over the email
    $msg="http://mchowdhury.co.uk/image_pass/reset_password.php?code=$t&uid=$uID";
    if($res){
        //send email
        mail($userEmail,"Reset image password",$msg);
        //send a respose back to user screen upon successfull update
        echo json_encode(array('success' => 1,'email'=>$userEmail));
        
    }else{
        echo json_encode(array('success' => 0));
    }
    
}
?>