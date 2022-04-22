# coding:utf-8
import jwt
import datetime as dt
import sys

#client_id = 'SEARCHADS.27478e71-3bb0-4588-998c-182e2b405577'
#team_id = 'SEARCHADS.27478e71-3bb0-4588-998c-182e2b405577'
#key_id = 'bacaebda-e219-41ee-a907-e2c25b24d1b2'
audience = 'https://appleid.apple.com'
alg = 'ES256'
client_id = sys.argv[1]
team_id = sys.argv[2]
key_id = sys.argv[3]
route = sys.argv[4]
# client_id = 'SEARCHADS.70411d00-7647-4e08-b694-f43b6f4fb3f0'
# team_id = 'SEARCHADS.70411d00-7647-4e08-b694-f43b6f4fb3f0'
# key_id = 'cb40a989-ad28-470d-80eb-10b59cdce5e4'

# Define issue timestamp.
issued_at_timestamp = int(dt.datetime.utcnow().timestamp())
# Define expiration timestamp. May not exceed 180 days from issue timestamp.
expiration_timestamp = issued_at_timestamp + 86400*180

# Define JWT headers.
headers = dict()
headers['alg'] = alg
headers['kid'] = key_id


# Define JWT payload.
payload = dict()
payload['sub'] = client_id
payload['aud'] = audience
payload['iat'] = issued_at_timestamp
payload['exp'] = expiration_timestamp
payload['iss'] = team_id

# Path to signed private key.
KEY_FILE = '/home/wwwroot/asa/public/uploads/route/'+route

with open(KEY_FILE,'r') as key_file:
     key = ''.join(key_file.readlines())

#key = 'MHcCAQEEIDvR/4weEbxpAHV8+w7ohogdcdSlVAHILUW7dagZUAWWoAoGCCqGSM49AwEHoUQDQgAEc94TMPuMlu6e/klo6muwWnTrb7VqzZBquur7cnDmnVMAUrQ0iWFfOy6QR2kKsG3bHq+4lwQ40j6EULVwAVY08Q=='
client_secret = jwt.encode(
payload=payload,
headers=headers,
algorithm=alg,
key=key
)

print(client_secret)
exit()
with open('/Users/yangshichao/Desktop/client_secret.txt', 'w') as output:
     output.write(client_secret)