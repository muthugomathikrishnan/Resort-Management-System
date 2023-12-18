<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8"> 
    <meta name="home" content="olympics, Toppers, Overall, FAQ">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title> Welcome to Olystat </title>
    <link rel="stylesheet" type="text/css" href="medal.css"> 
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" type="text/css" href="./home.css">
    <style>
        body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}


.top-countries {
    display: flex;
    -ms-flex-align: ;

    -ms-flex-item-align: 1fr;
    column-gap: 1fr 1fr1fr;
    justify-content: space-between;
    margin-top: 20px;
}
.box-with-shadow {
      width: 200px;
      height: 200px;
      background-color: #f0f0f0;
      box-shadow: 10px 10px 20px rgba(0, 0, 0, 0.1); 
      margin: 20px;
    }
.country {
    flex: 1;
    padding: 20px;
    text-align:center;
    box-shadow: 10px 10px 20px rgba(0, 0, 0, 0.1);
    background-color: #f0f0f0;
}

h5{
    padding-left: 45%;
    color: orange;
    font-weight: 800;
}

h5.hover {
    text-decoration: underline;

}
.about{
    display: flex;
}

.container {
            max-width: 800px;
            margin: 20px auto;
            overflow: hidden;
            
        }

        .image {
            float: right;
            max-width: 40%;
            margin-left: 20px;
            border: 5px orange solid;
        }
        .image.hover{
            size: 100%;
            transition-duration: 5s;
        }

        .text {
            max-width: 70%;
        }

        .container::after {
            co: "";
            display: table;
            clear: both;
        }
        .orange-button {
            background-color: #ffA500; 
            color: #fff; 
            padding: 10px 20px; 
            border: 2px solid #fff; 
            border-radius: 10px; 
            cursor: pointer;
            font-size: 16px; 
            float: right;
            padding-right: 25px;    
        }

        .orange-button:hover {
            background-color: #ffD700;
        }
    </style>
</head>
<?php
include 'session.php';
?>
<body>
    <header>
    <section class="main-content">
        <h1>Welcome to Olympic Stats</h1>
        <p>Explore statistical data about Olympic medals, training programs, India's journey, and more.</p>
        <a href="logout.php"><button class="logout" id="logout" name="logout"> <?php echo 'Hi , ',$_SESSION["name"],'<br>','LOGOUT'; ?> </button></a>
    </section>
        <nav>
            <ul>
                <li><a href="home.php" style="background-color:orange;color: white;"> Home </a></li>
                <li><a href="medals.php"> Medals </a></li>
                <li><a href="country.php"> Performance Comparison </a></li>
                <li><a href="india.php"> India's Road </a></li>
                <li><a href="form.php"> Training </a></li>
                <li><a href="contactus.php"> Contact Us </a></li>
            </ul>
        </nav>
        <hr style="width: 90% ;align-items: center;background-color: orange;height:3px">
    <br>
    </header>

    <br><br><br>


<form method="post">
<h2> All time Olympics Medal tally </h2>
    <label> Top </label>
    <input type="number" id="max" name="max" min="1" onchange="document.getElementById('con').click()" required> 
    <label> Countries </label>
    <button id="con" name="con" style="display:none"> Show </button>
    <br><br><br><br><br><br>
</form>

<?php
$host = 'localhost';
$dbname = 'project';
$user = 'postgres';
$password = 'postgres';

