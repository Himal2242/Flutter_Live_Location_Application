<?php 
  $db = "flutter"; //database name
  $dbuser = "root"; //database username
  $dbpassword = ""; //database password
  $dbhost = "localhost"; //database host

  $return["error"] = false;
  $return["message"] = "";

  $link = mysqli_connect($dbhost, $dbuser, $dbpassword, $db);
  //connecting to database server

  $val = isset($_POST["name"]) && isset($_POST["mobile"]) && isset($_POST["gender"] );
      

  if($val){
       //checking if there is POST data

       $name = $_POST["name"]; //grabing the data from headers
       $num = $_POST["mobile"];
       $gender = $_POST["gender"];

      

       //add more validations here

       //if there is no any error then ready for database write
       if($return["error"] == false){
            $name = mysqli_real_escape_string($link, $name);
            $num = mysqli_real_escape_string($link, $num);
            $gender = mysqli_real_escape_string($link, $gender);
            //escape inverted comma query conflict from string

            $sql = "INSERT INTO xyz SET
                                name = '$name',
                                
                                gender = '$gender',

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