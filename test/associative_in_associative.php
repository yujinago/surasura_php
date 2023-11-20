<pre>
  <?php
  $result = array("math" => 90, "English" => 80);
  $friends = array("Haruki" => $result);
  var_dump($friends);

  $friends["Kaoru"] = array("math" => 95, "English" => 85);
  var_dump($friends);
  ?>
</pre>