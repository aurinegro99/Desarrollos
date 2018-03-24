<?
 //require_once '../Excel\Spreadsheet\Writer.php';

$num_format =& $workbook->addFormat();
$num_format->setNumFormat('###,###,##0.00');
$num_format->setBold();
$num_format->setAlign('right');
//$num_format->setBorder(1);
//$num_format->setFgColor(43);



$num_formatf =& $workbook->addFormat();
$num_formatf->setNumFormat('##0.0000');
$num_formatf->setBold();
$num_formatf->setAlign('right');


$num_format00 =& $workbook->addFormat();
$num_format00->setNumFormat('0.00%');
$num_format00->setBold();
$num_format00->setAlign('right');


$num_formatp =& $workbook->addFormat();
$num_formatp->setNumFormat('0.00%');
$num_formatp->setBold();
$num_formatp->setAlign('right');
$num_formatp->setBorder(1);
$num_formatp->setFgColor(43);




$num_format1 =& $workbook->addFormat();
$num_format1->setNumFormat('###,##0');
$num_format1->setBold();
$num_format1->setAlign('right');


$format_bold =& $workbook->addFormat();
$format_bold->setBold();



$format_bold1 =& $workbook->addFormat();
$format_bold1->setBold();
$format_bold1->setBorder(1);
$format_bold1->setFgColor(43);

$format_boldcenter =& $workbook->addFormat();
$format_boldcenter->setBold();
$format_boldcenter->setAlign('center');



$format_01 =& $workbook->addFormat();
$format_01->setBold();
$format_01->setsize(7);

$format_02 =& $workbook->addFormat();
$format_02->setBold();
$format_02->setsize(14);

$format_tit1=& $workbook->addFormat();
$format_tit1->setBold();
$format_tit1->setsize(12);
$format_tit1->setBorder(2);
$format_tit1->setFgColor(53);
$format_tit1->setVAlign('vcenter');
$format_tit1->setNumFormat('###,##0.00');

$format_tit2=& $workbook->addFormat();
$format_tit2->setBold();
$format_tit2->setsize(12);
$format_tit2->setBorder(2);
$format_tit2->setFgColor(53);
$format_tit2->setVAlign('vcenter');
$format_tit2->setNumFormat('0.00%');



$format_99 =& $workbook->addFormat();

$format_99->setBorder(1);








?>