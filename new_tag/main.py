import eel
import requests
import json

  
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
    f = open('project_note.json')
    # a dictionary
    data = json.load(f)
    response = requests.get("http://127.0.0.1/gold_project/new_gold_api/public/api/dev/savedJobs")
    if response.status_code==200:
        saveJobDetails = response.json().get('data')       
        x='<table class= "table"><thead> <tr><th>Job Number</th><th>Date</th><th>Quantity</th><th>Size</th></tr>  </thead>  <tbody>'
        for i in saveJobDetails:
            x += '<tr>'
            x += add_tags('td',str(i['job_number']))
            x += add_td(str(i['date']))
            x += add_td(str(i['quantity']))
            x += add_td(str(i['size']))
            x += add_td(add_button('Select',i['job_number'],'finished-job'))
            x += '</tr>'
        x+= '<tbody></table>'
    return x
  
# Start the index.html file
eel.start("index.html")