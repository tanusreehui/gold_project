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




@eel.expose
def fetchTagDetails(jojobNumberbId):
    response = requests.get("http://127.0.0.1/gold_project/new_gold_api/public/api/dev/job/tag/jobMaster/JOB-00001-2122")
    if response.status_code==200:
        jobDetails = response.json().get('data')
        print(jobDetails)
    return jobDetails

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