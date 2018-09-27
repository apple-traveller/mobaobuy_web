<?php
/**
 * @copyright Created by SuChuang
 * @author User: Spark Chen
 * @date: 2018/3/7
 * @time: 10:02
 */

namespace App\Helpers;


class BaseUpload {
    private $path = "./uploads";          //上传文件保存的路径
    private $allowtype = array('jpg','gif','png'); //设置限制上传文件的类型
    private $maxsize = 10*1024*1024;           //限制文件上传大小（字节）默认10 Mb
    private $israndname = true;           //设置是否随机重命名文件， false不随机

    private $originName;              //源文件名
    private $tmpFileName;              //临时文件名
    private $fileType;               //文件类型(文件后缀)
    private $fileSize;               //文件大小
    private $newFileName;              //新文件名
    private $errorNum = 0;             //错误号
    private $errorMess="";             //错误报告消息


    /**
     * BaseUpload constructor.
     * @param null $file_path 指定上传路径名，不指定则使用默认
     */
    public function __construct($file_path=null)
    {
        if ($file_path) $this->path = $file_path;
    }

    /**
     * 用于设置成员属性（$path, $allowtype,$maxsize, $israndname）
     * 可以通过连贯操作一次设置多个属性值
     *@param  string $key  成员属性名(不区分大小写)
     *@param  mixed  $val  为成员属性设置的值
     *@return  object     返回自己对象$this，可以用于连贯操作
     */
    function set($key, $val){
        $key = strtolower($key);
        if( array_key_exists( $key, get_class_vars(get_class($this) ) ) ){
            $this->setOption($key, $val);
        }
        return $this;
    }

    /**
     * 调用该方法上传文件
     * @param  string $fileField  上传表单字段名称
     * @return array|bool
     */

    function upload($fileField) {
        $return = true;
        /* 检查文件路径是否合法 */
        if( !$this->checkFilePath() ) {
            $this->errorMess = $this->getError();
            return false;
        }
        /* 将文件上传的信息取出赋给变量 */
        $name = $_FILES[$fileField]['name']; //上传文件的文件名
        $tmp_name = $_FILES[$fileField]['tmp_name']; //服务器端临时文件存放路径
        $size = $_FILES[$fileField]['size']; //上传文件的大小 879394   858 KB (879394 字节)
        $error = $_FILES[$fileField]['error']; //错误信息 0

        /* 如果是多个文件上传则$file["name"]会是一个数组 */
        if(is_array($name)){
            $errors=array();
            /*多个文件上传则循环处理 ， 这个循环只有检查上传文件的作用，并没有真正上传 */
            for($i = 0; $i < count($name); $i++){
                /*设置文件信息 */
                if($this->setFiles($name[$i],$tmp_name[$i],$size[$i],$error[$i] )) {
                    if(!$this->checkFileSize() || !$this->checkFileType()){
                        $errors[] = $this->getError();
                        $return=false;
                    }
                }else{
                    $errors[] = $this->getError();
                    $return=false;
                }
                /* 如果有问题，则重新初使化属性 */
                if(!$return)
                    $this->setFiles();
            }
            /* 存放所有上传后文件名的变量数组 */
            $fileNames = array();
            $originNames = array();

            if($return){
                /* 如果上传的多个文件都是合法的，则通过循环向服务器上传文件 */
                for($i = 0; $i < count($name); $i++){
                    if($this->setFiles($name[$i], $tmp_name[$i], $size[$i], $error[$i] )) {
                        $this->setNewFileName();
                        if(!$this->copyFile()){
                            $errors[] = $this->getError();
                            $return = false;
                        }
                        $fileNames[] = $this->fullPathName();
                        $originNames[] = $this->originName;
                    }
                }
            }
            if ($return) {
                $data = [
                    'code' => true,
                    'fileNames' => $fileNames,
                    'originNames' => $originNames
                ];
            }else{
                $data = [
                    'code' => false,
                    'msg' => $errors
                ];
            }
            return $data;
            /*上传单个文件处理方法*/
        } else {
            /* 设置文件信息 */
            if($this->setFiles($name,$tmp_name,$size,$error)) {
                /* 上传之前先检查一下大小和类型 */
                if($this->checkFileSize() && $this->checkFileType()){
                    /* 为上传文件设置新文件名 */
                    $this->setNewFileName();
                    /* 上传文件  返回0为成功， 小于0都为错误 */
                    if(!$this->copyFile()){
                        $return=false;
                    }
                }else{
                    $return=false;
                }
            } else {
                $return=false;
            }
            //出错返回提示，正确返回路径
            if ($return) {
                $data = [
                    'code' => true,
                    'fileName' => $this->fullPathName(),
                    'originName' => $this->originName
                ];
            }else{
                $data = [
                    'code' => false,
                    'msg' => $this->getError()
                ];
            }
            return $data;
        }
    }

