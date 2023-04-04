<?php


?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
 <div class="row">
   <div class="col-sm-8">
    <?php echo $deleteMsg??''; ?>
    
    <form style="display:flex" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
      <div style=" height: 15vh; width:20vw; margin-top:2vh; float:left">
        Start Time
        <input type="datetime-local" id="time1" name="time1"/>
      </div>
      <div style=" height: 15vh; width:20vw; margin-top:2vh; float:center">
        End Time
        <input type="datetime-local" id="time2" name="time2"/>
      </div>
      <div style=" height: 15vh; width:20vw; margin-top:2vh; float:right">
        Database Name
        <select id="dbname" name="dbname">
          <option value="Park_UP_Data">Parking Data</option>
          <option value="Sl_UP_Data">Street Light Data</option>      
          <option value="test1">test1</option>      
        </select>
      </div>
      <div style=" height: 15vh; width:20vw; margin-left:2vw; margin-top:5vh; float:right">
        <input type="submit" />
      </div>
    </form>

    <?php
    
    if (isset($_POST)) {
      $time1 = $_POST['time1'];
      $time2 = $_POST['time2'];
      $tabelname1 = $_POST['dbname'];
      
      echo "SELECT * FROM `".$tabelname1."` WHERE `date` BETWEEN '".$time1."' AND '".$time2."';";
      echo "<br><br>";
      // echo "".$time2."<br><br>";
      // echo "".$tabelname1."<br><br>";
    }

    

   
      $hostName = "localhost";
      $userName = "root";
      $password = "";
      $databaseName = "test1";
      $conn = new mysqli($hostName, $userName, $password, $databaseName);
      // Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      $db= $conn;
      $tableName="test1";
      $columns= ['id', 'name','number','date'];
      $fetchData = fetch_data($db, $tableName, $columns);

      // echo $time1."<br><br>";
      //   echo $time2."<br><br>";
      //   echo $tabelname1."<br><br>";

      function fetch_data($db, $tableName, $columns){
      if(empty($db)){
        $msg= "Database connection error";
      }elseif (empty($columns) || !is_array($columns)) {
        $msg="columns Name must be defined in an indexed array";
      }elseif(empty($tableName)){
        $msg= "Table Name is empty";
      }else{
        if (isset($_POST)) {
          $time1 = $_POST['time1'];
          $time2 = $_POST['time2'];
          $tabelname1 = $_POST['dbname'];
          
          
        }
        

      $columnName = implode(", ", $columns);
      $query = "SELECT * FROM ".$tabelname1." WHERE `date` BETWEEN '".$time1."' AND '".$time2."'";
      // SELECT * FROM `test1` WHERE `date` BETWEEN '2023-02-10 09:00:00' AND '2023-03-10 09:00:00';
      $result = $db->query($query);

      // echo $time1."<br><br>";
      // echo $time2."<br><br>";
      // echo $tabelname1."<br><br>";

      if($result== true){ 
      if ($result->num_rows > 0) {
          $row= mysqli_fetch_all($result, MYSQLI_ASSOC);
          $msg= $row;
      } else {
          $msg= "No Data Found"; 
      }
      }else{
        $msg= mysqli_error($db);
      }
      }
      return $msg;
      }
      
      
      ?>
    


    <div class="table-responsive">
      <table class="table table-bordered">
       <thead><tr><th>S.N</th>

         <th>Name</th>
         <th> Mobile Number</th>
         <th>Date</th>

    </thead>
    <tbody>
  <?php
      if(is_array($fetchData)){      
      $sn=1;
      foreach($fetchData as $data){
    ?>
      <tr>
      <td><?php echo $sn; ?></td>
      <td><?php echo $data['name']??''; ?></td>
      <td><?php echo $data['number']??''; ?></td>
      <td><?php echo $data['date']??''; ?></td>

     </tr>
     <?php
      $sn++;}}else{ ?>
      <tr>
        <td colspan="8">
    <?php echo $fetchData; ?>
  </td>
    <tr>
    <?php
    }
  
    ?>
    </tbody>
     </table>
   </div>
</div>
</div>
</div>
</body>
</html>