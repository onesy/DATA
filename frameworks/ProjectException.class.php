<?php

class ProjectException extends Exception {
    
}

class ArgumentsException extends ProjectException {
    
}

class FrameworkLoadFailedException extends ProjectException {
    
}

class UserDefinedException extends ProjectException {
    
}

/**
 * 数据库人工异常继承这
 */
class DATADbException extends ProjectException {
    
}

class DBLogicException extends DATADbException {
    
}

/**
 * 配置异常继承这个Exception.
 */
class ConfigException extends ProjectException {
    
}

class CfgFileGoneAwayException extends ConfigException {
    
}

class CfgItemsNotFoundException extends ConfigException {
    
}

class ImplementedException extends ProjectException {
    
}