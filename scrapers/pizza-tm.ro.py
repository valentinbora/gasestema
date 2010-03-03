# -*- coding: utf-8 -*-
#import mechanize
#from mechanize import Browser
import urllib2
from urllib2 import URLError
from lxml import etree
from lxml import html
from StringIO import StringIO
import time
import re
import sys
import MySQLdb
link = MySQLdb.connect (host = "localhost",
                           user = "gasestema",
                           passwd = "gasestema",
                           db = "gasestema_test",
                           charset = "utf8",
                           use_unicode = True
                           )     


def translit(string):
    translit = {
            u"\u0102" : "A",
            u"\u0103" : "a",
            u"\u00c2" : "A",
            u"\u00e2" : "a",
            u"\u00ce" : "I",
            u"\u00ee" : "i",
            u"\u0218" : "S",
            u"\u0219" : "s",
            u"\u021a" : "T",
            u"\u021b" : "t",
            u"\u015e" : "S",
            u"\u015f" : "s",
            u"\u0162" : "T",
            u"\u0163" : "t"
    }

    for k in translit:
        string = string.replace(k,translit[k])
            
    return string
            

def insertLabel(label):
    label = translit(label)
    
    cursor = link.cursor()
    result = cursor.execute("SELECT id FROM tag WHERE nume='"+str(label)+"' ")
    row = cursor.fetchone()
    if row:
        return row[0]
    else:
        link.cursor().execute("INSERT INTO tag(nume) VALUES('"+str(label)+"')")
        cursor = link.cursor()
        result = cursor.execute("SELECT LAST_INSERT_ID();")
        row = cursor.fetchone()
        return row[0]
    
def insertLocatie(nume,localitate=1,adresa='',url='',contact='',descriere='',orar=''):
    nume = translit(nume)
    adresa = translit(adresa)
    url = translit(url)
    contact = translit(contact)
    descriere = translit(descriere)
    orar = translit(orar)
    
    cursor = link.cursor()
    result = cursor.execute("SELECT id FROM locatie WHERE nume='"+str(nume)+"' ")
    row = cursor.fetchone()
    if row:
        return row[0]
    else:
        
        link.cursor().execute("set autocommit=1;INSERT INTO locatie(nume,localitate,adresa,link,contact,descriere,orar) VALUES('"+nume+"','"+str(localitate)+"','"+adresa+"','"+url+"','"+contact+"','"+descriere+"','"+orar+"')")
        cursor = link.cursor()
        result = cursor.execute("SELECT LAST_INSERT_ID();")
        row = cursor.fetchone()
        return row[0]
        
def insertNume(nume,descriere):
    descriere = translit(descriere).replace("-","").strip()
    nume = translit(nume).strip()
    
    
    cursor = link.cursor()
    result = cursor.execute("SELECT id FROM obiect_nume WHERE nume='"+str(nume)+"' and descriere='"+str(descriere)+"' ")
    row = cursor.fetchone()
    if row:
        return row[0]
    else:
        
        link.cursor().execute("set autocommit=1;INSERT INTO obiect_nume(nume,descriere) VALUES('"+nume+"','"+str(descriere)+"')")
        cursor = link.cursor()
        result = cursor.execute("SELECT LAST_INSERT_ID();")
        row = cursor.fetchone()
        return row[0]

def insertTagObiect(tagId,obiectId):
    cursor = link.cursor()
    result = cursor.execute("SELECT id FROM tag_obiect WHERE tag='"+str(tagId)+"' and obiect='"+str(obiectId)+"' ")
    row = cursor.fetchone()
    if row:
        return row[0]
    else:
        link.cursor().execute("set autocommit=1;INSERT INTO tag_obiect(tag,obiect) VALUES('"+str(tagId)+"','"+str(obiectId)+"')")
        cursor = link.cursor()

def insertObiect(numeId=0,localitate = 1,locatieId=0,user = 2,adaugat = False):
    if adaugat == False:
        adaugat = int(time.time())
    cursor = link.cursor()
    result = cursor.execute("SELECT id FROM obiect WHERE nume='"+str(numeId)+"'and localitate='"+str(localitate)+"'")
    row = cursor.fetchone()
    if row:
        return row[0]
    else:
        
        link.cursor().execute("set autocommit=1;INSERT INTO obiect(nume,localitate,locatie,user,adaugat) VALUES('"+str(numeId)+"','"+str(localitate)+"','"+str(locatieId)+"','"+str(user)+"','"+str(adaugat)+"')")
        cursor = link.cursor()
        result = cursor.execute("SELECT LAST_INSERT_ID();")
        row = cursor.fetchone()
        return row[0]    

class crawler:
    
    
    
    
    def getUrl(self,url):
        user_agent='Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.15) Gecko/20080623'
        http_accept="text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8"
        request = urllib2.Request(url)
        request.add_header('User-Agent',user_agent)
        request.add_header('Accept',http_accept)
        request.add_header('Accept-Language','en-us,en;q=0.5')
        opener = urllib2.build_opener()
        url_contents = opener.open(request).read()

        
        
        try:
            self.dom = html.fromstring(url_contents)
        except  etree.XMLSyntaxError, e:
            print e; 
            

pizzaTagId = insertLabel('pizza')
            
a = crawler()
a.getUrl('http://www.pizza-tm.ro/mancare-in-timisoara/pizza/')

results = a.dom.xpath('//div[@class="margin"]/h2/a/@href')
for result in results:                
    pizzaUrl = result
    a.getUrl(pizzaUrl)
    
    numePizzerie = a.dom.xpath('//h1[@class="pageTitle"]/text()')[0]
    labels = a.dom.xpath('//div[@class="boxWhiteMargin"]/strong')
    telefon = adresa = orar = site = ''
    for label in labels:
        type = label.text.replace(":","").lower()
        value = label.xpath('(following-sibling::text())[1]')[0].strip()
        if type=='website' :
            site = a.dom.xpath('//div[@class="boxWhiteMargin"]/a/@href')[0]
        if type == 'telefon':
            telefon = value
        if type == 'adresa':
            adresa = value
        if type == 'orar':
            orar = value            
    
    locatieId = insertLocatie(numePizzerie,1,adresa,site,telefon,"",orar);
    
    #exit()
    
    try:
        menuItems = a.dom.xpath('//table[@class="meniuPizza"]/tbody/tr')
        for menuItem in menuItems:
            tds = menuItem.xpath('td')
            numePizza = tds[1].xpath('h3/text()')[0].strip()
            ingrediente = tds[1].xpath('p/text()')[0].replace(u"\u2013","").strip()
            #print numePizza,ingrediente
            numeId = insertNume(numePizza,ingrediente)
            
            
            obiectId = insertObiect(numeId,1,locatieId)
            
            insertTagObiect(pizzaTagId,obiectId)
            print 'obiect=',obiectId
    except Exception,e:
        print pizzaUrl

    #exit() 
    
    
    
