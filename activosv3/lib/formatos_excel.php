<?
 //require_once '../Excel\Spreadsheet\Writer.php';

$num_format =& $workbook->addFormat();
$num_format->setNumFormat('###,###,##0.00');
$num_format->setBold();
$num_format->setAlign('right');



$format_date =& $workbook->addFormat();
$format_date->setNumFormat('dd/mm/YYYY');
$format_date->setAlign('right');


$format_date_mm =& $workbook->addFormat();
$format_date_mm->setNumFormat("mmm-yy");
$format_date_mm->setBold();
$format_date_mm->setAlign('right');


$format_date_h =& $workbook->addFormat();
$format_date->setNumFormat('dd/mm/aaaa HH:mm');
$format_date->setAlign('right');


$num_formatp =& $workbook->addFormat();
$num_formatp->setNumFormat('0.00%');
$num_formatp->setBold();
$num_formatp->setAlign('right');





$num_format1 =& $workbook->addFormat();
$num_format1->setNumFormat('###,###,###');
$num_format1->setBold();
$num_format1->setAlign('right');


$format_bold =& $workbook->addFormat();
$format_bold->setBold();



$format_bold1 =& $workbook->addFormat();
$format_bold1->setBold();

$format_boldcenter =& $workbook->addFormat();
$format_boldcenter->setBold();
$format_boldcenter->setAlign('center');



$format_01 =& $workbook->addFormat();
$format_01->setBold();

$format_02 =& $workbook->addFormat();
$format_02->setBold();
$format_02->setsize(14);

$format_tit1=& $workbook->addFormat();
$format_tit1->setBold();
$format_tit1->setsize(12);

$format_tit1->setVAlign('vcenter');
$format_tit1->setNumFormat('###,##0.00');

$format_tit2=& $workbook->addFormat();
$format_tit2->setBold();
$format_tit2->setsize(12);

$format_tit2->setVAlign('vcenter');
$format_tit2->setNumFormat('0.00%');



$format_99 =& $workbook->addFormat();

$format_99->setBorder(1);








?>