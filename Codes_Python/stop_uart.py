import serial
import sys

com_uart = serial.Serial("/dev/ttyAMA0")
com_uart.close()
print("Communication UART termine")
