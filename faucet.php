<?php

session_start();

/**
 *  web3p library & utils
 * 
 * */

require('./base.php');
require('./utils.php');
require_once 'conn.php';
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

require_once "./lib/Keccak/Keccak.php";
require_once "./lib/Elliptic/EC.php";
require_once "./lib/Elliptic/Curves.php";
require_once "./lib/JWT/jwt_helper.php";

$GLOBALS['JWT_secret'] = '4Eac8AS2cw84easd65araADX';

use Elliptic\EC;
use kornrunner\Keccak;

// ================ Help functions ===================== //
// Check if the message was signed with the same private key to which the public address 
function pubKeyToAddress($pubkey)
{
    return "0x" . substr(Keccak::hash(substr(hex2bin($pubkey->encode("hex")), 1), 256), 24);
}

function verifySignature($message, $signature, $address)
{
    $msglen = strlen($message);
    $hash = Keccak::hash("\x19Ethereum Signed Message:\n{$msglen}{$message}", 256);
    $sign = [
        "r" => substr($signature, 2, 64),
        "s" => substr($signature, 66, 64)
    ];
    $recid = ord(hex2bin(substr($signature, 130, 2))) - 27;
    if ($recid != ($recid & 1))
        return false;

    $ec = new EC('secp256k1');
    $pubkey = $ec->recoverPubKey($hash, $sign, $recid);

    return $address == pubKeyToAddress($pubkey);
}

function msgBuilder($state, $message)
{
    return json_encode(array('status' => $state, 'msg' => $message));
}
// ================== Helper end ========================== //
$data = json_decode(file_get_contents("php://input"));
$request = $data->request;

if ($request == "donate") {
    $privateKey = $data->privateKey;
    $address = new Address($privateKey);
    $fromAddress = '0x' . $address->get();

    $faucetAccount = $faucetWalletAddress;

    $fromAddressBalance = getBalance($eth, $fromAddress); // DogeBalance in dogenet, Ethbalance in eth, etc...

    $contract = new Contract($web3->provider, $erc20AbiJson);

    $contract = $contract->at($tokenContractAddress);

    $contract->call('balanceOf', $fromAddress, function ($err, $result) use ($decimals, &$fromAddressBalance) {
        if ($err !== null) {
            throw $err;
        }
        if ($result) {
            $fromAddressBalance = $result[0]; // NETC balance
        }
    });

    $bigDecimals = Utils::toBn(pow(10, (int) $decimals));

    $donateLimitBalance = Utils::toBn(1)->multiply($bigDecimals); // donate 1 NETC

    if ($fromAddressBalance->compare($donateLimitBalance) < 0) {
        echo json_encode(array('status' => 'error', 'msg' => 'User has less than 1 NETC'));
        exit;
    }
    ;

    // send 1 NETC from user wallet(private key) to faucet

    $estimatedGas = '0x200b20';

    $donateAmountBn = Utils::toBn(1)->multiply($bigDecimals)->toString();

    $contract->at($tokenContractAddress)->estimateGas('transfer', $faucetAccount, $donateAmountBn, [
        'from' => $fromAddress,
    ], function ($err, $result) use (&$estimatedGas) {
        if ($err !== null) {
            throw $err;
        }
        $estimatedGas = '0x' . $result->toHex();
    });

    $data = $contract->getData('transfer', $faucetAccount, $donateAmountBn);
    $nonce = getNonce($eth, $fromAddress);

    $transaction = new Transaction([
        'nonce' => '0x' . $nonce->toHex(),
        'to' => $tokenContractAddress,
        'gas' => $estimatedGas,
        'gasPrice' => '0x' . Utils::toWei('50', 'gwei')->toHex(),
        'data' => '0x' . $data,
        'chainId' => $chainId
    ]);
    $transaction->sign($privateKey);

    $txHash = '';
    $eth->sendRawTransaction('0x' . $transaction->serialize(), function ($err, $transaction) use (&$txHash) {
        if ($err !== null) {
            echo 'Error: ' . $err->getMessage();
            exit;
        }
        // echo 'Tx hash: ' . $transaction . PHP_EOL;
        $txHash = $transaction;
    });

    $transaction = confirmTx($eth, $txHash);
    if (!$transaction) {
        throw new Error('Transaction was not confirmed.');
    }

    echo json_encode(array('status' => 'success', 'msg' => 'Thank you for your donation', 'txHash' => $txHash));

    exit;
}


// Create a standard of eth address by lowercasing them
// Some wallets send address with upper and lower case characters
$reqAddress = "";

if (!empty($data->reqAddress)) {
    $reqAddress = strtolower($data->reqAddress);
}
if ($reqAddress == "" and $request != "createWallet") {
    echo json_encode(array('status' => 'error', 'msg' => 'Please enter your address!'));
    exit;
}
// validate if reqAddress is an ethereum address
$validator = new EthereumValidator();
if ($validator->isAddress($reqAddress) === false  and $request != "createWallet") {
    echo json_encode(array('status' => 'error', 'msg' => 'Address is not valid. Please check it again!'));
    exit;
}


