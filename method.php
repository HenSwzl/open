/<?php

class Method
{
    /**
     * 读取excel内容导出(需要PHPExcel.php)
     */
    function Cs()
    {
        $reader = PHPExcel_IOFactory::createReader('Excel2007'); //设置以Excel5格式(Excel97-2003工作簿)
        $PHPExcel = $reader->load("C:/Users/Administrator/Desktop/111.xlsx"); // 载入excel文件
        $num = $PHPExcel->getSheetCount();//取得sheet的总数量
        $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表  多个sheet需要再循环读取
        $row_num = $sheet->getHighestRow(); // 取得总行数
        $col_num = $sheet->getHighestColumn(); // 取得总列数
        //循环出跟表格一样的格式
        echo "<table style='border: 1px solid red'>";
        for ($row = 1; $row <= $row_num; $row++) {  //行数是以第1行开始
            echo "<tr style='border: 1px solid red'>";
            for ($column = 'A'; $column <= $col_num; $column++) {  //列数是以A列开始
                echo "<td style='border: 1px dashed gold'>".$sheet->getCell($column.$row)->getValue()."</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }

    /**
     * 生成二维码(需要phpqrcode.php)
     */
    function getQrCode()
    {
        $url = '';$filename = '';
        $value = $url;
        $errorCorrectionLevel = "L"; // 纠错级别：L、M、Q、H
        $matrixPointSize = "4"; // 点的大小：1到10
        $filename = 'C:\Users\Administrator\Desktop/'.$filename.'.png';
        QRcode::png($value, $filename, $errorCorrectionLevel, $matrixPointSize);
        $QR = $filename; //已经生成的原始二维码图片文件
        $QR = imagecreatefromstring(file_get_contents($QR));
        imagepng($QR, 'qrcode.png');
        imagedestroy($QR);
        echo $value;
    }
    
    //删除目录下的文件和目录（不包括本目录）
    function delDirAndFile( $dirName )
    {
        if ( $handle = opendir( $dirName) ) {
            while ( false !== ( $item = readdir( $handle ) ) ) {
                if ( $item != "." && $item != ".." ) {
                    if ( is_dir( "{$dirName}/{$item}" ) ) {
                        $this->delDirAndFile( "{$dirName}/{$item}" );
                    } else {
                        if( unlink( "{$dirName}/{$item}" ) )echo "成功删除文件： {$dirName}/{$item}\n";
                }
            }
        }
        closedir( $handle );
        }
    }
    
    // 去0
    function del0($s)
    {
        $s = trim(strval($s));
        if (preg_match('#^-?\d+?\.0+$#', $s)) {
            return preg_replace('#^(-?\d+?)\.0+$#','$1',$s);
        }
        if (preg_match('#^-?\d+?\.[0-9]+?0+$#', $s)) {
            return preg_replace('#^(-?\d+\.[0-9]+?)0+$#','$1',$s);
        }
        return $s;
    }
    
        //笛卡尔积
    function cartesian($arr) {
        $result = array_shift($arr);
        while ($arr2 = array_shift($arr)) {
            $arr1 = $result;
            $result = array();
            foreach ($arr1 as $v) {
                foreach ($arr2 as $v2) {
                    if (!is_array($v)) $v = array($v);
                    if (!is_array($v2)) $v2 = array($v2);
                    $result[] = array_merge_recursive($v,$v2);
                }
            }
        }
        return $result;
    }
    
    //base64图片正则提取
    function pregBase64($str) {
        if (!is_string($str)) return [];
        $preg = '/data:image\/[a-z].*?;base64,([^"]+)"/';
        preg_match_all($preg, $str, $imgArr);
        return $imgArr[0];
    }
    
    //获取base64图片内容
    function get_str($str, $start, $end) {
        echo substr($str, strlen($start)+strpos($str, $start),(strlen($str) - strpos($str, $end))*(-1));
    }

    //放一些网址
    function setUrl() {
        $url_1 = "http://pecl.php.net/package/redis";  //redis官网包
        $url_2 = "https://www.bootcdn.cn/";     //css、js外链地址
        $url_3 = "https://blog.csdn.net/luanpeng825485697";   //java,c++,c#,python等文章 博客 
    }


    //curl请求
    function curl_method($url, $data, $header = false, $method = "POST") {
        //初使化init方法
        $ch = curl_init();
        //指定URL
        curl_setopt($ch,CURLOPT_URL, $url);
        //设定请求后返回结果
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        switch ($method) {
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( $data ));
                break;
            case 'GET': break;
            case 'PUT':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data); //设置请求体，提交数据包
                break;
            case 'DELETE':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
        }
        //忽略证书
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        //header头信息
        if ($header) curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        //设置超时时间
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        //发送请求
        $output = curl_exec($ch);
        //关闭curl
        curl_close($ch);
        //返回数据
        return $output;
    }
    
     /**
     * @param $header  数据表头
     * @param $data     数据
     * @param string $fileName  文件名
     * @return void
     * 生成cvs到本地
     */
    function csvExport($header, $data, $fileName = '') {

        set_time_limit(0);
        ini_set('memory_limit', '512M');
        
        // 防止没有添加文件后缀
        $fileName = str_replace('.csv', '', $fileName).'.csv';
        ob_clean();
        header( "Content-type:  application/octet-stream ");
        header( "Accept-Ranges:  bytes ");
        header( "Content-Disposition:  attachment;  filename=".$fileName);
        $num = 0;
        $limit = 50000;
        
        //数据表头
        if ($header) echo iconv('UTF-8', 'GBK', implode(',', $header) ) . "\t\r\n";
        
        foreach( $data as $k => $v) {
            $num++;
            //防止数据过多
            if ($limit == $num) {
                ob_flush();
                flush();
                $num = 0;
            }
            
            $newData = array();
            if ($header) {
                foreach ($header as $key => $val) {
                    //注 null转空字符串是为了打开excel时单元格对上title
                    if (array_key_exists($key, $header)) $newData[$key] = $v[$key]===null ? '' : $v[$key];
                }
            } else $newData = $v;
            
            // 如果是二维数组；转成一维
            if (is_array($newData)) {
                $newData = implode(',', $newData);
            }
            // 解决导出的数字会显示成科学计数法的问题
            $v = str_replace(',', "\t,", $newData);
            // 转成gbk以兼容office乱码的问题
            //echo iconv('UTF-8', 'GBK', $newData) . "\t\r\n";
            echo mb_convert_encoding($newData, 'GBK', 'UTF-8') . "\t\r\n";
        }
    }
    
    /**
    * @param $fileInfo   //上传文件的信息
    * @param array $allowType  //允许的类型
    * @return boolean
    * 获得文件的真实扩展名
    */
    function getFileType($fileInfo, $allowType=array('mp3', 'wav')){
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $fileInfo['tmp_name']);
        $arr = array(
            'mp3'   =>  array('audio/mpeg'),
            'wav'   =>  array('audio/x-wav'),
        );
        $suffix = explode('.', $fileInfo['name'])[1];
        $flag = false;
        foreach ($allowType as $v) {
            if (isset($arr[$v]) && in_array($mime, $arr[$v]) && in_array($suffix, $allowType)) {
                $flag = true;
                break;
            }
        }
        return $flag;
    }

}


