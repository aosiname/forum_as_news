<?php
/**
 * Created by PhpStorm.
 * User: aosiname
 * Date: 04/03/2015
 * Time: 10:53
 */

require_once("INewsCollection.php");
require_once("HENews.php");

class MoodleForumNewsCollection implements INewsCollection {

  protected $forumID;
  protected $order;
  protected $orderDirection;
  protected $limit;

  public function __construct() {
    $this->forumID = FAN_ForumID;
    $this->order = FAN_Order;
    $this->orderDirection = FAN_OrderDirection;
    $this->limit = FAN_Limit;
  }

  function getNewsCollection() {

    // CONCAT('/mod/forum/discuss.php?d=', d.id) AS link,
    // query fails if you use above because of the ? in the string so will build the link later
    global $DB;

    $sql = sprintf("
      SELECT
        d.name AS title,
        p.message AS body,
        d.id AS id,
        p.created AS posted,
        count(p.parent) - 1 AS comments
      FROM mdl_forum_discussions d
      INNER JOIN mdl_forum_posts p ON p.discussion = d.id
      WHERE d.forum = %d
      GROUP BY p.discussion
      ORDER BY %s %s
      LIMIT %d", $this->forumID, $this->order, $this->orderDirection, $this->limit);

    $posts = $DB->get_records_sql($sql);

    $newsCollection = array();
    foreach ($posts as $p) {
      $n = new HENews($p->title, $p->body, $this->formatMoodleForumIDToLink($p->id), $p->posted, $p->comments);
      $newsCollection[]= $n;
    }
    return $newsCollection;
  }

  private function formatMoodleForumIDToLink($id) {
    // this is how to get to a moodle forum post
    return sprintf("/mod/forum/discuss.php?d=%s", $id);
  }

  /**
   * @return mixed
   */
  public function getForumID() {
    return $this->forumID;
  }

  /**
   * @param mixed $forumID
   */
  public function setForumID($forumID) {
    $this->forumID = $forumID;
  }

  /**
   * @return mixed
   */
  public function getOrder() {
    return $this->order;
  }

  /**
   * @param mixed $order
   */
  public function setOrder($order) {
    $this->order = $order;
  }

  /**
   * @return mixed
   */
  public function getOrderDirection() {
    return $this->orderDirection;
  }

  /**
   * @param mixed $orderDirection
   */
  public function setOrderDirection($orderDirection) {
    $this->orderDirection = $orderDirection;
  }

  /**
   * @return mixed
   */
  public function getLimit() {
    return $this->limit;
  }

  /**
   * @param mixed $limit
   */
  public function setLimit($limit) {
    $this->limit = $limit;
  }
}