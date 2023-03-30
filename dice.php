<?php
include("base.php");
session_start();
$value = $_SESSION['deposit_address'];

echo $value;



?>
<!DOCTYPE html>
<html lang="en" dir="ltr">


<head>
  <meta charset="utf-8">
  <title>🎲 Dice Game</title>

  <!-- bootstrap 5 -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>

  <link rel="stylesheet" href="assets/dice.css">
  <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700&display=swap" rel="stylesheet">
  <script type="text/javascript" src="./assets/axios.min.js"></script>
  <script type="text/javascript" src="./assets/web3.min.js"></script>
  <script type="text/javascript" src="./assets/index.js"></script>
    <script type="text/javascript" src="./assets/index.min.js"></script>

</head>

<body>
  <nav class="navbar navbar-expand-sm bg-grey justify-content-center">

    <div class="container">
      <!-- Links -->
      <select class="form-select-lg mb-3" aria-label=".form-select-lg example">
        <option value="1">GOERLI Chain</option>
      </select>
      <span class="form-select-lg mb-3 text-center" aria-label=".form-select-lg example">
        <input type="text" class="form-control container-fluid" id="reqAdd"
          placeholder="Enter your ERC-20 compatible address (e.g.: 0x…)" aria-describedby="basic-addon1" value=""
          style="min-width: 350px;text-align: center;"><br>
        [Deposit Address (Note: Only NETC or DOGE coin in DOGECHAIN)]
      </span>



      <select id="select-coin" class="form-select-lg mb-3" aria-label=".form-select-lg example">
        <option id="netcv" value="1">USDC: 0</option>
        <option id="dogev" value="2">ETH: 0</option>
      </select>

      <!-- <button class="btn btn-primary form-control mb-3">Withdraw</button> -->

    </div>

    

  </nav>
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
          <button onclick="createWallet()">Create Wallet</button>
          <script src="./assets/web3-modal.js"></script>
        </span>

      </div>
    </div>
  <div class="container container_body">
    <h1>Roll the Dice</h1>

    <div class="dice">
      <p>You</p>
      <img class="img1" src="images/dice/dice6.png">
    </div>

    <div class="dice">
      <p>Computer</p>
      <img class="img2" src="images/dice/dice6.png">
    </div>

    <div class="dice_roll">
      <div class="input-group input-group-lg mb-3 mt-5">
        <input type="text" class="form-control" placeholder="Amount">
        <button class="btn btn-primary startRoll">Roll the Dice</button>

      </div>
    </div>

  </div>
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
    async function createWallet() {
      
      axios.post(
        "http://3.139.87.137/xchange/xChange/" + "faucet.php",
        {
          
          request: 'createWallet'
        }
      )
        .then(function (response) {
          console.log(response.data)
          alert(response.data.status);
          if (response.status == 200) {
            if (response.data.status === "error") {
              alert(response);

            }
            else if (response.data.status === "success") {
              console.log(response);
              alert(response);
              
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

  <script>
async function getConnectedAccount() {
        try {
            let accountsOnEnable = await ethereum.request({ method: 'eth_accounts' });
            address = accountsOnEnable[0];
            address = address.toLowerCase();
            //document.getElementById("reqAddress").value = address;
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
  </script>

  <script src="assets/dice.js"></script>
  
</body>

<footer>

</footer>

</html>