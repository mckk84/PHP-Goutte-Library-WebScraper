# PHP-Goutte-Library-WebScraper

PHP Web Scraper using Goutte Library

Goutte is a screen scraping and web crawling library for PHP. Goutte provides a nice API to crawl websites and extract data from the HTML/XML responses.

##Prerequisites

PHP version 7.1+

##Installation

Download the php_goutte folder to the local machine. Open the command prompt or terminal. Change the working directory to the php_curl folder. Enter the following command to Add fabpot/goutte as a require dependency in your composer.json file:

composer require fabpot/goutte

Check composer.json is created. 

##Using the code:

Type the following command

php php_goutte.php https://www.example.com

Response : Will output the response html from http://www.example.com to the terminal.

Errors : If the website is down or any other issue the response will show corresponding http status code and exit.
