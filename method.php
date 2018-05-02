<?php

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


}