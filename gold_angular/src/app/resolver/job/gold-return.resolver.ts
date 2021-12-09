import { Injectable } from '@angular/core';
import {
  Router, Resolve,
  RouterStateSnapshot,
  ActivatedRouteSnapshot, ActivatedRoute
} from '@angular/router';
import {forkJoin, Observable, of} from 'rxjs';
import {map} from "rxjs/operators";
import {JobTaskService} from "../../services/job-task.service";
import {JobService} from "../../services/job.service";
import {OrderService} from "../../services/order.service";
import {BillService} from "../../services/bill.service";
import {ErrorService} from "../../services/error.service";

@Injectable({
  providedIn: 'root'
})
export class GoldReturnResolver implements Resolve<any> {
  constructor(private jobTaskService: JobTaskService){

  }
  resolve(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<any> | boolean {
    const a = this.jobTaskService.getCurrentJobData(route.params.id);
    let b= this.jobTaskService.fetchAllMaterials();
    // let savedJobList= this.jobTaskService.getSavedJobList();
    // let d= this.billService.getAll();
    // let b= observable(2);
    // let c= observable(3);
    const join = forkJoin(a,b).pipe(map((allResponses) => {
      return {
        currentJob: allResponses[0],
        materials: allResponses[1]
      };
    }));

    return join;
    // return forkJoin(a,b,c);
    // return of(true);
  }
}
