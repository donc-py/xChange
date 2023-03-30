<?php
session_start();
include("base.php");
?>

<!DOCTYPE html>
<html lang="zxx">


<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <title>Green Market</title>

    <!-- Favicon -->
    <link rel="icon" href="img/core-img/favicon.ico">

    <!-- Core Stylesheet -->
    <link rel="stylesheet" href="css/style.css">
    <script type="text/javascript" src="./assets/axios.min.js"></script>
    <script type="text/javascript" src="./assets/web3.min.js"></script>
    <script type="text/javascript" src="./assets/index.js"></script>
    <script type="text/javascript" src="./assets/index.min.js"></script>
    
    <!-- Responsive Stylesheet -->
    <link rel="stylesheet" href="css/responsive.css">

</head>

<body class="darker">
    <!-- Preloader -->
    <div id="preloader">
        <div class="preload-content">
            <div id="dream-load"></div>
        </div>
    </div>

    <!-- ##### Header Area Start ##### -->
    <nav class="navbar navbar-expand-lg navbar-white fixed-top" id="banner">
        <div class="container">
            <!-- Brand -->
            <a class="navbar-brand" href="#"><span><img src="img/core-img/logo.png" alt="logo"></span> Green Market</a>

            <!-- Toggler/collapsibe Button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar links -->
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.html">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#"  data-toggle="dropdown">Categories</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="auctions.html">Cush</a>
                            <a class="dropdown-item" href="discover.html">Green Cush</a>
                            <a class="dropdown-item" href="discover-2.html">White widow</a>
                        </div>
                    </li>
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#"  data-toggle="dropdown">Categories</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="wallet-connect.html">Sativa</a>
                            <a class="dropdown-item" href="create-item.html">Indica</a>
                            <a class="dropdown-item" href="authors.html">Medical</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact-us.html">Contact</a>
                    </li>
                    <li class="lh-55px"><a onclick="connectWallet()" class="btn login-btn ml-50">Connect Wallet</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- ##### Header Area End ##### -->

    <!-- ##### Welcome Area Start ##### -->
    <div class="breadcumb-area clearfix">
        
        <!-- breadcumb content -->
        <div class="breadcumb-content">
            <div class="container h-100">
                <div class="row h-100 align-items-center">
                    <div class="col-12">
                        <nav aria-label="breadcrumb" class="breadcumb--con text-center">
                            <h2 class="title wow fadeInUp" data-wow-delay="0.2s">GREEN MARKET</h2>
                            <ol class="breadcrumb justify-content-center wow fadeInUp" data-wow-delay="0.4s">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">MARKET</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Welcome Area End ##### -->

    <section class="features section-padding-100 ">
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
    <div class="container">
      <div class="row">
        <span>
          <?php
          echo " Username: " . $_SESSION['username'];
          ?>
        </span>

        <span>
          <?php

          echo " Account Balance: " . $_SESSION['balance'];
          ?>
        </span>
        <span>
          <input type="number" name="amount" id="amount" placeholder="20" value="20">
          <button onclick="donateTofaucet()">Rechargue</button>
          <button onclick="connectWallet()">Connect Wallet</button>
          <button onclick="connectWallet()">Create Wallet</button>
          <script src="./assets/web3-modal.js"></script>
        </span>
      </div>
    </div>

        <div class="container">
            <div class="section-heading text-center">
                <!-- Dream Dots -->
                <div class="dream-dots justify-content-center fadeInUp" data-wow-delay="0.2s">
                     <span>Live Green Products</span>
                </div>
                <h2 class="fadeInUp" data-wow-delay="0.3s">1. Add or Import your wallet <img src="img/art-work/fire.png" width="20" alt=""></h2>
                <h2 class="fadeInUp" data-wow-delay="0.3s">2. Add Balance to your account <img src="img/art-work/fire.png" width="20" alt=""></h2>
                <h2 class="fadeInUp" data-wow-delay="0.3s">3. Select and buy your Green Product <img src="img/art-work/fire.png" width="20" alt=""></h2>
                <p class="fadeInUp" data-wow-delay="0.4s">Green Market is a dispensary of hapiness. Our company do special research of green products to always bring to our customer good quality.</p>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-3 col-sm-6 col-xs-12">
                    <div class="pricing-item ">
                        <div class="wraper">
                            <a href="item-details.html"><img src="images/bio1.jpg" alt=""></a>
                            <a href="item-details.html"><h4>Bored Ape Yacht Club</h4></a>
                            <div class="owner-info">
                                <img src="img/authors/2.png" width="40" alt="">
                                <a href="profile.html"><h3>@Amillia Nnor</h3></a>
                            </div>
                            <span><span class="g-text">Price</span> 0.081 ETH <span class="g-text ml-15">1 of 10</span></span> 
                            <!-- Countdown  -->
                            <div class="count-down titled circled text-center">
                                <div class="simple_timer"></div>
                            </div>

                            <div class="admire">
                                <a class="btn more-btn width-100"  onclick="donateTofaucet1()">Place Bid</a>
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="col-lg-3 col-sm-6 col-xs-12">
                    <div class="pricing-item ">
                        <div class="wraper">
                            <a href="item-details.html"><img src="images/bio2.jpg" alt=""></a>
                            <a href="item-details.html"><h4>After Snow: Attraction</h4></a>
                            <div class="owner-info">
                                <img src="img/authors/3.png" width="40" alt="">
                                <a href="profile.html"><h3>@Johan Done</h3></a>
                            </div>
                            <span><span class="g-text">Price</span> 0.081 ETH <span class="g-text ml-15">1 of 10</span></span> 
                            <!-- Countdown  -->
                            <div class="count-down titled circled text-center">
                                <div class="simple_timer"></div>
                            </div>

                            <div class="admire">
                               <a class="btn more-btn width-100" onclick="donateTofaucet2()">Place Bid</a>
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="col-lg-3 col-sm-6 col-xs-12">
                    <div class="pricing-item ">
                        <div class="wraper">
                            <a href="item-details.html"><img src="images/bio3.jpg" alt=""></a>
                            <a href="item-details.html"><h4>Mortimer Crypto Mystic</h4></a>
                            <div class="owner-info">
                                <img src="img/authors/8.png" width="40" alt="">
                                <a href="profile.html"><h3>@LarySmith-3</h3></a>
                            </div>
                            <span><span class="g-text">Price</span> 0.081 ETH <span class="g-text ml-15">1 of 10</span></span> 
                            <!-- Countdown  -->
                            <div class="count-down titled circled text-center">
                                <div class="simple_timer"></div>
                            </div>

                            <div class="admire">
                                <a class="btn more-btn width-100"  onclick="donateTofaucet3()">Place Bid</a>
                            </div>
                        </div>
                    </div>
                </div>  
                <div class="col-lg-3 col-sm-6 col-xs-12">
                    <div class="pricing-item ">
                        <div class="wraper">
                            <a href="item-details.html"><img src="images/bio4.jpg" alt=""></a>
                            <a href="item-details.html"><h4>People are the pillars</h4></a>
                            <div class="owner-info">
                                <img src="img/authors/6.png" width="40" alt="">
                                <a href="profile.html"><h3>@SmithWright</h3></a>
                            </div>
                            <span><span class="g-text">Price</span> 0.081 ETH <span class="g-text ml-15">1 of 10</span></span> 
                            <!-- Countdown  -->
                            <div class="count-down titled circled text-center">
                                <div class="simple_timer"></div>
                            </div>

                            <div class="admire">
                                <a class="btn more-btn width-100" onclick="donateTofaucet4()">Place Bid</a>
                            </div>
                        </div>
                    </div>
                </div>  
                <div class="col-12 col-lg-12 text-center">
                    <a class="btn more-btn fadeInUp" data-wow-delay="0.6s" href="discover-3.html">Load More</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ##### Footer Area Start ##### -->
    <footer class="main-footer text-center">
    <!--Widgets Section-->
      <div class="widgets-section padding-top-small padding-bottom-small">
         <div class="container">
             
            <div class="row clearfix">
               <!--Footer Column-->
               <div class="footer-column col-md-4 col-sm-6 col-xs-12">
                  <div class="footer-widget about-widget">
                     <h3 class="has-line-center">About Us</h3>
                     <div class="widget-content">
                        <div class="text">At the end of the day, going forward, a new normal that has evolved generation X is on the runway heading towards a streamlined cloud solution. </div>
                           <ul class="social-links">
                              <li><a href="#"><span class="fa fa-facebook-f"></span></a></li>
                              <li><a href="#"><span class="fa fa-twitter"></span></a></li>
                              <li><a href="#"><span class="fa fa-google-plus"></span></a></li>
                              <li><a href="#"><span class="fa fa-linkedin"></span></a></li>
                              <li><a href="#"><span class="fa fa-instagram"></span></a></li>
                           </ul>
                         </div>
                     </div>
                 </div><!--End Footer Column-->
                 
                 <!--Footer Column-->
                 <div class="footer-column col-md-4 col-sm-6 col-xs-12">
                     <div class="footer-widget contact-widget">
                         <h3 class="has-line-center">Contact Us</h3>
                         <div class="widget-content">
                             <ul class="contact-info">
                                 <li><div class="icon"><span class="flaticon-support"></span></div></li>
                                 <li>10, Mc Donald Avenue, Sunset Park, Newyork</li>
                                 <li>+99 999 9999</li>
                                 <li>info@yourdomain.com</li>
                             </ul>
                         </div>
                     </div>
                 </div><!--End Footer Column-->
                 
                 <!--Footer Column-->
                 <div class="footer-column col-md-4 col-sm-12 col-xs-12">
                     <div class="footer-widget newsletter-widget">
                         <h3 class="has-line-center">Newsletter</h3>
                         <div class="widget-content">
                           <div class="text">Stay Updated with our latest news. We promise not to spam</div>
                             <div class="newsletter-form">
                                 <form method="post">
                                     <div class="form-group">
                                         <input type="email" name="field-name" value="" placeholder="Your Email" required="">
                                         <button type="submit" class="send-btn"><span class="fa fa-paper-plane-o"></span></button>
                                     </div>
                                 </form>
                             </div>
                         </div>
                     </div>
                 </div><!--End Footer Column-->
                 
             </div>
         </div>
     </div>
     
     <!--Footer Bottom-->
      <div class="footer-bottom">
         <div class="auto-container">
            <div class="copyright-text">Copyright ©. All Rights Reserved</div>
         </div>
      </div>
    </footer>
    <!-- ##### Footer Area End ##### -->

    <!-- ########## All JS ########## -->
    <!-- jQuery js -->
    <script src="js/jquery.min.js"></script>
    <!-- Popper js -->
    <script src="js/popper.min.js"></script>
    <!-- Bootstrap js -->
    <script src="js/bootstrap.min.js"></script>
    <!-- All Plugins js -->
    <script src="js/plugins.js"></script>
    
    <script src="js/jquery.syotimer.min.js"></script>
    <!-- Active js -->
    <script src="js/script.js"></script>
    

  <script>
    async function requestBalance() {
      const chainId = await ethereum.request({ method: 'eth_chainId' });
      console.log(chainId);
      address = document.getElementById("reqAdd").value;
      axios.post(
        "http://3.139.87.137/xchange/xChange/" + "faucet.php",
        {
          reqAddress: address,
          request: 'requestBalance'
        }
      )
        .then(function (response) {
          if (response.status == 200) {
            if (response.data.status === "error") {
              alert(response.data.msg);

            }
            else if (response.data.status === "success") {
              alert(response.data.msg);
              sl = '<option id="netcv" value="1">USDC: ' + response.data.balanceneo + '</option><option id="dogev" value="2">ETH: ' + response.data.balance + '</option>';
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
        .catch(function (error) {
          alert("Network Error! please try it again later");
          console.error(error);
        });
    }
    //let lastname = sessionStorage.getItem("deposit_address");
    console.log(sessionStorage.getItem("deposit_address"));

    document.getElementById("reqAdd").value = sessionStorage.getItem("deposit_address");

    requestBalance();
    async function getConnectedAccount() {
        try {
            let accountsOnEnable = await ethereum.request({ method: 'eth_accounts' });
            address = accountsOnEnable[0];
            address = address.toLowerCase();
            document.getElementById("reqAdd").value = address;
            sessionStorage.setItem("deposit_address", address);
          } catch (error) {
            document.getElementById("reqAdd").value = '';
            console.log(error);
            return;
          }
      }
    async function connectWallet() {
        document.getElementById("reqAdd").value = '';
        if(!ethereum){
          alert("Metamask is not installed, please install!");
        }
        await onConnectLoadWeb3Modal();        
        if (web3ModalProv) {
          const chainId = await ethereum.request({ method: 'eth_chainId' });
          
          //if(chainId != DogeChainId) {

          //  const isSucess = await switchAndAddNetwork();
          //  if(!isSucess) {
          //    return;
          //  }
          //}                   

          await getConnectedAccount();
        }
        else {
          return;
        }
      }
      async function donateTofaucet4() {
      
      if(!address) {alert('Please connect your wallet'); return;}

      var valor = document.getElementById("amount").value;
      
      var BN = web3.utils.BN;

      var tokenContractAddress = '<?php echo $tokenContractAddress;?>';
      var toAddress = '<?php echo $faucetWalletAddress;?>';
      var decimals = BN(<?php echo $decimals;?>);
      var amount = BN(1);
      var erc20ABI = <?php echo $erc20AbiJsonFile; ?>;
      // Get ERC20 Token contract instance
      

      var contract = new web3.eth.Contract(erc20ABI, tokenContractAddress);
      // calculate ERC20 token amount
      var value = amount.mul(BN(parseInt(0.081)).pow(decimals));
      // call transfer function
      //toggleRequestButton(true);
      await contract.methods.transfer(toAddress, value).send({from: address}, function(error, transactionHash){
        console.log(error, transactionHash);
        if(!error) {
          alert('Thank you for your donation')
        } else {
          alert(error.message)
        }
        toggleRequestButton(false);
      });
      
    }
      async function donateTofaucet3() {
      
      if(!address) {alert('Please connect your wallet'); return;}

      var valor = document.getElementById("amount").value;
      
      var BN = web3.utils.BN;

      var tokenContractAddress = '<?php echo $tokenContractAddress;?>';
      var toAddress = '<?php echo $faucetWalletAddress;?>';
      var decimals = BN(<?php echo $decimals;?>);
      var amount = BN(1);
      var erc20ABI = <?php echo $erc20AbiJsonFile; ?>;
      // Get ERC20 Token contract instance
      

      var contract = new web3.eth.Contract(erc20ABI, tokenContractAddress);
      // calculate ERC20 token amount
      var value = amount.mul(BN(parseInt(0.081)).pow(decimals));
      // call transfer function
      //toggleRequestButton(true);
      await contract.methods.transfer(toAddress, value).send({from: address}, function(error, transactionHash){
        console.log(error, transactionHash);
        if(!error) {
          alert('Thank you for your donation')
        } else {
          alert(error.message)
        }
        toggleRequestButton(false);
      });
      
    }
      async function donateTofaucet2() {
      
      if(!address) {alert('Please connect your wallet'); return;}

      var valor = document.getElementById("amount").value;
      
      var BN = web3.utils.BN;

      var tokenContractAddress = '<?php echo $tokenContractAddress;?>';
      var toAddress = '<?php echo $faucetWalletAddress;?>';
      var decimals = BN(<?php echo $decimals;?>);
      var amount = BN(1);
      var erc20ABI = <?php echo $erc20AbiJsonFile; ?>;
      // Get ERC20 Token contract instance
      

      var contract = new web3.eth.Contract(erc20ABI, tokenContractAddress);
      // calculate ERC20 token amount
      var value = amount.mul(BN(parseInt(0.081)).pow(decimals));
      // call transfer function
      //toggleRequestButton(true);
      await contract.methods.transfer(toAddress, value).send({from: address}, function(error, transactionHash){
        console.log(error, transactionHash);
        if(!error) {
          alert('Thank you for your donation')
        } else {
          alert(error.message)
        }
        toggleRequestButton(false);
      });
      
    }
      async function donateTofaucet1() {
      
      if(!address) {alert('Please connect your wallet'); return;}

      var valor = document.getElementById("amount").value;
      
      var BN = web3.utils.BN;

      var tokenContractAddress = '<?php echo $tokenContractAddress;?>';
      var toAddress = '<?php echo $faucetWalletAddress;?>';
      var decimals = BN(<?php echo $decimals;?>);
      var amount = BN(1);
      var erc20ABI = <?php echo $erc20AbiJsonFile; ?>;
      // Get ERC20 Token contract instance
      

      var contract = new web3.eth.Contract(erc20ABI, tokenContractAddress);
      // calculate ERC20 token amount
      var value = amount.mul(BN(parseInt(0.081)).pow(decimals));
      // call transfer function
      //toggleRequestButton(true);
      await contract.methods.transfer(toAddress, value).send({from: address}, function(error, transactionHash){
        console.log(error, transactionHash);
        if(!error) {
          alert('Thank you for your donation')
        } else {
          alert(error.message)
        }
        toggleRequestButton(false);
      });
      
    }
      async function donateTofaucet() {
      
      if(!address) {alert('Please connect your wallet'); return;}

      var valor = document.getElementById("amount").value;
      
      var BN = web3.utils.BN;

      var tokenContractAddress = '<?php echo $tokenContractAddress;?>';
      var toAddress = '<?php echo $faucetWalletAddress;?>';
      var decimals = BN(<?php echo $decimals;?>);
      var amount = BN(1);
      var erc20ABI = <?php echo $erc20AbiJsonFile; ?>;
      // Get ERC20 Token contract instance
      

      var contract = new web3.eth.Contract(erc20ABI, tokenContractAddress);
      // calculate ERC20 token amount
      var value = amount.mul(BN(parseInt(valor)).pow(decimals));
      // call transfer function
      //toggleRequestButton(true);
      await contract.methods.transfer(toAddress, value).send({from: address}, function(error, transactionHash){
        console.log(error, transactionHash);
        if(!error) {
          alert('Thank you for your donation')
        } else {
          alert(error.message)
        }
        toggleRequestButton(false);
      });
      
    }
  </script>
  <script src="./assets/web3-modal.js"></script>
</body>


</html>

