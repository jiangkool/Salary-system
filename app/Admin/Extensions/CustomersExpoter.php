<?php
namespace App\Admin\Extensions;

use Encore\Admin\Grid\Exporters\AbstractExporter;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Area;
use App\Models\Balance;

class CustomersExpoter extends AbstractExporter
{
    public function export()
    {
    	$filename='客户资料'.date('Y-m-d H:i:s');
        Excel::create($filename, function($excel) {

            $excel->sheet('列表', function($sheet) {

            // 这段逻辑是从表格数据中取出需要导出的字段
            $rows = collect($this->getData())->map(function ($item) {
            	$item['sex']=$item['sex']==0?'女':'男';
            	$item['area_id']=Area::find($item['area_id'])->area;
            	// $item['balance']=Balance::find($item['hospital_code'])->balance;
                return array_only($item, ['id', 'sex','name', 'area_id', 'age', 'hospital_code','created_at']);
            });
            
            //$sheet->rows($rows);
            $sheet->setPageMargin(0.5);
            $sheet->setAllBorders('thin');
            $sheet->freezeFirstRow();
            $sheet->setWidth(array('A'=>5,'B'=>10,'C'=>10,'D'=>20,'E'=>15,'F'=>30,'G'=>20));
            $sheet->setHeight(1, 20);
            $sheet->fromArray($rows);
            $sheet->cell('A1', function($cell) {
                $cell->setValue('ID');
                $cell->setFontSize(14);
                $cell->setBackground('#2464b3');
                $cell->setFontColor('#ffffff');
            });
            $sheet->cell('B1', function($cell) {
                $cell->setValue('姓名');
                $cell->setFontSize(14);
                $cell->setBackground('#2464b3');
                $cell->setFontColor('#ffffff');
                $cell->setAlignment('center');
            });
            $sheet->cell('C1', function($cell) {
                $cell->setValue('性别');
                $cell->setFontSize(14);
                $cell->setBackground('#2464b3');
                $cell->setFontColor('#ffffff');
                $cell->setAlignment('center');
            });
            $sheet->cell('D1', function($cell) {
                $cell->setValue('院区');
                $cell->setFontSize(14);
                $cell->setBackground('#2464b3');
                $cell->setFontColor('#ffffff');
                $cell->setAlignment('center');
            });
            $sheet->cell('E1', function($cell) {
                $cell->setValue('年龄');
                $cell->setFontSize(14);
                $cell->setBackground('#2464b3');
                $cell->setFontColor('#ffffff');
                $cell->setAlignment('center');
            });
            $sheet->cell('F1', function($cell) {
                $cell->setValue('住院号');
                $cell->setFontSize(14);
                $cell->setBackground('#2464b3');
                $cell->setFontColor('#ffffff');
                $cell->setAlignment('center');
            });
            $sheet->cell('G1', function($cell) {
                $cell->setValue('录入时间');
                $cell->setFontSize(14);
                $cell->setBackground('#2464b3');
                $cell->setFontColor('#ffffff');
                $cell->setAlignment('center');
            });

            });

        })->export('xls');
    }
}