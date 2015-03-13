<?php
/**
 * Created by PhpStorm.
 * User: aosiname
 * Date: 04/03/2015
 * Time: 11:01
 */

require_once("NewsCollection.php");
require_once("HENews.php");

class TestNewsCollection implements NewsCollection {

  public function __construct() {

  }

  // items to return?
  // snippet length
  // break on word?
  // add ...
  function getNewsCollection() {

    $newsCollection = array();

    for($i = 0; $i < 5; $i++) {
      $lorem = "Lorem ipsum dolor ";
      $rand = rand(0, 20);
      $n = new HENews("Title $i", $lorem, "/", "1425375709", $rand);


      $newsCollection[]= $n;
    }

    return $newsCollection;
  }
}