<?php 
  $db = "flutter"; //database name
  $dbuser = "root"; //database username
  $dbpassword = ""; //database password
  $dbhost = "localhost"; //database host

  $return["error"] = false;
  $return["message"] = "";

  $link = mysqli_connect($dbhost, $dbuser, $dbpassword, $db);


  //connecting to database server

  header("Content-Type: application/json");
  header("Acess-Control-Allow-Origin: *");
  header("Acess-Control-Allow-Methods: POST");
  header("Acess-Control-Allow-Headers: Acess-Control-Allow-Headers,Content-Type,Acess-Control-Allow-Methods, Authorization");
  
  //include 'dbconfig.php'; // include database connection file
  
  $data = json_decode(file_get_contents("php://input"), true); // collect input parameters and convert into readable format
      
  $fileName  =  $_FILES['sendimage']['name'];
  $tempPath  =  $_FILES['sendimage']['tmp_name'];
  $fileSize  =  $_FILES['sendimage']['size'];
          
  if(empty($fileName))
  {
      $errorMSG = json_encode(array("message" => "please select image", "status" => false));	
      echo $errorMSG;
  }
  else
  {
      $upload_path = 'upload/'; // set upload folder path 
      
      $fileExt = strtolower(pathinfo($fileName,PATHINFO_EXTENSION)); // get image extension
          
      // valid image extensions
      $valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'pdf'); 
                      
      // allow valid image file formats
      if(in_array($fileExt, $valid_extensions))
      {				
          //check file not exist our upload folder path
          if(!file_exists($upload_path . $fileName))
          {
              // check file size '5MB'
              if($fileSize < 5000000){
                  move_uploaded_file($tempPath, $upload_path . $fileName); // move file from system temporary path to our upload folder path 
              }
              else{		
                  $errorMSG = json_encode(array("message" => "Sorry, your file is too large, please upload 5 MB size", "status" => false));	
                  echo $errorMSG;
              }
          }
          else
          {		
              $errorMSG = json_encode(array("message" => "Sorry, file already exists check upload folder", "status" => false));	
              echo $errorMSG;
          }
      }
      else
      {		
          $errorMSG = json_encode(array("message" => "Sorry, only JPG, JPEG, PNG & GIF files are allowed", "status" => false));	
          echo $errorMSG;		
      }
  }
  

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

                                mobile = '$num',
                                
                                img ='$fileName'";
            //student_id is with AUTO_INCREMENT, so its value will increase automatically
           // echo json_encode(array("message" => "File Uploaded Successfully", "status" => true));	
        }
            $res = mysqli_query($link, $sql);
            if($res){
                //write success
            }else{
                $return["error"] = true;
                $return["message"] = "Database error";
            }
       }
  else{
      $return["error"] = true;
      $return["message"] = 'Send all parameters.';
  }

  mysqli_close($link); //close mysqli

  header('Content-Type: application/json');
  // tell browser that its a json data
  echo json_encode($return);
  //converting array to JSON string
?>