<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 02.03.2018
 * Time: 13:17
 */

namespace Classes\Cdcl\Db;


/**
 *
 * Class Csv
 * @package Classes\Cdcl\Db
 * Exportation des données de manière automatique
 * avec en entrée $data de type array() et $filename qui est un string pour le nomn du fichier
 *
 * @refs : https://www.grafikart.fr/tutoriels/php/php-excel-csv-151
 *
 */
class CSV {
    static function exportCsv($data, $filename)
    {
        header('Content-Type: text/csv;');
        header('Content-Disposition: attachment; filename="'.$filename.'.csv"');
        $i=0;
        foreach($data as $v){
            if($i==0){
                echo '"'.implode('";"',array_keys($v)).'"'."\n";
            }
            echo '"'.implode('";"',$v).'"'."\n";
            $i++;
        }
    }

}