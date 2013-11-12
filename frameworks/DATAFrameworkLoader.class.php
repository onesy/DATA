<?php

include 'DATAFramework.class.php';

function DATAautoload($class_name){
    DATAFrameworkClassLoader::DATAFileLoader($class_name);
}
function DATAFrameworkOptinalFileLoad($class_name){
    DATAFrameworkClassLoader::DATAFrameworkLoadOptional($class_name);
}

function DATAForceLoad($class_name) {
    DATAFrameworkClassLoader::DATAForceLoad($class_name);
}
/**
 * 用户文件自动加载
 */
spl_autoload_register("DATAautoload");
/**
 * 框架可选文件自动加载
 */
spl_autoload_register("DATAFrameworkOptinalFileLoad");
/**
 * 强制文件自动加载
 */
spl_autoload_register("DATAForceLoad");