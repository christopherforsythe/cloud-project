<?php
function keywordAppearance($paragraph, $keyWord) {

  //Lowercase paragraph and key word
  $paragraph = strtolower($paragraph);
  $keyWord = strtolower($keyWord);

  //split paragraph into an array on the ' '
  $wordsToCount = explode(' ', $paragraph);

  $count = 0;

  //iterate through word array
  foreach ($wordsToCount as $word)
  {
    //remove non-alphanumeric characters and increment count if match
    if (preg_replace('/\s+/', '', $word) === $keyWord){
      $count++;
    }
  }

  return $count;


}

?>
