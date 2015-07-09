<?php
/**
 * Created by PhpStorm.
 * User: Enrico
 * Date: 10/06/2015
 * Time: 11:55
 */

namespace Wator\Controller;


use Wator\Render\PngRender;
use Wator\Render\PngRenderX4;
use Wator\Wator;
use Zend\Http\Response\Stream;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;


class WatorController  extends AbstractActionController  {


    /**
     * @return Container
     */
    private function getSession() {
        $session = new Container('wator');
        return $session ;
    }

    /**
     * Cancella tutto il mondo di wator e si prepara ad avviarne uno nuovo
     */
    private function initSession() {
        $session = $this->getSession();
        $session->chronons = 0 ;
        $session->wator = null ;
    }

    public function indexAction() {

    }

    /**
     * @return Stream
     * mapAction fornisce uno stream dell'immagine
     * creata dal PngRender e cambia ogni volta che
     * la mappa si aggiorna.
     */
    public function mapAction() {

        $session = $this->getSession();
        /** @var Wator $wator */
        $wator =  $session->wator ;
        $wator->updateWorld();

        $render = new PngRenderX4($wator);

        $filePng = $render->getPngFile($wator);

        $response = new Stream();
        $response->getHeaders()->addHeaders(array(
            'Content-type' => 'image/jpg'
        ));
        $response->setStream(fopen('/tmp/map.png', 'r'));

        return $response;
    }



    /**
     * Crea un nuovo mondo wator
     */
    public function createAction() {

        $this->initSession();
        $session = $this->getSession();

        $width = 35;
        $height = 35;

        $wator = new Wator($width,$height);
        $session->wator = $wator ;
    }

    /**
     * Fa passare un giorno nel mondo di wator
     */
    public function showAction() {
        $session = $this->getSession();
        /** @var Wator $wator */
        $wator =  $session->wator ;

        return new ViewModel(array(
            'cronono' => $session->chronons
        ));
    }

}