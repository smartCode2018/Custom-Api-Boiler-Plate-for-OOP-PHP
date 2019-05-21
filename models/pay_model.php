<?php

class pay_model extends model {
    
    function __construct()
    {
        parent::__construct();
    }
    
    

	protected function set()
	{
	    $data  = new stdClass();
		$input = file_get_contents("php://input");
		if(!empty($input)){
    		$input = json_decode($input);
    		foreach($input as $key => $value)
    		{
    			$data->$key = $value;
    		}
    		return $data;
		}
		return;
	}
	
	
    function validate() {
        $_data = $this->set();
        
        $error = "";
        if($_data->otherDetails->email == null)
        {
            $error .= ( (empty($error)) ? '' : ', ' ) .'Email required';
        }
        if($_data->otherDetails->phoneNumber == null) 
        {
            $error .= ( (empty($error)) ? '' : ', ' ) .'Phone Number required';
        }
        if($_data->otherDetails->userId == null)
        {
            $error .= ( (empty($error)) ? '' : ', ' ) .'User ID required';
        } else  {
            $sth = $this->db->prepare("SELECT * FROM users WHERE id = :id");
            $sth->execute(array(':id' => $_data->otherDetails->userId));
            if($sth->rowCount() > 0)
            {
                $user = $sth->fetch();
            } else {
                $error .= ( (empty($error)) ? '' : ', ' ) .'User not found!';
            }
            
        }
        
        if($_data->referenceID == null)
        {
            $error .= ( (empty($error)) ? '' : ', ' ) .'Reference ID required!';
        } else {
            $sth = $this->db->prepare("SELECT * FROM orders WHERE orderid = :orderid");
            $sth->execute(array(':orderid' => $_data->referenceID));
            if($sth->rowCount() > 0)
            {
                $order = $sth->fetch();
                if($_data->otherDetails->userId != null && $order['id'] != $_data->otherDetails->userId)
                {
                    $error .= ( (empty($error)) ? '' : ', ' ) .'Transactions does not belong to user';
                }
            } else {
                $error .= ( (empty($error)) ? '' : ', ' ) .'Transaction not found';
            }
        }
        
        $hashed =  hash::create("sha512", $_data->referenceID.$_data->otherDetails->userId.$_data->otherDetails->phoneNumber.$_data->otherDetails->email, HASH_GENERAL_KEY); 
        
        if($hashed != $_data->hash)
        {
            $error .= ( (empty($error)) ? '' : ', ' ) .'Invalid Hash';
        }
        
        if(empty($error))
        {
            $data = array();
            $data['referenceID'] = $_data->referenceID;
            $data['CustomerName'] = $_data->otherDetails->userId;
            $data['totalAmount'] = $order['payable'];
            $data['Currency'] = '566';
            $data['statusCode'] = '00';
            $data['statusMessage'] = 'Validation Successful!';
            $data['hash']  =  hash::create("sha512", $data['referenceID'].$data['CustomerName'].$data['totalAmount'].$data['Currency'].$data['statusCode'].$data['statusMessage'], HASH_GENERAL_KEY); 
            
        } else {
            $data= array();
            $data['statusCode'] = '01';
            $data['message'] = $error;
        }
        echo json_encode($data);
    }
    
	
    function paymentUpdate() {
        $_data = $this->set();
        $error = "";
        if($_data->transReference == null)
        {
            $error .= ( (empty($error)) ? '' : ', ' ) .'Transaction Reference required!';
        }
        if($_data->totalAmount == null)
        {
            $error .= ( (empty($error)) ? '' : ', ' ) .'Total Amount Required required!';
        }
        if($_data->referenceID == null)
        {
            $error .= ( (empty($error)) ? '' : ', ' ) .'Reference ID required!';
        } else {
            $sth = $this->db->prepare("SELECT * FROM orders WHERE orderid = :orderid");
            $sth->execute(array(':orderid' => $_data->referenceID));
            if($sth->rowCount() > 0)
            {
                $order = $sth->fetch();
                if($order['payable'] != $_data->totalAmount)
                {
                    $error .= ( (empty($error)) ? '' : ', ' ) ."Wrong amount paid!";
                }
            } else {
                $error .= ( (empty($error)) ? '' : ', ' ) .'Transaction not found';
            }
        }
        if($_data->Currency != '566')
        {
            $error .= ( (empty($error)) ? '' : ', ' ) .'Invalid Currency!';
        }
        
        
        
        $hashed =  hash::create("sha512", $_data->referenceID.$_data->transReference.$_data->totalAmount.$_data->Currency, HASH_GENERAL_KEY);
        
        if($hashed != $_data->hash)
        {
            $error .= ( (empty($error)) ? '' : ', ' ) .'Invalid Hash';
        }
        
        if(empty($error))
        {
            $update = array('status' => 1, 'transReference' => $_data->transReference);
            $this->db->update('orders', $update, "orderid = '{$_data->referenceID}'");
            $data = array();
            $data['referenceID'] = $_data->referenceID;
            $data['transReference'] = $_data->transReference;
            $data['PaymentReference'] = hash::create('sha256', $_data->referenceID.$_data->transReference, HASH_GENERAL_KEY);
            $data['responseCode'] = '00';
            $data['responseDesc'] = 'Payment Updated Successful!';
            $data['hash']  =  hash::create("sha512", $data['referenceID'].$data['transReference'].$data['PaymentReference'].$data['responseCode'].$data['responseDesc'], HASH_GENERAL_KEY); 
            
        } else {
            $data= array();
            $data['statusCode'] = '01';
            $data['responseDesc'] = $error;
        }
        echo json_encode($data);
    }
    
