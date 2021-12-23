import { Injectable } from '@angular/core';
import {
  Router, Resolve,
  RouterStateSnapshot,
  ActivatedRouteSnapshot
} from '@angular/router';
import {forkJoin, Observable, of} from 'rxjs';
import {JobTaskService} from "../services/job-task.service";
import {JobService} from "../services/job.service";
import {OrderService} from "../services/order.service";
import {BillService} from "../services/bill.service";
import {ErrorService} from "../services/error.service";
import {map} from "rxjs/operators";

@Injectable({
  providedIn: 'root'
})
export class BillResolver implements Resolve<any> {
  constructor(private billService: BillService){
  }
  resolve(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<any> | Promise<any> | any {
    // const a = this.jobTaskService.getAll();
    const b = this.billService.fetchBillableCustomers();
    console.log('bill resolver');
    const join = forkJoin(b).pipe(map((allResponses) => {
      return {
        billableCustomers: allResponses[0]
      };
    }));
    return join;
  }
}
