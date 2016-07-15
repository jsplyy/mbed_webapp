import mbed_connector_api 				# mbed Device Connector library
from   base64 			import standard_b64decode as b64decode
import os


if 'ACCESS_KEY' in os.environ.keys():
	token = os.environ['ACCESS_KEY'] # get access key from environment variable
else:
	token = "4SMf3bbEWuzD8tGxM7Kg9LQr4RZY7xpEPgbHde5AKGFd63CHvNajtDN3PoACybLLqce1dwa9kld2ketBUpqwvZZG41SqPXw7Mtnr" # replace with your API token

connector = mbed_connector_api.connector(token)

def index():
	# get list of endpoints, for each endpoint get the pattern (/3201/0/5853) value
	epList = connector.getEndpoints().result
	for index in range(len(epList)):
		print "Endpoint Found: ",epList[index]['name']
		e = connector.getResourceValue(epList[index]['name'],"/3201/0/5853")
		while not e.isDone():
			None
		epList[index]['blinkPattern'] = e.result
	# print "Endpoint List :",epList

def connect():
	print('connect ')
	join_room('room')

def disconnect():
	print('Disconnect')
	leave_room('room')

def subscribeToPresses(data):
	# Subscribe to all changes of resource /3200/0/5501 (button presses)
	print('subscribe_to_presses: ',data)
	e = connector.putResourceSubscription(data['endpointName'],'/3200/0/5501')
	while not e.isDone():
		None
	if e.error:
		print("Error: ",e.error.errType, e.error.error, e.raw_data)
	else:
		print("Subscribed Successfully!")
		emit('subscribed-to-presses')


def unsubscribeToPresses(data):
	print('unsubscribe_to_presses: ',data)
	e = connector.deleteResourceSubscription(data['endpointName'],'/3200/0/5501')
	while not e.isDone():
		None
	if e.error:
		print("Error: ",e.error.errType, e.error.error, e.raw_data)
	else:
		print("Unsubscribed Successfully!")
	emit('unsubscribed-to-presses',{"endpointName":data['endpointName'],"value":'True'})
    

def getPresses(data):
	# Read data from GET resource /3200/0/5501 (num button presses)
	print("get_presses ",data)
	e = connector.getResourceValue(data['endpointName'],'/3200/0/5501')
	while not e.isDone():
		None
	if e.error:
		print("Error: ",e.error.errType, e.error.error, e.raw_data)
	else:
		data_to_emit = {"endpointName":data['endpointName'],"value":e.result}
		print data_to_emit
		emit('presses', data_to_emit)
    

def updateBlinkPattern(data):
	# Set data on PUT resource /3201/0/5853 (pattern of LED blink)
    print('update_blink_pattern ',data)
    e = connector.putResourceValue(data['endpointName'],'/3201/0/5853',data['blinkPattern'])
    while not e.isDone():
    	None
    if e.error:
	    print("Error: ",e.error.errType, e.error.error, e.raw_data)
    	
def blink(data):
	# POST to resource /3201/0/5850 (start blinking LED)
    print('blink: ',data)
    e = connector.postResource(data['endpointName'],'/3201/0/5850')
    while not e.isDone():
    	None
    if e.error:
    	print("Error: ",e.error.errType, e.error.error, e.raw_data)

# 'notifications' are routed here, handle subscriptions and update webpage
def notificationHandler(data):
	global socketio
	print "\r\nNotification Data Received : %s" %data['notifications']
	notifications = data['notifications']
	for thing in notifications:
		stuff = {"endpointName":thing["ep"],"value":b64decode(thing["payload"])}
		print "Emitting :",stuff
		socketio.emit('presses',stuff)

if __name__ == "__main__":
	connector.deleteAllSubscriptions()							# remove all subscriptions, start fresh
	connector.startLongPolling()								# start long polling connector.mbed.com
	connector.setHandler('notifications', notificationHandler) 	# send 'notifications' to the notificationHandler FN
	epList = connector.getEndpoints().result
	for index in range(len(epList)):
		print "Endpoint Found: ",epList[index]['name']
	e = connector.getResourceValue(epList[0]['name'],'/3200/0/5501')
	while not e.isDone():
		None
	print e.result
	# data_to_emit = {"endpointName":epList[0]['name'],"value":e.result}
	# print data_to_emit

	# if e.error:
	# 	print("Error: ",e.error.errType, e.error.error, e.raw_data)
	# else:
	# 	data_to_emit = {"endpointName":epList[0]['name'],"value":e.result}
	# 	print data_to_emit