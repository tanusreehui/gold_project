import eel
import requests
import json

  
eel.init("web")  

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
            # print(i)
            x += '<tr><td>'+str(i['job_number'])+'</td><td>'+str(i['date'])+'</td><td>'+str(i['quantity'])+'</td><td>'+str(i['size'])+'</td></tr>'
        x+= '<tbody></table>'
    return x
  
# Start the index.html file
eel.start("index.html")