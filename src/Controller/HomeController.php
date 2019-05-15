<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\ObjectManager;
use App\Model\PlayerManager;
use App\Service\Player;
use App\Service\Map;
use App\Service\CellContent;
use http\Header;

class HomeController extends AbstractController
{

    private $class = [
        ['id' => 1, 'name' => 'Les Caïds', 'picture' => '/assets/images/caid.png',
            'description' => 'Mi-ours, mi-scorpion et re-mi-ours derrière', 'bonus' => 'Force : + 2',
            'malus' => 'Intelligence : -20'],
        ['id' => 2, 'name' => 'Les Intellos', 'picture' => '/assets/images/intello.png',
            'description' => 'Chouchou de la maitresse', 'bonus' => 'Dextérité : + 2', 'malus' => 'Courage : -15'],
        ['id' => 3, 'name' => 'Les Sportifs', 'picture' => '/assets/images/sportif.png',
            'description' => 'Foooooot , du foot, du foot , du foot !', 'bonus' => 'déplacement : + 1',
            'malus' => 'Micro pénis'],
        ['id' => 4, 'name' => 'Les Végans', 'picture' => '/assets/images/vegan.png',
            'description' => 'Je suis pas gros. je suis jovial et épanoui !', 'bonus' => 'Santé : + 20',
            'malus' => 'Charisme : -50']
    ];

    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {

        /*$test = new CellContent(4, 1);
        $test->action();*/

        return $this->twig->render('Home/index.html.twig');
    }

    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function eggs()
    {
        $array = ['bully.gif','sylv1.JPG', 'sadako.JPG', 'vincent.JPG',
            'milk.gif', 'milk2.gif', 'hack.JPG', 'lapin.gif', 'sylvain.JPG', 'hell.JPG'];
        $key= array_rand($array);

        return $this->twig->render('Home/eggs.html.twig', ['picture' => $array[$key]]);
    }

    public function config()
    {

        $truncatePlayer = new PlayerManager();
        $truncatePlayer->truncate();

        $truncateBags = new ObjectManager();
        $truncateBags->truncate();

        $map = new Map(12, 12, 3, 6, 4, 3);
        $map->generator();
        return $this->twig->render('Home/config.html.twig', ['classes' => $this->class]);
    }

    public function player1($kind)
    {
        $classSelected = ['caid', 'intello', 'sportif', 'vegan'];

        $player1 = new Player(1);
        $player1->init($classSelected[$kind - 1], 1, 1);
        return $this->twig->render('Home/config.html.twig', ['classes' => $this->class,
            'secondChoice' => true, 'player1' => $player1]);
    }

    public function player2($kind)
    {
        $classSelected = ['caid', 'intello', 'sportif', 'vegan'];

        $player2 = new Player(2);
        $player2->init($classSelected[$kind - 1], 12, 12);
        header('Location: ../../Map/index');
    }

    public function win()
    {
        return $this->twig->render('Home/win.html.twig');
    }
}
