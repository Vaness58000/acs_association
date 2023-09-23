while read line  
do   
   export $line
done < ${0%/*}/../.env
docker exec $NAME_SYMFONY_CONTAINER bash -c "cp .env.local.example $FOLDER_PROJECT_SYMFONY/.env.local"
docker exec $NAME_SYMFONY_CONTAINER bash -c "chmod 777 $FOLDER_PROJECT_SYMFONY/.env.local"
docker exec $NAME_SYMFONY_CONTAINER bash -c "cd $FOLDER_PROJECT_SYMFONY && composer install"
docker exec $NAME_SYMFONY_CONTAINER bash -c "cd $FOLDER_PROJECT_SYMFONY && symfony console doctrine:database:create && symfony console doctrine:migrations:migrate"
