<?php 
  $db = "ebookhub"; //database name
  $dbuser = "root"; //database username
  $dbpassword = ""; //database password
  $dbhost = "localhost"; //database host

  $return["error"] = false;
  $return["message"] = "";

  $link = mysqli_connect($dbhost, $dbuser, $dbpassword, $db);
  //connecting to database server

  $val = isset($_POST["bu_name"]) && isset($_POST["bu_email"]) && isset($_POST["bu_address"] )  && isset($_POST["bu_mobile"] )  && isset($_POST["pass"] );
      

  if($val){
       //checking if there is POST data

       $bu_name = $_POST["bu_name"]; //grabing the data from headers
       $bu_email = $_POST["bu_email"];
       $bu_address = $_POST["bu_address"];
       $bu_mobile = $_POST["bu_mobile"];
       $bu_pass = $_POST["bu_pass"];

      

       //add more validations here

       //if there is no any error then ready for database write
       if($return["error"] == false){
            $name = mysqli_real_escape_string($link, $name);
            $num = mysqli_real_escape_string($link, $num);
            $gender = mysqli_real_escape_string($link, $gender);
            //escape inverted comma query conflict from string

            $sql = "INSERT INTO xyz SET
                                bu_name = '$bu_name',
                                
                                bu_email = '$bu_email',

                                bu_adderss = '$bu_address',

                                bu_mobile = '$bu_mobile',

                                bu_pass = '$bu_pass',

                               mobile = '$num'";
                                
            //student_id is with AUTO_INCREMENT, so its value will increase automatically

            $res = mysqli_query($link, $sql);
            if($res){
                //write success
            }else{
                $return["error"] = true;
                $return["message"] = "Database error";
            }
       }
  }else{
      $return["error"] = true;
      $return["message"] = 'Send all parameters.';
  }

  mysqli_close($link); //close mysqli

  header('Content-Type: application/json');
  // tell browser that its a json data
  echo json_encode($return);
  //converting array to JSON string
?>