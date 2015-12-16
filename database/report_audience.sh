#!/bin/bash

function usage {
  printf "Usage:\n$0 <db_name> <collection_name> <output_csv_file>\n"
  exit 1
}

db_name=yomedia
collection=tracking_audience
output_file=test.csv
table=test
username=root
password=root
db_mysql=yomedia

[[ -z $collection ]] && usage
[[ -z $db_name ]] && usage
[[ -z $output_file ]] && usage

mongoexport --db "$db_name" --collection "$collection" --csv --fields "uuid,bid,impression,click,time" --out "$output_file"

printf "CSV contents exported to $output_file\n"
#truncate table "$table" | mysql -u"$username" -p"$password" -D"$db_mysql"
echo "truncate table $table" | mysql -u"$username" -p"$password" -D"$db_mysql"
#echo "truncate table $table"
mysqlimport  --ignore-lines=1 --fields-terminated-by=, --lines-terminated-by='\n' --columns='uuid,bid,impression,click,time' --local -u"$username" -p"$password" "$db_mysql" "$output_file"