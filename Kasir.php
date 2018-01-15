<?php

// require 'Barang.php';
// require 'Pesanan.php';
require 'Validasi.php';

class Kasir {

  public function __construct() {
    $this->tampilkanMenu();
  }

  private function tampilkanMenu() {
    echo "\n================ Kasir ================\n";
    echo "1. Tambah Barang\n";
    echo "2. Penjualan\n";
    echo "3. Stok Barang\n";
    echo "=======================================\n";
    $this->pilih();
  }

  private function pilihMenu() {
    echo "Pilih menu: ";
    $pilihan = Validasi::angka(trim(fgets(STDIN)));
    switch ($pilihan) {
      case '1':
        $this->tambahBarang();
        break;

      case '2':
        $this->penjualan();
        break;

      case '3':
        $this->stokBarang();
        break;

      default:
        echo "Pilihan salah.\n";
        $this->pilihMenu();
        break;
    }
  }

  private function tambahBarang() {
    echo "tambah barang";
  }

  private function penjualan() {
    echo "penjualan";
  }

  private function stokBarang() {
    echo "stok barang";
  }

}
