#!/bin/bash

FILE_CREATE=".\/bin\/createProject.sh"
FILE_UPDATE=".\/bin\/updateProject.sh"
FILE_START=".\/bin\/install\/start_install.sh"
FILE_END=".\/bin\/install\/end_install.sh"
FILE_MESSAGE=".\/bin\/install\/message.sh"
DESACTIVE="#"
FILE="${0%/*}/../../install.sh"

sed -i "s/$FILE_CREATE/$DESACTIVE$FILE_CREATE/" $FILE
sed -i "s/$DESACTIVE$FILE_UPDATE/$FILE_UPDATE/" $FILE
sed -i "s/$FILE_START/$DESACTIVE$FILE_START/" $FILE
sed -i "s/$FILE_END/$DESACTIVE$FILE_END/" $FILE
sed -i "s/$DESACTIVE$FILE_MESSAGE/$FILE_MESSAGE/" $FILE
