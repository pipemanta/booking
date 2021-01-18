#!/bin/sh

# Create new database in MySQL/MariaDB.
mysql_create_db() {
  [ -z "$3" ] && { echo "Usage: mysql-create-db (db_name)"; return; }
  mysql -u$1 -p$2 -ve "CREATE DATABASE IF NOT EXISTS $3"
}

# Grant all permissions for user for given database.
mysql_grant_db() {
  [ -z "$4" ] && { echo "Usage: mysql-grand-db (user) (database)"; return; }
  mysql -u$1 -p$2 -ve "GRANT ALL ON $4.* TO '$3'@'localhost'"
  mysql -u$1 -p$2 -ve "FLUSH PRIVILEGES"
}

mysql_drop_db() {
  [ -z "$3" ] && { echo "Usage: mysql-drop-db (db_name)"; return; }
  mysql -u$1 -p$2 -ve "DROP DATABASE IF EXISTS $3"
}

# Create user in MySQL/MariaDB.
mysql_create_user() {
  [ -z "$4" ] && { echo "Usage: mysql-create-user (user) (password)"; return; }
  mysql -u$1 -p$2 -ve "CREATE USER '$3'@'localhost' IDENTIFIED BY '$4'"
}


mysql_drop_db root secret booking_db
mysql_create_user root secret booking-user M!Aq12xjcDtLT#Zw
mysql_create_db root secret booking_db
mysql_grant_db root secret booking-user booking_db
