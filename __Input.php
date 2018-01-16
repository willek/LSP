<?php

/**
 * =================== Class & Static Method
 * Sebuah class untuk menangani error handling dari inputan (type inputan)
 */
class __Input {

    public static function integer($masukan)
    {
        if(is_numeric($masukan)){
            return $masukan;
        } else {
            throw new Exception("Masukan harus berupa angka!");
        }
    }

    public static function string($masukan)
    {
        if(is_string($masukan)){
            return $masukan;
        } else {
            throw new Exception("Masukan harus berupa huruf (bukan angka)!");
        }
    }

    public static function in($masukan, $list)
    {
        if(in_array($masukan, $list)) {
            return $masukan;
        } else {
            throw new Exception("Masukan ". $masukan ." tidak ada di pilihan!");
        }
    }

}
