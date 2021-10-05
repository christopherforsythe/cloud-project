<!DOCTYPE html>
<html>
<head>
<title>WebWordCount</title>

<?php

global $proxyURL;

$serviceGetContents = file_get_contents('proxylist.json');
$array = json_decode($serviceGetContents, true);

foreach ($array['proxies'] as $proxyLink){
  //Code inspired by https://stackoverflow.com/questions/9817046/get-the-site-status-up-or-down
    $proxyURL = $proxyLink;
    $header_check = get_headers("$proxyURL");
    $response_code = $header_check[0];
    if ($response_code == 'HTTP/1.1 200 OK'){
        break;
    }
}
?>

<script type="text/javascript">

//capture the working proxy link using php to echo javascript
//code inspired by https://code-boxx.com/pass-php-variables-arrays-to-javascript/
<?php
  echo "var proxyURL = '$proxyURL';";
?>
//Check if link is working
//console.log(proxyURL);

let result = 0;
let paragraph = '';
let word = '';
let service = 0;

function DisplayOne() {

  if (result > 0)
      result = result + " words";
  else
      result = 'Paragraph is empty';

  document.getElementById('display-1').value = result;

}

function DisplayTwo() {

    if (result == 1)
        result = 'Keyword exists!';
    else
        result = 'Keyword does not exist!';
    document.getElementById('display-2').value = result;

}

function DisplayThree() {

  if (result > 0)
      result = "Total Keyword Appearances = " + result;
  else
      result = "Keyword does not exist!";
  document.getElementById('display-3').value = result;

}

function Clear() {

    document.getElementById('paragraph').value = '';
    document.getElementById('word').value = '';
    document.getElementById('display-1').value = '';
    document.getElementById('display-2').value = '';
    document.getElementById('display-3').value = '';

}

function WordCount() {

  service = 1;
  paragraph = document.getElementById('paragraph').value;

  if (paragraph == '') {
    alert("Paragraph Empty!");
    return;

  } else {

        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var j = JSON.parse(this.response);
                result = j.answer;
                DisplayOne();
            }
        };

        xhttp.open("GET",proxyURL+"?paragraph="+paragraph+"&service="+service);
        xhttp.send();
        return;
    }
  }

function Check() {

    service = 2;
    paragraph = document.getElementById('paragraph').value.toLowerCase();
    word = document.getElementById('word').value.toLowerCase();

    var regexp = /[a-zA-Z]+\s+[a-zA-Z]+/g;
    //make sure only one word is being passed 
    if(regexp.test(word)){
        //word is more than one word
         alert("Only one keyword must be used.");
    }

    if (paragraph == '' || word == '') {
        alert("Paragraph Empty or No Keyword!");
        return;

    } else {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var j = JSON.parse(this.response);
                result = j.answer;
                DisplayTwo();
            }
        };

        xhttp.open("GET",proxyURL+"?paragraph="+paragraph+"&word="+word+"&service="+service);
        xhttp.send();
        return;
      }
  }


function KeywordAppearance() {

    service = 3;
    paragraph = document.getElementById('paragraph').value.toLowerCase();
    word = document.getElementById('word').value.toLowerCase();

    var regexp = /[a-zA-Z]+\s+[a-zA-Z]+/g;

    //make sure only one word is being passed 
    if(regexp.test(word)){
        //word is more than one word
        alert("Only one keyword must be used.");
    }

    if (paragraph == '' || word == '') {

        alert("Paragraph Empty or No Keyword!");
        return;

    } else {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var j = JSON.parse(this.response);
                result = j.answer;
                DisplayThree();
          }
      };

        xhttp.open("GET",proxyURL+"?paragraph="+paragraph+"&word="+word+"&service="+service);
        xhttp.send();
        return;
      }
}

</script>

<style type="text/css">
body  {
    font-size: 150%;
    font-family: monospace;
}

#logo
{
    font-family: Calibri, sans-serif;
    font-weight: lighter;
    color: #505050;
    margin: 0.5em;
}

#wordcount
{
    text-align: center;
    margin-top: 1em;
}

#paragraph {
    font-size: 90%;
    padding: 0.2em;
    margin: 0.2em;
    font-family: monospace;
    letter-spacing: 0.1em;
    border: 1px solid black;

}

#word {
    font-size: 90%;
    border: 1px solid black;
    padding: 0.2em;
    margin: 0.2em;
    font-family: monospace;
    letter-spacing: 0.1em;
    width: 400px;

}

.display {
    font-size: 90%;
    color: white;
    background-color: black;
    padding: 0.2em;
    margin: 0.2em;
    font-family: monospace;
    letter-spacing: 0.1em;
    width: 400px;

}

.wwcbutton {
    background-color: green;
    color: white;
    padding: 0px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 18px;
    margin: 4px 2px;
    cursor: pointer;
    height: 40px;
    width: 400px;
}

.wwcbutton-inactive {
    background-color: gray;
    color: white;
    padding: 0px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 18px;
    margin: 4px 2px;
    cursor: pointer;
    height: 40px;
    width: 400px;
}

.wwcbutton-clear {
    background-color: red;
    color: white;
    padding: 0px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 18px;
    margin: 4px 2px;
    cursor: pointer;
    height: 40px;
    width: 400px;
}

</style>

</head>
<body>
<div id="wordcount">
    <div id="logo">
        Web Word Count App
    </div>
    <div>
        <textarea id="paragraph" rows="5" cols="35" placeholder="Enter the paragraph here..." value="">Enter the paragraph here...
        </textarea>
    </div>
    <div>
        <input type="text" id="word" placeholder="Enter the keyword here..." value="">
    </div>
    <div>
        <input type="text" class="display" id="display-1" readonly=1 placeholder="Total word count = 0 " value=""><br>
        <input type="text" class="display" id="display-2" readonly=1 placeholder="Keyword does not exist!" value=""><br>
        <input type="text" class="display" id="display-3" readonly=1 placeholder="Total keyword appearances = 0" value="">
    </div>
    <div>
        <button class="wwcbutton" onclick="WordCount();">Total words?</button>
    </div>
    <div>
        <button class="wwcbutton" onclick="Check();">Check keyword appearance</button>
    </div>
    <div>
        <button class="wwcbutton" onclick="KeywordAppearance();">Total keyword appearances?</button>
    </div>
    <div>
        <button class="wwcbutton-clear" onclick="Clear();">Clear</button>
    </div>

</div>
</body>

<script type="text/javascript">
</script>

</html>
