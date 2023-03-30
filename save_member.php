<?php
	//starting the session
	require_once 'vendor/autoload.php';
	use kornrunner\Ethereum\Address;

	session_start();

	//including the database connection
	require_once 'conn.php';
	
	if(ISSET($_POST['register'])){
		// Setting variables
		$username = $_POST['username'];
		$password = $_POST['password'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		setcookie("name", $username, time() + (86400 * 30), "/");
		// Insertion Query
		$query = "INSERT INTO `member` (username, password, firstname, lastname) VALUES(:username, :password, :firstname, :lastname)";
		$stmt = $conn->prepare($query);
		$stmt->bindParam(':username', $username);
		$stmt->bindParam(':password', $password);
		$stmt->bindParam(':firstname', $firstname);
		$stmt->bindParam(':lastname', $lastname);
		
		// Check if the execution of query is success

		if($stmt->execute()){
			$new_mem_id = $conn->lastInsertId();
			$address = new Address();
			// get address
			$pub_address = $address->get();
			$private_key = $address->getPrivateKey();
			
			$query_wallet = "INSERT INTO `wallet` (mem_id, address, private_key) VALUES(:mem_id, :address, :private_key)";
			$stmt_wallet = $conn->prepare($query_wallet);
			$stmt_wallet->bindParam(':mem_id', $new_mem_id);
			$stmt_wallet->bindParam(':address', $pub_address);
			$stmt_wallet->bindParam(':private_key', $private_key);

			if($stmt_wallet->execute()) {
				//setting a 'success' session to save our insertion success message.
				$_SESSION['success'] = "Successfully created an account";

				//redirecting to the index.php 
				header('location: index.php');	
				return;
			}
			
		}

	}
?>