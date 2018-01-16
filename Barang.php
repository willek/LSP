<?php

Class Barang {
  private $file = 'Barang.json';
  public $daftar_barang;

  public function __construct() {
    $this->ambilData();
  }

  private function masukkan($array) {
    array_push($this->daftar_barang, $array);
    $data_barang = json_encode($this->daftar_barang, JSON_PRETTY_PRINT);
    file_put_contents($this->file, $data_barang);
    $this->ambilData();
  }

  private function ambilData() {
    $data = file_get_contents($this->file);
    $this->daftar_barang = json_decode($data, true);
  }

  public function tambahData($kode_barang, $nama_barang, $jumlah_barang, $harga_barang) {
    if (in_array($kode_barang, array_column($this->daftar_barang, 'kode_barang'))) {
      $key = array_search($kode_barang, array_column($this->daftar_barang, 'kode_barang'));
      $this->daftar_barang[$key]['jumlah_barang'] += $jumlah_barang;
      $this->editData();
    } else {
      try {
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

  public function editData() {
    $data_barang = json_encode($this->daftar_barang, JSON_PRETTY_PRINT);
    file_put_contents($this->file, $data_barang);
  }

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

  public function kosongkanDataBarang() {
    $this->daftar_barang = [];
    $this->editData();
  }

  public function sortir(&$array, $kolom, $arah = SORT_ASC) {
    $sortir_kolom = [];
    foreach ($array as $key => $baris) {
      $sortir_kolom[$key] = $baris[$kolom];
    }
    array_multisort($sortir_kolom, $arah, $array);
  }

  public function cari($kode_barang) {
    return in_array($kode_barang, array_column($this->daftar_barang, 'kode_barang'));
  }
}
