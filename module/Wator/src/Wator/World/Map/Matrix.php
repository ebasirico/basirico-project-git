<?php
/**
 * Created by PhpStorm.
 * User: Enrico
 * Date: 12/06/2015
 * Time: 16:17
 */
namespace Wator\World\Map;

use Wator\World\Position;

class Matrix
{

    private $w;
    private $h;
    private $matrix;


    /**
     * @param $w
     * @param $h
     * @param null $filler
     * costruttore matematico della nostra matrice di Wator
     * questa classe infatti si occupera' di gestire i numeri
     * soltanto senza conoscerne il significato.
     */
    public function __construct($w, $h, $filler = null)
    {
        $this->w = $w;
        $this->h = $h;

        $matrix = array();
        for ($i = 0; $i < $w; $i++) {
            $matrix[] = array_fill(0, $h, $filler);
        }
        $this->matrix = $matrix;
    }

    /**
     * @param $item
     * @param Position $pos
     * metodo put che si preoccupa di inserire l'$item
     * all'interno della posizione $pos indicata .
     * Viene utilizzata da tutti i metodi di Add del mondo
     * wator.
     */

    public function put($item, Position $pos)
    {
        $this->fixPosition($pos);
        $this->matrix[$pos->getX()][$pos->getY()] = $item;
    }

    /**
     * Recupera l'elemento alla posizione indicata
     *
     * @param Position $pos
     * @return mixed
     */
    public function get(Position $pos)
    {
        $this->fixPosition($pos);
        return $this->matrix[$pos->getX()][$pos->getY()];
    }

    /**
     * ricerca un elemento all'interno della matrice e lo restituisce come posizione
     * @param $item
     * @return Position|null
     */

    public function search($item)
    {

        for ($x = 0; $x < $this->w; $x++) {
            for ($y = 0; $y < $this->h; $y++) {
                if ($this->matrix[$x][$y] === $item) {
                    return new Position($x, $y);
                }
            }
        }
        return null;
    }

    /**
     * @param Position $pos
     * Il metodo fixPosition si occupa di far
     * si che il nostro mondo sia Toroidale.
     */
    public function fixPosition(Position $pos)
    {
        if ($pos->getX() < 0) {
            $pos->setX($this->w + $pos->getX());
        } elseif ($pos->getX() >= $this->w) {
            $pos->setX($pos->getX() - $this->w);
        }

        if ($pos->getY() < 0) {
            $pos->setY($this->h + $pos->getY());
        } elseif ($pos->getY() >= $this->h) {
            $pos->setY($pos->getY() - $this->h);
        }
    }

    /**
     * @return mixed
     */
    public function getWidth()
    {
        return $this->w;
    }

    /**
     * @return mixed
     */
    public function getHeight()
    {
        return $this->h;
    }

    /**
     * @return array
     */
    public function getMatrix()
    {
        return $this->matrix;
    }

}