class ZipX
{

    function excel($path, $zipName)
    {
        $this->zip($path, $zipName);

        header("Cache-Control: public");

        header("Content-Description: File Transfer");

        header('Content-disposition: attachment; filename=' . basename($zipName)); //文件名

        header("Content-Type: application/zip"); //zip格式的

        header("Content-Transfer-Encoding: binary"); //告诉浏览器，这是二进制文件

        header('Content-Length: ' . filesize($zipName)); //告诉浏览器，文件大小

        //清除缓冲区
        ob_clean();
        flush();

        @readfile($zipName);
        unlink($zipName);
    }

    /**
     * 总接口
     * @param $dir_path 需要压缩的目录地址（绝对路径）
     * @param $zipName 需要生成的zip文件名（绝对路径）
     */
    function zip($dir_path, $zipName)
    {
        $relationArr = [$dir_path => [
            'originName' => $dir_path,
            'is_dir' => true,
            'children' => []
        ]];
        $this->modifiyFileName($dir_path, $relationArr[$dir_path]['children']);
        $zip = new ZipArchive();
        $zip->open($zipName, ZipArchive::CREATE);
        $this->zipDir(array_keys($relationArr)[0], '', $zip, array_values($relationArr)[0]['children']);
        $zip->close();
        $this->restoreFileName(array_keys($relationArr)[0], array_values($relationArr)[0]['children']);
    }

