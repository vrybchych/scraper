<?php

$host = "localhost";
$user = "root";
$password = "qwerty";
$db = "sites";

if (isset($argv[1])) {
  if(!is_dir($argv[1])){
    echo "No such directory: $argv[1]".PHP_EOL;
    exit(0);
  }
  $path = $argv[1];
} else {
  echo 'No arguments!'.PHP_EOL;
  exit (0);
}

$mysqli = new mysqli($host, $user, $password, $db);
if ($mysqli->connect_errno) {
    echo "Can't connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

function insert_link_into_db($mysqli, $domain, $link, $from_url) {
  $sql = "INSERT INTO links (domain, link, from_url)
          VALUES ('".$domain."', '".$link."', '".$from_url."')";
  if ($mysqli->query($sql) === TRUE) {
    echo "New record created successfully\n";
  } else {
    echo "Error: " . $sql . "\n" . $mysqli->error."\n";
  }
}

function get_links($file, $path, $url, $mysqli) {
  if(!file_exists($file))
    return ;
  if (mime_content_type($file) !== "text/html")
    return ;
  $html = file_get_contents($file);
  if (!$html)
    return ;
  if (strpos($html, "nofollow") !== false) {
    echo "NOFOLLOW\n";
    unlink($file);
    return ;
  }
  preg_match_all("<a href=\"(http|https)://([^\s]*)\">", $html, $matches);
  foreach ($matches[0] as &$link) {
    $link = str_replace("a href=", "", $link); // remove a href=
    $link = str_replace("\"", "", $link); // remove "
    if (strpos($link, $path) !== false)
      continue ;
    $domain = parse_url($link)['host'];
    insert_link_into_db($mysqli, $domain, $link, $url);
  }
  unlink($file);
}

$list = explode("\n", file_get_contents($path.'.log.txt'));

for ($i = 0; $i < count($list); $i++) {
  if (strpos($list[$i], "URL: ") === 0) {
    $url = substr($list[$i], 5);
    $file = substr($list[$i+1], 7);
    get_links($file, $path, $url, $mysqli);
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
