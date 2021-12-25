import eel
import requests
import os
from random import randint
  
eel.init("web")  
  
# Exposing the random_python function to javascript
@eel.expose    
def random_python():
    print("Random function running")
    return randint(1,100)

# using the eel.expose command  
@eel.expose  
# defining the function for addition of two numbers  
def add(data_1, data_2):  
    int1 = int(data_1)  
    int2 = int(data_2)  
    output = int1 + int2  
    return output  

@eel.expose
def fetchTagDetails(jojobNumberbId):
    response = requests.get("http://127.0.0.1/gold_project/new_gold_api/public/api/dev/job/tag/jobMaster/JOB-00001-2122")
    if response.status_code==200:
        jobDetails = response.json().get('data')
        print(jobDetails)
    return jobDetails;
@eel.expose
def runBatch():
    os.system('test.bat')
  
# Start the index.html file
eel.start("index.html")