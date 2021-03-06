<!-- PROJECT SHIELDS -->
<!--
*** I'm using markdown "reference style" links for readability.
*** Reference links are enclosed in brackets [ ] instead of parentheses ( ).
*** See the bottom of this document for the declaration of the reference variables
*** for contributors-url, forks-url, etc. This is an optional, concise syntax you may use.
*** https://www.markdownguide.org/basic-syntax/#reference-style-links
-->

<!-- PROJECT LOGO -->
<br />
<p align="center">
  <h3 align="center">Pxlwidgets Test</h3>
  <p align="center">Link to life Version of the <a href="#">app</a></p>
  <p align="center">
    Write	a	process	such	that	it	may	be	terminated	(by	anything,	including	a	
    SIGTERM,	power	failure, what	have	you)	at	any	time,	after	which	it	may	resume	in	a	
    robust,	reliable	manner.	The	process	must	continue	exactly	where	it	left	off,	without	
    writing	duplicate	entries    <br />
    <a href="https://github.com/collinsugwu/tix.africa-test/blob/master/README.md"><strong>Explore the docs �</strong></a>
    <br />
    <br />
    �
    <a href="https://github.com/collinsugwu/pxl-test/issues">Report Bug</a>
    �
    <a href="https://github.com/collinsugwu/pxl-test/issues">Request Feature</a>
  </p>
</p>



<!-- TABLE OF CONTENTS -->
## Table of Contents

* [About the Project](#about-the-project)
  * [Built With](#built-with)
* [Getting Started](#getting-started)
  * [Prerequisites](#prerequisites)
  * [Installation](#installation)
* [Usage](#usage)
* [Roadmap](#roadmap)
* [Contributing](#contributing)
* [License](#license)
* [Contact](#contact)
* [Acknowledgements](#acknowledgements)



<!-- ABOUT THE PROJECT -->
## About The Project
<p>Gif of task</p>
<img src="https://res.cloudinary.com/job-boards/image/upload/v1616962698/test_mzc6wy.gif">


### Built With
This progam was made using this technologies
* [PHP](https://www.php.net/)
* [Laravel](https://laravel.com/)
* [PHPUnit](https://phpunit.de/)
* [MySQL](https://dev.mysql.com/)
* [Composer](https://getcomposer.org/)

<!-- GETTING STARTED -->
## Getting Started

To get a local copy up and running follow these simple example steps.

### Prerequisites

* PHP7
* Composer
* MySQL
* Laravel

### Installation

<!-- 1. Get a free API Key at [https://example.com](https://example.com) -->
1. Clone the repo
```sh
git clone https://github.com/collinsugwu/pxl-test
```
2. Install composer : run
```sh
 composer install
``` 
3. Run Migrations
```
php artisan migrate
```
4 Copy env.example into .env file

5. Start Server
```
php artisan migrate
```
6. Run Queue worker
```
php artisan queue:work
```
7. Test
```
phpunit
```
<!-- USAGE EXAMPLES -->
## Usage
 imports	the	contents	of	a	JSON-file	cleanly	and	consistently	to	a	
  database.

<!-- ROADMAP -->
## Roadmap
### todo
1. Read order file types

See the [open issues](https://github.com/collinsugwu/pxl-test/issues) for a list of proposed features (and known issues).


<!-- CONTRIBUTING -->
## Contributing

Contributions are what make the open source community such an amazing place to be learn, inspire, and create. Any contributions you make are **greatly appreciated**.

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request



<!-- LICENSE -->
## License

Distributed under the MIT License. See `LICENSE` for more information.


<!-- CONTACT -->
## Contact


* Collins Ugwu: [Github](https://github.com/collinsugwu), [Twitter](https://twitter.com/collinsugwu_me)

Project Link: [https://github.com/collinsugwu/pxl-test](https://github.com/collinsugwu/pxl-test)

<!-- ACKNOWLEDGEMENTS -->


# Answers to Bonus Questions


### What	happens  when the	source file grows to,  say, 500 times the given size?

<p>When there's 500 times the given data, this means there will be a high consumption of memory allocation, so the most efficent way to handle 
  such amount of data set would be to use streams. Streams provide on-demand access to data. This means you don’t need to load the entire contents of your dataset into memory before processing can start. Without streams, opening a 20MB file will consume 20MB of memory.
</p>

###  Is	your	solution	easily	adjustable	to	different	source	data	formats	(CSV,	XML, etc.)?

<p>Yes, it can easily be adjusted to suit other data formats, the validations validates other data format, while the serializeFile Traits alse checks for the file type, so a little adjustment will accomodate other data formats.</p>

###  Say	that	another	data	filter	would	be	the	requirement	that	the	credit	card	number must	have	three identical	digits	in	sequence.	How	would	you	tackle	this?

<p>I will write a method that filters out the credit cards that don't have consecutive three identical	digits in sequence before saving the details associated with the cards that have.</p>
