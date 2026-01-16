<?php
 
 
$host = "localhost";
$user = "root";
$password = "";
$dbname = "hotel_transelvinia";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
 
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="hotell.css ">
    <meta charset="UTF-8">
    <title>HoteL </title>
 </head>
 
<body>
<img src="istockphoto-472899538-1024x1024.jpg" 
  alt="profile picture" class="circle"
  style="width:250px; height:250px; border-radius:50%; object-fit:cover; border:2px solid #000; float:right; margin:10px;">
 

    <h1> HOTEL MANGMENT  SYSTEM </h1>

 <nav>
    <a href="?page=home">Home <pre></pre></a>
    <a href="?page=rooms">Rooms <pre></pre></a>
    <a href="?page=reservations">Reservations <pre></pre></a>
    <a href="?page=customers">Customers <pre></pre></a>
    <a href="?page=payments">Payments</a>
</nav>

<?php




 if($page == 'add_room'){
    echo "
    <h2>Add Room</h2>
    <form method='POST' action='?page=save_room'>
        Room No: <input type='text' name='room_no' required>><br><br>
        Room Type: <input type='text' name='room_type' required>><br><br>
        Price: <input type='number' name='price' step='0.01' required>><br><br>
        Status: <input type='text' name='status' required>><br><br>
        <button type='submit'>Save</button>
    </form>";
}



 
elseif ($page == 'save_room'){
    $no = $_POST['room_no'];
    $type = $_POST['room_type'];
    $price = $_POST['price'];
    $status = $_POST['status'];

    $sql = "INSERT INTO Room (ROOM_NO, Room_Type, Price, Status)
            VALUES ('$no', '$type', '$price', '$status')";
    if($conn->query($sql)){
        echo "<p>Room Added Successfully!</p>";
    }else{
        echo "<p>Error: ".$conn->error."</p>";
    }
}


 
elseif($page == 'add_customer'){
    echo "
    <h2>Add Customer</h2>
    <form method='POST' action='?page=save_customer' required>>
        First Name: <input type='text' name='fname' required>>  <br><br>
        Last Name: <input type='text' name='lname' required>>    <br><br>
        Phone: <input type='text' name='phone' required>>   <br><br>
        Email: <input type='email' name='email' required>>    <br><br>
        Nationality: <input type='text' name='nat' required>  <br><br>

        <h3>Customer Type:</h3>
        <select name='type'>
            <option value='individual'>Individual</option>
            <option value='corporate'>Corporate</option>
        </select><br><br>

        <div id='extraFields'></div>

        <button type='submit'>Save</button>
    </form>

    <script>
    const t = document.querySelector('select[name=\"type\"]');
    const extra = document.getElementById('extraFields');

    t.onchange = function(){
        if(this.value === 'individual'){
            extra.innerHTML = `
                Passport Number: <input type='text' name='passport'><br><br>
                National ID: <input type='text' name='nid'><br><br>
            `;
        } else {
            extra.innerHTML = `
                Company Name: <input type='text' name='cname'><br><br>
                Tax Number: <input type='text' name='tax'><br><br>
                Contact Person: <input type='text' name='contact'><br><br>
            `;
        }
    }
    </script>
    ";
}
   








