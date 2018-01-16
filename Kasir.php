<?php

require 'Barang.php';
// require 'Pesanan.php';
// require 'Validasi.php';

Class Kasir {

  // protected $pesanan;
  protected $barang;

  public function __construct() {
    // $this->pesanan = new Pesanan;
    $this->barang = new Barang;
    $this->tampilkanMenu();
  }

  public function tampilkanMenu() {
    echo "\n================ Kasir ================\n";
    echo "1. Tambah Barang\n";
    echo "2. Penjualan\n";
    echo "3. Stok Barang\n";
    echo "=======================================\n";
    $this->pilihMenu();
  }

  public function pilihMenu() {
    echo "Masukkan pilihan anda: ";
    $pilihan = trim(fgets(STDIN));

    echo "\n";
    switch ($pilihan){
      case '1':
        $this->tambahBarang();
        break;
      case '2':

        break;
      case '3' :
        $this->stokBarang();
        break;
      default:
        echo "Pilihan tidak ditemukan!\n";
        $this->pilihMenu();
        break;
    }
  }

  private function tambahBarang() {
    echo "Kode Barang: ";
    $kode_barang = trim(fgets(STDIN));

    if (condition) {
      # code...
    }

  }

  private function penjualan() {

  }

  private function stokBarang() {
    $daftar_barang = $this->barang->daftar_barang;
    $this->barang->sortir($daftar_barang, 'kode_barang');

    echo "\n";
    echo "============ Daftar Barang ============\n";
    echo "Kode\tNama\tJumlah\tHarga\n";
    foreach ($daftar_barang as $key => $barang) {
      echo $barang['kode_barang']."\t".$barang['nama_barang']."\t".$barang['jumlah_barang']."\t".$barang['harga_barang']."\n";
    }
    echo "=======================================\n";
  }


}

new Kasir;
