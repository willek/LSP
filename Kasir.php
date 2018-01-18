<?php

// require = packages/namespace
// digunakan untuk membaca file / package
require 'Barang.php';
require 'Penjualan.php';
require 'Input.php';
require '__Main.php';

Class Kasir implements __Main {

  // variabel diawali dengan $
  protected $barang;
  protected $penjualan;

  public function __construct() {
    // Object ($this->barang, $this->pesanan)
    $this->barang = new Barang;
    $this->penjualan = new Penjualan;
    $this->tampilkanMenu();
  }

  // Fungsi
  public function tampilkanMenu() {
    echo "\n";
    echo "=============== Kasir ===============\n";
    echo "Pilih Menu: \n";
    echo "  1. Daftar Barang\n";
    echo "  2. Tambah Barang\n";
    echo "  3. Hapus Barang\n";
    echo "  4. Kosongkan Daftar Barang\n";
    echo "  5. Penjualan\n";
    echo "  6. Keluar\n";
    echo "=====================================\n";
    $this->pilihMenu();
  }

  public function pilihMenu() {
    echo "Masukkan pilihan anda (1 - 5): ";
    $pilihan = trim(fgets(STDIN));

    echo "\n";

    /**
     * Stuktur Kontrol.
     * digunakan untuk meng-kontrol suatu program tergantung data yang diberikan (switch-case / if-else).
     **/
    switch ($pilihan){
      case '1':
        $this->daftarBarang();
        $this->tampilkanMenu();
        break;
      case '2':
        $this->tambahBarang();
        break;
      case '3' :
        $this->daftarBarang();
        $this->hapusBarang();
        break;
      case '4':
        $this->kosongkanBarang();
        break;
      case '5':
        $this->daftarBarang();
        $this->penjualanBarang();
        break;
      case '6':
        $this->keluar();
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
    } else if ($pilihan == 'N' || $pilihan == 'n') {
      echo "Kembali ke menu";
    } else {
      echo "Pilihan salah! Kembali ke menu\n";
    }
    $this->tampilkanMenu();
  }

  private function penjualanBarang() {
    echo "============= Penjualan =============\n";
    echo "Kode Barang: ";
    $kode_barang = trim(fgets(STDIN));
    if ($this->barang->cari($kode_barang)) {
      echo "Jumlah Barang: ";
      $total_pesanan = Input::angka(trim(fgets(STDIN)));
      if ($this->penjualan->cekKetersediaan($kode_barang, $total_pesanan)) {
        $this->penjualan->masukkanKeKeranjang($kode_barang, $total_pesanan);
        echo "Ingin memesan lagi? (Y/N)";
        $pilihan = trim(fgets(STDIN));
        if ($pilihan == 'Y' || $pilihan == 'y') {
          $this->penjualanBarang();
        } elseif ($pilihan == 'N' || $pilihan == 'n') {
          $this->penjualan->ubahDataBarang();
          $this->penjualan->cetakFakturPenjualan();
          $this->penjualan->kosongkanKeranjang();
          $this->tampilkanMenu();
        } else {
          echo "Pilihan salah\n";
          $this->tampilkanMenu();
        }
      } else {
        $this->tampilkanMenu();
      }
    } else {
      echo "Barang dengan kode $kode_barang tidak ditemukan.\n";
      $this->tampilkanMenu();
    }
  }

  private function keluar() {
    echo "Apakah anda yakin ingin keluar? (Y/N)";
    $pilihan = trim(fgets(STDIN));
    if ($pilihan == 'Y' || $pilihan == 'y') {
      die();
    } else if ($pilihan == 'N' || $pilihan == 'n') {
      echo "Kembali ke menu...\n";
      $this->tampilkanMenu();
    } else {
      echo "Pilihan salah!\n";
      $this->tampilkanMenu();
    }
  }

}

new Kasir;
