# -*- coding: utf8 -*-
import MySQLdb
import MySQLdb.cursors
import urllib2
from bs4 import BeautifulSoup
import sys
import time


#连接MYSQL
def db_connection():
    conn = MySQLdb.connect(host='127.0.0.1',db='04007CN',user='kermit',passwd='kermit127',port=3306,charset='utf8',cursorclass=MySQLdb.cursors.DictCursor)
    conn.autocommit(1)
    return conn

#取得区域的ID对应关系
def getArea():
    db_conn = db_connection()
    cursor=db_conn.cursor()
    cursor.execute('select * from qd_area')

    #提出所有区域
    areas = cursor.fetchall()
    areaName = {} 
    for area in areas:
        areau = area['area'].encode('UTF-8')
        areaName[areau]=area['id']
        #print str(area['area']) + '--' + str(area['id'])
    return areaName;

import json
def printjson(dictdata):
    print json.dumps(dictdata,encoding='utf-8',ensure_ascii=False)


reload(sys)
#sys.setdefaultencoding( "utf-8" )
area = getArea()
printjson(area)
exit()

def getOneHouseData():
    headers = { 'User-Agent':'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36' }
    req = urllib2.Request( 
        url="http://www.qdfd.com.cn/qdweb/realweb/indexnew.jsp", 
        headers = headers
    )
    res = urllib2.urlopen(req)
    cont = res.read()
    soup = BeautifulSoup(cont, "html.parser")
    datatable = soup.select('div[class="con2l f"] > div > table > tr')
    return datatable
