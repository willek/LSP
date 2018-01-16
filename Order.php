<?php
require "__Cart.php";

/**
 * =========================== Inheritance (Item)
 * =========================== Polimorphy (__Cart)
 * Berfungsi untuk menangani dan menyimpan order
 */
class Order extends Item implements __Cart
{
    public $transaction;
    public $pay;

    public $item;

    /**
     * Konstruktor
     */
    public function __construct()
    {
        $this->item = new Item;
    }

    /**
     * ======================== Overloading methods
     * @param $name
     * @param $arguments
     */
    public function __call($name, $arguments)
    {
        switch ($name):
            case 'emptyCart':
                    $this->transaction = [];
                    $this->pay = 0;
                    break;
        endswitch;
    }

    public function stockAvailable($kode, $total)
    {
        foreach ($this->item->list as $key => $item) {
            if ($item['kode'] == $kode) {
                if ($item['jumlah'] < $total && ($item['jumlah'] != 0)) {
                    echo "Stok minimal : " . $item['jumlah'] . " || Data tidak disimpan..\n";
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Menambah barang ke variabel $transaction
     * @param $kode
     * @param $total
     */
    public function addToCart($kode, $total)
    {
        /**
         * ====================== Exception Handling
         */
        try{
            foreach ($this->item->list as $key => $item){
                if($item['kode'] == $kode){
                    $newOrder = [
                        'kode' => $item['kode'],
                        'nama' => $item['nama'],
                        'jumlah' => $total,
                        'harga' => $total * $item['harga']
                    ];
                    $this->transaction[] = $newOrder;
                    $this->pay += $newOrder['harga'];
                }
            }
        } catch (Exception $e){
            die($e->getMessage());
        }
    }

    /**
     * Mengupdate stok dari item di database (file .json)
     */
    public function updateCart()
    {
        try{
            foreach ($this->item->list as $key => $item) {
                foreach ($this->transaction as $transaction){
                    if($item['kode'] == $transaction['kode']){
                        $this->item->list[$key]['jumlah'] -= $transaction['jumlah'];
                        $this->item->edit();
                    }
                }
            }
        } catch (Exception $e){
            die($e->getMessage());
        }
    }

    /**
     * Print nota pembelian
     */
    public function printCart()
    {
        echo "================ NOTA ==================\n";
        foreach ($this->transaction as $key => $item){
            echo $item['kode'] . "\t" . $item['nama'] . "\t" . $item['jumlah'] . "\t" . $item['harga'] . "\n";
        }
        echo "========================================\n";
        echo "Total Pembayaran : \t\t" . $this->pay . "\n";
        $this->transaction = []; //
    }
}
