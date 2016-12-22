#!/bin/bash
#requires avconv, espeak, and base64
mkdir /tmp/ttsfiles > /dev/null 2>&1
espeak "$1" -s 145 -ven+m3 -w /tmp/ttsfiles/file.wav > /dev/null 2>&1
OUTPUT=$(base64 /tmp/ttsfiles/file.wav)
rm /tmp/ttsfiles/file.mp3 > /dev/null 2>&1
echo $OUTPUT
