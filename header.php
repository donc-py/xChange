       <!-- <img src="logo3.png" width="1000px" /> -->
	<!--<div style="border:2px black solid;" > style="border:2px black solid;" -->
	 <ul id="TJK_dropDownMenu">
		<li id="AB" style="background:#616C7A ; width:12% "> <a href="index.php">Menu</a>	
  		 <ul>
			<li> <a href="./index.php">Home</a>  </li>
			<li> <a href="./dice.php">Dice</a>  </li>
			<li> <a href="./marketplace.php">MarketPlace</a>  </li>
			<li> <a href="./vote.php">CryptoVote</a>  </li>
			<li> <a href="./dice.php">Doge Dex</a>  </li>
			<li> <a href="?page=coins">Investments</a>  </li>
		 </ul>
		</li>
		<li id="CF" style="background:#5C6776 ; width:12% ">  <a href="?page=licence">About</a>  		
		 <ul>
			<li> <a href="./index.php">Home</a>  </li>
			<li> <a href="?page=contact">Contact</a>  </li>
		 </ul> </li>
        <li id="3m" style="background:#546070 ; width:12% "> <a href="?page=rmcookie"> </a>	</li>
        <li id="3m" style="background:#4A5568 ; width:12% "> <a href="forums.php"> </a>	</li>
        <li id="3m" style="background:#3A455B ; width:12% "> <a href="forums.php"> </a>	 </li>
        <li id="3m" style="text-align:right;background:#2D3851;width:40%"> <div style="margin-right:20px;"> <a> <?php print(date("D M d Y | G:i:s"));?> </a> </div> </li>
	  </ul>
	<!-- </div> menu-->

    <form action="upload.php" method="post" enctype="multipart/form-data">
        <p style="color:#F78989">use wallet generated file to upload transaction
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload" name="submit">
        </p>
    </form>