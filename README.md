# Arachnid Web Crawler

This library will crawl all unique internal links found on a given website
up to a specified maximum page depth.

This library is based on the original blog post by Zeid Rashwani here:

<http://zrashwani.com/simple-web-spider-php-goutte>

Josh Lockhart adapted the original blog post's code (with permission)
for Composer and Packagist and updated the syntax to conform with
the PSR-2 coding standard.

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/8ff1e4b2-d8c8-4465-b9ea-f5db69c3c2d0/mini.png)](https://insight.sensiolabs.com/projects/8ff1e4b2-d8c8-4465-b9ea-f5db69c3c2d0)
[![Build Status](https://travis-ci.org/zrashwani/arachnid.svg?branch=master)](https://travis-ci.org/zrashwani/arachnid)
[![codecov](https://codecov.io/gh/zrashwani/arachnid/branch/master/graph/badge.svg)](https://codecov.io/gh/zrashwani/arachnid)

## How to Install

You can install this library with [Composer][composer]. Drop this into your `composer.json`
manifest file:

    {
        "require": {
            "zrashwani/arachnid": "dev-master"
        }
    }

Then run `composer install`.

## Getting Started

Here's a quick demo to crawl a website:

    <?php
    require 'vendor/autoload.php';

    $url = 'http://www.example.com';
    $linkDepth = 3;
    // Initiate crawl    
    $crawler = new \Arachnid\Crawler($url, $linkDepth);
    $crawler->traverse();

    // Get link data
    $links = $crawler->getLinks();
    print_r($links);

## Advanced Usage:
   There are other options you can set to the crawler:


   Set additional options to underlying guzzle client, by specifying array of options in constructor 
or passing it to `setCrawlerOptions`:


    <?php
        //third parameter is the options used to configure guzzle client
        $crawler = new \Arachnid\Crawler('http://github.com',2, 
                                 ['auth'=>array('username', 'password')]);
           
        //or using separate method `setCrawlerOptions`
        $options = array(
            'curl' => array(
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false,
            ),
            'timeout' => 30,
            'connect_timeout' => 30,
        );
                        
        $crawler->setCrawlerOptions($options);


   You can inject a [PSR-3][psr3] compliant logger object to monitor crawler activity (like [Monolog][monolog]):

    <?php    
    $crawler = new \Arachnid\Crawler($url, $linkDepth); // ... initialize crawler   

    //set logger for crawler activity (compatible with PSR-3)
    $logger = new \Monolog\Logger('crawler logger');
    $logger->pushHandler(new \Monolog\Handler\StreamHandler(sys_get_temp_dir().'/crawler.log'));
    $crawler->setLogger($logger);
    ?>

   You can set crawler to visit only pages with specific criteria by specifying callback closure using `filterLinks` method:

    <?php
    //filter links according to specific callback as closure
    $links = $crawler->filterLinks(function($link){
                        //crawling only blog links
                        return (bool)preg_match('/.*\/blog.*$/u',$link); 
                    })
                    ->traverse()
                    ->getLinks();

## How to Contribute

1. Fork this repository
2. Create a new branch for each feature or improvement
3. Apply your code changes along with corresponding unit test
4. Send a pull request from each feature branch

It is very important to separate new features or improvements into separate feature branches,
and to send a pull request for each branch. This allows me to review and pull in new features
or improvements individually.

All pull requests must adhere to the [PSR-2 standard][psr2].

## System Requirements

* PHP 5.6.0+

## Authors

* Josh Lockhart <https://github.com/codeguy>
* Zeid Rashwani <http://zrashwani.com>

## License

MIT Public License

[composer]: http://getcomposer.org/
[psr2]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md
[psr3]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md
[monolog]: https://github.com/Seldaek/monolog

