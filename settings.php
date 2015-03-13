<?php
/**
 * Created by PhpStorm.
 * User: aosiname
 * Date: 06/03/2015
 * Time: 10:12
 * This is a place where all the settings are kept. They should ideally be taken from a database which the application talks to but at the moment, they are in here.
 */

/*
 * dont need this anymore
SELECT
	cm.id AS CourseModuleID,
    f.id AS ForumID
FROM mdl_course_modules cm
INNER JOIN mdl_modules m ON m.id = cm.module
INNER JOIN mdl_forum f ON f.course = cm.course
INNER JOIN mdl_context c ON c.instanceid = cm.course
WHERE cm.course = 2
AND c.contextlevel = 50
AND	m.name = 'forum';
*/

// this is really annoying, it wants me to pull this in before I can use cohort_add_member and cohort_is_member functions
// it does make sense but I thought the whole MOODLE API was available as the block is written in the official moodle way...
define("FAN_cohort_lib_location", "C:\\inetpub\\wwwroot\\moodletest.tmc.local\\cohort\\lib.php");

// these are forum news collection specific settings
// the course that contains the forum
define("FAN_CourseID", 2);

// the forum ID that contains posts you want to see (you can find this using the SQL query commented out above)
define("FAN_ForumID", 1819);

// you need this to add users to the course if you are using the application
// create a cohort and put the id in here...
define("FAN_CohortID", 3);

// SQL order by
# title or posted are currently the only options
define("FAN_Order", "posted");

// SQL ASC or DESC
define("FAN_OrderDirection","DESC");

// how many items to display in the news feed.
define("FAN_Limit", 5);

// how many items are visible at once
define("FAN_Visible", 2);

// default message to display if no news found
define("FAN_NoNews", "No news item feeds were found.");