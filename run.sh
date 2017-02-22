#!/usr/bin/env bash

XRARGS="-x -s http:0.0.0.0:$PORT"
rm fifo.* 2>/dev/null

for i in {0..9} ; do
  XRARGS="$XRARGS -b 127.0.0.1:800$i"
  echo Starting handler: 800$i
  { while true ; do FIFO=$(hexdump -n 16 -v -e '/1 "%02X"' -e '/16 "\n"' /dev/urandom) ; mkfifo fifo.$FIFO ; nc -l 800$i < fifo.$FIFO | php init.php > fifo.$FIFO ; rm fifo.$FIFO ; done } &
done;

echo Starting load-balancer on $PORT
echo xr $XRARGS
xr $XRARGS
