import requests

headers = {"Authorization": "Bearer 4SMf3bbEWuzD8tGxM7Kg9LQr4RZY7xpEPgbHde5AKGFd63CHvNajtDN3PoACybLLqce1dwa9kld2ketBUpqwvZZG41SqPXw7Mtnr",
"User-Agent": "curl/7.19.7 (x86_64-redhat-linux-gnu) libcurl/7.19.7 NSS/3.21 Basic ECC zlib/1.2.3 libidn/1.18 libssh2/1.4.2",
"Host": "api.connector.mbed.com",
"Accept": "*/*"
}

s = requests.get("https://api.connector.mbed.com/endpoints/",headers = headers)
print s.request.headers
print s.headers
print s.text
