<?php

namespace App;

use App\Game;

use App\LinkedList\Singly;
use App\Terminal;
use App\World\Land;

include 'vendor/autoload.php';

$game = new Game();
$game->run();

// $terminal = new Terminal();
// $land = new Land(10, 5);
// $list = new Singly();
// $listMap;


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
// $list->append([2, 3, 4]);
// $list->append(3);
// $list->append(4);
// $list->append(5);
// $list->append([2, 3, 4]);
// $list->append([2, 3, 4]);
// $list->append([2, 3, 4]);
// $list->append([2, 3, 4]);
// $list->append([2, 3, 4]);


// var_dump($list->getList());
// var_dump($list->get(2));
// var_dump($list->updateSpecificNode(2, 5));
// var_dump($list->delete(2));
// var_dump($list->getList());
// var_dump($list->deleteLast());
// var_dump($list->getList());

// $listMap = deepClone($list);

// $ctr = 0;
// while ($ctr != 10) {
//   $list = deepClone($listMap);

//   for ($i = 5; $i < mt_rand(6, 9); $i++) {
//     $items = $list->get($i);
//     $items[0] = 1;
//     $list->updateSpecificNode($i, $items);
//   }

//   var_dump(json_encode($list->getList()));
//   var_dump(json_encode($listMap->getList()));
//   usleep(60000);
//   $ctr++;
// }


// while (true) {
//   $input = $terminal->getChar();
//   $land->moveSnake($input);
//   var_dump(json_encode($land->getMap()));
//   usleep(60000);
// }
