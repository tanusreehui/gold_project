import hui_html as html
import eel
import requests
import json


class HTML_div:
    div_content=''
    id=''
    div_class=''
    def __intit__(self,content,id='',div_class=''):
        self.div_content += content
    def append(self,content):
        self.div_content +=content 
    def generate(self):
        return '<div type="button" id="%s" class="btn btn-secondary %s">%s</div>' % (self.id,self.div_class,self.div_content)    

class HTML_row:
    tds=list()
    div_class=''
    id=''
    def __intit__(self,id='',div_class=''):
        self.id=id
        self.div_class=div_class
        self.tds.clear()
    def append_td(self,td):
        self.tds.append(td)
    def generate(self):
        temp_row = ' '.join(self.tds)
        return '<tr id="%s" class="%s">%s</tr>' % (id,self.div_class,temp_row)  
    def refresh(self):
        self.tds.clear() 
        self.div_class=''
        self.id=''

class HTML_td:
    content=''
    id=''
    div_classes=list()
    def __init__(self,td_content,id='',div_class=''):
        self.content=td_content
        self.id=id
        if div_class!='':
            self.classes.append(div_class)
    def append_class(self,new_class):
        self.div_classes.append(new_class)
    def generate(self):
        all_classes = ' '.join(self.div_classes)     
        return '<td id="%s" class="%s">%s</td>' % (self.id,all_classes,self.content)
    @staticmethod
    def get_td(td_content,id='',div_class=''):
        return '<td id="%s" class="%s">%s</td>' % (id,div_class,td_content)
            
  
        


eel.init("web")  

def add_tags(tag, word):
	return "<%s>%s</%s>" % (tag, word, tag)
def add_td(word):
    return "<td>%s</td>" % (word)
def add_button(word, id='', btn_class=''):
    return '<button type="button" id="%s" class="btn btn-secondary %s">%s</button>' % (id,btn_class,word)

def add_div(word, id='', btn_class=''):
    return '<div type="button" id="%s" class="btn btn-secondary %s">%s</div>' % (id,btn_class,word)
def add_input_group(label, value,id=''):
    return '<div class="input-group mb-3"><div class="input-group-prepend"><span class="input-group-text">%s</span></div><input type="text" class="form-control" placeholder="Username" value="%s" aria-label="Username" id="%s"></div>' % (label,value,id)





@eel.expose
def fetchTagDetails(jojobNumberbId):
    response = requests.get("http://127.0.0.1/gold_project/new_gold_api/public/api/dev/job/tag/jobMaster/%s" % (jojobNumberbId))
    if response.status_code==200:
        jobDetails = response.json().get('data')
        row = add_input_group('JOB NUMBER',jobDetails['jobNumber'])
        row += add_input_group('Model',jobDetails['modelNumber'])
        row += add_input_group('Gross',jobDetails['grossWeight'])
        
        html_final = add_div(row,'','d-flex flex-row bd-highlight mb-3')
        print(jobDetails)
    return html_final

@eel.expose
def fillTable():
    f = open('project.json')
    # a dictionary
    data = json.load(f)
    response = requests.get("%s/gold_project/new_gold_api/public/api/dev/savedJobs" %  (data['ip_address']))
    if response.status_code==200:
        saveJobDetails = response.json().get('data')       
        myTable = html.Table('finished_job','table')
        row = HTML_row()
        row.append_td(HTML_td.get_td('Job'))
        row.append_td(HTML_td.get_td('Date'))
        row.append_td(HTML_td.get_td('Qty'))
        row.append_td(HTML_td.get_td('Size'))
        myTable.appen_header_row(row.generate());
        row.refresh()
        
        for i in saveJobDetails:
            row=HTML_row()
            row.append_td(HTML_td.get_td(str(i['job_number'])))
            row.append_td(HTML_td.get_td(str(i['date'])))
            row.append_td(HTML_td.get_td(str(i['quantity'])))
            row.append_td(HTML_td.get_td(str(i['size'])))
            row.append_td(HTML_td.get_td(add_button('Select',i['job_number'],'finished-job')))
            myTable.appen_row(row.generate())
            row.refresh()
    y = myTable.generate()
    return y
  
# Start the index.html file
eel.start("index.html")