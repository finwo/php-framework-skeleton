#!/usr/bin/env bash

XRARGS= -x -v -s http:0.0.0.0:$PORT

for i in {0..9} ; do
  XRARGS="$XARGS -b 127.0.0.1:800$i"
  while true ; do FIFO=$(hexdump -n 16 -v -e '/1 "%02X"' -e '/16 "\n"' /dev/urandom) ; mkfifo fifo.$FIFO ; nc -l 800$i < fifo.$FIFO | php sgi.php > fifo.$FIFO ; rm fifo.$FIFO ; done &
done;

xr $XRARGS
