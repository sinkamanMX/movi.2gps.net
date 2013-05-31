#!/bin/bash
# MySQL backup script
# Last update: 29042013
#
MHOST=173.224.120.179
MUSER=sa
MPASS=\$0lstic3\$
MDATABASE=ALG_BD_CORPORATE_SG
FILEEXIST=" /var/www/vhosts/ubicatec.com/backups/backup_bd_tecnolider.sql"
BACKUPDIR=" /var/www/vhosts/ubicatec.com/backups"
FILENAME="backup_bd_tecnolider"
FILETAR="BD_TECNO_"
BDATE=$(date +"%m_%d_%Y")

rm `find /var/www/vhosts/ubicatec.com/backups/  -name '*.tar.gz'` -rf

mysqldump -h$MHOST -u$MUSER -p$MPASS $MDATABASE > $BACKUPDIR/$FILENAME.sql

cd $BACKUPDIR

if [ -f "$FILENAME.sql" ];
then
        tar -zcf $FILETAR$BDATE.tar.gz $FILENAME.sql
        rm `find /var/www/vhosts/ubicatec.com/backups/  -name '*.sql'` -rf
fi