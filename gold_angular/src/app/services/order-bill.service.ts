import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {GlobalVariable} from '../shared/global';
import {catchError, tap} from 'rxjs/operators';
import {ErrorService} from './error.service';

@Injectable({
  providedIn: 'root'
})
export class OrderBillService {

  constructor(private http: HttpClient, private errorService: ErrorService) {

  }
  fetchBillableJobs(orderMasterId: number){
    return this.http.get<any>(GlobalVariable.BASE_API_URL + '/bill/jobs/' + orderMasterId);
  }
}
