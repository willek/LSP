<?php

require '__Keranjang.php';

Class Penjualan extends Barang {

  public $transaksi;
  public $bayar;
  public $barang;

  public function __construct() {
    $this->barang = new Barang;
  }

  public function cekKetersediaan($kode_barang, $total_pesanan) {
    $key = array_search($kode_barang, array_column($this->barang->daftar_barang, 'kode_barang'));
    if ($total_pesanan <= $this->barang->daftar_barang[$key]['jumlah_barang'] && $total_pesanan > 0) {
      return true;
    } else {
      $nama_barang = $this->barang->daftar_barang[$key]['nama_barang'];
      echo "Penjualan dibatalkan, karena jumlah pesanan $nama_barang terlalu banyak / salah";
      return false;
    }
  }

  public function masukkanKeKeranjang() {

  }

  public function cetakFakturPenjualan() {

  }
  
}
