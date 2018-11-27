<?php


    /**
     * 导出excel
     * @param array $data 导入数据
     * @param string $savefile 导出excel文件名
     * @param array $fileheader excel的表头
     * @param string $sheetname sheet的标题名
     */
    function exportExcel($data, $savefile, $fileheader, $sheetname){
        
        //加载phpexcel
        $excel = new PHPExcel();
        if (is_null($savefile)) {
            $savefile = time();
        }else{
            //防止中文命名，下载时ie9及其他情况下的文件名称乱码
            iconv('UTF-8', 'GB2312', $savefile);
        }
        //设置excel属性
        $objActSheet = $excel->getActiveSheet();
        //设置当前的sheet
        $excel->setActiveSheetIndex(0);
        //设置sheet的name
        $objActSheet->setTitle($sheetname);
        //业务逻辑
        ...
        ...
        //输出到客户端
        $write = new PHPExcel_Writer_Excel2007($excel);
        ob_end_clean();
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");
        header('Content-Disposition:attachment;filename="'.$savefile.'.xlsx"');
        header("Content-Transfer-Encoding:binary");
        $write->save('php://output');

    }
