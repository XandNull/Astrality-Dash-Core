<?php
/*
	QUESTS
*/
//NOW SET IN THE QUESTS TABLE IN THE MYSQL DATABASE
/*
	REWARDS
*/
//SMALL CHEST
$chest1minOrbs = 500;
$chest1maxOrbs = 1000;
$chest1minDiamonds = 25;
$chest1maxDiamonds = 60;
$chest1minShards = 1;
$chest1maxShards = 6;
$chest1minKeys = 1;
$chest1maxKeys = 6;
//BIG CHEST
$chest2minOrbs = 2000;
$chest2maxOrbs = 3000;
$chest2minDiamonds = 50;
$chest2maxDiamonds = 120;
$chest2minShards = 1;
$chest2maxShards = 6; // THIS VARIABLE IS NAMED IMPROPERLY, A MORE ACCURATE NAME WOULD BE $chest2minItemID AND $chest2maxItemID, BUT I DON'T WANT TO RENAME THIS FOR COMPATIBILITY REASONS... IF YOU'RE GETTING A BLANK CUBE IN YOUR DAILY CHESTS, YOU SET THIS TOO HIGH
$chest2minKeys = 1;
$chest2maxKeys = 6;
//REWARD TIMES (in seconds)
$chest1wait = 1800;
$chest2wait = 7200;
?>