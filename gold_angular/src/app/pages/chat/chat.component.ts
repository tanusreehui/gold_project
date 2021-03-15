import { Component, OnInit } from '@angular/core';
import {ChatService} from '../../services/chat.service';
import {User} from '../../models/user.model';
import {DatePipe, formatDate} from '@angular/common';

@Component({
  selector: 'app-chat',
  templateUrl: './chat.component.html',
  styleUrls: ['./chat.component.scss']
})
export class ChatComponent implements OnInit {
  employeeList: User [];
  userInfo: User;
  messages: any;
  message: string;
  toPersonId: number;
  shownMessages: any;
  isMessageShown = false;
  toPerson: User;
  selectedJobIndex = -1;

  new_job_date = new Date();
  current_date = formatDate(this.new_job_date , 'yyyy/MM/dd', 'en');

  constructor(private chatService: ChatService) {
    this.employeeList = this.chatService.getEmployees();
  }

  ngOnInit(): void {
    this.isMessageShown = false;
    this.selectedJobIndex = -1;
    this.chatService.getEmployeeListUpdateListener().subscribe((response) => {
      this.employeeList = response;
    });
    this.chatService.getMessageSubUpdateListener().subscribe((response) => {
      console.log(response);
      this.messages = response;
    });
    this.userInfo = JSON.parse(localStorage.getItem('user'));
    console.log(this.userInfo);
  }

  getChats(id){
    this.toPersonId = id;
    this.isMessageShown = true;
    const index = this.employeeList.findIndex(k => k.id === this.toPersonId);
    this.selectedJobIndex = index ;
    this.toPerson  = this.employeeList[index];
    this.shownMessages = this.messages.filter( (x => x.person_id === id || x.person_id === this.userInfo.id));
    this.shownMessages = this.shownMessages.filter( (x => x.to_person_id === id || x.to_person_id === this.userInfo.id));
    // if(this.shownMessages.length >0){
    //   this.isMessageShown = true;
    // }

    // this.shownMessages = this.messages.filter((x=>x.person_id === this.userInfo.id) && (x=>x.to_person_id === this.toPersonId));
    // this.shownMessages = this.shownMessages.filter(x=>x.to_person_id === this.userInfo.id);

    console.log(this.shownMessages);
  }

  saveMessage(){
    const data = {
      customer_name: this.userInfo.userName,
      messages: this.message,
      person_id: this.userInfo.id,
      to_person_id: this.toPersonId,
      date: this.current_date
    };
    this.chatService.sendChats(data).subscribe((response) => {
      if (response){
        // console.log(response);
        this.message = null;
        this.shownMessages = this.messages.filter( (x => x.person_id === this.toPersonId || x.person_id === this.userInfo.id));
        this.shownMessages = this.shownMessages.filter( (x => x.to_person_id === this.toPersonId || x.to_person_id === this.userInfo.id));
      }
    });
  }

  getBackgroundColor(index: number){
    if (index === this.selectedJobIndex){
      return {
        'background-color': '#6b6b47',
        color: 'seashell'
      };
    }
  }

}
