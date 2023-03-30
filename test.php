<?php
use phpseclib\Math\BigInteger;
require('./base.php');
require('./utils.php');

use Web3\Utils;
use Web3\Contract;
use Web3p\EthereumTx\Transaction;
use Web3p\EthereumTx\EIP1559Transaction;
use kornrunner\Ethereum\Address;

/** 
 * 
 *  Login & encrypt and decrypt message
 *  library
 * 
 * */
session_start();

/**
 *  web3p library & utils
 * 
 * */



require_once "./lib/Keccak/Keccak.php";
require_once "./lib/Elliptic/EC.php";
require_once "./lib/Elliptic/Curves.php";
require_once "./lib/JWT/jwt_helper.php";

$GLOBALS['JWT_secret'] = '4Eac8AS2cw84easd65araADX';

use Elliptic\EC;
use kornrunner\Keccak;

$faucetAccount = $faucetWalletAddress;

$web3->clientVersion(function ($err, $version) {
    if ($err !== null) {
        // do something
        return;
    }
    if (isset($version)) {
        
        
    }
});

//$faucetBalance = getBalance($eth, $faucetAccount);



$balance_eth = '0';

    $balance_neo = '0';

    $eth->getBalance("0xd7b13d726bb2ad83e005861dc65a4697da78a267", function ($err, $balance) use (&$balance_eth){
        if ($err !== null) {
            echo 'Error: ' . $err->getMessage();
            return;
        }
        //echo 'Balance: ' . $balance . PHP_EOL;
        $balance_eth = intval($balance. PHP_EOL) / 1000000000000000000;
        
        //echo json_encode(array('status'=>'success', 'msg'=>'Transaction has been confirmed', 'balance'=> $balance_eth . PHP_EOL));
    });
//var_dump($balance_eth);
    //$reqAddressBalance = getBalance($eth, $reqAddress);
 //   $web3->getBalance('0x6028cf17865da40fbd1a65924d9a3a8efc0ad2ee', function ($err, $resp) {
 //       if ($err !== null) {
 //           throw new \Exception($err->getMessage());
 //       }
 //       echo $resp->toString();
    
 //   });

 $contract = new Contract($web3->provider, $erc20AbiJson);

    $contract = $contract->at($tokenContractAddress);

    $contract->call('balanceOf', "0xd7b13d726bb2ad83e005861dc65a4697da78a267", function ($err, $result) use (&$balance_neo) {
        if ($err !== null) {
            throw $err;
        }
        if ($result) {
            
            
            $balance_neo = $result[0]->toHex();
        }
    });
    $dir = dirname(__FILE__);

    require($dir . '/vendor/autoload.php');
    use Web3\Web3;
    use Web3\Providers\HttpProvider;
    use Web3\RequestManagers\HttpRequestManager;
    
    $web3 = new Web3(new HttpProvider(new HttpRequestManager('https://dogechain.info/api/v1/blockchain/')));
    
    $password = 'my-password'; // Replace with the password you want to use
    
    $eth = $web3->eth;
    $account = $eth->accounts->create($password);
    
    if (!$account) {
        // Error creating new account
        $response = [
            'status' => 'error',
            'message' => 'Unable to create new account',
        ];
    } else {
        // Account created successfully
        $response = [
            'status' => 'success',
            'address' => $account,
        ];
    
        // Unlock the account to get the private key
        $unlockDuration = 300; // Replace with the duration you want to use (in seconds)
        $privateKey = $eth->personal_unlockAccount($account, $password, $unlockDuration);
    
        if (!$privateKey) {
            // Error unlocking account
            $response['message'] = 'Unable to unlock account';
        } else {
            // Account unlocked successfully
            $response['privateKey'] = $privateKey;
        }
    }
    
    // Output the response
    echo json_encode($response);
?>