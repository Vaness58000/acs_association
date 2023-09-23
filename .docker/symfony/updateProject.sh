while read line  
do   
   export $line
done < ${0%/*}/.env
cd /home/project/$FOLDER_PROJECT_SYMFONY
symfony server:$1 --no-tls -d >> /var/log/symfony/symfony_out.log 2>> /var/log/symfony/symfony_error.log
