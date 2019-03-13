<?php
# Deterministic random generator
# http://www.sitepoint.com/php-random-number-generator/
# Modified to support negative seed (using the + 9999999/2
# changes the range from -4999999..4999999)

class Random {

  private static $RSeed;

  public static function seed($s = 0) {
    self::$RSeed = abs(intval($s + 9999999/2)) % 9999999 + 1;
  }

  public static function num($min = 0, $max = 9999999) {
    self::$RSeed = (self::$RSeed * 125) % 2796203;
    return self::$RSeed % ($max - $min + 1) + $min;
  }

}
?>
