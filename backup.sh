#!/usr/bin/env bash
now=`date +%d%m%Y`
mysqldump -uroot -pbismillah imis_sput > /home/imis/poins-$now.sql

HOST='salamdakwah.com'
USER='udibagas'
PASSWD='bismillah'
FILE='file.txt'

ftp -n $HOST <<END_SCRIPT
quote USER $USER
quote PASS $PASSWD
binary
put $FILE
quit
END_SCRIPT
exit 0

echo "
 verbose
 open ftp.mydomain.net
 user myusername mypassword
 ascii
 put textfile1
 put textfile2
 bin
 put binaryfile1
 put binaryfile2
 bye
" | ftp -n > ftp_$$.log