    /**
     * 获取上传后的文件名称
     * @param  void
     * @return string 上传后，新文件的名称， 如果是多文件上传返回数组
     */
    public function getFileName(){
        return $this->newFileName;
    }

    /**
     * 上传失败后，调用该方法则返回，上传出错信息
     * @param  void
     * @return string  返回上传文件出错的信息报告，如果是多文件上传返回数组
     */
    public function getErrorMsg(){
        return $this->errorMess;
    }

    /**
     * 设置上传出错信息
     * @return string
     */
    private function getError() {
        $str = "上传文件{$this->originName}时出错 : ";
        switch ($this->errorNum) {
            case 4: $str .= "没有文件被上传"; break;
            case 3: $str .= "文件只有部分被上传"; break;
            case 2: $str .= "上传文件的大小超过了HTML表单中MAX_FILE_SIZE选项指定的值"; break;
            case 1: $str .= "上传的文件超过了php.ini中upload_max_filesize选项限制的值"; break;
            case -1: $str .= "未允许类型"; break;
            case -2: $str .= "文件过大,上传的文件不能超过{$this->maxsize}个字节"; break;
            case -3: $str .= "上传失败"; break;
            case -4: $str .= "建立存放上传文件目录失败，请重新指定上传目录"; break;
            case -5: $str .= "必须指定上传文件的路径"; break;
            default: $str .= "未知错误";
        }
        return $str;
    }

    /**
     * 设置和$_FILES有关的内容
     * @param string $name
     * @param string $tmp_name
     * @param int $size
     * @param int $error
     * @return bool
     */
    private function setFiles($name="", $tmp_name="", $size=0, $error=0) {
        $this->setOption('errorNum', $error);
        if($error)
            return false;
        $this->setOption('originName', $name);
        $this->setOption('tmpFileName',$tmp_name);
        $aryStr = explode(".", $name);
        $this->setOption('fileType', strtolower($aryStr[count($aryStr)-1]));
        $this->setOption('fileSize', $size);
        return true;
    }

    /**
     * 为单个成员属性设置值
     * @param $key
     * @param $val
     */
    private function setOption($key, $val) {
        $this->$key = $val;
    }

    /**
     * 设置上传后的文件名称
     */
    private function setNewFileName() {
        if ($this->israndname) {
            $this->setOption('newFileName', $this->proRandName());
            return $this->proRandName();
        } else{
            $this->setOption('newFileName', $this->originName);
            return $this->originName;
        }
    }

    /**
     * 检查上传的文件是否是合法的类型
     * @return bool
     */
    private function checkFileType() {
        if (in_array(strtolower($this->fileType), $this->allowtype)) {
            return true;
        }else {
            $this->setOption('errorNum', -1);
            return false;
        }
    }

    /**
     * 检查上传的文件是否是允许的大小
     * @return bool
     */
    private function checkFileSize() {
        if ($this->fileSize > $this->maxsize) {
            $this->setOption('errorNum', -2);
            return false;
        }else{
            return true;
        }
    }

    /**
     * 检查是否有存放上传文件的目录
     * @return bool
     */
    private function checkFilePath() {
        if(empty($this->path)){
            $this->setOption('errorNum', -5);
            return false;
        }
        if (!file_exists($this->path) || !is_writable($this->path)) {
            if (!@mkdir($this->path, 0755)) {
                $this->setOption('errorNum', -4);
                return false;
            }
        }
        return true;
    }

    /**
     * 设置随机文件名
     * @return string
     */
    private function proRandName() {
        $fileName = date('YmdHis')."_".rand(1000,9999);
        return $fileName.'.'.$this->fileType;
    }

    /**
     * 获取完整文件路径
     */
    private function fullPathName()
    {
        return $this->path . '/' . $this->newFileName;
    }

    /**
     * 复制上传文件到指定的位置
     * @return bool
     */
    private function copyFile() {
        if(!$this->errorNum) {
            $path = rtrim($this->path, '/').'/';
            $path .= $this->newFileName;
            if (@move_uploaded_file($this->tmpFileName, $path)) {
                return true;
            }else{
                $this->setOption('errorNum', -3);
                return false;
            }
        } else {
            return false;
        }
    }
}