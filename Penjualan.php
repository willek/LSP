<?php

require '__Keranjang.php';

Class Penjualan extends Barang {

  public $transaksi = [];
  public $bayar = 0;
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

  public function kosongkanKeranjang() {
    $this->transaksi = [];
    $this->bayar = 0;
  }

}
