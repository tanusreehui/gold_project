import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {GlobalVariable} from '../shared/global';
import {catchError, tap} from 'rxjs/operators';
import {ErrorService} from './error.service';
import {BillMaster} from '../models/billMaster.model';

@Injectable({
  providedIn: 'root'
})
export class OrderBillService {

  constructor(private http: HttpClient, private errorService: ErrorService) {

  }
  fetchBillableJobs(orderMasterId: number){
    return this.http.get<any>(GlobalVariable.BASE_API_URL + '/bill/jobs/' + orderMasterId);
  }
  fetchProformaInvoice(orderMasterId: number, jobIds: any[]){
    return this.http.post(GlobalVariable.BASE_API_URL + '/proformaInvoice/orderMaster/' + orderMasterId,{"job_ids": jobIds});
  }
  fetchSettings(){
    return this.http.get('assets/settings.json');
  }
  saveBillMaster(bill){
    return this.http.post<{ success: boolean, message: string, data: any }>( GlobalVariable.BASE_API_URL + '/saveBillMaster' , bill)
      .pipe(catchError(this.errorService.serverError), tap(((response: {success: boolean, message: string, data: any}) => {

      })));
  }
}
