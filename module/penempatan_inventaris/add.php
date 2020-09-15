<?php require_once('Connections/koneksi.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}



mysql_select_db($database_koneksi, $koneksi);
$query_rs_harta = "SELECT kode_suplier, nm_suplier FROM suplier ORDER BY kode_suplier ASC";
$rs_harta = mysql_query($query_rs_harta, $koneksi) or die(mysql_error());
$row_rs_harta = mysql_fetch_assoc($rs_harta);
$totalRows_rs_harta = mysql_num_rows($rs_harta);

mysql_select_db($database_koneksi, $koneksi);
$query_rs_ruangan = "SELECT * FROM ruangan ORDER BY kode_ruangan ASC";
$rs_ruangan = mysql_query($query_rs_ruangan, $koneksi) or die(mysql_error());
$row_rs_ruangan = mysql_fetch_assoc($rs_ruangan);
$totalRows_rs_ruangan = mysql_num_rows($rs_ruangan);

mysql_select_db($database_koneksi, $koneksi);
$query_rs_unit = "SELECT * FROM unit_kerja ORDER BY kode_unit ASC";
$rs_unit = mysql_query($query_rs_unit, $koneksi) or die(mysql_error());
$row_rs_unit = mysql_fetch_assoc($rs_unit);
$totalRows_rs_unit = mysql_num_rows($rs_unit);
 ?>
<?php


// membaca kode suplier terbesar
$query = "SELECT MAX(kode_inventarisasi) as max FROM inventarisasi ";
$hasil = mysql_query($query);
$data  = mysql_fetch_array($hasil);
$kodeBarang = $data['max'];

// mengambil angka atau bilangan dalam kode anggota terbesar,
// dengan cara mengambil substring mulai dari karakter ke-1 diambil 6 karakter
// misal 'BRG001', akan diambil '001'
// setelah substring bilangan diambil lantas dicasting menjadi integer
$noUrut = (int) substr($kodeBarang, 8, 10);

// bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
$noUrut++;

// membentuk kode anggota baru
// perintah sprintf("%03s", $noUrut); digunakan untuk memformat string sebanyak 3 karakter
// misal sprintf("%03s", 12); maka akan dihasilkan '012'
// atau misal sprintf("%03s", 1); maka akan dihasilkan string '001'
//$char = "SP";
$char = "BRS";
$newID = sprintf("%010s", $noUrut);

?>



<div class="grid_12">
<?php 
		  echo $pesan ;
		?>
</div>

<div class="grid_12">
  <div class="block-border">
    <div class="block-header">
      <h1>Tambah Penempatan Inventaris</h1>
      <span></span> </div>
     
      
    <form action="<?php echo $editFormAction; ?>" name="form"  method="POST" enctype="multipart/form-data" class="block-content form" id="input_inventarisasi">
   
   
       
      <fieldset> <legend>Memilih Barang 
      </legend><div class="_100">
        <p>
          <label for="file">Kode Inventaris *</label>
          <label for="id_pengadaan"></label>
          <input type="text" name="kode_barangg" id="kode_barang"  />
           *Klik pada kolom untuk memilih kode 
           <label for="kode_barang"></label>
           <input name="kode_barang" type="hidden" id="kode_barang" value="" />
        </p>
      </div>
     
      <div class="_50">
        <p>
          <label for="id_pengadaan"></label>
        Nama	Inventaris
        <label for="nm_barang"></label>
        <input name="nm_barang" type="text" id="nm_barang" readonly="readonly" />
        </p>
      </div>
      <div class="_50">
        <p>
          <label for="tahun"></label>
        Kode Pengadaan
        <label for="id_pengadaan"></label>
        <input name="id_pengadaan" type="text" id="id_pengadaan" readonly="readonly" />
        </p>
      </div>
    
        <div class="_50">
          <p>
            <label for="tahun2"></label>
            Kantor Cabang
            <label for="kode_harta"></label>
            <input name="kode_cabang" type="text" id="kode_cabang" readonly="readonly" />
          </p>
        </div>
        <div class="_25">
          <p>
            <label for="tahun2"></label>
            Sisa Jumlah
            <label for="kode_harta"></label>
            <input name="sisa_jumlah" type="text" id="sisa_jumlah" readonly="readonly" />
          </p>
        </div>
      </fieldset>
   
   <fieldset>
    <legend>Menentukan Penempatan
    </legend><div class="_25">
          <p>
            <label for="tahun2"></label>
            Ruangan *
            <label for="kode_harta"></label>
            <label for="kode_ruangan"></label>
          <select name="kode_ruangan" id="kode_ruangan">
            <?php do { ?>
                <option value="<?php echo $row_rs_ruangan['kode_ruangan']; ?>"><?php echo $row_rs_ruangan['nm_ruangan']; ?></option>
              <?php } while ($row_rs_ruangan = mysql_fetch_assoc($rs_ruangan)); ?>
            </select>
          </p>
        </div>
        
        <div class="_25">
          <p>
            <label for="tahun2"></label>
            Unit Kerja*
            <label for="kode_unit"></label>
              <select name="kode_unit" id="kode_unit">
            <?php do { ?>
                <option value="<?php echo $row_rs_unit['kode_unit']; ?>"><?php echo $row_rs_unit['nm_unit']; ?>              </option>
              <?php } while ($row_rs_unit = mysql_fetch_assoc($rs_unit)); ?>
              </select>
          </p>
        </div>
        
        <div class="_25">
          <p>
            <label for="tahun2"></label>
            Jumlah Inventarisasi *
            <label for="kode_harta"></label>
            <input name="jumlah" type="text" id="jumlah" />
            
          </p>
        </div>
        
        <div class="_25">
          <p>
            <label for="tahun2"></label>
            Kondisi
            <label for="kode_harta"></label>
            <input name="kondisi" type="text" id="kondisi" />
            
          
          </p>
        </div>
      </fieldset> 

   
      <div class="clear"></div>
      <div class="block-actions">
        <ul class="actions-left">
          <li><a class="button red"  href="?mod=penempatan_inventaris">Kembali</a></li>
        </ul>
        <ul class="actions-right">
          <li>
            <input name="Submit" type="submit" class="button" id="simpan" value="Simpan Pengadaan" />
          </li>
        </ul>
      </div>
      <input type="hidden" name="MM_insert" value="validate-form" />
      <input type="hidden" name="MM_insert" value="form" />
      <input name="tgl_posting" type="hidden" id="tahun" value="<?php echo date('Y-m-d');?>" />
      <input name="user_posting" type="hidden" id="tipe" value="admin" />
      <input name="status" type="hidden" id="status" value="1" />
      <?php $kode_inventarisasi = $_POST[kode_cabang].'-'.$_POST[kode_barang].'-'.$_POST[kode_ruang].'-'.$_POST[kode_unit].'-'.$newID  ?>
      <input name="kode_inventarisasi" type="hidden" id="kode_inventarisasi" />
    </form>
  </div>
</div>


<div id='form_cari_barang' title='Daftar barang yang belum diinventarisasi'>
	  <table width='100%'>
			<tr>
				<td width='15%'>Cari Barang</td>
				<td width='2%'>:</td>
				<td><input type='text' name='txt_penempatan_cari' id='txt_penempatan_cari' size='50'></td>
			</tr>
		</table>
		<div id='info_barang' align='center'></div>
	</div>
    
<div id="tampil"></div>
    
    
<?php
mysql_free_result($rs_harta);

mysql_free_result($rs_ruangan);

mysql_free_result($rs_unit);
?>
