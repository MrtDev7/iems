

echo "connecting to $1"

#connecting to server using sshpass
sshpass -p $3 ssh -o StrictHostKeyChecking=no $2@$1 'bash -s' <<EOF

#send mail using mailx
echo "mail" | mailx -r $5  -v -s "$6"  $4  < body.txt

exit
EOF

exit
