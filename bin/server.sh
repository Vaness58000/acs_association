while read line  
do   
   export $line
done < ${0%/*}/../.env

d_start () {
   docker container start $NAME_SYMFONY_CONTAINER
}

d_stop () {
   docker container stop $NAME_SYMFONY_CONTAINER
}
 
d_restart () {
   d_stop
   d_start
}

d_log () {
   docker exec $NAME_SYMFONY_CONTAINER bash -c "service startserver log"
}

option=$1
if [[ "$option" = "" ]]
then
    option="--helps"
fi

if [[ "$option" = "--helps" ]]
then
    echo "Options:"
    echo "   start"
    echo "   stop"
    echo "   restart"
    echo "   reload"
    echo "   log"
    echo "   --helps"
else
   case "$1" in
      start|stop)
         d_${1}
         ;;
   
      restart|reload)
         d_restart
         ;;

      log)
         d_log
         ;;

      *)
         echo "Usage: ./bin/server.sh {start|stop|restart|reload|log|helps}"
         exit 1
         ;;

   esac
fi
