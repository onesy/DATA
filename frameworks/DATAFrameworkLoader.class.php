<?php

include 'DATAFramework.class.php';

function DATAFrameworkLoader() {
    
}

function DATAautoload($class_name){
    DATAFramework::DATAFileLoader($class_name);
}
spl_autoload_register("DATAautoload");