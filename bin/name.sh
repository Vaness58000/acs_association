#!/bin/bash

NAME_PROJECT_DEF="domasym"
FICHIER_ENV_EXA="${0%/*}/../.env.example"
FICHIER_ENV="${0%/*}/../.env"

IFS='=' read -r -a array <<< "$1"

option="${array[0]}"
if [[ "$option" = "" ]]
then
    option="--helps"
fi

case "$option" in
    --name)
        NAME_PROJECT="${array[1]}"
        sed -i "s/NAME_PROJECT=$NAME_PROJECT_DEF/NAME_PROJECT=$NAME_PROJECT/" $FICHIER_ENV_EXA
        sed -i "s/CONTAINER=$NAME_PROJECT_DEF/CONTAINER=$NAME_PROJECT/" $FICHIER_ENV_EXA
        cp $FICHIER_ENV_EXA $FICHIER_ENV
        ;;

    *)
        echo "Options:"
        echo "   --name=project"
        echo "   --help"
        exit 1
        ;;

esac
