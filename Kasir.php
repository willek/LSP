<?php

require 'Barang.php';
// require 'Pesanan.php';
require 'Input.php';
require '__Main.php';

Class Kasir implements __Main {

  // protected $pesanan;
  protected $barang;

  public function __construct() {
    // $this->pesanan = new Pesanan;
    $this->barang = new Barang;
    $this->tampilkanMenu();
  }

  public function tampilkanMenu() {
    echo "\n";
    echo "=============== Kasir ===============\n";
    echo "Pilih Menu: \n";
    echo "  1. Daftar Barang\n";
    echo "  2. Tambah Barang\n";
    echo "  3. Hapus Barang\n";
    echo "  4. Kosongkan Daftar Barang\n";
    echo "  5. Penjualan\n";
    echo "=====================================\n";
    $this->pilihMenu();
  }

  public function pilihMenu() {
    echo "Masukkan pilihan anda (1 - 5): ";
    $pilihan = trim(fgets(STDIN));

    echo "\n";
    switch ($pilihan){
      case '1':
        $this->daftarBarang();
        $this->tampilkanMenu();
        break;
      case '2':
        $this->tambahBarang();
        break;
      case '3' :
        $this->hapusBarang();
        break;
      case '4':
        $this->kosongkanBarang();
        break;
      case '5':
        break;
      default:
        echo "Pilihan tidak ditemukan!\n";
        $this->pilihMenu();
        break;
    }
  }

  private function daftarBarang() {
    $daftar_barang = $this->barang->daftar_barang;
    $this->barang->sortir($daftar_barang, 'kode_barang');

    echo "=========== Daftar Barang ===========\n";
    echo "Kode\tNama\t\tJumlah\tHarga\n";
    echo "-------------------------------------\n";
    if (count($daftar_barang) > 0) {
      foreach ($daftar_barang as $barang) {
        echo $barang['kode_barang']."\t".$barang['nama_barang']."\t\t".$barang['jumlah_barang']."\t".$barang['harga_barang']."\n";
      }
    } else {
      echo "\tData Masih Kosong\n";
    }
    echo "=====================================\n";
  }

  private function tambahBarang() {
    echo "=========== Tambah Barang ===========\n";
    echo "Kode Barang: ";
    $kode_barang = trim(fgets(STDIN));

    if ($this->barang->cari($kode_barang)) {
      echo "Jumlah Barang: ";
      $jumlah_barang = Input::angka(trim(fgets(STDIN)));
      $harga_barang = '';
      $nama_barang = '';
    } else {
      echo "Nama Barang: ";
      $nama_barang = Input::huruf(trim(fgets(STDIN)));
      echo "Harga Barang: ";
      $harga_barang = Input::huruf(trim(fgets(STDIN)));
      echo "Jumlah Barang: ";
      $jumlah_barang = Input::huruf(trim(fgets(STDIN)));
    }

    $this->barang->tambahData($kode_barang, $nama_barang, $jumlah_barang, $harga_barang);

    echo "Ingin menambah barang lagi? (Y/N)";
    $pilihan = trim(fgets(STDIN));
    if ($pilihan == 'Y' || $pilihan == 'y') {
      $this->tambahBarang();
    } else if ($pilihan == 'N' || $pilihan == 'n') {
      $this->tampilkanMenu();
    } else {
      echo "Pilihan salah\n";
      $this->tampilkanMenu();
    }

  }

  private function hapusBarang() {
    echo "=========== Hapus Barang ============\n";
    echo "Kode Barang: ";
    $kode_barang = trim(fgets(STDIN));
    $this->barang->hapusData($kode_barang);
    $this->tampilkanMenu();
  }

  private function kosongkanBarang() {
    echo "========= Kosongkan Barang ==========\n";
    echo "Apa anda yakin ingin mengosongkan daftar barang? (Y/N)";
    $pilihan = trim(fgets(STDIN));
    if ($pilihan == 'Y' || $pilihan == 'y') {
      $this->barang->kosongkanDataBarang();
      echo "Berhasil menghapus semua data!\n";
      $this->tampilkanMenu();
    } else if ($pilihan == 'N' || $pilihan == 'n') {
      echo "Kembali ke menu";
      $this->tampilkanMenu();
    } else {
      echo "Pilihan salah! Kembali ke menu\n";
      $this->tampilkanMenu();
    }
  }

}

new Kasir;
