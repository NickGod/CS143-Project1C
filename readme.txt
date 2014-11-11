#README

Author: BEIQI GUAN
UID: 804160726

------------------------------
 * Contents:
  - addActorDirector.php
  - addComment.php
  - addMArelation.php
  - addMDrelation.php
  - addMovieInfo.php
  - searchActor:Movie.php
  - showActorInfo.php
  - showMovieInfo.php
  - template.css
  - bower_components
     |- bootstrap (we are using bootstrap's css)
     |- jquery 

Challenges and solutions
 ------------------------------
* How do we route between pages?

As you may notice, one issue in frontend is how we route from one page to another without repeatedly rendering the same HTML elements. To avoid this inefficiency, I chose to writer rendering functions in
functions.php.

Drawbacks
 ------------------------------
* we can only select one genre when adding movies
* in searching page, results for person and movies are not shown simultaneously

 
