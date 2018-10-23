#!/usr/bin/env python3

import socket
import selectors
import types
import requests
import json
import os
import logging
import logging.handlers

def cmd220():
    pass

def process_incoming_data(recv_data):
    incoming_data = recv_data.decode("utf-8").rstrip()

    if 'CMD220' in incoming_data:
        cmd220()
        return

    incoming_data = incoming_data.split(',', 15)

    if len(incoming_data) != 16:
        message = 'Panjang data tidak sesuai'
        logger.warning(message)
        # print('WARNING: ' + message)
        return

    data = {
        "nrp": incoming_data[1],
        "tgl": incoming_data[2],
        "time": incoming_data[3],
        "in_out_code": incoming_data[4],
        "shift": incoming_data[5],
        "zona_no": incoming_data[6],
        "terminal_no": incoming_data[7],
        "bpm": incoming_data[9],
        "spo": incoming_data[10],
        "jam_tidur": incoming_data[11],
        "jam_bangun": incoming_data[12],
        "minum_obat": incoming_data[13],
        "ada_masalah": incoming_data[14],
        "siap_bekerja": incoming_data[15]
    }

    logger.info("Mengirim data ke server...")
    # print("INFO: Mengirim data ke server...")
    logger.info(str(data))
    # print(str(data))

    try:
        r = requests.post(config["api_url"] + 'absensi', data=data)
    except Exception as e:
        message = 'GAGAL mengirim data ke server ' + str(e)
        logger.error(message)
        # print('ERROR: ' + message)
        return

    response = r.json()

    if response['status'] == False:
        logger.error(response['message'])
        # print('ERROR: ' + response['message'])
    else:
        logger.info(response['message'])
        # print('INFO: ' + response['message'])

def accept_wrapper(sock):
    conn, addr = sock.accept()
    message = 'accepted connection from ' + str(addr)
    logger.debug(message)
    # print('DEBUG: ' + message)
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
            process_incoming_data(recv_data)
            data.outb += recv_data
        else:
            message = 'closing connection to ' + str(data.addr)
            logger.debug(message)
            # print('DEBUG: ' + message)
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
        print("ERROR: Gagal membuka file konfigurasi (config.json) " + str(e))
        exit()

    log_level = {
        "NOTSET": 0,
        "DEBUG": 10,
        "INFO": 20,
        "WARNING": 30,
        "ERROR": 40,
        "CRITICAL": 50
    }

    log_file_path = os.path.join(os.path.dirname(__file__), 'absensi.log')
    logger = logging.getLogger(__name__)
    logger.setLevel(log_level[config["log_level"]])
    handler = logging.handlers.RotatingFileHandler(log_file_path, maxBytes=1024000, backupCount=100)
    handler.setLevel(log_level[config["log_level"]])
    formatter = logging.Formatter('%(asctime)s - %(levelname)s - %(message)s')
    handler.setFormatter(formatter)
    logger.addHandler(handler)

    sel = selectors.DefaultSelector()
    lsock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

    try:
        lsock.bind((config["host"], int(config["port"])))
    except Exception as e:
        message = "Failed to bind socket: " + str(e) + " (" + config["host"] + ":" + config["port"] + ")"
        logger.error(message)
        # print('ERROR: ' + message)
        exit()

    lsock.listen()
    message = 'listening on ' + config["host"] + ':' + config["port"]
    logger.debug(message)
    # print('DEBUG: ' + message)
    lsock.setblocking(False)
    sel.register(lsock, selectors.EVENT_READ, data=None)

    while True:
        events = sel.select(timeout=None)
        for key, mask in events:
            if key.data is None:
                accept_wrapper(key.fileobj)
            else:
                service_connection(key, mask)
