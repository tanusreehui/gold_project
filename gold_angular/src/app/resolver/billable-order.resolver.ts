import { Injectable } from '@angular/core';
import {
  Router, Resolve,
  RouterStateSnapshot,
  ActivatedRouteSnapshot, ActivatedRoute
} from '@angular/router';
import {forkJoin, Observable, of} from 'rxjs';
import {BillService} from '../services/bill.service';
import {map} from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class BillableOrderResolver implements Resolve<boolean> {
  customerId: number;
  constructor(private billService: BillService){
  }
  resolve(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<any> | Promise<any> | any {
    // const a = this.jobTaskService.getAll();
    console.log(route.params);
    const b = this.billService.fetchBillableOrdersByCustomerID(route.params.id);
    const join = forkJoin(b).pipe(map((allResponses) => {
      return {
        billableOrders: allResponses[0]
      };
    }));
    return join;
  }
}
