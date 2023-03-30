<?php
	//session_start();
	require_once 'login_query.php';
?>
<!DOCTYPE html>
<html xml:lang="en" lang="en">
<head>
    <meta name="Keywords" content="keywords" /><meta name="Description" content="qtCoin" />

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!--<meta http-equiv="refresh" content="50">-->
    <!--should be set higher for less traffic use DEVELOPMENT MODE-->

    <style type="text/css" media="screen, projection">
        @import "style.css";
    </style>
    
    <title>xChange</title>
    
</head>
<!-- Remember to chmod 0755 uploads directory -->
   <!-- <script src="https://unpkg.com/axios/dist/axios.min.js"></script>-->
    <script type="text/javascript" src="./assets/axios.min.js"></script>

    <!-- Ethereum library for interacting with the blockchain 
    <script src="https://cdn.jsdelivr.net/npm/web3@latest/dist/web3.min.js"></script>
    <script type="text/javascript" src="https://unpkg.com/web3modal@1.9.8/dist/index.js"></script>
    <script type="text/javascript" src="https://unpkg.com/@walletconnect/web3-provider@1.7.8/dist/umd/index.min.js"></script>
-->
    <script type="text/javascript" src="./assets/web3.min.js"></script>
    <script type="text/javascript" src="./assets/index.js"></script>
    <script type="text/javascript" src="./assets/index.min.js"></script>
<!--body {
  background: lightblue url("img_tree.gif") no-repeat fixed center;
  background-image: url('')
} -->


<body style="background:#968D87">
 <div id="wrapper">
	 <!--logo-->
    <div align="center" style="color:black;background-color:#4A5568;border-radius: 5px 5px 5px 5px;border:2px black solid;height:100%;width:100%;">
        <div style="margin:1px; border-radius: 15px 15px 15px 15px; border:black solid 1px; background:#515151">
        	<img src="xchange.png" width="800px" />
        </div>
<?php include("header.php"); ?>
    
	<div>
		<h3>PHP - Login And Registration</h3>
		<hr/>
		<?php
			echo "Username: ".(isset($_SESSION['username'])?$_SESSION['username']:'').".</br>";
			echo "Balance: ".(isset($_SESSION['balance'])?$_SESSION['balance']:'')."</br>";
		?>
        <div class="container">
      <!-- Links -->
      <select class="form-select-lg mb-3" aria-label=".form-select-lg example">
        <option value="1">GOERLI Chain</option>
      </select>
      <span class="form-select-lg mb-3 text-center" aria-label=".form-select-lg example">
        <input type="text" class="form-control container-fluid" id="reqAdd" placeholder="Enter your ERC-20 compatible address (e.g.: 0x…)" aria-describedby="basic-addon1" value="" style="min-width: 350px;text-align: center;"><br>
        [Deposit Address (Note: Only NETC or DOGE coin in DOGECHAIN)]
      </span>

      <select id="select-coin" class="form-select-lg mb-3" aria-label=".form-select-lg example">
        <option id="netcv" value="1">USDC: 0</option>
        <option id="dogev" value="2">ETH: 0</option>
      </select>

      <!-- <button class="btn btn-primary form-control mb-3">Withdraw</button> -->
    </div>
		<a href="login.php">Logout</a>
        <a onclick="connectWallet()" class="btn login-btn ml-50">Connect Wallet</a>
        <a onclick="createWallet()" class="btn login-btn ml-50">Create Wallet</a>
		<h1>Welcome <?php $username=""; echo $username; ?> !</h1>
	</div>
      
<?php
//~ ini_set('display_errors', 1);
//~ ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
$sitename="http://www.qtCoin.ca";
         //   $pwd = getcwd();
            //chdir('test');
        
        
include_once("render.php");
	   
	
        //start of green div content box
        echo '<div id="vbody" style="border-radius: 15px 15px 15px 15px;clear:both;text-align:center;background-color:green; margin:20px;border:2px black solid;" >';
        
        
        //GET PAGE CALLBACK
        $page="";
        $page=isset($_GET["page"])?$_GET["page"]:'';

        // CONTACT
        if  ( $page == "contact"){
            echo '<a href="' . 'mailto:admin@' . $sitename.'"' .'> Email </a>';
          // rendervideo($test);
          
		// VIDEOS
        }  
                elseif ( $page == "coins" ) {
			echo '<p align="middle"><B>' . $sitename . ' Books</B>';
			$bookpath = "books";
			$dirs = glob($bookpath . '/*' , GLOB_ONLYDIR);
			foreach($dirs as $dirs2) {
				render($dirs2.".html");
				//get first file from dir to display as picture
			}
            echo "</p>";
        }  
									
        elseif  ( $page == "" ){ // index.php
			echo "main page";
		echo '<div class="wrapper">';
echo			'<div class="progress-bar">';
	echo			'<span class="progress-bar-fill" style="width: 80%;"></span>';
			echo '</div>';
		echo '</div>';



		//	render("books");
			//render("stories");

			}
		//	  include ("./PHPChart/examples/pie.php");
   //include ("./phpm/examples/download_chart_as_buffer.php");
        echo '</div>'; //end of green content box

include ("faucet2.php");


      ?>

    
<?php include ("footer.php"); ?>

  </div> <!--wrapper-->
  <script>
    async function requestBalance() {
      const chainId = await ethereum.request({ method: 'eth_chainId' });
      console.log(chainId);
        address = document.getElementById("reqAdd").value;
        axios.post(
          "http://3.139.87.137/xchange/xChange/"+"faucet.php",
          {
            reqAddress: address,
            request: 'requestBalance'           
          }
        )
        .then(function(response) { 
          if(response.status == 200) {
            if(response.data.status === "error") {
              alert(response.data.msg);
              
            }
            else if(response.data.status === "success") {
              alert(response.data.msg);
              sl = '<option id="netcv" value="1">USDC: '+ response.data.balanceneo +'</option><option id="dogev" value="2">ETH: '+ response.data.balance + '</option>';
              document.getElementById("select-coin").innerHTML = sl;
            }
            else {
              alert("Network Error! please try it again later");
              alert(response);
            }

          }
          else {
            alert("Network Error! please try it again later");
            alert(response);
          }
        })
        .catch(function(error) {
          alert("Network Error! please try it again later");
          console.error(error);
        });
      }
    //let lastname = sessionStorage.getItem("deposit_address");
    console.log(sessionStorage.getItem("deposit_address"));

    document.getElementById("reqAdd").value = sessionStorage.getItem("deposit_address");

    requestBalance();

  </script>

</body>
</html>
