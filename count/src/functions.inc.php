<?php

function wordCount($paragraph) {

  //split paragraph into an array of strings on the ' '
  $words = explode(" ", $paragraph);
  //initiate word counter
  $wordsCount = 0;
  //loop through words array
  foreach ($words as $word){
    //if there word length is greater than 0 (not an empty space)
    if(strlen($word) > 0){
      //increment the word counter
      $wordsCount++;
    }
  }
  return $wordsCount;
}

?>