if ($request == "requestMessage") {
    if (!isset($_SESSION[$reqAddress]['nonce'])) {
        $nonce = uniqid();
        $_SESSION[$reqAddress]['nonce'] = $nonce;
        echo msgBuilder("signRequest", "Sign this message to validate that you are the owner of the account. Random string: " . $nonce);
        exit;
    } else {
        $nonce = $_SESSION[$reqAddress]['nonce'];
        echo msgBuilder("signRequest", "Sign this message to validate that you are the owner of the account. Random string: " . $nonce);
        exit;
    }
}

if ($request == "auth") {
    $nonce = $_SESSION[$reqAddress]['nonce'];
    $signature = $data->signature;
    $message = "Sign this message to validate that you are the owner of the account. Random string: " . $nonce;
    // If verification passed, authenticate user
    if (verifySignature($message, $signature, $reqAddress)) {
        // Create a new random nonce for the next login
        $nonce = uniqid();
        $_SESSION[$reqAddress]['nonce'] = $nonce;

        // Create JWT Token
        $token = array();
        $token['address'] = $reqAddress;
        $JWT = JWT::encode($token, $GLOBALS['JWT_secret']);
        echo msgBuilder("success", $JWT);
    } else {
        echo msgBuilder("failed", "You are not the owner of the account");
    }

    exit;
}

if ($request == "requestToken") {

    try {
        $JWT = JWT::decode($data->JWT, $GLOBALS['JWT_secret']);
    } catch (\Exception $e) {
        echo msgBuilder('error', 'Authentication error');
        exit;
    }

    if ($JWT->address !== $reqAddress) {
        echo msgBuilder('error', 'Authentication error');
        exit;
    }

    $faucetAccount = $faucetWalletAddress;
    $faucetBalance = getBalance($eth, $faucetAccount);
    $reqAddressBalance = getBalance($eth, $reqAddress);

    $contract = new Contract($web3->provider, $erc20AbiJson);

    $contract = $contract->at($tokenContractAddress);

    $contract->call('balanceOf', $faucetAccount, function ($err, $result) use ($decimals, &$faucetBalance) {
        if ($err !== null) {
            throw $err;
        }
        if ($result) {
            $faucetBalance = $result[0];
        }
    });

    $contract->call('balanceOf', $reqAddress, function ($err, $result) use ($decimals, &$reqAddressBalance) {
        if ($err !== null) {
            throw $err;
        }
        if ($result) {
            $reqAddressBalance = $result[0];
        }
    });

    $bigDecimals = Utils::toBn(pow(10, (int) $decimals));
    $maxBalance = Utils::toBn(MAX_BALANCE)->multiply($bigDecimals);

    if ($reqAddressBalance->compare($maxBalance) >= 0) {
        echo json_encode(array('status' => 'error', 'msg' => 'User is greedy - already has too much NETC'));
        exit;
    }
    ;

    // send specific amount of NETC to request account

    $estimatedGas = '0x200b20';

    $faucetAmountBn = Utils::toBn($faucetAmount)->multiply($bigDecimals)->toString();

    $contract->at($tokenContractAddress)->estimateGas('transfer', $reqAddress, $faucetAmountBn, [
        'from' => $faucetAccount,
    ], function ($err, $result) use (&$estimatedGas) {
        if ($err !== null) {
            throw $err;
        }
        $estimatedGas = '0x' . $result->toHex();
    });

    $data = $contract->getData('transfer', $reqAddress, $faucetAmountBn);
    $nonce = getNonce($eth, $faucetAccount);

    $transaction = new Transaction([
        'nonce' => '0x' . $nonce->toHex(),
        'to' => $tokenContractAddress,
        'gas' => $estimatedGas,
        'gasPrice' => '0x' . Utils::toWei('50', 'gwei')->toHex(),
        'data' => '0x' . $data,
        'chainId' => $chainId
    ]);
    $transaction->sign($faucetWalletPrivateKey);

    $txHash = '';
    $eth->sendRawTransaction('0x' . $transaction->serialize(), function ($err, $transaction) use ($eth, $reqAddress, $faucetAccount, &$txHash) {
        if ($err !== null) {
            echo 'Error: ' . $err->getMessage();
            exit;
        }
        // echo 'Tx hash: ' . $transaction . PHP_EOL;
        $txHash = $transaction;
    });

    $transaction = confirmTx($eth, $txHash);
    if (!$transaction) {
        throw new Error('Transaction was not confirmed.');
    }

    echo json_encode(array('status' => 'success', 'msg' => 'Transaction has been confirmed', 'txHash' => $txHash));
}

