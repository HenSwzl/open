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

    //放一些网址
    function setUrl() {
        $url_1 = "http://pecl.php.net/package/redis";  //redis官网包
    }

}
