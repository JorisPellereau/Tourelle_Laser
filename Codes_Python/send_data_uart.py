import serial
import sys

#Argument 

pos_x = sys.argv[1]
pos_y = sys.argv[2]


com_uart = serial.Serial("/dev/ttyAMA0")
com_uart.write(pos_x , pos_y);

print(pos_x,pos_y)
