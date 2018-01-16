<?php

require 'Barang.php';
require 'Pesanan.php';
require 'Validasi.php';

Class Kasir {

  protected $pesanan;

  public function __construct() {
    $this->pesanan = new Pesanan;
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
    $choose = trim(fgets(STDIN));

    echo "\n";
    switch ($choose){
      case '1':
        $this->addItem();
        break;
      case '2':
        $this->catalog();
        $this->shopping();
        break;
      case '3' :
        $this->catalog();
        $this->mainMenu();
        break;
      default:
        echo "Pilihan tidak ditemukan!\n";
        $this->mainMenu();
        break;
    }
  }

  public function tambahBarang() {

  }

  public function penjualan() {

  }

  public function stokBarang() {

  }


}

new Kasir;
