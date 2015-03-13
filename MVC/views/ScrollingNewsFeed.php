<?php
/**
 * Created by PhpStorm.
 * User: aosiname
 * Date: 04/03/2015
 * Time: 11:52
 */

function NewsToHTML(array $news){
  $html = '<div class="fan-wrap vticker">';
  $html .= "<ul>";

  if(count($news) > 0) {
    foreach($news as $n) {
      // had to overload constructor for HENews for this bit
      // as I wanted to define type of $n to auto activate intellisense later
      // currently in PHP, cannot use generics to specify data type for array
      //$n = new HENews();

      $html .= '<li class="fan-item alert-info well span12">';
      $html .= sprintf('<div class="forum-as-news fan-title span8">%s</div>', StringToHtmlLink($n->getTitle(), $n->getLink()));
      $html .= sprintf('<div class="forum-as-news fan-posted span4">%s</div>', $n->getPostedFormatted("D, jS F Y [h:i]"));

      $html .= sprintf('<div class="forum-as-news fan-body span12">%s</div>', $n->getBodyLimit(150));
      $html .= sprintf('<div class="forum-as-news fan-news span12">%s</div>', StringToHtmlButtonLink("full story &raquo;", $n->getLink()));
      $html .= "</li>";
    }
  }
  else {
    $html = "No news item feeds were found.";
  }

  $html .= '</ul>';
  $html .= '</div>';

  $html .= '<div class="text-center fan-controls">';

  $html .= StringToHtmlButtonControl("&laquo;", "btnDown");
  $html .= StringToHtmlButtonControl("Play/Pause", "btnToggle");
  $html .= StringToHtmlButtonControl("&raquo;", "btnUp");

  $html .= '</div>';

  return $html;
}
?>
im
<div class="fan-wrap vticker">
  <ul>
    <?php foreach($news as $n): ?>
      <li class="fan-item alert-info well span12">
        <div class="forum-as-news fan-title span8"><a href="<?php print $n->getLink(); ?>"><?php print $n->getTitle(); ?></a></div>
        <div class="forum-as-news fan-posted span4"><?php print $n->getPostedFormatted("D, jS F Y [h:i]"); ?></div>
        <div class="forum-as-news fan-body span12"><?php print $n->getBodyLimit(150); ?></div>
        <div class="forum-as-news fan-news span12"><a href="<?php print $n->getLink(); ?>" class="btn btn-info btnDown">full story &raquo;</a></div>
      </li>
    <?php endforeach; ?>
  </ul>
</div>

<div class="text-center fan-controls">
  <a href="#" class="btn btn-info btnDown">&laquo;</a>
  <a href="#" class="btn btn-info btnToggle">Play/Pause</a>
  <a href="#" class="btn btn-info btnUp">&raquo;</a>
</div>



