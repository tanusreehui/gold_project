import eel
import requests
import json
import pandas as pd

  
eel.init("web")  

def add_tags(tag, word):
	return "<%s>%s</%s>" % (tag, word, tag)
def add_td(word):
    return "<td>%s</td>" % (word)





def get_data():
    dict_data = [
        {
        'duration': 0.7,
        'project_id': 3,
        'resource':  'Arya Stark',
        'activity':  'Development'
    },
    {
        'duration': 0.9,
        'project_id': 4,
        'resource':  'Ned Stark',
        'activity':  'Development'
    },
    {
        'duration': 2.88,
        'project_id': 7,
        'resource':  'Robb Stark',
        'activity':  'Development'
    },
    {
        'duration': 0.22,
        'project_id': 9,
        'resource':  'Jon Snow',
        'activity':  'Support'
    },
    {
        'duration': 0.3,
        'project_id': 9,
        'resource':  'Jon Snow',
        'activity':  'Support'
    },
    {
        'duration': 2.15,
        'project_id': 3,
        'resource':  'Arya Stark',
        'activity':  'Practise'
    },
    {
        'duration': 3.35,
        'project_id': 4,
        'resource':  'Sansa Stark',
        'activity':  'Development'
    },
    {
        'duration': 2.17,
        'project_id': 9,
        'resource':  'Rickon Stark',
        'activity':  'Development'
    },
    {
        'duration': 1.03,
        'project_id': 4,
        'resource':  'Benjan Stark',
        'activity':  'Design'
    },
    {
        'duration': 1.77,
        'project_id': 4,
        'resource':  'Bran Stark',
        'activity':  'Testing'
    },
    {
        'duration': 1.17,
        'project_id': 4,
        'resource':  'Ned Stark',
        'activity':  'Development'
    },
    {
        'duration': 0.17,
        'project_id': 9,
        'resource':  'Jon Snow',
        'activity':  'Support'
    },
    {
        'duration': 1.77,
        'project_id': 3,
        'resource':  'catelyn stark',
        'activity':  'Development'
    },
    {
        'duration': 0.3,
        'project_id': 9,
        'resource':  'Jon Snow',
        'activity':  'Support'
    },
    {
        'duration': 0.45,
        'project_id': 9,
        'resource':  'Jon Snow',
        'activity':  'Support'
    }
    ]

    df = pd.DataFrame(dict_data)
    dfg = df.groupby(['project_id', 'resource', 'activity']).sum()
    k = dfg.to_html('result.html')
    return k





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
            x += '<tr>'
            x += add_tags('td',str(i['job_number']))
            x += add_td(str(i['date']))
            x += '<td>'+str(i['quantity'])+'</td>'
            x += '<td>'+str(i['size'])+'</td>'
            x += '</tr>'
        x+= '<tbody></table>'
    return get_data()
  
# Start the index.html file
eel.start("index.html")