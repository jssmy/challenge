<?php

namespace App;

use function Sodium\crypto_aead_aes256gcm_decrypt;

class GildedRose
{
    public $name;

    public $quality;

    public $sellIn;
    public $degradeQuality;
    public $degradeSellin;
    const MAX_QUALITY=50;
    const MIN_QUALITY=0;
    const MIN_SELLIN=0;
    const NOT_DEGRADE=0;
    const DEGRADE_TWO=2;
    const DEGRADE_ONE=1;
    const DEGRADE_FIVE=5;
    const DEGRADE_THREE=3;
    const DEGRADE_TEN =10;
    const DEGRADE_FOUR=4;

    public function __construct($name, $quality, $sellIn)
    {
        $this->name = $name;
        $this->quality = $quality;
        $this->sellIn = $sellIn;
        $this->degradeQuality=-1;
        $this->degradeSellin=-1;
    }

    public static function of($name, $quality, $sellIn) {
        return new static($name, $quality, $sellIn);
    }

    public function tick()
    {
        /*
        if ( !in_array($this->name,['Aged Brie','Backstage passes to a TAFKAL80ETC concert'])) {
            if ($this->quality > 0 && $this->name != 'Sulfuras, Hand of Ragnaros') {
                //$this->degradeQuality=-1;
                  $this->quality = $this->quality - 1;
            }
        } else {
            if ($this->quality < 50) {
                $this->quality = $this->quality + 1;

                if ($this->name == 'Backstage passes to a TAFKAL80ETC concert') {
                    if ($this->sellIn < 11) {
                        if ($this->quality < 50) {
                            $this->quality = $this->quality + 1;
                        }
                    }
                    if ($this->sellIn < 6) {
                        if ($this->quality < 50) {
                            $this->quality = $this->quality + 1;
                        }
                    }
                }
            }
        }

        if ($this->name != 'Sulfuras, Hand of Ragnaros') {
            $this->sellIn = $this->sellIn - 1;
        }

        if ($this->sellIn < 0) {
            if ($this->name != 'Aged Brie') {
                if ($this->name != 'Backstage passes to a TAFKAL80ETC concert') {
                    if ($this->quality > 0) {
                        if ($this->name != 'Sulfuras, Hand of Ragnaros') {
                            $this->quality = $this->quality - 1;
                        }
                    }
                } else {
                    $this->quality = $this->quality - $this->quality;
                }
            } else {
                if ($this->quality < 50) {
                    $this->quality = $this->quality + 1;
                }
            }
        }
*/


        /* reducir el día */
        $this->sellIn                   += $this->degradeSellin;
        switch ($this->name){
            case "normal":
                $this->degradeQuality   = $this->sellIn<SELF::MIN_SELLIN?-SELF::DEGRADE_TWO:-SELF::DEGRADE_ONE;
                break;
            case "Aged Brie":
                $this->degradeQuality   = $this->sellIn<SELF::MIN_SELLIN?self::DEGRADE_TWO:SELF::DEGRADE_ONE;
                break;
            case "Sulfuras, Hand of Ragnaros":
                    $this->sellIn++;
                    $this->degradeQuality= SELF::MIN_QUALITY;
                break;
            case "Backstage passes to a TAFKAL80ETC concert":
                    /* verificar que nopo haya pasado de la fecha, el degrade deberpia ser la misma cantidad de
                    la calidad para que el resultado de la calidad sea 0
                    */
                    $this->degradeQuality = $this->sellIn<SELF::MIN_SELLIN?-$this->quality:$this->degradeQuality;
                    $this->degradeQuality = ($this->sellIn>=SELF::MIN_QUALITY && $this->sellIn<SELF::DEGRADE_FIVE)?SELF::DEGRADE_THREE:$this->degradeQuality;
                    $this->degradeQuality = ($this->sellIn>SELF::DEGRADE_FIVE && $this->sellIn<SELF::DEGRADE_TEN)?SELF::DEGRADE_TWO: ($this->sellIn>=SELF::DEGRADE_TEN?SELF::DEGRADE_ONE:$this->degradeQuality);
                break;
            case "Conjured Mana Cake":
                $this->degradeQuality = $this->sellIn<SELF::MIN_SELLIN?-SELF::DEGRADE_FOUR:-SELF::DEGRADE_TWO;
                break;
        }

        $this->quality              += $this->degradeQuality;
        $this->quality              =  $this->quality<SELF::MIN_QUALITY      ?   SELF::MIN_QUALITY:$this->quality;
        $this->quality              =  $this->quality>SELF::MAX_QUALITY      ?   SELF::MAX_QUALITY:$this->quality;

    }
}
