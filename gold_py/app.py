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
    filedata_0f += "B405,70,2,1,2,1,33,N,'" + data.jobNumber + "'\n"
    filedata_0f += "A405,33,2,2,1,1,N,'BB'\n"
    filedata_0f += "A245,33,2,2,1,1,N,'" + data.jobNumber + "'\n"
    filedata_0f += "A680,80,2,1,1,1,N,'" + data.modelNumber + "'\n"
    filedata_0f += "A602,80,2,1,1,1,N,'Size:'\n"
    filedata_0f += "A549,80,2,1,1,1,N,'" + data.size + "'\n"
    filedata_0f += "A490,80,2,1,1,1,N,'Qty:'\n"
    filedata_0f += "A450,80,2,1,1,1,N,'" + data.quantity + "'\n"
    filedata_0f += "A680,60,2,1,1,1,N,'Gold Weight:'\n"
    filedata_0f += "A550,60,2,1,1,1,N,'" + data.goldWeight + "'\n"
    filedata_0f += "A480,60,2,1,1,1,N,'HM'\n"
    filedata_0f += "A680,40,2,1,1,1,N,'Gross Weight:'\n"
    filedata_0f += "A540,40,2,1,1,1,N,'" + data.grossWeight + "'\n"
    filedata_0f += "A680,20,2,1,1,1,N,'Charge:'\n"
    filedata_0f += "A600,20,2,1,1,1,N,'" + data.price + "'\n"
    filedata_0f += "A555,20,2,1,1,1,N,'X'\n"
    filedata_0f += "A535,20,2,1,1,1,N,'" + data.quantity + "'\n"
    filedata_0f += "A515,20,2,1,1,1,N,'='\n"
    filedata_0f += "A505,20,2,1,1,1,N,'" + data.total + "'\n"
    filedata_0f += "P1\n\n"
    create_text_file(filedata_0f)

def varInitialization(data):
    gui.name = 'Name'
    gui.jobNumber = str(data['jobNumber'])
    gui.modelNumber = str(data['modelNumber'])
    gui.size = 'test-size'
    gui.quantity = str(data['quantity'])
    gui.goldWeight = str(data['goldWeight'])
    gui.grossWeight = str(data['grossWeight'])
    gui.price = str(data['price'])


def getJobs(data):
    response = requests.get('http://127.0.0.1/gold_project/new_gold_api/public/api/dev/job/tag/jobMaster/' + str(data))

    if response.status_code == 200:
        jobMasterData = response.json().get('data')
        gui.result = jobMasterData

        gui.total = 0


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
    ['Name: ', '__name__', _, ['Create']],
    ['Job Number: ', '__jobNumber__', _, _],
    ['Model Number: ', '__modelNumber__', _, _],
    ['Size: ', '__size__', _, _],
    ['Quantity: ', '__quantity__', _, _],
    ['Gold Weight: ', '__goldWeight__', _, _],
    ['Gross Weight: ', '__grossWeight__', _, _],
    ['Price: ', '__price__', _, _],
    ['Total: ', 'total', _, _],
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
