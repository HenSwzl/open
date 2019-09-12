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
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
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

        // 如果手动设置表头；则放在第一行
        if (!is_null($header)) {
            array_unshift($data, $header);
        }
        // 防止没有添加文件后缀
        $fileName = str_replace('.csv', '', $fileName).'.csv';
        ob_clean();
        header( "Content-type:  application/octet-stream ");
        header( "Accept-Ranges:  bytes ");
        header( "Content-Disposition:  attachment;  filename=".$fileName);
        $num = 0;
        $limit = 50000;
        foreach( $data as $k => $v) {
            $num++;
            //防止数据过多
            if ($limit == $num) {
                ob_flush();
                flush();
                $num = 0;
            }
            // 如果是二维数组；转成一维
            if (is_array($v)) {
                $v = implode(',', $v);
            }
            // 解决导出的数字会显示成科学计数法的问题
            $v = str_replace(',', "\t,", $v);
            // 转成gbk以兼容office乱码的问题
            echo iconv('UTF-8', 'GBK', $v) . "\t\r\n";
        }
    }

}
