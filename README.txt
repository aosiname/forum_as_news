# Moodle-Forum-News-Feed
This block uses a Moodle Forum as a News Feed. 

The purpose for which it was created was because a customer required the HE students for a certain number of categories to view a news feed on their /my home page.

There is a default news forum feed with a block but thats for sitewide news and I preferred not to alter something that came with core moodle as you cannot (or should not) play with things such as altering the view, changing who can post to it, etc.

The solution uses a block that implements OOP and TDD and can be setup as follows:

Something to note is that OOP allows you to abstract the type of news collection that is fed into the view. I discovered this because I used TDD and immediately realised that I should be able to feed a generic array of objects into the view regardless of where it came from. This allows for future developments. You may decide you want assignment results and feedback to display. You can merge two arrays that contain generic news collection objects and it will work.

To use within Moodle 2.7 + (may work for older but I developed it on 2.7)

Uses bootstrap so it would be good if you have a bootstrap theme. It will still work without but you will need to do some CSS work. It also needs jQuery

1) Create a course with a forum.
2) Add a post or three!
3) Add block forum_as_news to you moodle directory
4) Open settings.php
5) Edit all the settings in settings.php where course id is simply the ?id= when you visit the course homepage.
6) In this case, we want the block to appear for all students so as admin, go to yourmoodlesite.com/my/indexsys.php and turn blocks editing on
7) Add block "Forum News Feed" to the middle region (or any region you like - it should bootstrap to fit)
8) Ensure only site administrators can add/remove the block in the Moodle built in capabilities management here: /admin/roles/manage.php then click "Authenticated Users" then scroll down and remove permission from the block.
9) Add the students to the course that you want to view the feed on their home page.
10) If like me you want to automate adding students to a course based on some feature (in my case, I found students from courses in a category that starts with HE
10a) Then you will need to add a cohort and put the cohortid into settings.php
10b) Otherwise, just add your students manually to the course that holds the forum for the news feed.
10c) In this case, you can delete or comment out everything between #AutoEnrolment and #ENDAutoEnrolment in block_forum_as_news.php

More Testing:
> what happens if you delete the course?

Future ideas:
> load settings.php values from a Moodle Block settings page
> handle images in the view based on attachments added to the forum post.
> implement the V from MVC properly - checkout ScrollingNewsFeed.php in which I started the process in using a conventional MVC view
> try adding another news collection type and merging the two arrays in block_forum_as_news.php->getNewsCollection()
> provide feedback when system is paused or playing
> different options to order by besides posted and title in settings.php