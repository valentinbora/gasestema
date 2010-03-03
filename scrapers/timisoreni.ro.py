import mechanize
from mechanize import Browser
import urllib2
from urllib2 import URLError
from lxml import etree
from lxml import html
from StringIO import StringIO
import re
import sys

class crawler:
    
    
    
    
    def getUrl(self,url):
        user_agent='Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.15) Gecko/20080623 Firefox/2.0.0.15'
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
                
def sanitize(text):
    
    sanitized = text.replace("\n","").replace("\t","").replace("\r","")
    sanitized = sanitized.replace("- Adresa:","").replace("- Telefon:","").replace("(meniu pizza disponibil)","").strip()
    return sanitized

def crawlPageFirms(url,titleClass,infoClass):            
    a = crawler()
    a.getUrl(url)
    
    results = a.dom.xpath('//div[@class="'+titleClass+'"]')
    ret = []
    for result in results:
        
        title = result.xpath('a/b')[0].text
        address = result.xpath('(following-sibling::div[@class="'+infoClass+'"])[1]/text()')[0]
        telephone = result.xpath('(following-sibling::div[@class="'+infoClass+'"])[1]/text()')[1]

        ret.append({'title':sanitize(title),
                    'address':sanitize(address),
                    'telephone':sanitize(telephone)  
                    })
    return ret


#print crawlPageFirms('http://www.timisoreni.ro/servicii/pizzerii/',"firma_titlu_rec","firma_rec")
#print crawlPageFirms('http://www.timisoreni.ro/servicii/pizzerii/2.htm',"firma_titlu","firma")
print crawlPageFirms('http://www.timisoreni.ro/servicii/servicii_funerare/',"firma_titlu","firma")
