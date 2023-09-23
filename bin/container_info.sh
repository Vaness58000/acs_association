while read line  
do   
   export $line
done < ${0%/*}/../.env

option=$1
if [[ "$option" = "" ]]
then
    option="--helps"
fi

if [[ "$option" = "--helps" ]]
then
    echo "Options:"
    echo "   --php"
    echo "   --mariadb"
    echo "   --phpmyadmin"
    echo "   --mailhog"
    echo "   --helps"
    echo "   [id ou nom du conteneur]"
else
    container=$1
    case "$container" in
        --php)
            container=$NAME_SYMFONY_CONTAINER
            ;;
    
        --mariadb)
            container=$NAME_MARIABD_CONTAINER
            ;;

        --phpmyadmin)
            container=$NAME_PHPMYADMIN_CONTAINER
            ;;

        --mailhog)
            container=$NAME_MAILHOG_CONTAINER
            ;;
    esac

    docker container inspect $container

fi
