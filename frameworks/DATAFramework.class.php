<?php

include 'DATACodeDefine.class.php';

class DATAFramework {
    
    public static $framework_file = array();
    
    /**
     * 文件载入路径.载入用户路径
     * 
     * @var type 
     */
    public static $load_path = array();
    
    /**
     * 描述不同路径下的文件suffix规则.如果下面存在多种
     * 
     * @var type 
     */
    // public static $file_suffix_rule = array('all' => array('class' => '.class.php', 'inc' => '.inc.php', 'tpl' => '.tpl.php'));
    public static $file_suffix_rule = array();
    /**
     * 路径后不需要添加路径分割符号.
     * 
     * @param type $path
     */
    public static function AddLoadPath(array $paths) {
        foreach ($paths as $key => $path) {
            self::$load_path[$key] = $path;
        }
    }
    
    /**
     * 增加文件夹里的后缀名.
     * 
     * @param array $suffixs
     */
    public static function AddFileSuffix(array $suffixs) {
        foreach ($suffixs as $pathKey => $suffixBunch) {
            self::$file_suffix_rule[$pathKey] = $suffixBunch;
        }
    }
    
    public static function DATAFileLoader($class_name) {
        
    }
    
    public static function DATAFrameworkAddFile($file) {
        $file_path;
        if( !defined(FRAMEWORK_ROOT)) { 
            throw new FrameworkLoadFailedException('框架根目录常量\'FRAMEWORK_ROOT\'未定义.框架加载失败.');
        }
        /**
         * 处理后面的分割符号
         */
        if (! substr(FRAMEWORK_ROOT,0,strlen(FRAMEWORK_ROOT)-1) == DIRECTORY_SEPARATOR ) {
            $file_path = FRAMEWORK_ROOT . DIRECTORY_SEPARATOR . $file;
        } else {
            $file_path = FRAMEWORK_ROOT;
        }
        $file_path = realpath($file_path);
        if(! file_exists($file_path)) {
            throw new FrameworkLoadFailedException('需要加载的文件' . $file_path . '不存在，框架加载失败.请检查文件.');
        }
        try {
            include $file;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            exit(CodeDefine::FRAMEWORK_LOAD_FILE_ERROR);
        }
    }
    
    public static function DATAFrameworkLoad() {
        global $FRAMEWORK_CONFIG;
        $files = $FRAMEWORK_CONFIG['framework_file_necessary'];
        foreach ($files as $file) {
            self::DATAFrameworkAddFile($files);
        }
    }
}