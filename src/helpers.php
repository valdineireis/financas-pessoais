<?php 

function dateParse($date) 
{
    //DD/MM/YYYY -> YYYY-MM-DD
    $dateArray = explode('/', $date);
    //[ dd, mm, yyyy]
    $dateArray = array_reverse($dateArray);
    //[ yyyy, mm, dd]
    return implode('-', $dateArray);
}

/**
 * Tenta formatar uma string (DD/MM/YYYY) em um tipo date (YYYY-MM-DD)
 * @param  [type] $date Data
 * @return DateTime
 */
function dateTryParse($date)
{
    $date = isset($date) && !empty($date) ? 
        $date : new \DateTime();

    if (!($date instanceof \DateTime)) 
        $date = \DateTime::createFromFormat('d/m/Y', $date);

    if ($date === false)
        throw new \Exception();

    return $date->format('Y-m-d');
}

function numberParse($number) 
{
    //1.000,50 -> 1000.50
    $newNumber = str_replace('.', '', $number);
    $newNumber = str_replace(',', '.', $newNumber);
    return $newNumber;
}
