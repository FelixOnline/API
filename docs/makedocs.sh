#!/bin/bash

rm -f sections/*.html # delete all html files that have been generated
FILES=sections/*
for f in $FILES
do
    b=`basename $f .mkd` # get basename
    echo "Converting $b to html..."
    # take action on each file. $f store current file name
    perl markdown/Markdown.pl --html4tags $f > sections/$b.html
done

