<?php

$con= new mysqli('localhost','root','','thesisarchive_db');

session_start();
// checks if connected to database
if($con){
    echo "Connection Successful";
}else{
    die(mysqli_error($con));
}

if($_SERVER["REQUEST_METHOD"]=="POST")
{
	//validate data for login
	function validate($data){
		$data= trim($data);
		$data= stripslashes($data);
		$data= htmlspecialchars($data);
		return $data;
	}
		$username= validate($_POST['username']);
		$password= validate($_POST['password']);
		//checks username field
		if(empty($username)){
			header("Location: login.php? error=Username is required");
			exit();

		//checks password field	
		}else if(empty($password)){
			header("Location: login.php? error=Password is required");
			exit();
		} else{
			// check if the username and password are in the database
			$sql="SELECT * FROM tbl_allusers where username='".$username."' AND password='".$password."' ";
			$result=mysqli_query($con,$sql);
			$row=mysqli_fetch_array($result);
			//admin login
			if($row["username"]==$username && $row["password"]==$password && $row["type"]=="Admin"){
				$_SESSION["username"]=$username;
				$_SESSION["password"]=$password;

				header("location:adminDashboard.php");
				exit();
			//student login	
			}else if($row["username"]==$username && $row["password"]==$password && $row["type"]=="Student"){
				$_SESSION["username"]=$username;
				$_SESSION["password"]=$password;

				header("location:studentDashboard.php");
				exit();
			}else if($row["username"]==$username && $row["password"]==$password && $row["type"]=="Librarian"){
				$_SESSION["username"]=$username;
				$_SESSION["password"]=$password;

				header("location:librarianThesisManagement.php");
				exit();
			}
			//incorrect pass or user
			else{
				header("location:login.php? error=Incorrect Username or Password") ;
		exit();
			}

		}
	}
?>