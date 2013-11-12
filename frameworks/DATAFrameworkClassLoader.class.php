<?php

include_once 'DATACodeDefine.class.php';

class DATAFrameworkClassLoader {
    
    /**
     * 框架内部的文件.
     * 
     * @var type 
     */
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
    public static $default_file_suffix_rule = array('all' => array('class' => '.class.php', 'inc' => '.inc.php', 'tpl' => '.tpl.php'));
    
    public static $file_suffix_rule = array();
    
    public static $framework_file_necessary ;
    
    public static $framework_file_optional;
    
    public static $force_load;
    
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
    
    /**
     * 加载常规用户目录.
     * 
     * @param type $class_name
     */
    public static function DATAFileLoader($class_name) {
        $parts = explode('_', $class_name);
        $prefix = $parts[0];
        $file_real_paths = array();
        if (in_array($prefix, self::$load_path)) {
            /**
             * 处理路径分割符号.
             */
            if (! substr(self::$load_path[$prefix], 0, strlen(self::$load_path[$prefix]) - 1) == DIRECTORY_SEPARATOR ) {
                $file_path = self::$load_path[$prefix] . DIRECTORY_SEPARATOR;
            } else {
                $file_path = self::$load_path[$prefix];
            }
            /**
             * 处理默认后缀名.
             */
            self::$file_suffix_rule = isset(self::$file_suffix_rule) ? self::$file_suffix_rule : self::$default_file_suffix_rule;
            self::$file_suffix_rule[$prefix] = self::$file_suffix_rule['all'];
            foreach (self::$file_suffix_rule[$prefix] as $suffixBunch) {
                $file_real_path = realpath($file_path . $suffixBunch);
                if ($file_real_path != false) {
                    array_push($file_real_paths, $file_real_path);
                }
            }
            unset($file_real_path);
            foreach ($file_real_paths as $file_real_path) {
                include $file_real_path;
            }
        }
    }
    
    public static function DATAFrameworkAddFile($file) {
        if( !defined(FRAMEWORK_ROOT)) { 
            throw new FrameworkLoadFailedException('框架根目录常量\'FRAMEWORK_ROOT\'未定义.框架加载失败.', CodeDefine::FRAMEWORK_ROOT_UNDEFINED_ERROR);
        }
        /**
         * 处理后面的分割符号
         */
        if (! substr(FRAMEWORK_ROOT, 0, strlen(FRAMEWORK_ROOT) - 1) == DIRECTORY_SEPARATOR ) {
            $file_path = FRAMEWORK_ROOT . DIRECTORY_SEPARATOR . $file;
        } else {
            $file_path = FRAMEWORK_ROOT;
        }
        $file_path = realpath($file_path);
        if(! file_exists($file_path)) {
            throw new FrameworkLoadFailedException('需要加载的文件' . $file_path . '不存在，框架加载失败.请检查文件.', CodeDefine::FRAMEWORK_LOAD_FILE_ERROR);
        }
        try {
            require $file;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            throw new FrameworkLoadFailedException('需要加载的文件' . $file_path . '不存在，框架加载失败.请检查文件.', CodeDefine::FRAMEWORK_LOAD_FILE_ERROR);
        }
    }
    
    public static function DATAFrameworkLoad() {
        
        $files = self::$framework_file_necessary;
        foreach ($files as $file) {
            self::DATAFrameworkAddFile($file);
        }
    }
    
    public static function DATAFrameworkLoadOptional($class_name) {
        $optional_files = self::$framework_file_optional;
        if (in_array($class_name . '.class.php' , $optional_files)) {
            self::DATAFrameworkAddFile($class_name . '.class.php');
        }
    }
    
    public static function DATAForceLoad($class_name) {
        $files = self::$force_load;
        if (!empty($files[$class_name])) {
            try{
                require $files[$class_name];
            } catch (Exception $ex) {
                echo $ex->getTraceAsString();
                throw new FrameworkLoadFailedException('需要加载的文件' . $files[$class_name] . '不存在，加载失败.请检查文件.', CodeDefine::FORCE_LOAD_FILE_ERROR);
            }
        }
    }
    
    public static function Initialize($config) {
        self::$framework_file_necessary = $config['framework_file_necessary'];
        self::$framework_file_optional = $config['framework_file_optional'];
        self::$framework_file = array_merge(self::$framework_file_necessary, self::$framework_file_optional);
        self::$force_load = $config['force_load'];
        self::$file_suffix_rule = $config['project_dir_paths'];
        self::AddFileSuffix($config['file_suffix_rule']);
        self::AddLoadPath($config['project_dir_paths']);
    }
}