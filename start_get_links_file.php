<?php

$counter = 0;
while(1)
{
  if (!file_exists('done_domains.txt')) {
    sleep(300);
    continue;
  }
  $domains = explode("\n", file_get_contents('done_domains.txt'));
  if (count($domains) <= $counter+1) {
    sleep(60);
    continue;
  }
  shell_exec('php get_links.php '.$domains[$counter]);
  if (file_exists($domains[$counter].'.log.txt')) {
    unlink($domains[$counter].'.log.txt');
  }
  shell_exec('rm -rf '.$domains[$counter]);
  $counter++;
}

