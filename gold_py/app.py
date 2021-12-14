from guietta import _, Gui, Quit,E
from tkinter import *
from tkinter import messagebox
import requests
import os
import json

filedata_0f = ''

# response = requests.get("http://127.0.0.1/gold_project/new_gold_api/public/api/dev/testJob/1")
#
# if response.status_code == 200:
#     print('ok: ')


def create_text_file(data):
    f = open("tag.txt", "w")
    f.write(data)
    f.close()
    # os.system('print_tag.bat')

def create_tag_data(data):
    filedata_0f = "N\n"
    filedata_0f += "R110,0\n"
    filedata_0f += "q831\n"
    filedata_0f += "S2\D12\OEb\n"
    filedata_0f += "A395,85,2,1,1,1,N,'" + data.name + "'\n"
    filedata_0f += "A245,85,2,1,1,1,N,'Of'\n"
    # filedata_0f += "B405,70,2,1,2,1,33,N,'" + str(jobDetails['job_id']) + "'\n"
    filedata_0f += "A405,33,2,2,1,1,N,'BB'\n"
    # filedata_0f += "A245,33,2,2,1,1,N,'" + str(jobDetails['job_id']) + "'\n"
    # filedata_0f += "A680,80,2,1,1,1,N,'" + str(modelNumber) + "'\n"
    filedata_0f += "A602,80,2,1,1,1,N,'Size:'\n"
    # filedata_0f += "A549,80,2,1,1,1,N,'" + str(jobDetails['product_size']) + "'\n"
    filedata_0f += "A490,80,2,1,1,1,N,'Qty:'\n"
    # filedata_0f += "A450,80,2,1,1,1,N,'" + str(jobDetails['pieces']) + "'\n"
    filedata_0f += "A680,60,2,1,1,1,N,'Gold Weight:'\n"
    # filedata_0f += "A550,60,2,1,1,1,N,'" + str(round(fineGold, 3)) + "'\n"
    filedata_0f += "A480,60,2,1,1,1,N,'HM'\n"
    filedata_0f += "A680,40,2,1,1,1,N,'Gross Weight:'\n"
    # filedata_0f += "A540,40,2,1,1,1,N,'" + str(round(jobDetails['product_wt'], 3)) + "'\n"
    filedata_0f += "A680,20,2,1,1,1,N,'Charge:'\n"
    # filedata_0f += "A600,20,2,1,1,1,N,'" + str(tagPrice) + "'\n"
    filedata_0f += "A555,20,2,1,1,1,N,'X'\n"
    # filedata_0f += "A535,20,2,1,1,1,N,'" + str(jobDetails['pieces']) + "'\n"
    filedata_0f += "A515,20,2,1,1,1,N,'='\n"
    # filedata_0f += "A505,20,2,1,1,1,N,'" + str(tagLcValue) + "'\n"
    filedata_0f += "P1\n\n"
    create_text_file(filedata_0f)

def varInitialization(data):
    gui.name = str(data['date'])


def getJobs(data):
    response = requests.get('http://127.0.0.1/gold_project/new_gold_api/public/api/dev/testJob/' + str(data))

    if response.status_code == 200:
        jobMasterData = response.json().get('data')
        gui.result = jobMasterData


        varInitialization(jobMasterData)
        # gui.jobMasterData = str(jobMasterData['date'])

        # gui.jobMasterData = str(jobMasterData['date'])
        # gui.jobMasterData = jobMasterData

        if not bool(gui.result):
            messagebox.showinfo("Information", "No Data Found")
            return
    else:
        messagebox.showerror("showerror", "Error")


gui = Gui(
    ['Enter Job Number: ', '__a__', ['Find'], ['Quit']],
    # ['Result:  -->', 'result', _, _],
    ['Name: ', '__name__', _, ['Create']],
)

while True:
    name, event = gui.get()

    if name == 'Quit':
        break

    # if not bool(gui.a):
    #     messagebox.showinfo("Information", "Missing Information")
    #     continue

    if name == 'Find':
        # gui.result = float(gui.a) + float(gui.b)
        # getJobs(gui.a)
        getJobs('JOB-00001-2122')
    else:
        gui.result = 0

    if name == 'Create':
        create_tag_data(gui)

# with gui.Calculate:
#     gui.result = float(gui.a) + float(gui.b)
#
# gui.run()

# while True:
#     name, event = gui.get()
#
#     if name == 'Calculate':
#         gui.result = float(gui.a) + float(gui.b)
#
#     elif name is None:
#         break