if ($request == "requestBalance") {



    $faucetAccount = $faucetWalletAddress;
    //$faucetBalance = getBalance($eth, $faucetAccount);
    //$reqAddressBalance = getBalance($eth, $reqAddress);
    $balance_eth = '0';

    $balance_neo = '0';

    $query = "SELECT mem_id FROM wallet WHERE address = :reqAddress";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':reqAddress', $reqAddress);
    $stmt->execute();
    $row = $stmt->fetchAll();

    //$query = "SELECT mem_id FROM wallet WHERE address = :reqAddress";
    //$stmt = $conn->prepare($query);
    //$stmt->bindParam(':reqAddress', $reqAddress);
    //$stmt->execute();
    //$row = $stmt->fetch();



    if (count($row) > 0) {

        $mem_id = $row[0]['mem_id'];

        $query2 = "SELECT mem_id, username, firstname FROM `member` WHERE `mem_id` = :mem_id";
        $stmt2 = $conn->prepare($query2);
        $stmt2->bindParam(':mem_id', $mem_id);
        $stmt2->execute();
        $row2 = $stmt2->fetch();
        $username_ = $row2['username'];
        $_SESSION['username'] = $username_;
        $balance_ = 0;
        $query3 = "SELECT trans_id, coin, transaction_hash, amount, trans_type FROM `transactions` WHERE `mem_id` = :mem_id";
        $stmt3 = $conn->prepare($query3);
        $stmt3->bindParam(':mem_id', $mem_id);
        $stmt3->execute();
        $row3 = $stmt3->fetch();

        foreach ($row3 as $tx) {

            $balance_ = $balance_ + floatval($tx['amount']);


        }

        $_SESSION['balance'] = $balance_;




    } else {
        //$query3 = "INSERT INTO `member` (username, password, firstname, lastname) VALUES(:username, :password, :firstname, :lastname)";
        //$stmt3 = $conn->prepare($query3);
        //$stmt3->bindParam(':username', $reqAddress);
        //$stmt3->bindParam(':password', $reqAddress);
        //$stmt3->bindParam(':firstname', $reqAddress);
        //$stmt3->bindParam(':lastname', $reqAddress);

        $qry = $conn->prepare(
            'INSERT INTO member (username, password, firstname, lastname,walletid) VALUES (?, ?, ?, ?, ?)'
        );
        $qry->execute(array($reqAddress, $reqAddress, $reqAddress, $reqAddress, 'as'));


        var_dump($reqAddress);
        $new_mem_id = $conn->lastInsertId();
        $address = new Address();
        // get address
        //$pub_address = $address->get();
        //$private_key = $address->getPrivateKey();

        $query_wallet = "INSERT INTO `wallet` (mem_id, address, private_key) VALUES(:mem_id, :address, :private_key)";
        $stmt_wallet = $conn->prepare($query_wallet);
        $stmt_wallet->bindParam(':mem_id', $new_mem_id);
        $stmt_wallet->bindParam(':address', $reqAddress);
        $stmt_wallet->bindParam(':private_key', $reqAddress);

        if ($stmt_wallet->execute()) {
            //setting a 'success' session to save our insertion success message.
            $_SESSION['success'] = "Successfully created an account";

            $mem_id = $row[0]['mem_id'];

            $query2 = "SELECT mem_id, username, firstname FROM `member` WHERE `mem_id` = :mem_id";
            $stmt2 = $conn->prepare($query2);
            $stmt2->bindParam(':mem_id', $new_mem_id);
            $stmt2->execute();
            $row2 = $stmt2->fetch();
            $username_ = $row2['username'];
            $_SESSION['username'] = $username_;

            //redirecting to the index.php 
            //header('location: index.php');	
            //return;
        }
    }

   

    $eth->getBalance($reqAddress, function ($err, $balance) use (&$balance_eth) {
        if ($err !== null) {
            echo 'Error: ' . $err->getMessage();
            return;
        }
        //echo 'Balance: ' . $balance . PHP_EOL;
        $balance_eth = intval($balance . PHP_EOL) / 1000000000000000000;

        //echo json_encode(array('status'=>'success', 'msg'=>'Transaction has been confirmed', 'balance'=> $balance_eth . PHP_EOL));
    });

    $contract = new Contract($web3->provider, $erc20AbiJson);

    $contract = $contract->at($tokenContractAddress);

    $contract->call('balanceOf', $reqAddress, function ($err, $result) use ($decimals, &$balance_neo) {
        if ($err !== null) {
            throw $err;
        }
        if ($result) {

            $balance_neo = intval($result[0]->toString()) / 1000000;
        }
    });

    echo json_encode(array('status' => 'success', 'msg' => 'Transaction has been confirmed' . $reqAddress, 'balanceneo' => $balance_neo, 'balance' => $balance_eth . PHP_EOL));

    //echo json_encode(array('status'=>'success', 'msg'=>'Transaction has been confirmed', 'balance'=> 0));

}

if ($request == "createWallet") {

    $password = "hodor";
    $account = $eth->personal_newAccount($password);

    $response = [
        'status' => 'success',
        'address' => $account,
    ];
    
    // Unlock the account to get the private key
    $unlockDuration = 300; // Replace with the duration you want to use (in seconds)
    $privateKey = $eth->personal_unlockAccount($account, $password, $unlockDuration);
    
    $response['privateKey'] = $privateKey;
    
    echo json_encode(array('status' => $account));

       
//echo json_encode($account);
    //echo json_encode(array('status' => 'success', 'msg' => 'Transaction has been confirmed' . $reqAddress, 'balanceneo' => $balance_neo, 'balance' => $balance_eth . PHP_EOL));

    

}