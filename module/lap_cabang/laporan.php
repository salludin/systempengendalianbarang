<?php

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

date_default_timezone_set('Asia/Jakarta');

/** Include PHPExcel */
require_once '../../excel/PHPExcel.php';

// Membuat script koneksi
require_once('../../Connections/koneksi.php'); 

mysql_select_db($database_koneksi, $koneksi);

// Membuat documen excel baru
echo date('H:i:s') , " Create new PHPExcel object" , EOL;
$objPHPExcel = new PHPExcel();

// Set Properti Documen excel yang akan dibuat
echo date('H:i:s') , " Set document properties" , EOL;
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");
							 
//set table header
//Tabel akan kita mulai dari Kolom B10 dan seterusnya
$objPHPExcel->getActiveSheet()->setCellValue('B10', 'No');
$objPHPExcel->getActiveSheet()->setCellValue('C10', 'Kode Cabang');
$objPHPExcel->getActiveSheet()->setCellValue('D10', 'Nama Cabang');
$objPHPExcel->getActiveSheet()->setCellValue('E10', 'Alamat');

// Add some data
echo date('H:i:s') , " Menampilkan bebarapa data dari tabel siswa" , EOL;
$query = mysql_query('select * from cabang order by kode_cabang');
//start data from row 11
$i = 11;
$no= 1;
while($data=mysql_fetch_array($query)){
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $no);
	$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $data['kode_cabang']);
	$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $data['nm_cabang']);
	$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $data['alamat']);
	$i++;
	$no++;
}

//Mengatur lebar cell pada documen excel
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);

// Set sheet yang aktif pada documen excel
$objPHPExcel->setActiveSheetIndex(0);

echo date('H:i:s') , " Write to Excel2007 format" , EOL;
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;

// Echo done
echo date('H:i:s') , " Done writing file" , EOL;
echo 'File has been created in ' , getcwd() , EOL;