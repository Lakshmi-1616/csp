<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = dataFilter($_POST['name']);
    $mobile = dataFilter($_POST['mobile']);
    $user = dataFilter($_POST['uname']);
    $email = dataFilter($_POST['email']);
    $pass = dataFilter(password_hash($_POST['pass'], PASSWORD_BCRYPT));
    $hash = dataFilter(md5(rand(0, 1000)));
    $category = dataFilter($_POST['category']);
    $addr = dataFilter($_POST['addr']);

    $_SESSION['Email'] = $email;
    $_SESSION['Name'] = $name;
    $_SESSION['Password'] = $pass;
    $_SESSION['Username'] = $user;
    $_SESSION['Mobile'] = $mobile;
    $_SESSION['Category'] = $category;
    $_SESSION['Hash'] = $hash;
    $_SESSION['Addr'] = $addr;
    $_SESSION['Rating'] = 0;
}

require '../db.php';

$length = strlen($mobile);

if ($length != 10) {
    $_SESSION['message'] = "Invalid Mobile Number!";
    header("location: error.php");
    die();
}

if ($category == 1) {
    $sql = "SELECT * FROM farmer WHERE fusername='$user'";
    $result = mysqli_query($conn, $sql);

    if ($result->num_rows > 0) {
        $_SESSION['message'] = "User with this username already exists!";
        header("location: error.php");
        exit();
    } else {
        $sql = "INSERT INTO farmer (fname, fusername, fpassword, fhash, fmobile, femail, faddress)
                VALUES ('$name','$user','$pass','$hash','$mobile','$email','$addr')";

        if (mysqli_query($conn, $sql)) {
            $fid = mysqli_insert_id($conn); // Get the inserted farmer ID

            $_SESSION['Active'] = 0;
            $_SESSION['logged_in'] = true;
            $_SESSION['picStatus'] = 0;
            $_SESSION['picExt'] = 'png';

            if ($_SESSION['picStatus'] == 0) {
                $_SESSION['picId'] = 0;
                $_SESSION['picName'] = "profile0.png";
            } else {
                $_SESSION['picId'] = $fid;
                $_SESSION['picName'] = "profile".$_SESSION['picId'].".".$_SESSION['picExt'];
            }

            $_SESSION['message'] = "Confirmation link has been sent to $email. Please verify your account by clicking on the link in the email!";

            $to = $email;
            $subject = "Account Verification (ArtCircle.com)";
            $message_body = "
            Hello $user,

            Thank you for signing up!

            Please click this link to activate your account:

            http://localhost/AgroCulture/Login/verify.php?email=$email&hash=$hash";

            //$check = mail($to, $subject, $message_body);

            header("location: profile.php");
            exit();
        } else {
            $_SESSION['message'] = "Registration failed!";
            header("location: error.php");
            exit();
        }
    }
} else {
    $sql = "SELECT * FROM buyer WHERE busername='$user'";
    $result = mysqli_query($conn, $sql);

    if ($result->num_rows > 0) {
        $_SESSION['message'] = "User with this username already exists!";
        header("location: error.php");
        exit();
    } else {
        $sql = "INSERT INTO buyer (bname, busername, bpassword, bhash, bmobile, bemail, baddress)
                VALUES ('$name','$user','$pass','$hash','$mobile','$email','$addr')";

    
            $bid = mysqli_insert_id($conn); // Get the inserted buyer ID

            $_SESSION['Active'] = 0;
            $_SESSION['logged_in'] = true;

           
            $to = $email;
            $subject = "Account Verification (ArtCircle.com)";
            $message_body = "
            Hello $user,

            Thank you for signing up!

            Please click this link to activate your account:

            http://localhost/AgroCulture/Login/verify.php?email=$email&hash=$hash";

            //$check = mail($to, $subject, $message_body);

            header("location: ../productMenu.php");
            exit();
        
            
        }
    
}

function dataFilter($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
