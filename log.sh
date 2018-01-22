#!/bin/bash
DOMAIN=$1
sh WGET.sh $DOMAIN  2>&1 >/dev/null | ./a.out > $DOMAIN.log.txt
#sh WGET.sh $DOMAIN  2> $DOMAIN.log
