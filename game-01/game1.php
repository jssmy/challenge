<?php


function calculate_subset($M=array(),$N)
{
    foreach ($M as $i =>$m)
    {
        foreach ($M as $j=>$n)
        {
            if($j!=$i) echo "$m + $n =".$m+$n."</br>";
            if($m+$n==$N && $i!=$j) return [$m,$n];
        }
    }
}

//$arr=calculate_subset([5,2,8,14,0],10);
//var_dump($arr);


/* versión 2.0 */

function calculate_subset_arr($M=array(),$N)
{
    /* $tmpArr alacena una copia idéntica a $M*/
    $tmpArr=$M;
    /* la matriz $M tiene un conjunto de elemntos enteros [m1,m2,m3,m4,m5...mn] */
    /*  se procede a analizar cada uno de los valores de $M */
    foreach ($M as $index =>$val)
    {
        /* el valor que se analizará debe ser menor o igual a N */
        /* puede darse el caso que el valor ($val) que se analizará
        se repite más de una vez, ejemplo: [5,5],
        así que eliminamos el $val actual
        ejemplo [5], el cual no es el mismo que se analiza ahora
         */
        unset($tmpArr[$index]);
        /*  se debe encontrar $val+$n=$N
        entonces $n=$N-$val;
        averiguar si $n se encuentra en la matriz temporal
         */
        if($val<=$N && in_array($N-$val,$tmpArr))
        {
            return [$val,$N-$val];
        }
    }
}