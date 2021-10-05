<?php

include "../count/src/functions.inc.php";
use PHPUnit\Framework\TestCase;

class countTest extends TestCase
{
  public function testCountReturnsCorrectAnswer()
  {
    $paragraph = "Test paragraph";
    $expect = 2;

    $this->assertEquals($expect, wordCount($paragraph));
  }

  //https://stackoverflow.com/questions/6560512/send-http-request-with-curl-to-local-file
  //code taken from above link
  public function testCountHTTP(){

    //create a server to run the file on
    $url = "http://localhost:8000/src/index.php";

    $paragraph = "Test paragraph";
    $expect = 2;

    $c = curl_init($url);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_HEADER, 1);
    $page = curl_exec($c);
    $header_size = curl_getinfo($c, CURLINFO_HEADER_SIZE);
    $headers = substr($page, 0, $header_size);
    //explode the header to remove excess data
    $headers = explode("\r\n", $headers);
    $header = $headers[0];
    //check if the link is active and working
    $this->assertEquals($header, "HTTP/1.1 200 OK");
    curl_close($c);
  }


}

 ?>
