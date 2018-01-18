#!/bin/bash
URL=$1
timeout 180s wget -r -nd -P $URL -R avi,css,djvu,doc,docx,gif,gz,ico,jpeg,jpg,js,json,mp3,mp4,pdf,png,ppt,ps,rar,svg,tex,tmp,txt,xls,xlsx,zip $URL
