#!/usr/bin/python

import httplib2
import os
import sys

from apiclient.discovery import build
from apiclient.errors import HttpError
from oauth2client.client import flow_from_clientsecrets
from oauth2client.file import Storage
from oauth2client.tools import argparser, run_flow



import mymod

import json
# http://d.hatena.ne.jp/nishiohirokazu/20120112/1326355987
import sys, codecs
sys.stdout = codecs.getwriter(sys.stdout.encoding)(sys.stdout, errors='backslashreplace')




# The CLIENT_SECRETS_FILE variable specifies the name of a file that contains
# the OAuth 2.0 information for this application, including its client_id and
# client_secret. You can acquire an OAuth 2.0 client ID and client secret from
# the Google Developers Console at
# https://console.developers.google.com/.
# Please ensure that you have enabled the YouTube Data API for your project.
# For more information about using OAuth2 to access the YouTube Data API, see:
#   https://developers.google.com/youtube/v3/guides/authentication
# For more information about the client_secrets.json file format, see:
#   https://developers.google.com/api-client-library/python/guide/aaa_client_secrets

CLIENT_SECRETS_FILE = "../client_secrets.json"

# This variable defines a message to display if the CLIENT_SECRETS_FILE is
# missing.
MISSING_CLIENT_SECRETS_MESSAGE = """
WARNING: Please configure OAuth 2.0

To make this sample run you will need to populate the client_secrets.json file
found at:

   %s

with information from the Developers Console
https://console.developers.google.com/

For more information about the client_secrets.json file format, please visit:
https://developers.google.com/api-client-library/python/guide/aaa_client_secrets
""" % os.path.abspath(os.path.join(os.path.dirname(__file__),
                                   CLIENT_SECRETS_FILE))

# This OAuth 2.0 access scope allows for full read/write access to the
# authenticated user's account.
YOUTUBE_SCOPE = "https://www.googleapis.com/auth/youtube"
YOUTUBE_API_SERVICE_NAME = "youtube"
YOUTUBE_API_VERSION = "v3"

# If offsetMs is not valid, the API will throw an error
VALID_OFFSET_TYPES = ("offsetFromEnd", "offsetFromStart",)

def get_authenticated_service(args):
  flow = flow_from_clientsecrets(os.path.join(os.path.dirname(__file__),CLIENT_SECRETS_FILE),
    scope=YOUTUBE_SCOPE,
    message=MISSING_CLIENT_SECRETS_MESSAGE)

  #storage = Storage("%s-oauth2.json" % sys.argv[0])
  storage = Storage(os.path.join(os.path.dirname(__file__),"@installed-oauth2.json"))
  credentials = storage.get()

  if credentials is None or credentials.invalid:
    credentials = run_flow(flow, storage, args)

  return build(YOUTUBE_API_SERVICE_NAME, YOUTUBE_API_VERSION,
    http=credentials.authorize(httplib2.Http()))

def save_json_w_utf8(dic, filename):
  s = json.dumps(dic, indent=2, ensure_ascii=False)
  f = codecs.open(filename,'w','utf8')
  f.write(s)
  f.close()

def print_json(dic):
  s = json.dumps(dic, indent=2, ensure_ascii=False)
  print "%s" % (s)

if __name__ == '__main__':

  args = argparser.parse_args()

  mymod.del_installed_oauth2_json()

  youtube = get_authenticated_service(args)

  # https://developers.google.com/youtube/v3/docs/channels/list
  #channels_response = youtube.channels().list(mine=True, part="contentDetails").execute()
  channels_response = youtube.channels().list(mine=True, part="id,snippet,contentDetails").execute()

  print_json(channels_response)
