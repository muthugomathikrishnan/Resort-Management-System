<?php
$host = 'resortmanagement.postgres.database.azure.com';
$dbname = 'project';
$user = 'resort';
$password = 'Muthu@2004';

try {
    $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
    $query1 = $db->prepare("SELECT username FROM users ORDER BY username ASC");
    $query1->execute();
    $userNames = $query1->fetchAll(PDO::FETCH_COLUMN);

    $query2 = $db->prepare("SELECT distinct r.room_id as difference 
        FROM users u
        INNER JOIN reservation r ON u.user_id = r.user_id;
    ");
    $query2->execute();
    $userReservations = $query2->fetchAll(PDO::FETCH_COLUMN);

    $query3 = $db->prepare("SELECT username from users where user_id=(SELECT user_id from reservation order by total_payment desc limit 1);
        
        
    ");
    $query3->execute();
    $userq3 = $query3->fetchAll(PDO::FETCH_COLUMN);

    $query4 = $db->prepare("SELECT activity from users group by activity order by count(*) desc;
    ");
    $query4->execute();
    $userq4 = $query4->fetchAll(PDO::FETCH_COLUMN);

    $query5 = $db->prepare("SELECT max(total_payment) from reservation;
    ");
    $query5->execute();
    $userq5 = $query5->fetchAll(PDO::FETCH_COLUMN);

    $query6 = $db->prepare("SELECT sum(total_payment) from reservation;
    ");
    $query6->execute();
    $userq6 = $query6->fetchAll(PDO::FETCH_COLUMN);
    //q7
    $query7 = $db->prepare("SELECT DISTINCT u.username
        FROM users u
        JOIN reservation r ON u.user_id = r.user_id
        JOIN roomlist rl ON r.room_id = rl.room_id
        WHERE rl.room_category = 'luxury';
    ");
    $query7->execute();
    $userq7 = $query7->fetchAll(PDO::FETCH_COLUMN);

    // q8
    $queryq8 = $db->prepare("SELECT u.username
        FROM users u
        JOIN (
            SELECT user_id, COUNT(*) as num_reservations
            FROM reservation
            GROUP BY user_id
            ORDER BY num_reservations DESC
            LIMIT 1
        ) r ON u.user_id = r.user_id;
    ");
    $queryq8->execute();
    $userq8 = $queryq8->fetchAll(PDO::FETCH_COLUMN);
    //q9
    $queryq9 = $db->prepare("SELECT  COUNT(*) as num_reservations
    FROM reservation r
    GROUP BY EXTRACT(MONTH FROM r.check_in_date);
    
");
$queryq9->execute();
$userq9 = $queryq9->fetchAll(PDO::FETCH_COLUMN);
    
//q10
$queryq10 = $db->prepare(" SELECT  u.username FROM users u JOIN 
payment_method pm ON u.user_id = pm.user_id
WHERE pm.payment_method ='card';

");
$queryq10->execute();
$userq10 = $queryq10->fetchAll(PDO::FETCH_COLUMN);
//q11
$queryq11 = $db->prepare(" SELECT u.username
FROM users u
LEFT JOIN payment_method pm ON u.user_id = pm.user_id
WHERE pm.payment_id IS NULL;




");
$queryq11->execute();
$userq11 = $queryq11->fetchAll(PDO::FETCH_COLUMN);

//q12
$queryq12 = $db->prepare("SELECT rl.room_name
FROM roomlist rl
LEFT JOIN reservation r ON rl.room_id = r.room_id
WHERE r.reservation_id IS NULL;

");
$queryq12->execute();
$userq12 = $queryq12->fetchAll(PDO::FETCH_COLUMN);
//q13
$queryq13 = $db->prepare("SELECT DISTINCT u.username
FROM users u
JOIN reservation r ON u.user_id = r.user_id
WHERE r.check_in_date >= CURRENT_DATE - INTERVAL '1 month';

");
$queryq13->execute();
$userq13 = $queryq13->fetchAll(PDO::FETCH_COLUMN);
//q14
$queryq14 = $db->prepare("SELECT rl.room_name
FROM roomlist rl
LEFT JOIN reservation r ON rl.room_id <> r.room_id
WHERE r.check_in_date NOT BETWEEN '2023-01-01' AND '2023-01-10'
AND r.check_out_date NOT BETWEEN '2023-01-01' AND '2023-01-10'
GROUP BY rl.room_name;

");
$queryq14->execute();
$userq14 = $queryq14->fetchAll(PDO::FETCH_COLUMN);

//q15
$queryq15 = $db->prepare("SELECT username from users where user_id in(select user_id from rating where rating=5);


");
$queryq15->execute();
$userq15 = $queryq15->fetchAll(PDO::FETCH_COLUMN);

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>


        
<!DOCTYPE html> 
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin</title>
    <link rel="icon" href="IMAGES/" type="image/png">
    <!-- CSS -->
    <link rel="stylesheet" href="admin.css">
    <!-- BOX ICONS -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <style>
        
            .reser {
    text-align: center;
 
}
h1{
    color:white;

    
}

thead{
    background-color: black;
    color: white;
}

tbody{
    background-color: aliceblue;
    color: blue;
}
.answer-container {
    text-align: center;
    margin: 0 auto;
    width:70%; /* This centers the container horizontally */
}

/* Optional: Add some styling to your tables */
.answer-container table {
    width: 60%; /* Adjust the width as needed */
    border-collapse: collapse;
    margin: 20px auto; /* Center the table within the container */
}

.answer-container th, .answer-container td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: center;
}

/* Optional: Style the buttons */
.btn {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.btn:hover {
    background-color: #45a049;
}

.home{
    width: 117%;
    min-height: 80vh;
    background: url(IMAGES/bg.png);
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(17rem, auto));
    align-items: center;
    gap: 1.5rem;
}


      

    </style>
    

</head>

  <body>
    <!-- Navigation bar -->
    <header>
        <a href="ap_resort.html" class="logo">
            <img src="images/log.png"  alt="logohere">
        </a>
        <!-- Menu-Icon -->
        <i class="bx bx-menu" id="menu-icon"></i>
        <!-- Links -->
        <ul class="navbar">
        

            <li><a href="#roomlistrating">Stats</a></li>

            <li><a href="sample.php">Admin view</a></li>
            
            <li><a href="adminchange.php">Manage Rooms</a></li>
           
        </ul>
        <!-- Icons -->
        <div class="header-icon">
            <a href="ap_resort.html">
                <iconify-icon icon="mdi-light:logout" style="color: white;"></iconify-icon>
            </a>

            <i class='' id="search-icon"></i>
        </div>
        <!-- Search Box -->
    </header>
       <!--Home-->
       <section class="home" id="home">
        <div class="home-text">
            <h1>WELCOME<br> ADMIN</h1>
        
        
    </section>


    <section class="roomlistrating" id="roomlistrating">
       <div class="reser">
            <h2>Frequently Asked Questions</h2>
            <div>
                <h3>Q1: Show all users </h3>
                <button class="btn" onclick="q1()" id="q1">Answer</button>
                <!-- Container to display user names -->
                <div class="answer-container" id="answerContainer1" style="display:none"></div>
            <br><br><br>

            
            <h3>Q2: Show all reservations room_id </h3> 
                <button class="btn" onclick="q2()" id="q2">Answer</button>
                <!-- Container to display user names -->
                <div class="answer-container" id="answerContainer2" style="display:none"></div>
           
            <br><br><br>
            
            <h3>Q3:  Retrieve the username of the user who made the highest reservation. </h3> 
                <button class="btn" onclick="q3()" id="q3">Answer</button>
                <!-- Container to display user names -->
                <div class="answer-container" id="answerContainer3" style="display:none"></div>
           
            
            <br><br><br>
            
            <h3>Q4:Show the activities which people like the most priority wise.</h3> 
                <button class="btn" onclick="q4()" id="q4">Answer</button>
                <!-- Container to display user names -->
                <div class="answer-container" id="answerContainer4" style="display:none"></div>
            
            <br><br><br>
            <h3>Q5:  The highest price : </h3> 
                <button class="btn" onclick="q5()" id="q5">Answer</button>
                <!-- Container to display user names -->
                <div class="answer-container" id="answerContainer5" style="display:none"></div>
        
            <br><br><br>
            <h3>Q6: The total cost of all reservaton : </h3> 
                <button class="btn" onclick="q6()" id="q6">Answer</button>
                <!-- Container to display user names -->
                <div class="answer-container" id="answerContainer6" style="display:none"></div>
          
            <br><br><br>
            <h3>Q7: Name the users who booked luxury rooms : </h3> 
                <button class="btn" onclick="q7()" id="q7">Answer</button>
                <!-- Container to display user names -->
                <div class="answer-container" id="answerContainer7" style="display:none"></div>
          
            <br><br><br>
            <h3>Q8: who made the highest number of reservations: </h3> 
                <button class="btn" onclick="q8()" id="q8">Answer</button>
                <!-- Container to display user names -->
                <div class="answer-container" id="answerContainer8" style="display:none"></div>
            
            <br><br><br>
            <h3>Q9: Count the number of reservations for each month: </h3> 
                <button class="btn" onclick="q9()" id="q9">Answer</button>
                <!-- Container to display user names -->
                <div class="answer-container" id="answerContainer9" style="display:none"></div>
            
            <br><br><br>
            <h3>Q10:who have made reservations with a specific payment method(credit card): </h3> 
                <button class="btn" onclick="q10()" id="q10">Answer</button>
                <!-- Container to display user names -->
                <div class="answer-container" id="answerContainer10" style="display:none"></div>
                <br><br><br>
                <h3>Q11:Average amount of the reservation: </h3> 
                <button class="btn" onclick="q11()" id="q11">Answer</button>
                <!-- Container to display user names -->
                <div class="answer-container" id="answerContainer11" style="display:none"></div>
                <br><br><br>
                <h3>Q12:List the rooms that have never been reserved: </h3> 
                <button class="btn" onclick="q12()" id="q12">Answer</button>
                <!-- Container to display user names -->
                <div class="answer-container" id="answerContainer12" style="display:none"></div>
                <br><br><br>
                <h3>Q13:who made a reservation in the last month: </h3> 
                <button class="btn" onclick="q13()" id="q13">Answer</button>
                <!-- Container to display user names -->
                <div class="answer-container" id="answerContainer13" style="display:none"></div>
                <br><br><br>
                <h3>Q14:List the available rooms : </h3> 
                <button class="btn" onclick="q14()" id="q14">Answer</button>
                <!-- Container to display user names -->
                <div class="answer-container" id="answerContainer14" style="display:none"></div>
                <br><br><br>
                <h3>Q15:List the users who gave 5 star rating: </h3> 
                <button class="btn" onclick="q15()" id="q15">Answer</button>
                <!-- Container to display user names -->
                <div class="answer-container" id="answerContainer15" style="display:none"></div>
                <br><br><br>

    






            </div>

</div>
        
        
        <br><br><br>
        
    </section>

    <!-- Add your existing body content here -->

    <script>
    function q1() {
        // Fetched user names from PHP (passed as JSON)
        var userNames = <?php echo json_encode($userNames); ?>;

        // Create an HTML table to display user names
        var answerContainer = document.getElementById('answerContainer1');
        var tableHTML = "<h3>Answer:</h3><table border='1'><thead><tr><th>User Names</th></tr><thead><tbody>";

        // Add each user name to the table
        userNames.forEach(function (name) {
            tableHTML += "<tr><td>" + name + "</td></tr>";
        });

        // Close the table HTML
        tableHTML += "<tbody></table>";

        // Set the HTML content to the answer container  
        answerContainer.innerHTML = tableHTML;

    }

    function hideUsers() {
        q1();
        var answerContainer = document.getElementById('answerContainer1');
        if(answerContainer.style.display == 'block'){
            answerContainer.style.display = 'none';
        }else{
            answerContainer.style.display = 'block';
        }

    }

    // Attach event listener to the "Answer" button for mouseover event
    var answerButton = document.getElementById('q1');

    // Attach event listener to the "Answer" button for click event
    answerButton.addEventListener('click', hideUsers);

    
    function q2() {
            // Fetched user reservations from PHP (passed as JSON)
            var userReservations = <?php echo json_encode($userReservations); ?>;

            // Create an HTML table to display user reservations
            var answerContainer2 = document.getElementById('answerContainer2');
            var tableHTML2 = "<h3>Answer:</h3><table border='1'><thead><tr><th>Room Id</th></tr></thead><tbody>";

            userReservations.forEach(function (entry) {
                tableHTML2 += "<tr><td>" + entry + "</td></tr>" ;
            });

            // Close the table HTML
            tableHTML2 += "</tbody></table>";

            // Set the HTML content to the answer container
            answerContainer2.innerHTML = tableHTML2;
        

        
        }

        function hideReservations() {
            q2();
            
            var answerContainer2 = document.getElementById('answerContainer2');
            if(answerContainer2.style.display == 'block'){
            answerContainer2.style.display = 'none';
        }else{
            answerContainer2.style.display = 'block';
        }
        }

        var answerButton2 = document.getElementById('q2');
        answerButton2.addEventListener('mouseover', q2);

        answerButton2.addEventListener('click', hideReservations);
        //q3

        function q3() {
        // Fetched user names from PHP (passed as JSON)
        var userNames = <?php echo json_encode($userq3); ?>;

        // Create an HTML table to display user names
        var answerContainer = document.getElementById('answerContainer3');
        var tableHTML3= "<h3>Answer:</h3><table border='1'><thead><tr><th>User Names</th></tr></thead><tbody>";

        // Add each user name to the table
        userNames.forEach(function (name) {
            tableHTML3 += "<tr><td>" + name + "</td></tr>";
        });

        // Close the table HTML
        tableHTML3 += "</tbody></table>";

        // Set the HTML content to the answer container  
        answerContainer3.innerHTML = tableHTML3;

    }

    function hideq3() {
        q3();
        var answerContainer = document.getElementById('answerContainer3');
        if(answerContainer.style.display == 'block'){
            answerContainer.style.display = 'none';
        }else{
            answerContainer.style.display = 'block';
        }

    }

    // Attach event listener to the "Answer" button for mouseover event
    var answerButton = document.getElementById('q3');

    // Attach event listener to the "Answer" button for click event
    answerButton.addEventListener('click', hideq3);
//q4

function q4() {
        // Fetched user names from PHP (passed as JSON)
        var userNames = <?php echo json_encode($userq4); ?>;

        // Create an HTML table to display user names
        var answerContainer4 = document.getElementById('answerContainer4');
        var tableHTML4 = "<h3>Answer:</h3><table border='1'><thead><tr><th>activity</th></tr></thead><tbody>";

        // Add each user name to the table
        userNames.forEach(function (reservatio_id) {
            tableHTML4 += "<tr><td>" + reservatio_id + "</td></tr>";
        });

        // Close the table HTML
        tableHTML4 += "<tbody></table>";

        // Set the HTML content to the answer container  
        answerContainer4.innerHTML = tableHTML4;

    }

    function hideq4() {
        q4();
        var answerContainer = document.getElementById('answerContainer4');
        if(answerContainer.style.display == 'block'){
            answerContainer.style.display = 'none';
        }else{
            answerContainer.style.display = 'block';
        }

    }

    // Attach event listener to the "Answer" button for mouseover event
    var answerButton = document.getElementById('q4');

    // Attach event listener to the "Answer" button for click event
    answerButton.addEventListener('click', hideq4);
//q5

function q5() {
        // Fetched user names from PHP (passed as JSON)
        var userNames = <?php echo json_encode($userq5); ?>;

        // Create an HTML table to display user names
        var answerContainer5 = document.getElementById('answerContainer5');
        var tableHTML5 = "<h3>Answer:</h3><table border='1'><thead><tr><th>maximum _price</th></tr></thead><tbody>";

        // Add each user name to the table
        userNames.forEach(function (room_id) {
            tableHTML5 += "<tr><td>" + room_id + "</td></tr>";
        });

        // Close the table HTML
        tableHTML5 += "</tbody></table>";

        // Set the HTML content to the answer container  
        answerContainer5.innerHTML = tableHTML5;

    }

    function hideq5() {
        q5();
        var answerContainer = document.getElementById('answerContainer5');
        if(answerContainer.style.display == 'block'){
            answerContainer.style.display = 'none';
        }else{
            answerContainer.style.display = 'block';
        }

    }

    // Attach event listener to the "Answer" button for mouseover event
    var answerButton = document.getElementById('q5');

    // Attach event listener to the "Answer" button for click event
    answerButton.addEventListener('click', hideq5);
    
    //q6
    function q6() {
        // Fetched user names from PHP (passed as JSON)
        var userNames = <?php echo json_encode($userq6); ?>;

        // Create an HTML table to display user names
        var answerContainer6 = document.getElementById('answerContainer6');
        var tableHTML6 = "<h3>Answer:</h3><table border='1'><thead><tr><th>Total cost of all reservation :</th></tr></thead><tbody>";

        // Add each user name to the table
        userNames.forEach(function (room_id) {
            tableHTML6 += "<tr><td>" + room_id + "</td></tr>";
        });

        // Close the table HTML
        tableHTML6 += "</tbody></table>";

        // Set the HTML content to the answer container  
        answerContainer6.innerHTML = tableHTML6;

    }

    function hideq6() {
        q6();
        var answerContainer = document.getElementById('answerContainer6');
        if(answerContainer.style.display == 'block'){
            answerContainer.style.display = 'none';
        }else{
            answerContainer.style.display = 'block';
        }

    }

    // Attach event listener to the "Answer" button for mouseover event
    var answerButton = document.getElementById('q6');

    // Attach event listener to the "Answer" button for click event
    answerButton.addEventListener('click', hideq6);
    
    //q7
        function q7() {
        // Fetched user names from PHP (passed as JSON)
        var userNames = <?php echo json_encode($userq7); ?>;

        // Create an HTML table to display user names
        var answerContainer7 = document.getElementById('answerContainer7');
        var tableHTML7 = "<h3>Answer:</h3><table border='1'><thead><tr><th>name:</th></tr></thead><tbody>";

        // Add each user name to the table
        userNames.forEach(function (room_id) {
            tableHTML7 += "<tr><td>" + room_id + "</td></tr>";
        });

        // Close the table HTML
        tableHTML7 += "</tbody></table>";

        // Set the HTML content to the answer container  
        answerContainer7.innerHTML = tableHTML7;

    }

    function hideq7() {
        q7();
        var answerContainer = document.getElementById('answerContainer7');
        if(answerContainer.style.display == 'block'){
            answerContainer.style.display = 'none';
        }else{
            answerContainer.style.display = 'block';
        }

    }

    // Attach event listener to the "Answer" button for mouseover event
    var answerButton = document.getElementById('q7');

    // Attach event listener to the "Answer" button for click event
    answerButton.addEventListener('click', hideq7);
    //q8
    function q8() {
        // Fetched user names from PHP (passed as JSON)
        var userNames = <?php echo json_encode($userq8); ?>;

        // Create an HTML table to display user names
        var answerContainer8 = document.getElementById('answerContainer8');
        var tableHTML8= "<h3>Answer:</h3><table border='1'><thead><tr><th>name:</th></tr></thead><tbody>";

        // Add each user name to the table
        userNames.forEach(function (room_id) {
            tableHTML8 += "<tr><td>" + room_id + "</td></tr>";
        });

        // Close the table HTML
        tableHTML8 += "</tbody></table>";

        // Set the HTML content to the answer container  
        answerContainer8.innerHTML = tableHTML8;

    }

    function hideq8() {
        q8();
        var answerContainer = document.getElementById('answerContainer8');
        if(answerContainer.style.display == 'block'){
            answerContainer.style.display = 'none';
        }else{
            answerContainer.style.display = 'block';
        }

    }

    // Attach event listener to the "Answer" button for mouseover event
    var answerButton = document.getElementById('q8');

    // Attach event listener to the "Answer" button for click event
    answerButton.addEventListener('click', hideq8);
    //q9
    function q9() {
        // Fetched user names from PHP (passed as JSON)
        var userNames = <?php echo json_encode($userq9); ?>;

        // Create an HTML table to display user names
        var answerContainer9 = document.getElementById('answerContainer9');
        var tableHTML9= "<h3>Answer:</h3><table border='1'><thead><tr><th>name:</th></tr></thead><tbody>";

        // Add each user name to the table
        userNames.forEach(function (room_id) {
            tableHTML9 += "<tr><td>" + room_id + "</td></tr>";
        });

        // Close the table HTML
        tableHTML9 += "</tbody></table>";

        // Set the HTML content to the answer container  
        answerContainer9.innerHTML = tableHTML9;

    }

    function hideq9() {
        q9();
        var answerContainer = document.getElementById('answerContainer9');
        if(answerContainer.style.display == 'block'){
            answerContainer.style.display = 'none';
        }else{
            answerContainer.style.display = 'block';
        }

    }

    // Attach event listener to the "Answer" button for mouseover event
    var answerButton = document.getElementById('q9');

    // Attach event listener to the "Answer" button for click event
    answerButton.addEventListener('click', hideq9);

    //q10
    function q10() {
        // Fetched user names from PHP (passed as JSON)
        var userNames = <?php echo json_encode($userq10); ?>;

        // Create an HTML table to display user names
        var answerContainer10 = document.getElementById('answerContainer10');
        var tableHTML10= "<h3>Answer:</h3><table border='1'><thead><tr><th> using: credit card</th></tr></thead><tbody>";

        // Add each user name to the table
        userNames.forEach(function (room_id) {
            tableHTML10 += "<tr><td>" + room_id + "</td></tr>";
        });

        // Close the table HTML
        tableHTML10 += "</tbody></table>";

        // Set the HTML content to the answer container  
        answerContainer10.innerHTML = tableHTML10;

    }

    function hideq10() {
        q10();
        var answerContainer = document.getElementById('answerContainer10');
        if(answerContainer.style.display == 'block'){
            answerContainer.style.display = 'none';
        }else{
            answerContainer.style.display = 'block';
        }

    }

    // Attach event listener to the "Answer" button for mouseover event
    var answerButton = document.getElementById('q10');

    // Attach event listener to the "Answer" button for click event
    answerButton.addEventListener('click', hideq10);
//q11

function q11() {
        // Fetched user names from PHP (passed as JSON)
        var userNames = <?php echo json_encode($userq11); ?>;

        // Create an HTML table to display user names
        var answerContainer11= document.getElementById('answerContainer11');
        var tableHTML11= "<h3>Answer:</h3><table border='1'><thead><tr><th> using: credit card</th></tr></thead><tbody>";

        // Add each user name to the table
        userNames.forEach(function (room_id) {
            tableHTML11 += "<tr><td>" + room_id + "</td></tr>";
        });

        // Close the table HTML
        tableHTML11 += "</tbody></table>";

        // Set the HTML content to the answer container  
        answerContainer11.innerHTML = tableHTML11;

    }

    function hideq11() {
        q11();
        var answerContainer = document.getElementById('answerContainer11');
        if(answerContainer.style.display == 'block'){
            answerContainer.style.display = 'none';
        }else{
            answerContainer.style.display = 'block';
        }

    }

    // Attach event listener to the "Answer" button for mouseover event
    var answerButton = document.getElementById('q11');

    // Attach event listener to the "Answer" button for click event
    answerButton.addEventListener('click', hideq11);

    //q12
    
function q12() {
        // Fetched user names from PHP (passed as JSON)
        var userNames = <?php echo json_encode($userq12); ?>;

        // Create an HTML table to display user names
        var answerContainer12= document.getElementById('answerContainer12');
        var tableHTML12= "<h3>Answer:</h3><table border='1'><thead><tr><th> using: room_name</th></tr></thead><tbody>";

        // Add each user name to the table
        userNames.forEach(function (room_id) {
            tableHTML12 += "<tr><td>" + room_id + "</td></tr>";
        });

        // Close the table HTML
        tableHTML12 += "</tbody></table>";

        // Set the HTML content to the answer container  
        answerContainer12.innerHTML = tableHTML12;

    }

    function hideq12() {
        q12();
        var answerContainer = document.getElementById('answerContainer12');
        if(answerContainer.style.display == 'block'){
            answerContainer.style.display = 'none';
        }else{
            answerContainer.style.display = 'block';
        }

    }

    // Attach event listener to the "Answer" button for mouseover event
    var answerButton = document.getElementById('q12');

    // Attach event listener to the "Answer" button for click event
    answerButton.addEventListener('click', hideq12);

    //q13
     
function q13() {
        // Fetched user names from PHP (passed as JSON)
        var userNames = <?php echo json_encode($userq13); ?>;

        // Create an HTML table to display user names
        var answerContainer13= document.getElementById('answerContainer13');
        var tableHTML13= "<h3>Answer:</h3><table border='1'><thead><tr><th> using: username</th></tr></thead><tbody>";

        // Add each user name to the table
        userNames.forEach(function (room_id) {
            tableHTML13 += "<tr><td>" + room_id + "</td></tr>";
        });

        // Close the table HTML
        tableHTML13 += "</tbody></table>";

        // Set the HTML content to the answer container  
        answerContainer13.innerHTML = tableHTML13;

    }

    function hideq13() {
        q13();
        var answerContainer = document.getElementById('answerContainer13');
        if(answerContainer.style.display == 'block'){
            answerContainer.style.display = 'none';
        }else{
            answerContainer.style.display = 'block';
        }

    }

    // Attach event listener to the "Answer" button for mouseover event
    var answerButton = document.getElementById('q13');

    // Attach event listener to the "Answer" button for click event
    answerButton.addEventListener('click', hideq13);
    //14
        
function q14() {
        // Fetched user names from PHP (passed as JSON)
        var userNames = <?php echo json_encode($userq14); ?>;

        // Create an HTML table to display user names
        var answerContainer14= document.getElementById('answerContainer14');
        var tableHTML14= "<h3>Answer:</h3><table border='1'><thead><tr><th> using: room_name</th></tr></thead><tbody>";

        // Add each user name to the table
        userNames.forEach(function (room_id) {
            tableHTML14 += "<tr><td>" + room_id + "</td></tr>";
        });

        // Close the table HTML
        tableHTML14 += "</tbody></table>";

        // Set the HTML content to the answer container  
        answerContainer14.innerHTML = tableHTML14;

    }

    function hideq14() {
        q14();
        var answerContainer = document.getElementById('answerContainer14');
        if(answerContainer.style.display == 'block'){
            answerContainer.style.display = 'none';
        }else{
            answerContainer.style.display = 'block';
        }

    }

    // Attach event listener to the "Answer" button for mouseover event
    var answerButton = document.getElementById('q14');

    // Attach event listener to the "Answer" button for click event
    answerButton.addEventListener('click', hideq14);
    //q15
            
function q15() {
        // Fetched user names from PHP (passed as JSON)
        var userNames = <?php echo json_encode($userq15); ?>;

        // Create an HTML table to display user names
        var answerContainer15= document.getElementById('answerContainer15');
        var tableHTML15= "<h3>Answer:</h3><table border='1'><thead><tr><th> user </th></tr></thead><tbody>";

        // Add each user name to the table
        userNames.forEach(function (room_id) {
            tableHTML15 += "<tr><td>" + room_id + "</td></tr>";
        });

        // Close the table HTML
        tableHTML15 += "</tbody></table>";

        // Set the HTML content to the answer container  
        answerContainer15.innerHTML = tableHTML15;

    }

    function hideq15() {
        q15();
        var answerContainer = document.getElementById('answerContainer15');
        if(answerContainer.style.display == 'block'){
            answerContainer.style.display = 'none';
        }else{
            answerContainer.style.display = 'block';
        }

    }

    // Attach event listener to the "Answer" button for mouseover event
    var answerButton = document.getElementById('q15');

    // Attach event listener to the "Answer" button for click event
    answerButton.addEventListener('click', hideq15);

    

            // Add each user reservation to the table
</script>
<!--Q3-->

    
    
             
    


    <!-- Copyright Section -->
    <div class="copyright">
        <p>&#169; COPYRIGHT AP RESORT.</p>
    </div>

    <script src="main.js"></script>
</body>