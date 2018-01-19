<?php

/**
 * Struct adalah sebuah object dengan membernya bersifat public.
 **/

Class Barang {
  // property yang dimiliki class barang

  // database (file .json)
  private $file = 'Barang.json';
  public $daftar_barang;

  // method yang dipanggil ketika object barang dijalankan
  public function __construct() {
    $this->ambilData();
  }

  // method untuk memasukkan 1 data ke file .json
  private function masukkan($array) {
    array_push($this->daftar_barang, $array);
    $this->daftar_barang = array_values($this->daftar_barang);
    $data_barang = json_encode($this->daftar_barang, JSON_PRETTY_PRINT);
    file_put_contents($this->file, $data_barang);
    $this->ambilData();
  }

  // mengambil / membaca semua data dari file .json
  public function ambilData() {
    // read file & get the data (file_get_contents)
    $data = file_get_contents($this->file);
    $this->daftar_barang = json_decode($data, true);
    $this->daftar_barang = array_values($this->daftar_barang);
  }

  // menambahkan data barang
  public function tambahData($kode_barang, $nama_barang, $jumlah_barang, $harga_barang) {
    if (in_array($kode_barang, array_column($this->daftar_barang, 'kode_barang'))) {
      $key = array_search($kode_barang, array_column($this->daftar_barang, 'kode_barang'));
      $this->daftar_barang[$key]['jumlah_barang'] += $jumlah_barang;
      $this->editData();
    } else {

      // exception handling
      try {
        // Array 1 dimensi
        $barang_baru = [
          'kode_barang' => $kode_barang,
          'nama_barang' => $nama_barang,
          'jumlah_barang' => $jumlah_barang,
          'harga_barang' => $harga_barang
        ];
        $this->masukkan($barang_baru);
      } catch (Exception $e) {
        die($e->getMessage());
      }
    }
  }

  // method untuk melakukan edit / update daftar barang yang telah diubah, seperti hapus barang, dan menambah barang baru
  public function editData() {
    $this->daftar_barang = array_values($this->daftar_barang);
    $data_barang = json_encode($this->daftar_barang, JSON_PRETTY_PRINT);
    file_put_contents($this->file, $data_barang);
  }

  // fungsi yang digunakan untuk menghapus barang berdasarkan kode barang sebagai parameternya
  public function hapusData($kode_barang){
    if (in_array($kode_barang, array_column($this->daftar_barang, 'kode_barang'))) {
      $key = array_search($kode_barang, array_column($this->daftar_barang, 'kode_barang'));
      unset($this->daftar_barang[$key]);
      $this->editData();
      echo "Data berhasil dihapus\n";
    } else {
      echo "Kode barang $kode_barang tidak ditemukan\n";
    }
  }

  // fungsi yang digunakan untuk menghapus semua data dari daftar barang
  public function kosongkanDataBarang() {
    $this->daftar_barang = [];
    $this->editData();
  }

  /**
   *Pointer = &$array
   */

  // digunakan untuk sortir data barang
  public function sortir(&$array, $kolom, $arah = SORT_ASC) {
    $sortir_kolom = [];
    foreach ($array as $key => $baris) {
      $sortir_kolom[$key] = $baris[$kolom];
    }
    array_multisort($sortir_kolom, $arah, $array);
  }

  // fungsi yang digunakan untuk mencari barang berdasarkan kode barang
  public function cari($kode_barang) {
    return in_array($kode_barang, array_column($this->daftar_barang, 'kode_barang'));
  }
}
