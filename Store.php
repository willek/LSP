<?php

require "Item.php";
require "Order.php";
require "__Input.php";

class Store
{
    protected $order;

    /**
     * Konstruktor
     */
    public function __construct()
    {
        $this->order = new Order;
        $this->mainMenu();
    }

    /**
     * Menampilkan pilihan menu utama
     */
    public function mainMenu()
    {
        echo "\n===============KASIR===============\n";
        echo "1. Tambah Barang\n";
        echo "2. Penjualan\n";
        echo "3. Lihat Stok Barang\n";
        echo "Pilihan Anda : ";
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

    /**
     * Bila pengguna memilih 1, maka akan memproses penambahan stok item
     */
    private function addItem(){
        echo "Masukkan Kode : ";
        $code = trim(fgets(STDIN));

        // Kalau kodenya ditemukan di database, maka stok bertambah
        if($this->order->item->search($code)){
            echo "Masukkan Jumlah : ";
            $qty = __Input::integer(trim(fgets(STDIN)));
            $price = '';
            $name = '';
        } else {
            echo "Masukkan Nama Barang : ";
            $name = __Input::string(trim(fgets(STDIN)));
            echo "Masukkan Harga : ";
            $price = __Input::integer(trim(fgets(STDIN)));
            echo "Masukkan Jumlah : ";
            $qty = __Input::integer(trim(fgets(STDIN)));
        }

        $this->order->item->add($code, $name, $qty, $price);

        echo "Ada lagi ? (Y/N)";
        $choose = trim(fgets(STDIN));
        switch ($choose){
            case 'y':
            case 'Y':
                $this->addItem();
                break;
            case 'n':
            case 'N':
                $this->mainMenu();
                break;
            default:
                echo "Pilihan tidak ditemukan!\n";
                $this->mainMenu();
                break;
        }
    }

    /**
     * Bila pengguna memilih 2, maka akan memproses belanja
     */
    private function shopping(){
        echo "Masukkan Kode : ";
        $code = trim(fgets(STDIN));

        // Kalau kodenya tidak ditemukan saat belanja, maka tidak bisa membeli barang
        if($this->order->item->search($code)){
            echo "Masukkan Jumlah : ";
            $qty = __Input::integer(trim(fgets(STDIN)));

            // Kalau stoknya ada, barang bisa dibeli
            if($this->order->stockAvailable($code, $qty)){
                $this->order->addToCart($code, $qty);

                echo "Ada lagi ? (Y/N)";
                $choose = trim(fgets(STDIN));
                switch ($choose){
                    case 'y':
                    case 'Y':
                        $this->shopping();
                        break;
                    case 'n':
                    case 'N':
                        $this->order->updateCart();
                        $this->order->printCart();
                        $this->order->emptyCart(); // Memanggil overloading methods
                        $this->mainMenu();
                        break;
                    default:
                        echo "Pilihan tidak ditemukan!\n";
                        $this->mainMenu();
                        break;
                }
            } else {
                $this->mainMenu();
            }

        } else {
            echo "Barang tidak ditemukan!\n";
            $this->mainMenu();
        }
    }

    /**
     * Bila pengguna memilih 3, maka akan melihat daftar stok
     */
    private function catalog(){
        $this->order->item->sort($this->order->item->list, "kode");
        foreach ($this->order->item->list as $item){
            echo $item['kode'] . "\t" . $item['nama'] . "\t" . $item['jumlah'] . "\t" . $item['harga'] . "\n";
        }
        echo "===================================\n";
    }
}

new Store();
