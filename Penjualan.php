<?php

require '__Keranjang.php';

// inheritance antara penjualan dan barang
Class Penjualan extends Barang {

  public $transaksi = [];
  public $bayar = 0;
  public $barang;

  public function __construct() {
    $this->barang = new Barang;
  }

  // overloading
  public function __call($name, $arguments) {
    switch ($name) {
      case 'kosongkanKeranjang':
        $this->transaksi = [];
        $this->bayar = 0;
        break;
    }
  }

  // digunakan untuk mengecek ketersediaan barang ketika melakukan transaksi / penjualan
  public function cekKetersediaan($kode_barang, $total_pesanan) {
    $key = array_search($kode_barang, array_column($this->barang->daftar_barang, 'kode_barang'));
    if ($total_pesanan <= $this->barang->daftar_barang[$key]['jumlah_barang'] && $total_pesanan > 0) {
      return true;
    } else {
      $nama_barang = $this->barang->daftar_barang[$key]['nama_barang'];
      echo "Penjualan dibatalkan, karena jumlah pesanan $nama_barang terlalu banyak / salah / stok telah habis.";
      return false;
    }
  }

  // digunakan untuk memasukkan data ke property transaksi yang nantinya akan diproses untuk transaksi
  public function masukkanKeKeranjang($kode_barang, $total_pesanan) {
    try {
      $key = array_search($kode_barang, array_column($this->barang->daftar_barang, 'kode_barang'));
      $barang_pesanan = $this->barang->daftar_barang[$key];
      if ($barang_pesanan['kode_barang'] == $kode_barang) {
        $pesanan = [
          'kode_barang' => $barang_pesanan['kode_barang'],
          'nama_barang' => $barang_pesanan['nama_barang'],
          'total_pesanan' => $total_pesanan,
          'total_harga' => $barang_pesanan['harga_barang'] * $total_pesanan
        ];
        array_push($this->transaksi, $pesanan);
        $this->bayar += $pesanan['total_harga'];
      }
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  // fungsi yang digunakan untuk mengubah data barang (mengurangi jumlah stok barang) setelah melakukan transaksi / penjualan
  public function ubahDataBarang() {
    try {
      foreach ($this->barang->daftar_barang as $key => $barang) {
        foreach ($this->transaksi as $transaksi) {
          if ($barang['kode_barang'] == $transaksi['kode_barang']) {
            $this->barang->daftar_barang[$key]['jumlah_barang'] -= $transaksi['total_pesanan'];
            $this->barang->editData();
          }
        }
      }
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  // fungsi untuk mencetak barang yang dijual dan menampilkan total harganya
  public function cetakFakturPenjualan() {
    echo "========== Faktur Penjualan =========\n";
    echo "Kode\tNama\t\tJumlah\tTotal\n";
    foreach ($this->transaksi as $transaksi) {
      echo $transaksi['kode_barang']."\t".$transaksi['nama_barang']."\t\t".$transaksi['total_pesanan']."\t".$transaksi['total_harga']."\n";
    }
    echo "-------------------------------------\n";
    echo "\t\tTotal bayar: ".$this->bayar."\n";
    echo "=====================================\n";
  }

}