elseif($page == 'save_customer'){
    $f = $_POST['fname'];
    $l = $_POST['lname'];
    $p = $_POST['phone'];

    
if(!preg_match('/^[0-9]{11}$/', $p)){
    echo "<p>Error: Phone number must be exactly 11 digits.</p>";
    exit;   
}



    $e = $_POST['email'];
    $n = $_POST['nat'];
    $type = $_POST['type'];

    $sql = "INSERT INTO Customer(F_Name, L_Name, Phone, Email, Nationality)
            VALUES ('$f','$l','$p','$e','$n')";
    $conn->query($sql);

    $cid = $conn->insert_id;

    if($type == 'individual'){
        $pass = $_POST['passport'];
        $nid = $_POST['nid'];
        $sql2 = "INSERT INTO IndividualCustomer(customer_id, PassportNumber, NationalID)
                 VALUES ('$cid', '$pass', '$nid')";
    } else {
        $cname = $_POST['cname'];
        $tax = $_POST['tax'];
        $contact = $_POST['contact'];
        $sql2 = "INSERT INTO CorporateCustomer(customer_id, CompanyName, TaxNumber, ContactPerson)
                 VALUES ('$cid', '$cname', '$tax', '$contact')";
    }

    if($conn->query($sql2)){
        echo "<p>Customer Added!</p>";
    } else {
        echo "<p>Error: ".$conn->error."</p>";
    }
}






 
elseif($page == 'add_reservation'){
    echo "<h2>Add Reservation</h2>";

    $customers = $conn->query("SELECT customer_id, F_Name, L_Name FROM Customer");
    $rooms = $conn->query("SELECT RoomID, ROOM_NO FROM Room");

    echo "
    <form method='POST' action='?page=save_reservation'>
        Customer:
        <select name='customer_id'>";
        while($c = $customers->fetch_assoc()){
            echo "<option value='{$c['customer_id']}'>{$c['F_Name']} {$c['L_Name']}</option>";
        }
    echo "
        </select><br><br>

        Room:
        <select name='room_id'>";
        while($r = $rooms->fetch_assoc()){
            echo "<option value='{$r['RoomID']}'>{$r['ROOM_NO']}</option>";
        }
    echo "
        </select><br><br>

        Check-In: <input type='date' name='in'><br><br>
        Check-Out: <input type='date' name='out'><br><br>

        <button type='submit'>Save</button>
    </form>";
}





 

 elseif($page == 'save_reservation'){
    $cid = $_POST['customer_id'];
    $room = $_POST['room_id'];
    $in = $_POST['in'];
    $out = $_POST['out'];

    
    $sql_check = "SELECT *
                  FROM Reservation r
                  JOIN ReservationRoom rr ON r.ReservationID = rr.ReservationID
                  WHERE rr.RoomID = '$room'
                    AND r.CheckOutDate > '$in'
                    AND r.CheckInDate < '$out'";
    $result_check = $conn->query($sql_check);

    if($result_check->num_rows > 0){
        echo "<p style='color:red;'>Error: The selected room is already booked for this period.</p>";
        exit;
    }
 
    $sql = "INSERT INTO Reservation(customer_id, CheckInDate, CheckOutDate, Status)
            VALUES ('$cid', '$in', '$out', 'confirmed')";
    if($conn->query($sql)){
        $rid = $conn->insert_id;
 
        $sql2 = "INSERT INTO ReservationRoom(ReservationID, RoomID)
                 VALUES ('$rid','$room')";
        if($conn->query($sql2)){
            echo "<p>Reservation Added Successfully!</p>";
        } else {
            echo "<p>Error: ".$conn->error."</p>";
        }

    } else {
        echo "<p>Error: ".$conn->error."</p>";
    }
}



 




elseif($page == 'add_payment'){

    echo "<h2>Add Payment</h2>";

    $reservations = $conn->query("SELECT ReservationID FROM Reservation");

    echo "
    <form method='POST' action='?page=save_payment'>
        
        Reservation:
        <select name='reservation_id'>";
        
        while($r = $reservations->fetch_assoc()){
            echo "<option value='{$r['ReservationID']}'>Reservation #{$r['ReservationID']}</option>";
        }

    echo "
        </select><br><br>

        Amount:
        <input type='number' name='amount' step='0.01'><br><br>

        Payment Method:
        <select name='method'>
            <option value='card'>Card Payment</option>
            <option value='online'>Online Payment</option>
        </select><br><br>

        <div id='extraPayFields'></div>

        <button type='submit'>Save</button>
    </form>

    <script>
    const m = document.querySelector('select[name=\"method\"]');
    const extra = document.getElementById('extraPayFields');

    m.onchange = function(){
        if(this.value === 'card'){
            extra.innerHTML = `
                Card Number: <input type='text' name='card_no'><br><br>
                Exp Date: <input type='text' name='exp'><br><br>
                Holder Name: <input type='text' name='holder'><br><br>
            `;
        } else {
            extra.innerHTML = `
                Transaction ID: <input type='text' name='trans'><br><br>
                Service Name: <input type='text' name='service'><br><br>
            `;
        }
    }
    </script>
    ";
}



 




