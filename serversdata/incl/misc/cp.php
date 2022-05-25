<?php
include "../../incl/lib/connection.php";
$query = $db->prepare("UPDATE users 
SET creatorPoints = (
     SELECT COUNT(*)
     FROM levels 
     WHERE levels.userID = users.userID AND starStars != 0
) + (
     SELECT COUNT(*)
     FROM levels 
     WHERE levels.userID = users.userID AND levels.starFeatured != 0 AND levels.starEpic = 0 
) + (
    SELECT COUNT(*)
    FROM levels 
    WHERE levels.userID = users.userID AND levels.starEpic = 1 AND levels.starFeatured = 0
) + (
    SELECT COUNT(*)
    FROM levels 
    WHERE levels.userID = users.userID AND levels.starEpic = 1 AND levels.starFeatured = 0
) + (
    SELECT COUNT(*)
    FROM levels 
    WHERE levels.userID = users.userID AND levels.starEpic = 1 AND levels.starFeatured = 1
) + (
     SELECT COUNT(*)
     FROM levels 
     WHERE levels.userID = users.userID AND levels.starEpic = 1 AND levels.starFeatured = 1
)");
$query->execute();
?>