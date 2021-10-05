<?php
//1. send a request from frontend to proxy with a variable to denote the service
//2. act on that variable in the proxy to send a new request to the relevant service
//3. receive the result in the proxy and echo it back to the frontend
//return as json
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");

global $URL;

// Check it is a GET request
if ($_SERVER['REQUEST_METHOD'] == 'GET'){

    //Use GET super global to get the service
    $serviceNumber = $_GET['service'];
    //Use GET super global and urlencode to remove any spaces in the paragraph to avoid errors
    $paragraph = urlencode($_GET['paragraph']);
    //Use GET super global to get the word
    $word = $_GET['word'];

    $serviceList = file_get_contents('services.json');
    $array = json_decode($serviceList, true);

    //Check the service number is valid
    if ($serviceNumber < 1 || $serviceNumber > 3){
        // Display error if not and exit
        echo(json_encode(array("error"=>true, "message"=>"Invalid service request")));
        exit();
    } else {
        //switch on the service number
        switch ($serviceNumber) {

          case 1:
            if (is_array($array['count']) || is_object($array['count'])) {
              //iterate throught the array to find an active check url
              foreach ($array['count'] as $serviceLink){
                //code inspired from information here https://stackoverflow.com/questions/9817046/get-the-site-status-up-or-down
                $URL = $serviceLink;
                $header_check = get_headers("$serviceLink");
                $response_code = $header_check[0];
                //check the response code is working
                if ($response_code == 'HTTP/1.1 200 OK'){
                  //break out of the function
                  break;
                }
              }
            } else {
                echo "Error! Array of services is empty.";
            }

            $response = json_decode(file_get_contents($URL."?paragraph=".$paragraph), true);
            $answer = $response['answer'];
            break;

          case 2:
            if (is_array($array['check']) || is_object($array['check'])) {
              //iterate throught the array to find an active check url
              foreach ($array['check'] as $serviceLink){
                //code inspired from information here https://stackoverflow.com/questions/9817046/get-the-site-status-up-or-down
                $URL = $serviceLink;
                $header_check = get_headers("$serviceLink");
                $response_code = $header_check[0];
                //check the response code is working
                if ($response_code == 'HTTP/1.1 200 OK'){
                  //break out of the function
                  break;
                }
              }
            } else {
                echo "Error! Array of services is empty.";
            }
            $response = json_decode(file_get_contents($URL."?paragraph=".$paragraph."&word=".$word), true);
            $answer = $response['answer'];
            break;

          case 3:
            if (is_array($array['keywordCount']) || is_object($array['keywordCount'])) {
              //iterate throught the array to find an active check url
              foreach ($array['keywordCount'] as $serviceLink){
                //code inspired from information here https://stackoverflow.com/questions/9817046/get-the-site-status-up-or-down
                $URL = $serviceLink;
                $header_check = get_headers("$serviceLink");
                $response_code = $header_check[0];
                //check the response code is working
                if ($response_code == 'HTTP/1.1 200 OK'){
                  //break out of the function
                  break;
                }
              }
            } else {
                echo "Error! Array of services is empty.";
            }
            $response = json_decode(file_get_contents($URL."?paragraph=".$paragraph."&word=".$word), true);
            $answer = $response['answer'];
            break;

          default:
            break;
        }
        echo json_encode(array("error"=>false, "paragraph"=>$paragraph, "answer"=>$answer));
        exit();
      }
} else {
  echo (json_encode(array("error"=>true, "message"=>"Must be GET request")));
  exit();
}
?>
