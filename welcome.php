<?php
   function get_server_memory_usage(){
    $free = shell_exec('free');
    $free = (string)trim($free);
    $free_arr = explode("\n", $free);
    $mem = explode(" ", $free_arr[1]);
    $mem = array_filter($mem);
    $mem = array_merge($mem);
    $memory_usage = $mem[2]/$mem[1]*100;
    return $memory_usage;
   }
   function get_server_cpu_usage(){
    $load = sys_getloadavg();
    return $load[0];
   }
   $name=$email="";
   $ncounter=$counter=0;
   if(isset($_POST['submit']) ) {
      $name=$_POST['name'];
      $email=$_POST['email'];
      $times=$_POST['times'];
      $success = fopen("success.txt","a");
      $fail = fopen("fail.txt","a");
      $link = mysqli_connect("localhost", "root", "", "cloud");
      if ($link->connect_error || $success == NULL || $fail == NULL )
      {
          $time=time().",".get_server_memory_usage().",".get_server_cpu_usage()."\n";
          fwrite(fail,$time);
          exit("Server is Down. Please Try again Later");
      }
      for ( $x =1 ; $x <= $times ; $x=$x+1)
       {
      $sql = "INSERT INTO cl (NAME, EMAIL) VALUES ('$name','$email')";
      if(mysqli_query($link, $sql)){
              $time=time().",".get_server_memory_usage().",".get_server_cpu_usage()."\n";
              fwrite($success,$time);    
              $counter++;
       }  else{
        echo "ERROR: Was not able to execute $sql. " . mysqli_error($link);
              $time=time().",".get_server_memory_usage().",".get_server_cpu_usage()."\n";
              fwrite($fail,$time);
              $ncounter++;
      }  
      }
      echo "Insertion Info : <br/>";
      echo "Name: " . $_POST['name'] . "<br />" ;
      echo "Last name: " . $_POST['email'] . "<br /> ";
      echo " Number of Successful Insertions in database:". $counter. "<br /> ";
      echo " Number of Failures: ". $ncounter;
      }  
?>
