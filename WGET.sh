#!/bin/bash
URL=$1
wget -r -nd -P $URL -D $URL -R avi,bmp,css,djvu,doc,docx,gif,GIF,gz,ico,jpeg,jpg,JPG,js,json,mp3,mp4,ogv,pdf,png,ppt,ps,rar,rss,svg,swf,tex,tmp,txt,txt.tmp,webm,xls,xlsx,xml,zip $URL