elseif($page == 'save_payment'){

    $rid = $_POST['reservation_id'];
    $amount = $_POST['amount'];
    $method = $_POST['method'];

     
    $sql = "INSERT INTO Payment( ReservationID, Amount, PaymentDate, PaymentMethod)
            VALUES ('$rid', '$amount', CURDATE(), '$method')";
    $conn->query($sql);

    $pid = $conn->insert_id;

    if($method == 'card'){

        $card = $_POST['card_no'];
        $exp = $_POST['exp'];
        $holder = $_POST['holder'];

        $sql2 = "INSERT INTO CardPayment(PaymentID, CardNumber, ExpDate, HolderName)
                 VALUES ('$pid', '$card', '$exp', '$holder')";
    }
    else{

        $trans = $_POST['trans'];
        $service = $_POST['service'];

        $sql2 = "INSERT INTO OnlinePayment(PaymentID, TransactionID, ServiceName)
                 VALUES ('$pid', '$trans', '$service')";
    }

    if($conn->query($sql2)){
        echo "<p>Payment Added Successfully!</p>";
    } else {
        echo "<p>Error: ".$conn->error."</p>";
    }
}


 


elseif($page == 'rooms'){
    echo "<h1>Available Rooms</h1>";
    $sql = "SELECT RoomID, ROOM_NO, Room_Type, Price
            FROM Room
            WHERE RoomID NOT IN (SELECT RoomID FROM ReservationRoom)";
    $result = $conn->query($sql);

    echo "<table><tr><th>Room ID</th><th>Room No</th><th>Room Type</th><th>Price</th></tr>";
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()){
            echo "<tr>
                    <td>{$row['RoomID']}</td>
                    <td>{$row['ROOM_NO']}</td>
                    <td>{$row['Room_Type']}</td>
                    <td>{$row['Price']}</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No rooms available</td></tr>";
    }
    echo "</table>";
}


 



 elseif($page == 'reservations'){
    echo "<h1>Reservations</h1>";
  $sql = "SELECT 
                r.ReservationID,
                c.F_Name,
                c.L_Name,
                r.CheckInDate,
                r.CheckOutDate,
                r.Status,
                GROUP_CONCAT(ro.ROOM_NO SEPARATOR ', ') AS Rooms,
                GROUP_CONCAT(CONCAT(ro.ROOM_TYPE, ' - ', ro.PRICE) SEPARATOR ' | ') AS RoomDetails
            FROM Reservation r
            JOIN Customer c 
                ON r.customer_id = c.customer_id
            JOIN ReservationRoom rr 
                ON r.ReservationID = rr.ReservationID
            JOIN Room ro 
                ON rr.RoomID = ro.RoomID
            GROUP BY r.ReservationID
            ORDER BY r.ReservationID DESC";


    $result = $conn->query($sql);

    if ($result === false) {
        echo "<p style='color:red;'>SQL Error: " . $conn->error . "</p>";
        exit;
    }

    echo "<table border='1' cellpadding='10' cellspacing='0' style='border-collapse: collapse; width:100%;'>
            <tr style='background:#f2f2f2; font-weight:bold;'>
                <th>Reservation ID</th>
                <th>Customer Name</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Status</th>
                <th>Rooms</th>
                <th>Room Details (Type - Price)</th>
            </tr>";

    if ($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo "<tr>
                    <td>{$row['ReservationID']}</td>
                    <td>{$row['F_Name']} {$row['L_Name']}</td>
                    <td>{$row['CheckInDate']}</td>
                    <td>{$row['CheckOutDate']}</td>
                    <td>{$row['Status']}</td>
                    <td>{$row['Rooms']}</td>
                    <td>{$row['RoomDetails']}</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='7' style='text-align:center;'>No Reservations Found</td></tr>";
    }

    echo "</table>";
}


 







