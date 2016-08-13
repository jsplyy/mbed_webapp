import mbed_connector_api 				# mbed Device Connector library
import pybars 							# use to fill in handlebar templates
from   flask 			import Flask,request,render_template	# framework for hosting webpages
from   flask_socketio 	import SocketIO, emit,send,join_room, leave_room  
from   base64 			import standard_b64decode as b64decode
import os
import random
import time
app = Flask(__name__)
socketio = SocketIO(app,async_mode='threading')

if 'ACCESS_KEY' in os.environ.keys():
	token = os.environ['ACCESS_KEY'] # get access key from environment variable
else:
	token = "4SMf3bbEWuzD8tGxM7Kg9LQr4RZY7xpEPgbHde5AKGFd63CHvNajtDN3PoACybLLqce1dwa9kld2ketBUpqwvZZG41SqPXw7Mtnr" # replace with your API token

connector = mbed_connector_api.connector(token)

@app.route('/')
def index():
	#return "hello world!"

	# get list of endpoints, for each endpoint get the pattern (/3201/0/5853) value
	epList = connector.getEndpoints().result
	print epList
	# for index in range(len(epList)):
	# 	print "Endpoint Found: ",epList[index]['name']
	# 	e = connector.getResourceValue(epList[index]['name'],"/3201/0/5853")
	# 	while not e.isDone():
	# 		None
	# 	epList[index]['blinkPattern'] = e.result
	# print "Endpoint List :",epList
	# # fill out html using handlebar template
	# handlebarJSON = {'endpoints':epList}
	# comp = pybars.Compiler()
	# source = unicode(open("./views/index.hbs",'r').read())
	# template = comp.compile(source)
	# return "".join(template(handlebarJSON))
	#return render_template("index.html");

	return render_template("index.html",epList=epList,number=range(len(epList)))
@app.route('/resources',methods=['GET'])
def resources():
	# epList = connector.getEndpoints().result
	# print epList
	#epResources = connector.getResources(request.args.get("pointid"))
	#epResources = connector.getResources(request.args.get("pointid"))
	epResources = connector.getResources(request.args.get("pointid")).result
	number = range(len(epResources))
	#return epResources[0]['rt']
	# print epResources
	return render_template("tpl_resources.html",pointid=request.args.get("pointid"),epResources=epResources,number=number)

@app.route('/get_blink_resource',methods=['GET'])
def get_blink_resource():
	epBlinkResource = connector.postResource(request.args.get("pointid"),request.args.get("blinkid"),"flash")
	while not epBlinkResource.isDone():
		None
	return render_template("tpl_blink_resources.html")

@app.route('/get_button_resource',methods=['GET'])
def get_button_resource():
	epButtonResource = connector.getResourceValue(request.args.get("pointid"),request.args.get("buttonid"))
	while not epButtonResource.isDone():
		None	
	#return epButtonResource.result
	return render_template("tpl_btn_resources.html",cntNumber=epButtonResource.result,pointid=request.args.get("pointid"))

@app.route('/get_pattern_resource',methods=['GET'])
def get_pattern_resource():
	if(request.args.get("value")!='1'):
		epPatternResource = connector.putResourceValue(request.args.get("pointid"),request.args.get("patternid"),request.args.get("value"))
		while not epPatternResource.isDone():
			None
	epPatternResource = connector.getResourceValue(request.args.get("pointid"),request.args.get("patternid"))
	while not epPatternResource.isDone():
		None
	#return epPatternResource.result
	return render_template("tpl_pattern_resources.html",patternContent=epPatternResource.result,pointid=request.args.get("pointid"),patternid=request.args.get("patternid"))
@app.route('/mcu_temp', methods=['GET'])
def get_mcu_temp():
	return render_template("mcu_temp.html")

@app.route('/temp', methods=['GET'])
def get_temp():
	# if(request.args.get("data")=='2'):
		# return str(random.randint(34,40))
	# 	tempResource = connector.postResource("dc04acea-1d5a-4bbf-b1b6-fb7ee0de9e69","/3205/0/3206/","temp")
	# 	while not tempResource.isDone():
	# 		None
	# 	return tempResource.result


	# return connector.getEndpoints().result
	# print "receive success"
	ticks = "receive:" + str(time.time()) + "</br>"
	# return ticks
	# tempResource = connector.postResource("dc04acea-1d5a-4bbf-b1b6-fb7ee0de9e69","/3205/0/3206", "temp")
	# while not tempResource.isDone():
	# 	None
	# tempResource = connector._postURL("/endpoints/dc04acea-1d5a-4bbf-b1b6-fb7ee0de9e69/3205/0/3206")
	# epPatternResource = connector.getResourceValue("dc04acea-1d5a-4bbf-b1b6-fb7ee0de9e69","/3205/0/3206")
	# while not epPatternResource.isDone():
	# 	None
	# return epPatternResource.result
	epButtonResource = connector.postResource(request.args.get("pointid"),request.args.get("tempid"))
	while not epButtonResource.isDone():
		None
	return epButtonResource.result
	# ticks = ticks + "response:" + str(time.time()) + "</br>"
	# ticks = ticks + str(tempResource.content)
	# return str(tempResource)
	# return tempResource.result
	# return "100"		

@socketio.on('connect')
def connect():
	print('connect ')
	join_room('room')

@socketio.on('disconnect')
def disconnect():
	print('Disconnect')
	leave_room('room')

@socketio.on('subscribe_to_presses')
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

@socketio.on('unsubscribe_to_presses')
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
    
@socketio.on('get_presses')
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
    
@socketio.on('update_blink_pattern')
def updateBlinkPattern(data):
	# Set data on PUT resource /3201/0/5853 (pattern of LED blink)
    print('update_blink_pattern ',data)
    e = connector.putResourceValue(data['endpointName'],'/3201/0/5853',data['blinkPattern'])
    while not e.isDone():
    	None
    if e.error:
	    print("Error: ",e.error.errType, e.error.error, e.raw_data)
    	

@socketio.on('blink')
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
	socketio.run(app,host='0.0.0.0', port=80,debug=True)
	# socketio.run(app,host='0.0.0.0', port=80)