    /**
     * 递归添加文件进入zip
     * @param $real_path 在需要压缩的本地的目录
     * @param $zip_path zip里面的相对目录
     * @param $zip ZipArchive对象
     * @param $relationArr 目录的命名关系
     */
    function zipDir($real_path, $zip_path, &$zip, $relationArr)
    {
        $sub_zip_path = empty($zip_path) ? '' : $zip_path . '/';
        if (is_dir($real_path)) {
            foreach ($relationArr as $k => $v) {
                if ($v['is_dir']) {  //是文件夹
                    $zip->addEmptyDir($sub_zip_path . $v['originName']);
                    $this->zipDir($real_path . $k . '/', $sub_zip_path . $v['originName'], $zip, $v['children']);
                } else { //不是文件夹
                    $zip->addFile($real_path . $k, $sub_zip_path . $k);
                    $zip->deleteName($sub_zip_path . $v['originName']);
                    $zip->renameName($sub_zip_path . $k, $sub_zip_path . $v['originName']);
                }
            }
        }
    }

    /**
     * 递归将目录的文件名更改为随机不重复编号，然后保存原名和编号关系
     * @param $path 本地目录地址
     * @param $relationArr 关系数组
     * @return bool
     */
    function modifiyFileName($path, &$relationArr)
    {
        if (!is_dir($path) || !is_array($relationArr)) {
            return false;
        }
        if ($dh = opendir($path)) {
            $count = 0;
            while (($file = readdir($dh)) !== false) {
                if (in_array($file, ['.', '..', null])) continue; //无效文件，重来
                if (is_dir($path . $file)) {
                    $newName = md5(rand(0, 99999) . rand(0, 99999) . rand(0, 99999) . microtime() . 'dir' . $count);
                    $relationArr[$newName] = [
                        'originName' => iconv('GBK', 'UTF-8', $file),
                        'is_dir' => true,
                        'children' => []
                    ];
                    rename($path . $file, $path . $newName);
                    $this->modifiyFileName($path . $newName . '/', $relationArr[$newName]['children']);
                    $count++;
                } else {
                    $extension = strchr($file, '.');
                    $newName = md5(rand(0, 99999) . rand(0, 99999) . rand(0, 99999) . microtime() . 'file' . $count);
                    $relationArr[$newName . $extension] = [
                        'originName' => iconv('GBK', 'UTF-8', $file),
                        'is_dir' => false,
                        'children' => []
                    ];
                    rename($path . $file, $path . $newName . $extension);
                    $count++;
                }
            }
        }
    }

    /**
     * 根据关系数组，将本地目录的文件名称还原成原文件名
     * @param $path 本地目录地址
     * @param $relationArr 关系数组
     */
    function restoreFileName($path, $relationArr)
    {
        foreach ($relationArr as $k => $v) {
            if (!empty($v['children'])) {
                $this->restoreFileName($path . $k . '/', $v['children']);
                rename($path . $k, iconv('UTF-8', 'GBK', $path . $v['originName']));
            } else {
                rename($path . $k, iconv('UTF-8', 'GBK', $path . $v['originName']));
            }
        }
    }

//删除本地文件目录
    function delDir($dir)
    {
        //先删除目录下的文件：
        $dh = opendir($dir);
        while ($file = readdir($dh)) {
            if ($file != "." && $file != "..") {
                $fullpath = $dir . "/" . $file;
                if (!is_dir($fullpath)) {
                    unlink($fullpath);
                } else {
                    $this->deldir($fullpath);
                }
            }
        }
        closedir($dh);
    }
}


