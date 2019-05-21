<?php

class pay extends controller {
    
    function __construct()
    {
        parent::__construct();
    }
    
    function validationRequest() {
        $this->model->validate();
    }
    
    function PaymentUpdateRequest() {
        $this->model->paymentUpdate();
    }
    
    function TransactionRequery_TransRef() {
        $this->model->Requery();
    }
    
    function testHash() {
        $h = hash::create("sha512", "5cd14c2c3c3cb"."OSEB883666"."2349119224567"."arinze@sqtwebsolutions.com", HASH_GENERAL_KEY);
        echo json_encode(array('hash' => $h));
    }
    
    function testHash2() {
        $h = hash::create("sha512", "5cd14c2c3c3cb"."12345678"."1206"."566", HASH_GENERAL_KEY);
        echo json_encode(array('hash' => $h));
    }
    
    function testHash3() {
        $h = hash::create("sha512", "12345678", HASH_GENERAL_KEY);
        echo json_encode(array('hash' => $h));
    }
}