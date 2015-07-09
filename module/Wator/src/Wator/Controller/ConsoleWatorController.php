<?php
/**
 * Created by PhpStorm.
 * User: Enrico
 * Date: 17/06/2015
 * Time: 12:47
 */

namespace Wator\Controller;

use Wator\Render\ConsoleRender;
use Wator\Render\InteractiveConsoleRender;
use Wator\Render\MonitorConsoleRender;
use Wator\Wator;
use Zend\Mvc\Controller\AbstractConsoleController;
use Zend\View\Model\ViewModel;
use Wator\HS\Wator as VariantWator;
use Zend\Console\Request as ConsoleRequest;

class ConsoleWatorController  extends AbstractConsoleController {

    public function indexAction(){
        return new ViewModel();
    }

    public function monitorAction() {
        $width  = $this->params()->fromRoute('w',100);
        $height = $this->params()->fromRoute('h',100);

        $wator = new VariantWator($width,$height);
        $render = new MonitorConsoleRender($wator,$this->getConsole());

        while(true){
            $render->render();
            $render->consoleUpdate();

        }
    }


    /**
     * Render Stile Log .
     */

    public function logAction(){

        $console = $this->getConsole();
        $request = $this->getRequest();

        if (!$request instanceof ConsoleRequest){
            throw new \RuntimeException('You can only use this action from a console!');
        }

        $width  = $this->params()->fromRoute('w',100);
        $height = $this->params()->fromRoute('h',100);

        $wator = new Wator($width,$height);

        $render = new ConsoleRender($wator,$console);

        while(true){
            $render->getConsoleWrite($wator->getChronons(),$wator);
            $wator->updateWorld();
        }
    }

    /**
     * Render Interattivo con Monitor .
     */
    public function interactiveAction()
    {

        $console = $this->getConsole();

        $width  = $this->params()->fromRoute('w',100);
        $height = $this->params()->fromRoute('h',100);

        $wator = new Wator($width, $height);

        $render = new InteractiveConsoleRender($wator, $console);

        while (true) {
            $render->getConsoleWrite($wator->getChronons(), $wator);
            $wator->updateWorld();
        }
    }

}