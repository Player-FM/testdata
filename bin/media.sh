#!/bin/bash

# Utils

function yoink() {
  # TODO would be cool to do a head
  echo "Downloading $1 to $2"
  wget -O "$2" --no-check-certificate -c "$1"
  #cat $2 | curl -L -C - $1 > $2 # http://www.commandlinefu.com/commands/view/2876/use-curl-to-resume-a-failed-download
  #if [ ! -f $2 ] ; then
    #curl -L $1 > $2
  #fi
}

# Ensure directory

cd `dirname $0`/..
mediadir=`pwd`/web/media
mkdir -p $mediadir

# Copy small files stored in project

rsync -avz smallmedia/* $mediadir

# Yoink big files stored at Archive.org

cd $mediadir

#yoink https://archive.org/download/alicesadventures19573gut/mp3%2F19573-09.mp3 alice.mp3
#yoink https://archive.org/download/alicesadventures19573gut/ogg%2F19573-10.ogg alice.ogg
#yoink https://archive.org/download/alicesadventures19573gut/m4b%2F19573-10.m4b alice.m4b

#yoink https://archive.org/download/dracula19797gut/mp3%2F19797-27.mp3 dracula.mp3
#yoink https://archive.org/download/dracula19797gut/ogg%2F19797-27.ogg dracula.ogg
#yoink https://archive.org/download/dracula19797gut/m4b%2F19797-27.m4b dracula.m4b

#yoink https://archive.org/download/WithALittleHelpMp3s/06-Human_Readable_-_Cory_Doctorow_-_With_a_Little_Help.mp3 human.mp3

#yoink https://archive.org/download/Cory_Doctorow_Podcast_255/Cory_Doctorow_Podcast_255_Metadata_A_Wartime_Drama.ogg meta.ogg
#yoink https://archive.org/download/Cory_Doctorow_Podcast_255/Cory_Doctorow_Podcast_255_Metadata_A_Wartime_Drama_64kb.mp3 meta.mp3
#yoink https://archive.org/download/Cory_Doctorow_Podcast_255/Cory_Doctorow_Podcast_255_Metadata_A_Wartime_Drama.mp3 metavbr.mp3
