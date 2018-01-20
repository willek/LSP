<?php

Class Input {

  // error handling

  // fungsi yang hanya memperbolehkan angka sebagai inputan
  public static function angka($masukan) {
    if (preg_match('/^[0-9]{1,}/', $masukan)) {
      return $masukan;
    } else {
      die("Hanya angka yang diperbolehkan\n");
    }
  }

  // fungsi yang hanya memperbolehkan huruf sebagai inputan
  public static function huruf($masukan) {
    if (preg_match('/^[A-Za-z]{1,}/', $masukan)) {
      return $masukan;
    } else {
      die("Hanya huruf yang diperbolehkan\n");
    }
  }

}
