import { Injectable } from '@angular/core';
import {Agent} from '../models/agent.model';
import {HttpClient} from '@angular/common/http';
import {Subject} from 'rxjs';
import {FormControl, FormGroup, Validators} from '@angular/forms';
import {Product} from '../models/product.model';
import {ProductResponseData} from './product.service';
import {GlobalVariable} from '../shared/global';
import {Customer} from '../models/customer.model';
import {catchError, tap} from 'rxjs/operators';
import {OrderMaster} from '../models/orderMaster.model';

export interface AgentResponseData {
  success: number;
  data: object;
}

@Injectable({
  providedIn: 'root'
})

export class AgentService {
  agentData: Agent[] = [];
  dueByAgentData: any = [];
  userTypeList: any[] = [];
  customerUnderAgentData: Customer[] = [];
  private dueByAgentDataSub = new Subject<any>();
  private  customerUnderAgentDataSub = new Subject<Customer[]>();
  agentForm: FormGroup;

  private agentSub = new Subject<Agent[]>();

  getAgentUpdateListener(){
    return this.agentSub.asObservable();
  }
  getDueByAgentDataUpdateListener(){
    return  this.dueByAgentDataSub.asObservable();
  }

  constructor(private http: HttpClient) {

    this.agentForm = new FormGroup({
      id : new FormControl(null),
      user_name : new FormControl(null, [Validators.required, Validators.maxLength(20), Validators.minLength(4)]),
      // email : new FormControl(null, [Validators.required, Validators.email]),
      mobile1 : new FormControl('+91', [Validators.maxLength(13)]),
      mobile2 : new FormControl('+91', [Validators.maxLength(13)]),
      user_type_id: new FormControl(7),
      // user_type_name: new FormControl(null),
      customer_category_id : new FormControl(2),
      address1 : new FormControl(null),
      address2 : new FormControl(null),
      state : new FormControl('West Bengal'),
      po : new FormControl(null),
      area : new FormControl(null),
      city : new FormControl(null),
      pin : new FormControl(null, [Validators.pattern('^[0-9]*$'), Validators.maxLength(6)]),
      opening_balance_LC : new FormControl(0.00),
      opening_balance_Gold : new FormControl(0.00),
      mv : new FormControl(0.00),
      discount : new FormControl(0.00),
      email : new FormControl(null,[Validators.email]),
      password : new FormControl(null)
    });

    this.http.get(GlobalVariable.BASE_API_URL + '/agents')
      .subscribe((response: {success: number, data: Agent[]}) => {
        // @ts-ignore
        const {data} = response;
        this.agentData = data;
        this.agentSub.next([...this.agentData]);
      });

    this.http.get(GlobalVariable.BASE_API_URL + '/getDueByAgent')
      .subscribe((response: {success: number, data: any}) => {
        this.dueByAgentData = response.data;
        this.dueByAgentDataSub.next([...this.dueByAgentData]);
      });


  }

  fillAgentFormForEdit(data){

    this.agentForm.setValue(data);
  }



  getLatestAgent(){
    this.http.get(GlobalVariable.BASE_API_URL + '/agents')
      .subscribe((response: {success: number, data: Agent[]}) => {
        // @ts-ignore
        const {data} = response;
        this.agentData = data;
        this.agentSub.next([...this.agentData]);
      });
  }

  getCustomerUnderAgent(data){
    return  this.http.get(GlobalVariable.BASE_API_URL + '/getCustomerUnderAgent/' + data)
       .pipe(tap(((response: {success: number, data: Customer[]}) => {
        this.customerUnderAgentData = response.data;
        this.customerUnderAgentDataSub.next([...this.customerUnderAgentData]);
       })));
  }

  getCustomerPassbook(data){
    return  this.http.get(GlobalVariable.BASE_API_URL + '/getCustomerPassbook/' + data)
      .pipe(tap(((response: {success: number, data: any }) => {

      })));
  }


  saveAgent(){
    return this.http.post<AgentResponseData>(GlobalVariable.BASE_API_URL + '/agents', this.agentForm.value)
      .pipe(tap(((response: {success: number, data: Agent }) => {
           this.agentData.unshift(response.data);
           this.agentSub.next([...this.agentData]);

      })));
  }

  deleteAgent(id){
    return this.http.delete<AgentResponseData>(GlobalVariable.BASE_API_URL + 'agents/' + id);
  }

  updateAgent(){
    return this.http.patch<AgentResponseData>(GlobalVariable.BASE_API_URL + '/agents/' + this.agentForm.value.id, this.agentForm.value);
  }
  getAgentList(){
    return [...this.agentData];
  }

  // getDueByAgentList(){
  //   return [...this.dueByAgentData];
  // }

  getLatestDueByAgentListList(){
   return this.http.get(GlobalVariable.BASE_API_URL + '/getDueByAgent')
      .subscribe((response: {success: number, data: any}) => {
        this.dueByAgentData = response.data;
        this.dueByAgentDataSub.next([...this.dueByAgentData]);
      });
  }
  getDueByAgentListList(){
    return [...this.dueByAgentData];
  }

  getUserTypes(){
    return this.http.get(GlobalVariable.BASE_API_URL + '/getUserTypes');
  }
}