$mg="SELECT * from reservation;";
$ms="SELECT * FROM users;";
$po="";
$to="";
$o28="";

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
    echo "<th> Rank </th>";
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
<br><br><br><br>
    
    <div class="container">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRm7TbP-FbH8ZQFYVfXHPtvTVF3TBAHX-IHEw&usqp=CAU" alt="Your Image" class="image">
        <div class="text">
            <h2 style="color: orange;font-family:Verdana, Geneva, Tahoma, sans-serif;font-weight: 900;
            text-decoration: wavy;" >ABOUT OLYMPICS</h2>
            <p>The Olympics is a quadrennial international sporting 
             event that brings together athletes from around the world
            to compete in various disciplines. Founded in ancient Greece, 
             the modern Olympic Games feature a wide range of sports, promoting unity
            and friendly competition. The event includes both the Summer and Winter Games, each hosting a diverse 
            array of athletic competitions. Athletes showcase their skills, dedication, and sportsmanship, with the 
            Games serving as a platform for global unity and cultural exchange. The Olympic flame symbolizes the continuity
             of this historic tradition, and the host city changes every four years.     
            </p>   
        </div>
    </div>
    <h2>OVERALL MEDAL TOPPERS</h2>
    <div class="top-countries">
        <div class="country">
        <img src='image\\USA.png' width='80px'>
            <h2>UNITED STATES</h2>
            <ol style="text-decoration: none;list-style: none;">
                <li><p>GOLD=1061</p></li>
                <li><p>SILVER=830</p></li>
                <li><p>BRONZE=738</p></li>
            </ol>
        </div>
        <div class="country">
        <img src='image\\Russia.png' width='80px'>
                <h2>RUSSIA</h2>
                <ol style="text-decoration: none;list-style: none;">
                    <li><p>GOLD=395</p></li>
                    <li><p>SILVER=319</p></li>
                    <li><p>BRONZE=296</p></li>
                </ol>
            </div>
            <div class="country">
            <img src='image\\UK.png' width='80px'>
              <h2>UNITED KINGDOM</h2>
            
              <ol style="text-decoration: none;list-style: none;">
            <li><p>GOLD=284</p></li>
            <li><p>SILVER=318</p></li>
            <li><p>BRONZE=314</p></li>
        </ol>
            </div>
           
        </div>  
        <br>
        <br>
        <br>
        <br>
       <br> <hr style="width: 40% ;align-items: center;background-color: orange;height:3px">
       <br>
       <h3 style="color: orange;font-family:Verdana, Geneva, Tahoma, sans-serif;font-weight: 900;
       text-decoration: wavy;" >INDIA AT OLYMPICS</h3>   
        <a href="india.php"><button class="orange-button">Explore more</button></a>
        <div class="container">
            <img src="https://static01.nyt.com/images/2012/08/13/world/asia/13-Indian-Olympics-IndiaI-slide-PSGI/13-Indian-Olympics-IndiaI-slide-PSGI-jumbo.jpg" alt="India" class="image">
            <div class="text">
                <p>India has a rich Olympic history, participating since 1900. The country has excelled in sports like field hockey, winning gold multiple times. 
                    In recent years, Indian athletes across various disciplines have garnered attention and medals. 
                    Notable achievements include successes in shooting, wrestling, and badminton. 
                    Challenges persist, but India continues to invest in sports development, fostering a promising future for its athletes on the global stage.</p>              
            </div>
        </div>
        <br>
        <br>
        <br>
        <br>

       <br> <hr style="width: 40% ;align-items: center;background-color: orange;height:3px">
       <br>
       <h3 style="color: orange;font-family:Verdana, Geneva, Tahoma, sans-serif;font-weight: 900;
       text-decoration: wavy;text-align:center;" >Our Training Academy</h3>
       <a href="form.php"><button class="orange-button">KNOW MORE</button></a>
       <div class="container">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRisWLOgvQ4c7ZIHRa53qT_BRTk3YXC0TKHmQ&usqp=CAU" alt="Training" class="image">
        <div class="text">
            <p>Olystat.it offers comprehensive training programs for aspiring athletes, catering to both free and premium memberships tailored to individual skill levels. With expert guidance and personalized plans, athletes can elevate their performance. Join us today to unlock your athletic potential and embark on a journey towards excellence!</p> 
            <br>
            <p>Elevate Your Game: Explore our training programs at olysatc.it.
                Unleash Your Potential: Join now for personalized coaching and take the first step towards athletic greatness.</p>   
                        
        </div>
    </div>
<br><br><br><br><br>
<h2> FAQs </h2>
<br><br><br>
<div>
    <hr>
    <h3> Which country won the most gold medals in olympics history ? <span class="material-symbols-outlined" 
        onclick="q1(this)"> stat_minus_1 </span></h3>
    <p id="mg" style="display:none"> <?php echo $q1['country'] ," :",$q1['gold']," Golds ";?> </p>
</div>
<div>
<hr>
    <h3> Which country won the most medals in olympics history ? <span class="material-symbols-outlined" 
        onclick="q2(this)"> stat_minus_1 </span></h3>
    <p id="ms" style="display:none"> <?php echo $q2['country'] ," :",$q2['total']," Medals ";?> </p>
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

<footer>
            <div class="footer-content">
                <p>&copy; 2023 Olympic Stats. All rights reserved.</p>
               
            </div>
            <ol style="list-style-type: none;"> 
                <li>olystact@inc</li>
                <li>facebook</li>
                <li>twitter</li>
            </ol>
        </footer>
</body>
</html>