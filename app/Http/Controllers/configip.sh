

echo "connecting to $1"

#connecting to server using sshpass
sshpass -p $3 ssh -o StrictHostKeyChecking=no $2@$1 'bash -s' <<EOF

#install maix
yum install -y mailx

#creating email body
echo "dance , dance!" > body.txt


#start postfix
postfix start

#install sendmail
yum install -y sendmail sendmail-cf m4


#restart sendmail service
service sendmail restart


exit
EOF

exit



