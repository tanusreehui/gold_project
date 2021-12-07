import { Injectable } from '@angular/core';
import {
  Router, Resolve,
  RouterStateSnapshot,
  ActivatedRouteSnapshot
} from '@angular/router';
import {forkJoin, Observable, of} from 'rxjs';
import {JobService} from '../services/job.service';
import {JobTaskService} from '../services/job-task.service';
import {catchError, map} from 'rxjs/operators';
import {OrderService} from '../services/order.service';
import {BillService} from '../services/bill.service';
import {ErrorService} from '../services/error.service';

@Injectable({
  providedIn: 'root'
})
export class JobDetailResolver implements Resolve<any> {
  constructor(private jobTaskService: JobTaskService
              , private jobService: JobService
              , private orderService: OrderService
              , private billService: BillService
              , private errorService: ErrorService
  ){
    console.log('resolver created');
  }
  resolve(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<any> {
    console.log('Job detail resolver working');
    console.log('current route parameter is: ', route.params.id);
    const a = this.jobTaskService.getAll().pipe(
      catchError(error => {
        return of(false);
      }));
    const b = this.jobService.getAll().pipe(
      catchError(error => {
        return of(false);
      }));
    const c = this.jobTaskService.getCurrentJobData(route.params.id).pipe(
      catchError(error => {
        console.log('Error is: ', error);
        return of(false);
      }));
    // let c= this.orderService.getAll();
    // let savedJobList= this.jobTaskService.getSavedJobList();
    // let d= this.billService.getAll();
    // let b= observable(2);
    // let c= observable(3);
    const join = forkJoin(a, b, c).pipe(catchError(this.errorService.serverError), map((allResponses) => {
      return {
        jobTask: allResponses[0],
        job: allResponses[1],
        currentJob: allResponses[2]
      };
    }));

    return join;
   // return forkJoin(a,b,c);
    // return of(true);
  }

  // resolve(route: ActivatedRouteSnapshot,state: RouterStateSnapshot,): Observable<any> {
  //   let a= this.jobTaskService.getAll();
  //   let b= this.jobService.getAll();
  //   let data = {A: a, B: b};
  //   return of(data);
  // }
}
