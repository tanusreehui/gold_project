import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {GlobalVariable} from "../shared/global";
import {FinishedJobs} from "../models/finishedJobs";
import {User} from "../models/user.model";
import {Subject} from "rxjs";
import {catchError, tap} from "rxjs/operators";

@Injectable({
  providedIn: 'root'
})
export class ChatService {
  employeeData : User [] = [];
  employeeDataSub = new Subject<User[]>();
  message : any;
  messageSub = new Subject<any>();

  getMessageSubUpdateListener(){
    return this.messageSub.asObservable();
  }

  getEmployeeListUpdateListener(){
    return this.employeeDataSub.asObservable();
  }

  constructor(private  http: HttpClient) {
    this.http.get(GlobalVariable.BASE_API_URL + '/getEmployees')
      .subscribe((response: {success: number, data: User[]}) => {
          this.employeeData = response.data;
          this.employeeDataSub.next(this.employeeData);
      });
    this.http.get('http://localhost:3000/messages')
      .subscribe((response) => {
        if (response){
          this.message = response;
          this.messageSub.next(this.message);
        }
      });
  }

  // getChats(id){
  //  return  this.http.get('http://localhost:3000/messages?person_id='+id)
  //     .pipe(tap((response: {success: number, data: string}) => {
  //       if (response){
  //         this.message = response;
  //         this.messageSub.next(this.message);
  //       }
  //     }));
  // }

  sendChats(item){
    return this.http.post('http://localhost:3000/messages',item).pipe(tap(((response) => {
      this.message.push(response);
      this.messageSub.next([...this.message]);
    })));
  }
  getEmployees(){
    return [...this.employeeData];
  }
}
