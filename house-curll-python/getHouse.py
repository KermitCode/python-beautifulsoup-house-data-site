#!/usr/bin/python2.7
# -*- coding: utf8 -*-
import MySQLdb
import MySQLdb.cursors
import urllib2
import json
from bs4 import BeautifulSoup
import sys
import time


#0 */3 * * * /home/pythonroot/getHouse.py >> /home/pythonroot/python.log

reload(sys)
sys.setdefaultencoding( "utf-8" )

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


def getOneHouseData():
    headers = { 'User-Agent':'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36' }
    req = urllib2.Request( 
        #url="http://www.qdfd.com.cn/qdweb/realweb/indexnew.jsp", 
        url="https://www.qdfd.com.cn/qdweb/realweb/indexnew.jsp",
        headers = headers
    )
    res = urllib2.urlopen(req)
    cont = res.read()
    soup = BeautifulSoup(cont, "html.parser")
    datatable = soup.select('div[class="con2l f"] > div > table > tr')
    return datatable


def getSecondHouseData():
    headers = { 'User-Agent':'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36' }
    req = urllib2.Request( 
        #url="http://www.qdfd.com.cn/qdweb/realweb/indexnew.jsp", 
        url="https://www.qdfd.com.cn/qdweb/realweb/indexnew.jsp",
        headers = headers
    )
    res = urllib2.urlopen(req)
    cont = res.read()
    soup = BeautifulSoup(cont, "html.parser")
    datatable = soup.select('div[class="con2l r"] > div > table > tr')
    return datatable

#1取得地区
area = getArea()
#print json.dumps(area, encoding="UTF-8", ensure_ascii=False)

#2抓取一手房数据
oneData = getOneHouseData()

#3基础数据
date = time.strftime("%Y-%m-%d")
db_conn = db_connection()
cursor=db_conn.cursor()

for data in oneData:
    sql = ''
    souptr = BeautifulSoup(str(data), "html.parser")
    tr = souptr.select('td')
    ar = tr[0].get_text()
    one_h_n = tr[1].get_text()
    one_h_a = tr[2].get_text()
    one_a_n = tr[3].get_text()
    one_a_a = tr[4].get_text()
    ars =  ar.encode('UTF-8')
    aid =  area.get(ars)
    if not aid:
        continue 
    sql = "insert ignore into qd_house(area_id,date,one_house_num,one_house_area,one_all_num,one_all_area) values('%s','%s','%s','%s','%s','%s') on duplicate key update one_house_num='%s',one_house_area='%s',one_all_num='%s',one_all_area='%s'"%(aid,date,one_h_n,one_h_a,one_a_n,one_a_a,one_h_n,one_h_a,one_a_n,one_a_a)
    #插入数据表
    #print sql
    rs = cursor.execute(sql)
    #print rs

#4抓取二手房数据
twoData = getSecondHouseData()

for data in twoData:
    sql = ''
    souptr = BeautifulSoup(str(data), "html.parser")
    tr = souptr.select('td')
    ar = tr[0].get_text()
    two_h_n = tr[1].get_text()
    two_h_a = tr[2].get_text()
    two_a_n = tr[3].get_text()
    two_a_a = tr[4].get_text()
    ars =  ar.encode('UTF-8')
    aid =  area.get(ars)
    if not aid:
        continue 
    sql = "insert ignore into qd_house(area_id,date,two_house_num,two_house_area,two_all_num,two_all_area) values('%s','%s','%s','%s','%s','%s') on duplicate key update two_house_num='%s',two_house_area='%s',two_all_num='%s',two_all_area='%s'"%(aid,date,two_h_n,two_h_a,two_a_n,two_a_a,two_h_n,two_h_a,two_a_n,two_a_a)
    #插入数据表
    #print sql
    rs = cursor.execute(sql)
    #print rs

db_conn.close()

#获得当前时间时间戳
timeStamp = int(time.time())
#转换为其他日期格式,如:"%Y-%m-%d %H:%M:%S"
timeArray = time.localtime(timeStamp)
datetime = time.strftime("%Y-%m-%d %H:%M:%S", timeArray)

#datetime = time.strptime("%Y-%m-%d %H:%M:%S")
print 'success:' + datetime


