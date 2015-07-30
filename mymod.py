#!/usr/bin/python
# -*- coding: utf-8 -*-

import sys, codecs
import json

# JSONファイル書き込み  http://d.hatena.ne.jp/fenrifja/20130306/1362571700
#def save_json_w_utf8(dic, filename):
#  s = json.dumps(dic, indent=2, ensure_ascii=False)
#  f = codecs.open(filename,'w','utf8')
#  f.write(s)
#  f.close()
def save_json_w_utf8(dic, filename):
  with codecs.open(filename,'w','utf8') as f:
    json.dump(dic, f, indent=2, ensure_ascii=False)




import os.path

def del_installed_oauth2_json():
  path = os.path.join(os.path.dirname(__file__),"@installed-oauth2.json")
  if(os.path.exists(path)):
    os.remove(path)
