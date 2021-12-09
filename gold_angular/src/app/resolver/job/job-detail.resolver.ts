import { Injectable } from '@angular/core';
import {
  Router, Resolve,
  RouterStateSnapshot,
  ActivatedRouteSnapshot
} from '@angular/router';
import {forkJoin, Observable, of} from 'rxjs';
import {JobService} from '../../services/job.service';
import {JobTaskService} from '../../services/job-task.service';
import {catchError, map} from 'rxjs/operators';
import {OrderService} from '../../services/order.service';
import {BillService} from '../../services/bill.service';
import {ErrorService} from '../../services/error.service';

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
  }
  resolve(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<any> | boolean {
    const a = this.jobTaskService.getAll();
    const b = this.jobService.getAll();
    const c = this.jobTaskService.getCurrentJobData(route.params.id);
    const d = this.jobTaskService.fetchJobSummarisation(route.params.id);

    // let c= this.orderService.getAll();
    // let savedJobList= this.jobTaskService.getSavedJobList();
    // let d= this.billService.getAll();
    // let b= observable(2);
    // let c= observable(3);
    const join = forkJoin(a, b, c,d).pipe(map((allResponses) => {
      return {
        jobTask: allResponses[0],
        job: allResponses[1],
        currentJob: allResponses[2],
        JobSummarisation: allResponses[3]
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
