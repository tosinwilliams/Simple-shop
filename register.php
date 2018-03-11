<?php

$page_title = 'Register';
include('includes/header.html');

if($_SERVER['REQUEST_METHOD']=='POST')
{
    //Open database connecion and initialize an array for error messages
    require('../connect_db.php');
    $errors = array();
    
    
    //Insert statement to store error message if first name field reamins empty,else store value in variable
    if(empty($_POST['first_name']))
    {$errors[]='Enter your first name.';}
    else
    {$fn = mysqli_real_escape_string($conn,trim($_POST['first_name']));}
    
    if(empty($_POST['last_name']))
    {$errors[]='Enter your last name.';}
    else
    {$ln = mysqli_real_escape_string($conn,trim($_POST['last_name']));}
    
    if(empty($_POST['email']))
    {$errors[]='Enter your email address.';}
    else
    {$e = mysqli_real_escape_string($conn,trim($_POST['email']));}
    
    //Insert statement to store password value in a variable if passwords match or store an error message if they do not match
    if(!empty($_POST['pass1']))
    {
        if($_POST['pass1']!=$_POST['pass2'])
        {$errors[] = 'Passwords do not match.';}
        else
        {$p = mysqli_real_escape_string($conn,trim($_POST['pass1']));}       
    }
    else{$errors[]='Enter your password.';}
    
    //Insert statements to store an error message if the email address is already registered.
    if(empty($errors))
    {
        $q="SELECT user_id FROM users WHERE email='e'";
        $r= mysqli_query($conn, $q);
        if(mysqli_num_rows($r)!=0)
        {$errors[]= 'Email address already registered.<a href="login.php">Login</a>';}
    }
    
    if(empty($errors))
    {
        $q =" INSERT INTO users (first_name,last_name,email,password,registration_date) VALUES ('$fn','$ln','$e', sha1('$p'),NOW() )";
        $r= mysqli_query($conn, $q);
        
        if($r)
        {
            echo'<h1>Registered!</h1>
                 <p>You are now registered.</p>
                 <p><a href="login.php">Login</a></p>';
        }
        mysqli_close($conn);
        include('includes/footer.html');
        exit();
    }
    else
    {
        echo'<h1>Error!</h1> <p id="err_msg">The following error(s) occured:<br>';
        foreach($errors as $msg)
        {
            echo" - $msg<br>";
        }
        echo'Please try again.</p>';
        mysqli_close($conn);
    }

}
?>

<h1> Register </h1>
<form action="register.php" method="POST">
    <p>
        First Name: <input type="text" name="first_name"
        value="<?php if (isset($_POST['first_name']))
               echo $_POST['first_name'];?>"> 
        
        Last Name: <input type="text" name="last_name"
        value="<?php if (isset($_POST['last_name']))
               echo $_POST['last_name'];?>"> 
    </p> 
    
    <p>
        Email Address: <input type="text" name="email"
        value="<?php if (isset($_POST['email']))
               echo $_POST['email'];?>"> 
    </p>
    
    <p>
        Password: <input type="password" name="pass1"
        value="<?php if (isset($_POST['pass1']))
               echo $_POST['pass1'];?>"> 
        Confirm Password: <input type="password" name="pass2"
        value="<?php if (isset($_POST['pass2']))
               echo $_POST['pass2'];?>">
    </p>
    <p>
        <input type="submit" value="Register">
    </p>
</form>
<?php include('includes/footer.html');?>
