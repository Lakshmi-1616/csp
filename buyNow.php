<?php
session_start();
require 'db.php';

$pid = $_GET['pid'];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_POST['name'];
    $city = $_POST['city'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $pincode = $_POST['pincode'];
    $addr = $_POST['addr'];
    $bid = $_SESSION['id'];

    $sql = "INSERT INTO transaction (bid, pid, name, city, mobile, email, pincode, addr)
            VALUES ('$bid', '$pid', '$name', '$city', '$mobile', '$email', '$pincode', '$addr')";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = "Order successfully placed! Thanks for shopping with us!!!";

        // Send email notification to the seller
        $to = "repanalakshminaryana@gmail.com"; // Replace with the seller's email address
        $subject = "New Order Notification";
        $message = "Dear Seller,\n\nA new order has been placed for your product.\n\nPlease check your AgroCulture account for more details.\n\nThank you!";
        $headers = "From: your-email@example.com"; // Replace with your email address

        // Uncomment the line below to send the email
        // mail($to, $subject, $message, $headers);

        header('Location: Login/success.php');
        exit();
    } else {
        $_SESSION['message'] = "Sorry! Order was not placed";
        header('Location: Login/error.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Agr0-Connect: Transaction</title>
    <meta lang="eng">
    <meta charset="UTF-8">
    <title>AgroCulture</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!--[if lte IE 8]><script src="css/ie/html5shiv.js"></script><![endif]-->
    <script src="js/jquery.min.js"></script>
    <script src="js/skel.min.js"></script>
    <script src="js/skel-layers.min.js"></script>
    <script src="js/init.js"></script>
    <link rel="stylesheet" href="Blog/commentBox.css" />
    <noscript>
        <link rel="stylesheet" href="css/skel.css" />
        <link rel="stylesheet" href="css/style.css" />
        <link rel="stylesheet" href="css/style-xlarge.css" />
    </noscript>
</head>
<body>
    <?php
    require 'menu.php';
    ?>

    <section id="main" class="wrapper">
        <div class="container">
            <center>
                <h2>Transaction Details</h2>
            </center>
            <section id="two" class="wrapper style2 align-center">
                <div class="container">
                    <center>
                        <form method="post" action="buyNow.php?pid=<?= $pid; ?>" style="border: 1px solid black; padding: 15px;">
                            <center>
                                <div class="row uniform">
                                    <div class="6u 12u$(xsmall)">
                                        <input type="text" name="name" id="name" value="" placeholder="Name" required/>
                                    </div>
                                    <div class="6u 12u$(xsmall)">
                                        <input type="text" name="city" id="city" value="" placeholder="City" required/>
                                    </div>
                                </div>
                                <div class="row uniform">
                                    <div class="6u 12u$(xsmall)">
                                        <input type="text" name="mobile" id="mobile" value="" placeholder="Mobile Number" required/>
                                    </div>
                                    <div class="6u 12u$(xsmall)">
                                        <input type="email" name="email" id="email" value="" placeholder="Email" required/>
                                    </div>
                                </div>
                                <div class="row uniform">
                                    <div class="4u 12u$(xsmall)">
                                        <input type="text" name="pincode" id="pincode" value="" placeholder="Pincode" required/>
                                    </div>
                                    <div class="8u 12u$(xsmall)">
                                        <input type="text" name="addr" id="addr" value="" placeholder="Address" style="width:80%" required/>
                                    </div>
                                </div>
                                <br />
                                <p>
                                    <input type="submit" value="Confirm Order" />
                                </p>
                            </center>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </section>
</body>
</html>
