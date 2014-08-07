Codequiz
===========

3 Tier architecture application written for CS 490 - Design in Software Engineering.
Written by [@zintinio](https://github.com/Zintinio) and [@JohnnyJuicebox](https://github.com/JohnnyJuicebox).


Disclaimer!
===========

NO FRAMEWORKS WERE ALLOWED, we HAD to use PHP 5.3 (in July-August 2014!). This was written in a period of about two weeks total, though the commits say it was about 27 days. This was a project that was supposed to take 4 months, and we had to reach a milestone every week. 

* Week 1 was Alpha. 
* Week 2 was Beta. 
* Week 3 was Release Client 
* Week 4 was Final Release

In order to meet these deadlines, we did horrible, terrible, unspeakable things. __However__, *there are some pretty cool things included in here*:

* Assets are GZIPed
* Database is designed pretty well
* Can run user scripts written in python (horrible, terrible, despicable security flaws here)
* Communication between three different applications via JSON
* Cross Origin Resource Sharing
* The UI is pretty (and functional!)
* Some of the tables implement pagination
* Backend is RESTful - mostly, but the abstraction broke down as our time ran out (deadlines!)


What Does It Do?
================

The goal of [CodeQuiz](http://web.njit.edu/~arm32/client/) was to create a similar service to [CodingBat](http://codingbat.com/). Basically, instructors can create exams for students that are multiple choice, coding, fill in the blank, and true-false. The site centers around programming/computer science questions. Students can log in and take exams, and the results must be released by the instructors.

Requirements
============
>In addition to assigning roles based on login, you must implement four use cases as a minimum: 1) an instructor can create a new question and add it to the question bank, 2) an instructor can select questions from the question bank to make up an exam, 3) a student can take the exam, and 4) a student can check score and feedback for automatically graded exam.)
>Constraints:

>You must follow a Model View Controller architecture. Each student will be responsible for only one part, with no overlap. You will be graded individually on your contribution to the group project. To ensure that, you may ONLY run code from your own AFS account. 

>We will develop a communication protocol that all groups will be required to employ. Post requests will be used for requests; XML or JSON will be used for replies.

>You will lose points if you fail to comply with any of the requirements or constraints specified above

Instructor Views
----------------
![Instructor Dash](https://i.imgur.com/MchZuvm.png)

![Question Creation](https://i.imgur.com/lIL8bY9.png)

![Exam Creation](https://i.imgur.com/kH5c6yB.png)

![Release Grade](https://i.imgur.com/pzXgMCu.png)


Student Views
-------------

![Review Exam](https://i.imgur.com/3sycqpa.png)
