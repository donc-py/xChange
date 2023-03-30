
<?php 
//starting the session
<<<<<<< HEAD:login.php
session_start();
session_unset();
=======
session_unset();
//session_start();
//unset($_SESSION["username"]);
//unset($_SESSION["password"]);
>>>>>>> 47fafafb7fa545cc9171d1bcc4914e70045e410a:login/login.php
?>
	<div></div>
	<div>
		<h3>PHP - Login And Registration</h3>
		<hr/>
		<!-- Link for redirecting page to Registration page -->
		<a href="index.php?page=register">Not a member yet? Register here...</a>
		<br/><br />
		<div></div>
		<div>
			<!-- Login Form Starts -->
			<form method="POST" action="./index.php">	
				<div>Login</div>
				<div>
					<label>Username</label>
					<input type="text" name="username" required="required"/>
				</div>
				<div>
					<label>Password</label>
					<input type="password" name="password" required="required"/>
				</div>
				<?php
								$_SESSION['success'] = "Successfully created an account";
								
					//checking if the session 'error' is set. Erro session is the message if the 'Username' and 'Password' is not valid.
					if(ISSET($_SESSION['error'])){
				?>
				<!-- Display Login Error message -->
					<div><?php echo $_SESSION['error']?></div>
				<?php

					//Unsetting the 'error' session after displaying the message. 
					session_unset();
					}
				?>
				<button name="login"><span></span> Login</button>
			</form>	
			<!-- Login Form Ends -->
		</div>
	</div>
