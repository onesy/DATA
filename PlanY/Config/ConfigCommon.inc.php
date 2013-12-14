<?php
return array(

    'framework_file_necessary' => array(
        'DATACodeDefine.class.php', 
        'DATAFramework.class.php', 
        'DATAFrameworkLoader.class.php',
    ),
    'framework_file_optional' => array(

    ),

    /**
     * class_name => /xxx/xxxx/xxx/file.class.php
     */
    'force_load' => array(
        'ExampleException' => realpath(ROOT . DIRECTORY_SEPARATOR . 'Commons' . DIRECTORY_SEPARATOR . 'SexyBitch' . DIRECTORY_SEPARATOR . 'ExampleException.class.php'),
    ),
    'project_dir_paths' => array(
        'Controller' => PROJECT_ROOT . DIRECTORY_SEPARATOR . 'Controller',
        'Collection' => ROOT . DIRECTORY_SEPARATOR . 'Commons' . DIRECTORY_SEPARATOR . 'Collection',
        'Model' => ROOT . DIRECTORY_SEPARATOR . 'Commons' . DIRECTORY_SEPARATOR . 'Model',
        'Module' => ROOT . DIRECTORY_SEPARATOR . 'Commons' . DIRECTORY_SEPARATOR . 'Module',
        'Beans' => ROOT . DIRECTORY_SEPARATOR . 'Commons' . DIRECTORY_SEPARATOR . 'Beans',
    ),
    'file_suffix_rule' => array(
        'Controller' => array('.class.php'),
        'Collection' => array('.class.php'),
        'Model' => array('.class.php'),
        'Module' => array('.class.php'),
        'Beans' => array('.class.php'),
    ),
);