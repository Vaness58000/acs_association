if [ ! -e ${0%/*}/../.env ]
then
    echo "Il manque le fichier '.env'."
    echo "- Avant de faire l'installation, vous devez entrer la commande '$ cp .env.example .env'."
    ${0%/*}/message_bis.sh
    exit 1
fi