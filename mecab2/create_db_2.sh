CMD_MYSQL="mysql -u root"

SQLUSER='twitter'
SQLPASS='twitter'

SQLDB='mecab2'

SQL_0="CREATE USER '$SQLUSER'@localhost IDENTIFIED BY '$SQLPASS' ;"
SQL_1="CREATE DATABASE $SQLDB ;"
SQL_2="CREATE TABLE ${SQLDB}.Tweet (ID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,Data TEXT) ;"

echo $SQL_0 | $CMD_MYSQL
echo $SQL_1 | $CMD_MYSQL



for i in `seq 0 68`
do
	SQL[$i]="CREATE TABLE ${SQLDB}.POSpeech_${i}_db (ID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,Data TEXT) ;"
	echo ${SQL[$i]} | $CMD_MYSQL
done

SQL_3="create table ${SQLDB}.Junban(ID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,j0 INT,j1 INT, j2 INT) ;"

SQL_G="GRANT ALL ON ${SQLDB}.* TO '$SQLUSER'@localhost;"
echo $SQL_2 | $CMD_MYSQL
echo $SQL_3 | $CMD_MYSQL
echo $SQL_G | $CMD_MYSQL
