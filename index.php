<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);

require 'vendor/autoload.php';

$url = 'https://newdistrict.ca';
$linkDepth = 3;
// Initiate crawl
$crawler = new \Arachnid\Crawler($url, $linkDepth);
$crawler->traverse();

// Get link data
$links = $crawler->getLinks();

// pretty print
print("<pre>".print_r($links,true)."</pre>");

foreach ($links as $row)
  {
    // echo $row['http://www.dreadheadhq.com']['status_code'][0];
    // echo print_r($row['title']);
    // echo print_r($row['status_code']);

  }
