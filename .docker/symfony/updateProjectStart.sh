while read line  
do   
   export $line
done < ${0%/*}/.env
cd /home/project/$FOLDER_PROJECT_SYMFONY
symfony server:$1
