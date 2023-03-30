<?php
    session_start();
	require_once 'db/conn.php';
	
	if(ISSET($_POST['login'])){
		$username = $_POST['username'];
		$password = $_POST['password'];
		$query = "SELECT mem_id FROM `member` WHERE `username` = :username AND `password` = :password";
		$stmt = $conn->prepare($query);
		$stmt->bindParam(':username', $username);
		$stmt->bindParam(':password', $password);
		$stmt->execute();
		$row = $stmt->fetch();
		
		$mem_id = $row['mem_id'];
		
		if($mem_id > 0){
			$_SESSION['username'] = $username;
			$_SESSION['password'] = $password;

			$query_wallet = "SELECT address FROM `wallet` WHERE `mem_id` = :mem_id";
			$stmt_wallet = $conn->prepare($query_wallet);
			$stmt_wallet->bindParam(':mem_id', $mem_id);
			$stmt_wallet->execute();
			$row = $stmt_wallet->fetch();

			$_SESSION['deposit_address'] = $row['address'];			

		}else{
			$_SESSION['error'] = "session val ::: Invalid username or password";
			header('location:login.php');
		}
	}
?>