     function Requery(){
        $_data = $this->set();

        $error = "";
        
        if($_data->transReference == null)
        {
            $error .= ( (empty($error)) ? '' : ', ' ) .'Transaction Reference ID is required';
        }

        $hashed =  hash::create("sha512", $_data->transReference, HASH_GENERAL_KEY);
        
        if($hashed != $_data->hash)
        {
            $error .= ( (empty($error)) ? '' : ', ' ) .'Invalid Hash';
        }else{
            $sth = $this->db->prepare("SELECT * FROM orders WHERE transReference = :transReference");
            $sth->execute(array(':transReference' => $_data->transReference));
            if($sth->rowCount() > 0)
            {
                $status = $sth->rowCount() == 1 ? '00' : '000';

                $order = $sth->fetch();

            } else {
                $error .= ( (empty($error)) ? '' : ', ' ) .'Transaction not found';
            }
        }

        if(empty($error))
        {
            $data = array();
            $data['responseCode'] = $status;
            $data['responseDesc'] = 'Transaction details has been found';
            $data['transReference'] = $_data->transReference;
            $data['transDate'] = $order['date'];
            $data['transTime'] = 'null';
            $data['amount'] = $order['payable'];
            $data['transStatus'] = $order['status'] == 1 ? 'Transaction completed' : 'Transaction is pending';

            $cid = $order['id'];
            $supid = $order['sid'];
            $ostatus = $order['status'];

            $sth = $this->db->prepare("SELECT * FROM users WHERE id = :id");
            $sth->execute(array(':id' => $cid));
            $order = $sth->fetch();

            $data['customerName'] = $order['first_name'].' '.$order['orther_name'];


            $sth = $this->db->prepare("SELECT * FROM suppliers WHERE id = :id");
            $sth->execute(array(':id' => $supid));
            $order = $sth->fetch();

            $data['merchantName '] = $order['name'];

            $data['transMessage'] = $ostatus == 1 ? 'This transaction has been completed' : 'Transaction is still pending';

           $data['hash']  =  hash::create("sha512", $data['responseCode'].$data['responseDesc'].$data['transReference'].$data['transDate'].$data['transTime'].$data['amount'].$data['transStatus'].$data['customerName'].$data['merchantName'].$data['transMessage'], HASH_GENERAL_KEY); 
            
        } else {
            $data= array();
            $data['statusCode'] = '01';
            $data['responseDesc'] = $error;
        }

        echo json_encode($data);
    }
}
