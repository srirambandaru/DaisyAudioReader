Every time user is redirected to index.php for the first time.
Code checks, if he is already logged in, and if he is, it will redirect to home.php
And if he is not, he has to login and once user logs in successfully, he/she will then be redirected to home.php
There is an option for registering if user is a new user which onclicking redirects to signup.php
Once user is in home.php, it gets all the information from bookmarks, allbooks, mybooks tables and is displayed. By default bookmarks div is hidden
		For this, I have created a php file(home_model.php), in which there will be three functions, which grabs the data at the beginning.
User can navigate to any particular location using the navigation shortcuts or buttons.
User has the facility to bookmark the current location or add the current book to mybooks at any time after he loads the book.
User can also send the feedback, which is stored in the database directly.
If he is unable to find any books in the sidepane of home page, he/she can go to search.php and enter the bookname/author/language and can play the book from there.
User can also download the page. This option is provided in search page itself. A request will be sent to download.php which creates a bookmarks file and adds to the zip file
User can get more information from contact, about and help pages which are all static