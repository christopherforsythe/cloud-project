<?php
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");

include("conn.php");

//grab list of services
$listOfServices = json_decode(file_get_contents("services.json"), true);

if($listOfServices != TRUE){
  echo "Error in reading list of services json file.";
}

//2.iterate through services checking repsonse status
//a)if not 200 then fail
//b)response time
foreach ($listOfServices as $service){

  foreach ($service as $url){

    //set start time
    $starttime = microtime(true);
    $header_check = get_headers($url);
    $response_code = $header_check[0];

    //set stop time
    $stoptime = microtime(true);
    //divide by one billion to get time in seconds
    $serviceResponseTime = ($stoptime - $starttime);
    $message = "";

    if($conn){
      //create array of results for each microservice
      if ($response_code == 'HTTP/1.1 200 OK'){

        $message = "WORKING";

        $sql = "INSERT INTO `webwordcount_monitoring_stats` (`service_url`, `status`, `service_response_time`, `message`)
        VALUES ('$url', '$response_code', '$serviceResponseTime', '$message')";

        $result = $conn->query($sql);

        if($result){
          echo json_encode(
              array('message' => 'added to database')
            );
        } else {
          echo json_encode(
              array('message' => 'error adding to database')
            );
        }

      } else {
        //for finding errors in the service
        $message = "NOT WORKING";

        $sql = "INSERT INTO `webwordcount_monitoring_stats` (`service_url`, `status`, `service_response_time`, `message`)
        VALUES ('$url', '$response_code', '$serviceResponseTime', '$message')";

        $result = $conn->query($sql);

        if($result){
          echo json_encode(
              array('message' => 'added to database')
            );
        } else {
          echo json_encode(
              array('message' => 'error adding to database')
            );
        }      
        include('mail.php');
    } 
    //echo json_encode($serviceInfo);
  }else {
    echo "Error in connecting to database";
  }
  echo "finished";
 }
}


/*   MAKING HTTP REQUESTS WITH RANDOM TEXT TO THE SERVICES
     AND ADDING RESULTS TO DB SECTION  */

//grab list of keywords and paragraphs to test
$paraArray = file_get_contents('paragraphs.json');
$paragraphs = json_decode($paraArray, true);

//get a random paragraph 
foreach ($paragraphs as $paragraph) {
    $p= $paragraph[rand(0, sizeof($paragraph) - 1)];
}

if($conn){
// CHECK FUNCTION 
$getcontents = file_get_contents('checklist.json');
$array = json_decode($getcontents, true);

foreach ($array['check'] as $serviceLink) {

        $test_para = urlencode("$p");
        $test_word = "the";
        $URL_TEST = $serviceLink;
        $expectedAnswer = 1;
        $testResult = "";

        $header_check_2 = get_headers($URL_TEST);
        $response_code_2 = $header_check_2[0];

        $response = json_decode(file_get_contents($URL_TEST.'?paragraph='.$test_para.'&word='.$test_word), true);

        $answer = $response['answer'];
        
        if ($answer == $expectedAnswer){
            $testResult = 'TEST SUCCESS';
        }else {
            $testResult = "TEST FAILURE - SERVICE ERROR";
        }  

        $sql = "INSERT INTO `webwordcount_service_test` (`service_url`, `status`, `result`)
        VALUES ('$URL_TEST', '$response_code', '$testResult')";

        $result = $conn->query($sql);

        if($result){
          echo json_encode(
              array('message' => 'added to database')
            );
        } else {
          echo json_encode(
              array('message' => 'error adding to database')
            );
        }
}


// KEY WORD COUNT FUNCTION
$getcontents = file_get_contents('keywordcountlist.json');
$array = json_decode($getcontents, true);

foreach ($array['keywordCount'] as $serviceLink) {

    $test_para = urlencode("$p");
    $test_word = "the";
    $URL_TEST = $serviceLink;
    $expectedAnswer = 2;
    $testResult = "";

    $header_check_2 = get_headers($URL_TEST);
    $response_code_2 = $header_check_2[0];

    $response = json_decode(file_get_contents($URL_TEST.'?paragraph='.$test_para.'&word='.$test_word), true);

    $answer = $response['answer'];
    
    if ($answer == $expectedAnswer){
        $testResult = 'TEST SUCCESS';
    } else {
        $testResult = "TEST FAILURE - SERVICE ERROR";
    }

    $sql = "INSERT INTO `webwordcount_service_test` (`service_url`, `status`, `result`)
        VALUES ('$URL_TEST', '$response_code', '$testResult')";

        $result = $conn->query($sql);

        if($result){
          echo json_encode(
              array('message' => 'added to database')
            );
        } else {
          echo json_encode(
              array('message' => 'error adding to database')
            );
        }
}

// COUNT FUNCTION
$getcontents = file_get_contents('countlist.json');
$array = json_decode($getcontents, true);

foreach ($array['count'] as $serviceLink) {

    $test_para = urlencode("$p");
    $URL_TEST = $serviceLink;
    $expectedAnswer = 7;
    $testResult = "";

    $header_check_2 = get_headers($URL_TEST);
    $response_code_2 = $header_check_2[0];

    $response = json_decode(file_get_contents($URL_TEST.'?paragraph='.$test_para), true);

    $answer = $response['answer'];

    if ($answer == $expectedAnswer){
        $testResult = 'TEST SUCCESS';
    } else {
        $testResult = "TEST FAILURE - SERVICE ERROR";
    }

    $sql = "INSERT INTO `webwordcount_service_test` (`service_url`, `status`, `result`)
        VALUES ('$URL_TEST', '$response_code', '$testResult')";

        $result = $conn->query($sql);

        if($result){
          echo json_encode(
              array('message' => 'added to database')
            );
        } else {
          echo json_encode(
              array('message' => 'error adding to database')
            );
        }
  }
}
?>