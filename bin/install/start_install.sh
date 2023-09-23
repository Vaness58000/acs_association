# vérifier l'existance du fichier .env
if [ ! -e ${0%/*}/../../.env ]
then
    echo "Il manque le fichier '.env'."
    echo "- Avant de faire l'installation, vous devez entrer la commande '$ ./bin/name.sh --name=nameProject'."
    echo "- Remplacer 'nameProject' par le nom du projet sans espace."
    ${0%/*}/message_bis.sh
    exit 1
fi
