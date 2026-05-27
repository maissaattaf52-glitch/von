#!/bin/bash
# SA-MP Server Control Script
# Put your actual samp03svr binary path here

SERVER_DIR="$1"
ACTION="$2"

if [ -z "$SERVER_DIR" ]; then
    echo "Usage: $0 <server_directory> <start|stop|restart|status>"
    exit 1
fi

case "$ACTION" in
    start)
        cd "$SERVER_DIR"
        nohup ./samp03svr > server_log.txt 2>&1 &
        echo $! > samp03svr.pid
        echo "Server started"
        ;;
    stop)
        if [ -f "$SERVER_DIR/samp03svr.pid" ]; then
            kill $(cat "$SERVER_DIR/samp03svr.pid")
            rm "$SERVER_DIR/samp03svr.pid"
            echo "Server stopped"
        fi
        ;;
    restart)
        $0 "$SERVER_DIR" stop
        sleep 2
        $0 "$SERVER_DIR" start
        ;;
    status)
        if [ -f "$SERVER_DIR/samp03svr.pid" ]; then
            if ps -p $(cat "$SERVER_DIR/samp03svr.pid") > /dev/null 2>&1; then
                echo "Online"
            else
                echo "Offline"
            fi
        else
            echo "Offline"
        fi
        ;;
    *)
        echo "Usage: $0 <server_directory> <start|stop|restart|status>"
        ;;
esac