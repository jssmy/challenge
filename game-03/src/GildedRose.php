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
        /* version 1.0 */
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



        /* se calcula la cantidad días de venta */
        $this->sellIn                   += $this->degradeSellin;

        switch ($this->name){
            case "normal":
                /* para los productos normales */
                /* se calcula la la cantidad en que se degrada la calidad de acuerdo a los dpias de venta */
                /* para este producto si los días de ventas ha pasado la calidad se degrada en dos, de lo contrario
                la calidad se degrada en uno
                 */
                $this->degradeQuality   = $this->sellIn<SELF::MIN_SELLIN?-SELF::DEGRADE_TWO:-SELF::DEGRADE_ONE;
                break;
            case "Aged Brie":
                /* para los productos Aged*/
                /* se calcula la cantidad en que se degrada la calidad de acuerdo a los días de venta */
                /* para este producto si los días de venta ha paso la calidad del producto se incrementa en dos, de lo
                contrario la calidad aumenta en uno
                 */
                $this->degradeQuality   = $this->sellIn<SELF::MIN_SELLIN?SELF::DEGRADE_TWO : SELF::DEGRADE_ONE;
                break;
            case "Sulfuras, Hand of Ragnaros":
                   /*Para los productos Sulfuras
                    * nunca deben ser vendidos y no se degrada su calidad
                    * */
                    $this->sellIn++;
                    $this->degradeQuality= SELF::MIN_QUALITY;
                break;
            case "Backstage passes to a TAFKAL80ETC concert":
                    /* Para los procductos Backstage
                     * si ha pasado los días de venta la calidad se degrada en uno
                     */
                    $this->degradeQuality = $this->sellIn<SELF::MIN_SELLIN?-$this->quality:$this->degradeQuality;
                    /*si los días de ventas está entre el día mínimo y 5 la calidad aumenta en 3*/
                    $this->degradeQuality = ($this->sellIn>=SELF::MIN_SELLIN && $this->sellIn<SELF::DEGRADE_FIVE)?SELF::DEGRADE_THREE:$this->degradeQuality;
                    /* si los días de venta esta entre 5 y 10 la calidad aumenta en 2
                    pero si la cantidad de días es mayo a 10 entonces la calidad aumenta en 1
                    */

                    $this->degradeQuality = ($this->sellIn>SELF::DEGRADE_FIVE && $this->sellIn<SELF::DEGRADE_TEN)?SELF::DEGRADE_TWO: ($this->sellIn>=SELF::DEGRADE_TEN?SELF::DEGRADE_ONE:$this->degradeQuality);
                break;
            case "Conjured Mana Cake":
                /*para el caso de conjured */
                /* si los días de venta ha pasado entonces la calidad se degrada en 4 de lo contrario se degrada en 2 */
                $this->degradeQuality = $this->sellIn<SELF::MIN_SELLIN?-SELF::DEGRADE_FOUR:-SELF::DEGRADE_TWO;
                break;
        }

        /* degradar la calidad */
        $this->quality              += $this->degradeQuality;
        /* verificar que la calidad no sea menor a la calidad mínima*/
        $this->quality              =  $this->quality<SELF::MIN_QUALITY      ?   SELF::MIN_QUALITY:$this->quality;
        /* verificar que la calidad no pase la calidad máxima */
        $this->quality              =  $this->quality>SELF::MAX_QUALITY      ?   SELF::MAX_QUALITY:$this->quality;

    }
}
