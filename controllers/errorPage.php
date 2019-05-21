<?php

class errorPage extends controller {
    
    function __construct() {
        parent::__construct();
    }
    
    function index()
    {
        http_response_code(403);
    }
}