#!/bin/bash
BACKUP_DIR=~/zima-backups
DATE=$(date +%Y%m%d-%H%M%S)

mkdir -p $BACKUP_DIR

echo "Бэкап БД..."
cp storage/database.sqlite $BACKUP_DIR/db-$DATE.sqlite

echo "Бэкап тем и плагинов..."
tar -czf $BACKUP_DIR/site-$DATE.tar.gz themes plugins .env

echo "Бэкап завершён!"
echo "Файлы: $BACKUP_DIR"