<?php

namespace App;

use App\Game;

use App\LinkedList\Singly;
use App\Terminal;

include 'vendor/autoload.php';

$game = new Game();
$game->run();

// $terminal = new Terminal();
// $list = new Singly();


// var_dump($terminal->getHeight());

// for ($i = 0; $i < $terminal->getHeight(); ++$i) {
//   // var_dump(array_fill(0, $terminal->getWidth(), ' '));
//   // die();
//   $list->append(array_fill(0, $terminal->getWidth(), ' '));
// }



// $cols = $list->get(2);
// $cols[2] = "2551";
// $list->updateSpecificNode(2, $cols);
// var_dump($list->get(41));
// var_dump($list->delete(41));
// var_dump(count($list->getList()));
// $list->append(1);
// $list->append(2);
// $list->append(3);
// $list->append(4);


// var_dump($list->getList());
// var_dump($list->get(2));
// var_dump($list->updateSpecificNode(2, 5));
// var_dump($list->delete(2));
// var_dump($list->getList());
// var_dump($list->deleteLast());
// var_dump($list->getList());
