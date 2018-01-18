#!/bin/bash
DOMAIN=$1
sh WGET.sh $DOMAIN  2>&1 >/dev/null | ./a.out > $DOMAIN.log.txt
php get_links.php $DOMAIN
rm  $DOMAIN.log.txt
rm -rf $DOMAIN