elseif($page == 'customers'){
    echo "<h1>Individual Customers</h1>";
    $sql = "SELECT c.F_Name, c.L_Name, c.Phone, ic.PassportNumber, ic.NationalID
            FROM Customer c
            JOIN IndividualCustomer ic ON c.customer_id = ic.customer_id";
    $result = $conn->query($sql);

    echo "<table><tr><th>Name</th><th>Phone</th><th>Passport Number</th><th>National ID</th></tr>";
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()){
            echo "<tr>
                    <td>{$row['F_Name']} {$row['L_Name']}</td>
                    <td>{$row['Phone']}</td>
                    <td>{$row['PassportNumber']}</td>
                    <td>{$row['NationalID']}</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No individual customers</td></tr>";
    }
    echo "</table>";

    echo "<h1>Corporate Customers</h1>";
    $sql = "SELECT c.F_Name, c.L_Name, cc.CompanyName, cc.TaxNumber, cc.ContactPerson
            FROM Customer c
            JOIN CorporateCustomer cc ON c.customer_id = cc.customer_id";
    $result = $conn->query($sql);

    echo "<table><tr><th>Name</th><th>Company</th><th>Tax Number</th><th>Contact Person</th></tr>";
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()){
            echo "<tr>
                    <td>{$row['F_Name']} {$row['L_Name']}</td>
                    <td>{$row['CompanyName']}</td>
                    <td>{$row['TaxNumber']}</td>
                    <td>{$row['ContactPerson']}</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No corporate customers</td></tr>";
    }
    echo "</table>";
}









 
elseif($page == 'payments'){
    echo "<h1>Card Payments</h1>";
    $sql = "SELECT p.PaymentID, p.Amount, p.PaymentDate, cp.CardNumber, cp.ExpDate, cp.HolderName
            FROM Payment p
            JOIN CardPayment cp ON p.PaymentID = cp.PaymentID";
    $result = $conn->query($sql);

    echo "<table><tr><th>Payment ID</th><th>Amount</th><th>Date</th><th>Card Number</th><th>Exp Date</th><th>Holder Name</th></tr>";
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()){
            echo "<tr>
                    <td>{$row['PaymentID']}</td>
                    <td>{$row['Amount']}</td>
                    <td>{$row['PaymentDate']}</td>
                    <td>{$row['CardNumber']}</td>
                    <td>{$row['ExpDate']}</td>
                    <td>{$row['HolderName']}</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No card payments</td></tr>";
    }
    echo "</table>";

    echo "<h1>Online Payments</h1>";
    $sql = "SELECT p.PaymentID, p.Amount, p.PaymentDate, op.TransactionID, op.ServiceName
            FROM Payment p
            JOIN OnlinePayment op ON p.PaymentID = op.PaymentID";
    $result = $conn->query($sql);

    echo "<table><tr><th>Payment ID</th><th>Amount</th><th>Date</th><th>Transaction ID</th><th>Service Name</th></tr>";
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()){
            echo "<tr>
                    <td>{$row['PaymentID']}</td>
                    <td>{$row['Amount']}</td>
                    <td>{$row['PaymentDate']}</td>
                    <td>{$row['TransactionID']}</td>
                    <td>{$row['ServiceName']}</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No online payments</td></tr>";
    }
    echo "</table>";
}


 








else{
    echo "
    <h1> WELCOME </h1>
    <p>Use the buttons below to add new data:</p>

    <div style='margin-top:20px;'>
        <a href='?page=add_room' class='btn'>Add Room</a>
        <a href='?page=add_customer' class='btn'>Add Customer</a>
        <a href='?page=add_reservation' class='btn'>Add Reservation</a>
        <a href='?page=add_payment' class='btn'>Add Payment</a>
    </div>

    <style>
        .btn{
            display:inline-block;
            margin:10px;
            padding:12px 20px;
            background: #f80505d2;
            color:white;
            text-decoration:none;
            border-radius:12px;
            font-size:16px;
        }
        .btn:hover{ background:  #f80505d2;
        color: white; }
    </style>
    ";
}


?>
 
</body>
</html>