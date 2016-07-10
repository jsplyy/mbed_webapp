from flask import Flask
from flask import request
import requests

app = Flask(__name__)

@app.route('/', methods=['GET', 'POST'])
def home():
        headers = {"Authorization": "Bearer 4SMf3bbEWuzD8tGxM7Kg9LQr4RZY7xpEPgbHde5AKGFd63CHvNajtDN3PoACybLLqce1dwa9kld2ketBUpqwvZZG41SqPXw7Mtnr",
        "User-Agent": "curl/7.19.7 (x86_64-redhat-linux-gnu) libcurl/7.19.7 NSS/3.21 Basic ECC zlib/1.2.3 libidn/1.18 libssh2/1.4.2",
        "Host": "api.connector.mbed.com",
        "Accept": "*/*"
        }

        s = requests.get("https://api.connector.mbed.com/endpoints/",headers = headers)
        return str(s.request.headers) + str(s.headers) + str(s.text)

@app.route('/signin', methods=['GET'])
def signin_form():
    return '''<form action="/signin" method="post">
              <p><input name="username"></p>
              <p><input name="password" type="password"></p>
              <p><button type="submit">Sign In</button></p>
              </form>'''

@app.route('/signin', methods=['POST'])
def signin():
    if request.form['username']=='admin' and request.form['password']=='password':
        return '<h3>Hello, admin!</h3>'
    return '<h3>Bad username or password.</h3>'

app.run()
