import serial
import sys

#Argument 

speed = sys.argv[1]
nb_data = sys.argv[2]
parite = sys.argv[3]
nb_stpb = sys.argv[4]

com_uart = serial.Serial("/dev/ttyAMA0")			#Creation de l'objet
#-- Config vitesse de transmission --
if speed == '9600':
	com_uart.baudrate = 9600
	print("Ok 9600")
elif speed == '4800':
	com_uart.baudrate = 4800
	print("Ok 4800")
elif speed == '2400':
	com_uart.baudrate = 2400
	print("Ok 2400")
else:
	print("Probleme choix vitesse de transmission")
#-----------------------------------

#-- Config nombre de donnees a envoyer --
if nb_data == '8':
	com_uart.bytesize = serial.EIGHTBITS
	print("8 bits de donnees")
else:
	print("Probleme choix nombre de bits")
#---------------------------------------

#-- Config parite --
if parite == 'Aucune':
	com_uart.parity = serial.PARITY_NONE
	print("Aucune parite")
elif parite == 'Impaire':
	com_uart.parity = serial.PARITY_ODD
	print("Parite impaire")
elif parite == 'Paire':
	com_uart.parity = serial.PARITY_EVEN
	print("Parite pair")
else:
	print("Probleme choix de la parite")
#------------------

#-- Config nombre de bits de stop --
if nb_stpb == '1':
	com_uart.stopbits = serial.STOPBITS_ONE
	print("1 bit de stop")
elif nb_stpb == '2':
	com_uart.stopbits = serial.STOPBITS_TWO
	print("2 bits de stop")
else:
	print("Probleme choix nombre de bits de stop")

com_uart.timeout = 0.5

print(speed , nb_data , parite , nb_stpb)
com_uart.open()		#Ouverture de la communication
