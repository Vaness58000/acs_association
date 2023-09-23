#!/bin/bash

while read line  
do   
   export $line
done < ${0%/*}/../../.env

LINE1="- .\/.docker\/config\/.env.local.example:\/home\/project\/www\/.env.local:ro"
LINE1_REPLACE="- .\/.docker\/config\/.env.local.example:\/home\/project\/$FOLDER_PROJECT_SYMFONY\/.env.local:ro"
DESACTIVE="#"
FILE="${0%/*}/../../docker-compose.yml"

cp ${0%/*}/../../.docker/config/.gitignore ${0%/*}/../../project/www/.gitignore

sed -i "s/$DESACTIVE$LINE1/$LINE1_REPLACE/" $FILE

cd ${0%/*}/../../
docker-compose up -d
