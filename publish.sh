#!/bin/sh

#################################################################################
#                                                                               #
#                                PUBLISHER                                      #
#                                                                               #
#################################################################################
# DESCRIPTION       Push a site from the GIT repo to live                       #
# RELEASE           1.0                                                         #
# DATE              9th October 2017                                            #
# AUTHOR            Jon Thompson                                                #
#################################################################################


GITNAME=$1
LIVENAME=$2
SRCFOLDER="/path/to/git/repo/${GITNAME}"

if [ "$2" == "" ];
then
    DESTFOLDER="/var/www/${GITNAME}"
else
    DESTFOLDER="/var/www/${LIVENAME}"
fi

DATESTAMP=`date +%Y%m%d`
VERSION="1.1 (2017-03-28)"



# ############################################################################# #


# Make sure a domain name is passed on the CLI
if [ "$1" == "" ]; 
then
    echo
    echo "USAGE : $0 [GIT REPOSITORY NAME]"
    echo
    echo "- Move a project from its GIT repo to live"
    echo
    exit
fi


if [ ! -d ${SRCFOLDER} ];
then
    echo "ERROR : GIT REPOSITORY DOES NOT EXIST AT ${SRCFOLDER}"
    exit;
fi 

if [ ! -d ${DESTFOLDER} ];
then
    echo "ERROR : GIT REPOSITORY DOES NOT EXIST AT ${DESTFOLDER}"
    exit;
fi

rsync -h -v -r -P -a --delete-before --log-file=var/log/gitPublish/rsyncd.log -- ${SRCFOLDER} ${DESTFOLDER}