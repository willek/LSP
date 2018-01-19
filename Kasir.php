<?php

// require = packages/namespace
// digunakan untuk membaca file / package
require 'Barang.php';
require 'Penjualan.php';
require 'Input.php';
require '__Main.php';

Class Kasir implements __Main {

  // property yang dimiliki oleh kasir
  protected $barang;
  protected $penjualan;

  public function __construct() {
    // membuat object ($this->barang, $this->pesanan)
    $this->barang = new Barang;
    $this->penjualan = new Penjualan;
    // menggunakan $this untuk memanggil method tampilkanMenu()
    $this->tampilkanMenu();
  }

  // Fungsi / Method
  public function tampilkanMenu() {
    $this->barang->ambilData();
    echo "\n";
    echo "=============== Kasir ===============\n";
    echo "Pilih Menu: \n";
    echo "  1. Daftar Barang\n";
    echo "  2. Tambah Barang\n";
    echo "  3. Penjualan\n";
    // echo "  4. Hapus Barang\n";
    // echo "  5. Kosongkan Daftar Barang\n";
    // echo "  6. Keluar\n";
    echo "=====================================\n";
    $this->pilihMenu();
  }

  // Method untuk memilih menu
  public function pilihMenu() {
    echo "Masukkan pilihan anda (1 - 3): ";
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
      case '3':
        $this->daftarBarang();
        $this->penjualanBarang();
        break;
      // case '4' :
      //   $this->daftarBarang();
      //   $this->hapusBarang();
      //   break;
      // case '5':
      //   $this->kosongkanBarang();
      //   break;
      // case '6':
      //   $this->keluar();
      //   break;

      // jika pengguna memilih pilihan yang tidak ada.
      default:
        echo "Pilihan tidak ditemukan!\n";
        $this->pilihMenu();
        break;
    }
  }

  // method untuk menampilkan daftar barang
  private function daftarBarang() {
    // mengambil data daftar barang dan mensortirnya
    $daftar_barang = $this->barang->daftar_barang;
    $this->barang->sortir($daftar_barang, 'kode_barang');

    echo "=========== Daftar Barang ===========\n";
    echo "Kode\tNama\t\tJumlah\tHarga\n";
    echo "-------------------------------------\n";
    // jika daftar barang lebih dari 0 maka akan dilakukan perulangan untuk menampilkan daftar barang
    if (count($daftar_barang) > 0) {
      foreach ($daftar_barang as $barang) {
        echo $barang['kode_barang']."\t".$barang['nama_barang']."\t\t".$barang['jumlah_barang']."\t".$barang['harga_barang']."\n";
      }

    // jika daftar barang  kosong
    } else {
      echo "\tData Masih Kosong\n";
    }
    echo "=====================================\n";
  }

  // method untuk menambah daftar barang
  private function tambahBarang() {
    echo "=========== Tambah Barang ===========\n";
    echo "Kode Barang: ";
    $kode_barang = trim(fgets(STDIN));

    // mengecek barang dengan kode barang dan jika ditemukan, maka hanya akan menambah stok / jumlah barang
    if ($this->barang->cari($kode_barang)) {
      echo "Jumlah Barang: ";
      $jumlah_barang = Input::angka(trim(fgets(STDIN)));
      $harga_barang = '';
      $nama_barang = '';
    // jika kode barang tidak ada / tidak ditemukan, maka akan menambah barang baru
    } else {
      echo "Nama Barang: ";
      $nama_barang = Input::huruf(trim(fgets(STDIN)));
      echo "Harga Barang: ";
      $harga_barang = Input::huruf(trim(fgets(STDIN)));
      echo "Jumlah Barang: ";
      $jumlah_barang = Input::huruf(trim(fgets(STDIN)));
    }

    // lalu menambah barang melalui object barang yang terbuat dari class barang
    $this->barang->tambahData($kode_barang, $nama_barang, $jumlah_barang, $harga_barang);

    // menampilkan pilihan jika ingin menambah barang lagi
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

  // method untuk menghapus barang berdasarkan kode barang
  private function hapusBarang() {
    echo "=========== Hapus Barang ============\n";
    echo "Kode Barang: ";
    $kode_barang = trim(fgets(STDIN));
    $this->barang->hapusData($kode_barang);
    $this->tampilkanMenu();
  }

  // method untuk meng-kosongkan semua data barang
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

  // method untuk melakukan transaksi / penjualan barang
  private function penjualanBarang() {
    echo "============= Penjualan =============\n";
    echo "Kode Barang: ";
    $kode_barang = trim(fgets(STDIN));
    // jika kode barang ditemukan, maka akan ditampilkan berapa barang yang ingin dipesan
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
    // jika barang tidak ditemukan
    } else {
      echo "Barang dengan kode $kode_barang tidak ditemukan.\n";
      $this->tampilkanMenu();
    }
  }

  // method untuk keluar program
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
