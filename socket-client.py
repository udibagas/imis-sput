#!/usr/bin/env python3

import socket
import time

HOST = '127.0.0.1'  # The server's hostname or IP address
PORT = 9998        # The port used by the server

data_absen = b'010212345,KC11122,2018-10-20,9:36:03,1,1,001,001,10,0,0,19:30:00,6:30:00,Y,T,Y'

while True:
    with socket.socket(socket.AF_INET, socket.SOCK_STREAM) as s:
        try:
            s.connect((HOST, PORT))
        except Exception as e:
            continue

        s.sendall(data_absen)
        data = s.recv(65535)
        print('Received', repr(data))
    time.sleep(5)
