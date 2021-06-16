echo "test : $1"

#connecting to server using sshpass
sshpass -p dfemsdasdasdk ssh -o StrictHostKeyChecking=no $2@$1 'bash -s' <<EOF

#send mail using mailx
echo "mail" | mailx -r $4  -v -s "$6"  $3  < body.txt

exit
EOF

exit

