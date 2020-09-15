<?php
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2012 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @category PHPExcel
 * @package PHPExcel
 * @copyright Copyright (c) 2006 - 2012 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt LGPL
 * @version 1.7.7, 2012-05-19
 */
 
/** Error reporting */
error_reporting(E_ALL);
 
date_default_timezone_set('Europe/London');
 
/** Include PHPExcel */
require_once '../../excel/PHPExcel.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
 
// Set document properties
$objPHPExcel->getProperties()->setCreator("Fauzan Azis")
							 ->setLastModifiedBy("Fauzan Azis")
							 ->setTitle("Data Inventaris")
							 ->setSubject("Data Inventaris")
							 ->setDescription("Laporan Data Inventaris Yayasan Mutiara Harapan Bangsa")
							 ->setKeywords("Data Inventaris")
							 ->setCategory("Data Inventaris");
 
// Create the worksheet
$objPHPExcel->setActiveSheetIndex(0);

// mulai judul kolom dengan row 12
$objPHPExcel->getActiveSheet()->setCellValue('A9', "NO")
							  ->setCellValue('B9', "KODE ASET")
							  ->setCellValue('C9', "NAMA ASET")
							  ->setCellValue('D9', "GOLONGAN")
							  ->setCellValue('E9', "SUB GOLONGAN")
							  ->setCellValue('F9', "MERK")
							  ->setCellValue('G9', "TIPE")
							  ->setCellValue('H9', "TAHUN")
							  ->setCellValue('I9', "MASA SERVIS(BULAN)");

// koneksi database
include ("../../Connections/koneksi.php"); 
mysql_select_db($database_koneksi,$koneksi);
// query database
$SQL = mysql_query("select * from tampil_inventaris order by nm_barang");

// jumlah data
$jumlah = mysql_num_rows($SQL);
  
$dataArray= array();
$no=0;

// menampilkan data, susunan field sesuai dengan urutan judul kolom 
while($row = mysql_fetch_array($SQL, MYSQL_ASSOC)){
	$no++;
	$row_array['no'] 		  		= $no;
	$row_array['kode_barang'] 	  	= $row['kode_barang'];
	$row_array['nm_barang']    	  	= $row['nm_barang'];
	$row_array['nm_golongan'] 	  	= $row['nm_golongan'];
	$row_array['nm_subgolongan'] 	= $row['nm_subgolongan'];
	$row_array['merk'] 	 			= $row['merk'];
	$row_array['tipe'] 	  			= $row['tipe'];
	$row_array['tahun']  	  		= $row['tahun'];
	$row_array['masa_servis'] 	  	= $row['masa_servis'];
	
	array_push($dataArray,$row_array);
}

// Mulai record dengan row 8
$nox=$no+9;
$objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A10'); 

// Set page orientation and size
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);
$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.75);
$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.75);
$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.75);
$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.75);
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');
 
// Set title row bold;
$objPHPExcel->getActiveSheet()->getStyle('A9:I9')->getFont()->setBold(true);
// Set fills
$objPHPExcel->getActiveSheet()->getStyle('A9:I9')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A9:I9')->getFill()->getStartColor()->setARGB('FF808080');

//untuk auto size colomn 
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
 
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
 
$sharedStyle1 = new PHPExcel_Style();
$sharedStyle2 = new PHPExcel_Style();
 
$sharedStyle1->applyFromArray(
 array('borders' => array(
 'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
 'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
 'right' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
 'left' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM)
 ),
 ));
 
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A9:I$nox");
 
// Set style for header row using alternative method
$objPHPExcel->getActiveSheet()->getStyle('A9:I9')->applyFromArray(
 array(
 'font' => array(
 'bold' => true
 ),
 'alignment' => array(
 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
 ),
 'borders' => array(
 'top' => array(
 'style' => PHPExcel_Style_Border::BORDER_THIN
 )
 ),
 'fill' => array(
 'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
 'rotation' => 90,
 'startcolor' => array(
 'argb' => 'FFA0A0A0'
 ),
 'endcolor' => array(
 'argb' => 'FFFFFFFF'
 )
 )
 )
);
 
// Add a drawing to the worksheet
/*$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo');
$objDrawing->setDescription('Logo');
$objDrawing->setPath('./images/logo.jpg');
$objDrawing->setCoordinates('D2');
$objDrawing->setHeight(100);
$objDrawing->setWidth(100);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());*/
 
//untuk font dan size data
$objPHPExcel->getActiveSheet()->getStyle('A9:I1000')->getFont()->setName('Arial');
$objPHPExcel->getActiveSheet()->getStyle('A9:I1000')->getFont()->setSize(9);
 
// Mulai Merge cells Judul
$objPHPExcel->getActiveSheet()->mergeCells('D2:I2');
$objPHPExcel->getActiveSheet()->setCellValue('D2', "DAFTAR DATA INVENTARIS");

$objPHPExcel->getActiveSheet()->mergeCells('D3:I3');
$objPHPExcel->getActiveSheet()->setCellValue('D3', "Kantor Camat Simpang Mamplam - Bireuen");

$objPHPExcel->getActiveSheet()->mergeCells('D4:I4');
$objPHPExcel->getActiveSheet()->setCellValue('D4', "Tahun ".date('Y'));

$objPHPExcel->getActiveSheet()->getStyle('D2:I5')->getFont()->setName('Arial');
$objPHPExcel->getActiveSheet()->getStyle('D2:I5')->getFont()->setSize(14);
$objPHPExcel->getActiveSheet()->getStyle('D2:I5')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('D3:I5')->getFont()->setSize(13);

// untuk sub judul
$objPHPExcel->getActiveSheet()->setCellValue('A7', "Jumlah Data : $jumlah");

/*$objPHPExcel->getActiveSheet()->setCellValue('A8', "Kota : Karawang");
$objPHPExcel->getActiveSheet()->setCellValue('A9', "Propinsi : Jawa Barat");

$objPHPExcel->getActiveSheet()->setCellValue('H8', "Tingkat : SMA");
$objPHPExcel->getActiveSheet()->setCellValue('H9', "Sekolah : SMAN4 Karawang ");

$objPHPExcel->getActiveSheet()->getStyle('A7:I9')->getFont()->setName('Arial');
$objPHPExcel->getActiveSheet()->getStyle('A7:I9')->getFont()->setSize(9);*/

// Judul Center
$objPHPExcel->getActiveSheet()->getStyle('A2:I6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 
$tgl = date('d-m-Y');
// Redirect output to a client�s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="DATA_INVENTARIS"'.date("d-F-Y").'".xlsx"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
 
// Save Excel 2007 file
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save(str_replace('.php', '.xlsx', __FILE__));