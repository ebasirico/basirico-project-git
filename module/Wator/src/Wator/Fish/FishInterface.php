<?php
/**
 * Created by PhpStorm.
 * User: Enrico
 * Date: 11/06/2015
 * Time: 12:35
 */

namespace Wator\Fish;


interface FishInterface
{

    /**
     * @return integer  Valore della vita del fish in questione.
     */
    public function getHealth();

    /**
     * @return array di Fish o array null
     */
    public function getChildren() ;

    /**
     * setta la vita del pesce
     * @param $health
     */
    public function setHealth($health);

    /**
     * @return string specie.
     */
    public function getSpecies();
}