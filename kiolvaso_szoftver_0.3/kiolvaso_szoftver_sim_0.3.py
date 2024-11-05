
import csv
import boto3
import schedule
import time
import asyncio
from random import randint
from datetime import datetime
import logging
import sys
from pymodbus.client import ModbusTcpClient
from pymodbus.payload import BinaryPayloadDecoder
from pymodbus.constants import Endian
import struct
import random


logger=logging.getLogger(__name__)
logger.addHandler(logging.StreamHandler(sys.stdout))
logging.basicConfig(filename='szoftver.log', level=logging.INFO)

HOST = 'xxx'
PORT = 'xxx'


class FakeModbusClient:
    def read_holding_registers(self, register, count):
        
        class Response:
            def __init__(self, registers):
                self.registers = registers

            def isError(self):
                return False

        # Generate a random float and pack it as a 32-bit float to simulate Modbus registers
        random_float = random.uniform(0, 1000)
        packed_float = struct.pack('!f', random_float)  # Pack as 32-bit float
        # Convert packed bytes to two 16-bit registers
        registers = [
            int.from_bytes(packed_float[:2], byteorder='big'),
            int.from_bytes(packed_float[2:], byteorder='big')
        ]

        return Response(registers)


client = FakeModbusClient()

#MODBUS CSATLAKOZÁS

felho = 'iotmero.com'
adatbazis = 'adatbazis.csv'
s3 = boto3.client('s3')

#AWS S3

Regiszterek = [3028, 3032, 3034, 3000, 3002, 3004, 3076, 3060, 3068, 3110, 3196, 3240, 3208, 3224]
#L1,L2,L3 fesz   L1,L2,L3 áramerősség                   frekvencia,  IEc, kumulált látsz,hat,meddő energiamenny

def olvas():
    olvasott = []  # üres lista
    n=0
    for beolvasott in Regiszterek:
        x = client.read_holding_registers(beolvasott, 1)
        
        decoder=BinaryPayloadDecoder.fromRegisters(x.registers,byteorder=Endian.BIG, wordorder=Endian.BIG)
        y=decoder.decode_32bit_float()


        olvasott.append(y)
        logger.info(str(Regiszterek[n])+'A register olvasasa sikeres, Erteke:'+str(y))
        n=n+1
        continue
    


        

    return olvasott

def iras(adat):
    datum = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
    sor = [datum] + adat

    with open(adatbazis, 'a', newline='') as file:
        
        csv.writer(file).writerow(sor)

    s3.upload_file(adatbazis, felho, adatbazis)
    logger.info(str(sor)+'FELToLTVE')
    

async def main():
    
    logger.info('A program elkezdodott')
    adat = olvas()
   
    iras(adat)
    logger.info('1 perc varakozas!')
    await asyncio.sleep(20)
    

try:

    while True:
        asyncio.run(main())
        
        

except KeyboardInterrupt:
    logger.info('LEALLITVA')


