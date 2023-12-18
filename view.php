<!-- admin.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url(IMAGES/sa2.jpeg);
             background-size: cover;
            background-position: center;
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .admin-container {
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
            background-color: rgba(0, 0, 0, 0.7);
        }

        .button-container {
            margin-top: 20px;
        }

        .table{
            overflow: auto;
        }

        h2{
            text-align : center;
        }

        a {
            text-decoration: none;
            color: white;
            background-color: #4CAF50;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid white;
            padding: 10px;
        }
        
    </style>
</head>
<body>

<div class="admin-container">
    <h2>Admin Panel</h2>
    <p id="a"><a href="admin.php">Back</a>   /     <a href="ap_resort.html">Home</a> </p>
    <br>    <br>    <br>    <br>
    <div class="button-container">


</div>
    <div class="table">
    <?php
    // Include your PostgreSQL connection code here
    $host = 'resortmanagement.postgres.database.azure.com';
    $dbname = 'project';
    $user = 'resort';
    $password = 'Muthu@2004';
    
$mg="SELECT reservation_id,user_id FROM reservation;";
$ms="SELECT country,total FROM overall where total=(SELECT max(total) from overall);";
$po="SELECT * FROM place where year < '2023' order by year desc limit 1;";
$to="SELECT * FROM place where year > '2023' order by year limit 1;";
$o28="SELECT * FROM place where year = '2028';";

$q1=pg_fetch_assoc(pg_query($conn,$mg));
$q2=pg_fetch_assoc(pg_query($conn,$ms));
$q3=pg_fetch_assoc(pg_query($conn,$po));
$q4=pg_fetch_assoc(pg_query($conn,$to));
$q5=pg_fetch_assoc(pg_query($conn,$o28));

if(array_key_exists('con',$_POST)) {
$max= $_POST['max'];
$sql="SELECT * from overall ORDER BY gold desc LIMIT $max;";
$result=pg_query($conn,$sql);
if($result){
    echo "<table>";
    echo "<thead>";
    echo "<th>user_id</th>";
    echo "<th> Country </th>";
    echo "<th> Gold </th>";
    echo "<th> Silver </th>";
    echo "<th> Bronze </th>";
    echo "<th> Total </th>";
    echo "</thead>";
    echo "<tbody>";
    while($row= pg_fetch_assoc($result)){
        echo "<tr>";
        echo "<td>". $row['pos'] ."</td>";
        $r="image\\".$row["country"].".png";
        echo "<td>". "<img src='$r' width='40px'>"." ".$row['country'] ."</td>";
        echo "<td>". $row['gold'] ."</td>";
        echo "<td>". $row['silver'] ."</td>";
        echo "<td>". $row['bronze'] ."</td>";
        echo "<td>". $row['total'] ."</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
}else{
    echo "<p> Please Select year </p>";
}
}
    
    
    ?>
    <br><br><br>
    </div>
<div>
<hr>

    <h3> question 1 ? <span class="material-symbols-outlined" 
        onclick="q2(this)"> stat_minus_1 </span></h3>
    <p id="ms" style="display:none"> <?php echo $q2['reservation_id'] ," :",$q2['user_id']," Medals ";?> </p>
</div>
<div>
<hr>
    <h3> Where was last olympics played ? <span class="material-symbols-outlined" 
        onclick="q3(this)"> stat_minus_1 </span></h3>
    <p id="po" style="display:none"> <?php echo $q3['city'] ," , ",$q3['country']," , ", $q3['year'],
       " . But,Due to Covid-19 Pandemics, It was held on 2021.";?> </p>
</div>
<div>
<hr>
    <h3> Where will be the next olympics played ? <span class="material-symbols-outlined" 
        onclick="q4(this)"> stat_minus_1 </span></h3>
    <p id="to" style="display:none"> <?php echo $q4['city'] ," , ",$q4['country']," , ", $q4['year'];?> </p>
</div>
<div>
<hr>
    <h3> Which city will host the olympics in 2028? <span class="material-symbols-outlined" 
        onclick="q5(this)"> stat_minus_1 </span></h3>
    <p id="o28" style="display:none"> <?php echo $q5['city'] ," , ",$q5['country'];?> </p>
</div>
<br><br><br><br><br><br><br><br><br>
<script>
    function q1(ele){
        if(document.getElementById('mg').style.display=='none'){
            ele.innerHTML= "stat_1";
            document.getElementById('mg').style.display='block';
        }else{
            ele.innerHTML= "stat_minus_1";
            document.getElementById('mg').style.display='none';
        }
    }
    function q2(ele){
        if(document.getElementById('ms').style.display=='none'){
            ele.innerHTML= "stat_1";
            document.getElementById('ms').style.display='block';
        }else{
            ele.innerHTML= "stat_minus_1";
            document.getElementById('ms').style.display='none';
        }
    }
    function q3(ele){
        if(document.getElementById('po').style.display=='none'){
            ele.innerHTML= "stat_1";
            document.getElementById('po').style.display='block';
        }else{
            ele.innerHTML= "stat_minus_1";
            document.getElementById('po').style.display='none';
        }
    }
    function q4(ele){
        if(document.getElementById('to').style.display=='none'){
            ele.innerHTML= "stat_1";
            document.getElementById('to').style.display='block';
        }else{
            ele.innerHTML= "stat_minus_1";
            document.getElementById('to').style.display='none';
        }
    }
    function q5(ele){
        if(document.getElementById('o28').style.display=='none'){
            ele.innerHTML= "stat_1";
            document.getElementById('o28').style.display='block';
        }else{
            ele.innerHTML= "stat_minus_1";
            document.getElementById('o28').style.display='none';
        }
    }
</script>

    </div>
</div>

</body>
</html>
