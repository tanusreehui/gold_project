import { Injectable } from '@angular/core';
import {
  Router, Resolve,
  RouterStateSnapshot,
  ActivatedRouteSnapshot
} from '@angular/router';
import {forkJoin, Observable, of} from 'rxjs';
import {JobTaskService} from "../../services/job-task.service";
import {JobService} from "../../services/job.service";
import {OrderService} from "../../services/order.service";
import {BillService} from "../../services/bill.service";
import {ErrorService} from "../../services/error.service";
import {map} from "rxjs/operators";

@Injectable({
  providedIn: 'root'
})
export class JobReportResolver implements Resolve<boolean> {
  constructor(private jobService: JobService){
  }
  resolve(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<any> | Promise<any> | any {
    const b = this.jobService.getAllJobs();
    const join = forkJoin(b).pipe(map((allResponses) => {
      return {
        allJobs: allResponses[0],
      };
    }));

    return join;
  }
}
