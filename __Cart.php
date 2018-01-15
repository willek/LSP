<?php

/**
 * =================== Interface
 * Sebuah interface yang digunakan untuk menangani sebuah Cart (keranjang)
 */
interface __Cart
{
    public function addToCart($kode, $total);
    public function printCart();
}
