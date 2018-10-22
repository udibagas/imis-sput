#!/usr/bin/env python3

import socket
import selectors
import types
import requests
import json
import os
import logging
import logging.handlers

def processIncomingData(incomingData):
    if (len(incomingData) != 16):
        logger.warning('Panjang data tidak sesuai')
        return

    data = {
        "nrp": incomingData[1],
        "tgl": incomingData[2],
        "time": incomingData[3],
        "in_out_code": incomingData[4],
        "shift": incomingData[5],
        "zona_no": incomingData[6],
        "terminal_no": incomingData[7],
        "bpm": incomingData[9],
        "spo": incomingData[10],
        "jam_tidur": incomingData[11],
        "jam_bangun": incomingData[12],
        "minum_obat": incomingData[13],
        "ada_masalah": incomingData[14],
        "siap_bekerja": incomingData[15]
    }

    logger.info("Mengirim data ke server...")
    logger.info(str(data))

    try:
        r = requests.post(config["api_url"] + 'absensi', data=data)
    except Exception as e:
        logger.error('GAGAL mengirim data ke server ' + str(e))

    response = r.json()
    if (response['status'] == False):
        logger.error(response['message'])
    else:
        logger.info(response['message'])

def accept_wrapper(sock):
    conn, addr = sock.accept()  # Should be ready to read
    logger.info('accepted connection from ' + str(addr))
    conn.setblocking(False)
    data = types.SimpleNamespace(addr=addr, inb=b'', outb=b'')
    events = selectors.EVENT_READ | selectors.EVENT_WRITE
    sel.register(conn, events, data=data)

def service_connection(key, mask):
    sock = key.fileobj
    data = key.data
    if mask & selectors.EVENT_READ:
        recv_data = sock.recv(65535)
        if recv_data:
            processIncomingData(recv_data.decode("utf-8").split(',', 15))
            data.outb += recv_data
        else:
            logger.info('closing connection to ' + str(data.addr))
            sel.unregister(sock)
            sock.close()
    if mask & selectors.EVENT_WRITE:
        if data.outb:
            sent = sock.send(data.outb)
            # sent = sock.send(str.encode('OK'))
            data.outb = data.outb[sent:]


if __name__ == "__main__":
    config_file_path = os.path.join(os.path.dirname(__file__), 'config.json')

    try:
        with open(config_file_path) as config_file:
            config = json.load(config_file)
    except Exception as e:
        print("Gagal membuka file konfigurasi (config.json) " + str(e))
        exit()

    log_level = {
        "NOTSET": 0,
        "DEBUG": 10,
        "INFO": 20,
        "WARNING": 30,
        "ERROR": 40,
        "CRITICAL": 50
    }

    log_file_path = os.path.join(os.path.dirname(__file__), 'storage/logs/absensi.log')
    logger = logging.getLogger(__name__)
    logger.setLevel(log_level[config["log_level"]])
    handler = logging.handlers.RotatingFileHandler(log_file_path, maxBytes=1024000, backupCount=100)
    handler.setLevel(log_level[config["log_level"]])
    formatter = logging.Formatter('%(asctime)s - %(levelname)s - %(message)s')
    handler.setFormatter(formatter)
    logger.addHandler(handler)

    sel = selectors.DefaultSelector()
    lsock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    lsock.bind((config["host"], int(config["port"])))
    lsock.listen()
    logger.debug('listening on ' + config["host"] + ':' + config["port"])
    lsock.setblocking(False)
    sel.register(lsock, selectors.EVENT_READ, data=None)

    while True:
        events = sel.select(timeout=None)
        for key, mask in events:
            if key.data is None:
                accept_wrapper(key.fileobj)
            else:
                service_connection(key, mask)
