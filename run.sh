#!/bin/bash
DOMAIN=$1
timeout 60s sh log.sh $DOMAIN
php get_links.php $DOMAIN
rm  $DOMAIN.log.txt
rm -rf $DOMAIN
