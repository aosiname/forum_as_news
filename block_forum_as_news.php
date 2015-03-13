<?php

/*how odd... doing this up here breaks page /admin/blocks.php*/
// require_once("settings.php");

require_once("MoodleForumNewsCollection.php");
require_once("TestNewsCollection.php");

class block_forum_as_news extends block_base {

    /**
     * @throws coding_exception
     */
    public function init() {

        global $PAGE;
		global $USER;
        //global $CFG;

        $this->page = $PAGE;
		$this->user = $USER;

        // get file name
        $fileName = basename(__FILE__);
		$p1 = substr($fileName, 0, strpos($fileName, ".")); // remove.php to= block_generic_block
		$p2 = substr($p1, 6); // remove "block_" to= generic_block
		$this->p2 = $p2; // use this to later load js file
        $this->title = "HE News";//get_string($p2, $p1);
    }
    
    public function get_content() {

        $p2 = $this->p2;
        $this->page->requires->jquery();
        $this->page->requires->js("/blocks/$p2/js/jquery.easing.min.js");
        $this->page->requires->js("/blocks/$p2/js/jquery.easy-ticker.min.js");
        $this->page->requires->js("/blocks/$p2/js/scripts.js");

        if ($this->content !== null) {
          return $this->content;
        }
        
        $this->content =  new stdClass();

        require_once("settings.php"); // why cant i put this up line top!?

        if(get_user_roles_in_course($this->user->id, FAN_CourseID)) {
            $this->content->text = getNewsCollection();
            //$this->content->footer = '&copy; TMC IT Services 2014 - ' . date('Y');
            //$this->content->text .= "<p>EXISTING</p>" . FAN_ContextID . " " . $this->user->id;
            return $this->content; 
        }
        else {
            #AutoEnrolment
            // should they be allowed to see the forums?.
            if(AccessAllowedByCategoryName(($this->user))) {

                $cohortID = FAN_CohortID;
                require_once(FAN_cohort_lib_location); // WHAT!!!? WHY!!? PHP!!!!?
                if(!cohort_is_member($cohortID, $this->user->id)) {
                    cohort_add_member($cohortID, $this->user->id);
                    $this->content->text = getNewsCollection();
                    //$this->content->text .= "<p>ADDED</p>";
                    return $this->content;
                }
                else {
                    // if they are a cohort member, they would have had a role on the course.
                    // so should never get here really...
                    // well they actually end up here if the cohort is removed from the course but thats ok ...just return null to hide the block
                    // also if they were on the cohort then you removed them from the cohort.
                    return null;
                    $this->content->text = "Access Not Allowed Via Cohort";
                    return $this->content;
                }
            }
            else {
                return null;
                // below is just for tests
                //$this->content->text = "Access Not Allowed Via Category";
                //return $this->content;
            }
            #ENDAutoEnrolment
        }
    }
}

// functions go here
/**
 * @return string HTML fomatted string to display as news feed
 * the idea is that $news gets a news collection as an array of HENEws Objects
 * this can be gotten from any source as long as its formatted into an array of HENews Objects it will work
 */
function getNewsCollection() {

    // you may want a NewsCollection from the Moodle blog tool or an external URL feed... You could add it here
    // consider what happens when you want a news feed from two or more sources... (uncomment the commented out code below) then pass $finalNews into the NewsToHTML view.


    $newsCollection = new MoodleForumNewsCollection();
    $newsCollectionData = $newsCollection->getNewsCollection();
    return HTMLNewsScroller($newsCollectionData);



    /*$newsCollection2 = new TestNewsCollection();
    $newsCollectionData2 = $newsCollection2->getNewsCollection();
    return HTMLNewsScroller($newsCollectionData2);*/


    //$finalNews = array_merge($newsCollectionData, $newsCollectionData2);
    //return HTMLNewsScroller($finalNews);
}

/**
 * @param $news
 * an array of HENews objects
 * @return string formatted as html
 * this represents the view from MVC pattern
 * longterm, would like to move it into a separate view file so can create different views for different display types.
 */
