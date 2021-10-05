<?php

function check($paragraph, $word){

  //lowercase paragraph and word
  $paragraph = strtolower($paragraph);
  $word = strtolower($word);

    if (strpos($paragraph, $word) !== false)
        return 1;
    else
        return 0;
}
?>
