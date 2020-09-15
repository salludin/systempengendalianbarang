
<?php error_reporting(0);?>
<?php
require_once('../../Connections/koneksi.php'); 
mysql_select_db($database_koneksi, $koneksi);
$kode	= $_POST['kode'];
$text	= "SELECT kode_inventarisasi,aset.kode_barang,nm_barang,nm_ruangan,nm_unit,jumlah,kondisi,nm_status,inventarisasi.tgl_posting,inventarisasi.user_posting FROM inventarisasi LEFT JOIN aset ON inventarisasi.kode_barang = aset.kode_barang LEFT JOIN ruangan ON inventarisasi.kode_ruangan = ruangan.kode_ruangan LEFT JOIN unit_kerja ON inventarisasi.kode_unit = unit_kerja.kode_unit LEFT JOIN status ON inventarisasi.status = status.status WHERE inventarisasi.kode_inventarisasi= '$kode'";
$sql 	= mysql_query($text, $koneksi) or die(mysql_error());
$row	= mysql_num_rows($sql);
if ($row>0){
while ($r=mysql_fetch_array($sql)){	
	$data['kode_barang'] 		= $r[kode_barang] ;
	$data['nm_barang']			= $r[nm_barang];
	$data['merk']				= $r[merk];
	$data['tipe']				= $r[tipe];
	$data['tgl_entry']			= $r[tgl_entry];
	$data['kode_ruangan']		= $r[kode_ruangan];
	$data['nm_ruangan']			= $r[nm_ruangan];
	$data['kode_unit']			= $r[kode_unit];
	$data['nm_unit']			= $r[nm_unit];
	$data['kode_inventarisasi']	= $r[kode_inventarisasi];
	$data['jumlah']			    = $r[jumlah];
	$data['id_inventarisasi']	= $r[id_inventarisasi];
	$data['kode_cabang']	= $r[kode_cabang];
	$data['nm_status']	= $r[nm_status];

	echo json_encode($data);
}
}else{
	$data['nm_barang']	= 'error';
	$data['id_pengadaan']			= '';
	$data['kode_cabang']			= '';
	$data['sisa_jumlah']			= '';
	
	echo json_encode($data);
	
}

?>