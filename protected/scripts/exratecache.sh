#!/bin/bash

BASEDIR="$HOME/projects/oson.tj"

curl http://nbt.tj/index.html | \
	grep 'td width.*.id="k_kurs"' | \
	sed 's/^.*.>1/1/g' | sed 's/<.*$//g' > $BASEDIR/www/cache/nbt.html

