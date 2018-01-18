<?php

if (isset($argv[1])) {
  if(!is_dir($argv[1])){
    echo "No such directory: $argv[1]".PHP_EOL;
    exit(0);
  }
  $path = $argv[1];
} else {
  $path = '.';
}

function get_links($file, $path) {
  echo 'MIME: '.mime_content_type($file).PHP_EOL;
  if (mime_content_type($file) !== "text/html")
    return ;
  $html = file_get_contents($file);
  if (strpos($html, "nofollow") !== false) {
    echo "NOFOLLOW\n";
    return ;
  }
  preg_match_all("<a href=\"(http|https)://([^\s]*)\">", $html, $matches);
  foreach ($matches[0] as &$link) {
    $link = str_replace("a href=", "", $link); // remove a href=
    $link = str_replace("\"", "", $link); // remove "
    if (strpos($link, $path) !== false)
      continue ;
    $domain = parse_url($link)['host'];
    echo 'DOMAIN: '.$domain.PHP_EOL;
    echo 'LINK: '.$link.PHP_EOL;
    echo PHP_EOL;
    // insert_link_into_db($mysqli, $domain, $link, $row['id');
  }
}

$list = explode("\n", file_get_contents($path.'.log.txt'));

// for ($i = 0; $i < count($list); $i++) {
for ($i = 0; $i < 20; $i++) {
  if (strpos($list[$i], "URL: ") === 0) {
    // $url = substr($list[$i], 5);
    // echo $url.PHP_EOL;
    $file = substr($list[$i+1], 7);
    // echo $file.PHP_EOL;
    get_links($file, $path);
  }
}


// echo $list[0].PHP_EOL;
// echo $list[1].PHP_EOL;
//
// // echo strpos($list[0], "URL: ");
// if (strpos($list[1], "URL: ") === 0)
//   echo 'SUCCES'.PHP_EOL;
// else
//   echo 'FAIL'.PHP_EOL;
// foreach ($variable as $key => $value) {
//
// }

/*

// PAGE STATUS???

$mysqli = new mysqli("localhost", "root", "qwerty", "sites");
if ($mysqli->connect_errno) {
    echo "Can't connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$res = $mysqli->query("SELECT * FROM pages");

function insert_link_into_db($mysqli, $domain, $link, $page_id) {
  $sql = "INSERT INTO links (domain, link, page_id)
          VALUES ('".$domain."', '".$link."', '".$page_id."')";
  if ($mysqli->query($sql) === TRUE) {
    echo "New record created successfully\n";
  } else {
    echo "Error: " . $sql . "\n" . $mysqli->error."\n";
  }
}

while ($row = $res->fetch_assoc()) {
  $html = base64_decode($row['html']);
  if (strpos($html, "nofollow") !== false) {
    echo "NOFOLLOW\n";
    continue ;
  }
  preg_match_all("<a href=\"(http|https)://([^\s]*)\">", $html, $matches);
  foreach ($matches[0] as &$link) {
    $link = str_replace("a href=", "", $link); // remove a href=
    $link = str_replace("\"", "", $link); // remove "
    $domain = parse_url($link)['host'];
    insert_link_into_db($mysqli, $domain, $link, $row['id']);
  }
}
$mysqli->close();
*/
