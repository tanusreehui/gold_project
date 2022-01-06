import { Injectable } from '@angular/core';
import {
  Router, Resolve,
  RouterStateSnapshot,
  ActivatedRouteSnapshot
} from '@angular/router';
import {forkJoin, Observable, of} from 'rxjs';
import {BillService} from '../services/bill.service';
import {map} from 'rxjs/operators';
import {OrderBillService} from '../services/order-bill.service';

@Injectable({
  providedIn: 'root'
})
export class BillJobMasterResolver implements Resolve<boolean> {
  constructor(private orderBillService: OrderBillService){
  }
  resolve(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<any> | Promise<any> | any {
    const b = this.orderBillService.fetchBillableJobs(route.params.id);
    const join = forkJoin(b).pipe(map((allResponses) => {
      return {
        billableJobs: allResponses[0]
      };
    }));
    return join;
  }
}
