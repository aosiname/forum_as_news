<?php
/**
 * Created by PhpStorm.
 * User: aosiname
 * Date: 03/03/2015
 * Time: 10:41
 */

//require_once("FANComment.php");

class HENews {
  protected $title;
  protected $body;
  protected $link;
  protected $posted;
  protected $comments;

  /*function __construct() {

  }*/

  // load default empty values as cannot overload constructor in PHP...yet
  function __construct($ttl, $bdy , $lnk, $pst, $cmt) {
    $this->title = $ttl;
    $this->body = $bdy;
    $this->link = $lnk;
    $this->posted = $pst;
    $this->comments = $cmt;
  }

  /**
   * @return string
   */
  public function getPosted() {
    return $this->posted;
  }

  public function getComments() {
    return $this->comments;
  }

  public function setComments($c) {
    $this->comments = $c;
  }

  /**
   * @param $format must be an acceptable PHP date format
   * @return string
   */
  public function getPostedFormatted($format) {
    return date($format, $this->posted);
  }

  /**
   * @param string $posted
   */
  public function setPosted($posted) {
    $this->posted = $posted;
  }

  /**
   * @return mixed
   */
  public function getTitle() {
    return $this->title;
  }

  /**
   * @param mixed $title
   */
  public function setTitle($title) {
    $this->title = $title;
  }

  /**
   * @return mixed
   */
  public function getBody() {
    return $this->body;
  }

  public function getBodyLimit($limit = 180) {
    $htmlLessBody = strip_tags($this->body);
    if(strlen($this->body) > $limit) {
      return substr($htmlLessBody, 0, $limit) . "...";
    }
    return $htmlLessBody . "....";
  }

  /**
   * @param mixed $body
   */
  public function setBody($body) {
    $this->body = $body;
  }

  /**
   * @return mixed
   */
  public function getLink() {
    return $this->link;
  }

  /**
   * @param mixed $link
   */
  public function setLink($link) {
    $this->link = $link;
  }
}