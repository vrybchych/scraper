#!/bin/bash
DOMAIN=$1
timeout 3600s sh log.sh $DOMAIN
./read_line $DOMAIN.log > $DOMAIN.log.txt
rm $DOMAIN.log
echo $DOMAIN >> done_domains.txt
#php get_links.php $DOMAIN
#rm  $DOMAIN.log.txt
#rm -rf $DOMAIN