function HTMLNewsScroller(array $news){
    // this value really needs to match the value in scripts.js for visible: 2
    $loadTickerAndScroll = 2;
    $newsCount = count($news);

    $html = '<div class="fan-wrap vticker">';
    $html .= '<ul class="vicker-ul">';

    if($newsCount > 0) {
        foreach($news as $n) {
            // had to overload constructor for HENews for this bit
            // as I wanted to define type of $n to auto activate intellisense later
            // currently in PHP, cannot use generics to specify data type for array
            //$n = new HENews();

            $html .= '<li class="fan-item well well-sm alert-warning span12">';
            $html .= sprintf('<div class="forum-as-news fan-title span8">%s</div>', StringToHtmlLink($n->getTitle(), $n->getLink()));
            $html .= sprintf('<div class="forum-as-news fan-posted span4">%s</div>', $n->getPostedFormatted("D, jS F Y [H:i]"));

            $html .= sprintf('<div class="forum-as-news fan-body span12">%s</div>', $n->getBodyLimit(150));
            $html .= sprintf('<div class="forum-as-news fan-news span10">%s</div>', StringToHtmlLink("full story &raquo;", $n->getLink()));
            $html .= sprintf('<div class="forum-as-news fan-news fan-comments span2 text-center">%s</div>', StringToHtmlLink($n->getComments(), $n->getLink()));
            $html .= "</li>";
        }
    }
    else {
        $html .= '<li class="fan-item well well-large span12"><div class="span12">' . FAN_NoNews . '</div></li>';
    }

    $html .= '</ul>';
    $html .= '</div>';

    $html .= sprintf('<div id="FAN_Visible">%d</div>', FAN_Visible);
    $html .= '<div class="text-center fan-controls">';

    // this value really needs to match the value in scripts.js for visible: 2
    if(count($news) > $loadTickerAndScroll) {
        $html .= StringToHtmlImgLinkControl("prev", "btnDown");
        $html .= StringToHtmlImgLinkControl("stop", "btnStop");
        $html .= StringToHtmlImgLinkControl("play", "btnStart");
        $html .= StringToHtmlImgLinkControl("next", "btnUp");
    }


    $html .= '</div>';

    return $html;
}

// COMMON FUNCTIONS - these should go into a common functions file as they may be used in future in other projects. In the past, i put common.php in moodleroot/lib and called it from config.php...

// isnt there a php link() function?
function StringToHtmlLink($text, $url) {
    return sprintf('<a href="%s">%s</a>', $url, $text);
}

function StringToHtmlButtonLink($text, $url) {
    return sprintf('<a class="btn btn-default" href="%s">%s</a>', $url, $text);
}

function StringToHtmlButtonControl($text, $classes) {
    return sprintf('<a class="btn btn-default %s" href="#">%s</a>', $classes, $text);
}

// glyphicons didnt work for some reason so just cut out the images and used thouse...
function StringToHtmlImgLinkControl($img, $classes) {
    $imgSrc = "/blocks/forum_as_news/images/controls-$img.png";
    return sprintf('<img class="%s" src="%s" />', $classes, $imgSrc);
}

// had to redeclare this as it wouldnt work with direct call...
function fan_cohort_is_member($cohortid, $userid) {
    global $DB;
    return $DB->record_exists('cohort_members', array('cohortid'=>$cohortid, 'userid'=>$userid));
}

function AccessAllowedByCategoryName($u) {
    $username = $u->username;
    $sql = "
        SELECT
            r.name,
            u.username,
            u.firstname,
            u.lastname
        FROM
            mdl_role_assignments ra
        INNER JOIN
            mdl_context c ON c.id = ra.contextid
        INNER JOIN
            mdl_role r ON r.id = ra.roleid
        INNER JOIN
            mdl_user u ON u.id = ra.userid
        INNER join
            mdl_course co ON co.id = c.instanceid
        INNER JOIN
            mdl_course_categories cc ON cc.id = co.category
        WHERE c.contextlevel = 50
            AND cc.name LIKE 'HE %'
            AND u.username = '$username'
        GROUP BY u.id";

    global $DB;
    $userInCategory = $DB->get_records_sql($sql);
    return (count($userInCategory) >= 1);
}