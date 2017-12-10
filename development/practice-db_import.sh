#!/usr/bin/env bash

sourceUrl="https://admin.b2b-carmarket.com//test/project"
sourceFilename="practice_data.csv"

wget -O "${sourceFilename}" "${sourceUrl}"

sed '1d' "${sourceFilename}" > practice_data-no_header.csv

#mysql -uroot -proot -e