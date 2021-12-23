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
  resolve(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<any> | Promise<any> | any {
    // const a = this.jobTaskService.getAll();
    const b = this.jobService.fetchKarigarhs();
    const c = this.jobTaskService.getCurrentJobData(route.params.id);
    const d = this.jobTaskService.fetchJobSummarisation(route.params.id);
    const e = this.jobTaskService.fetchBadges(route.params.id);
    const f = this.jobTaskService.fetchAllMaterials();
    const g = this.jobTaskService.getAllTransactions(route.params.id);
    const join = forkJoin(b, c, d, e,f,g).pipe(map((allResponses) => {
      return {
        karigarhs: allResponses[0],
        currentJob: allResponses[1],
        JobSummarisation: allResponses[2],
        jobBadges: allResponses[3],
        materials: allResponses[4],
        allJobTransactions: allResponses[5]
      };
    }));
    return join;
  }
}
