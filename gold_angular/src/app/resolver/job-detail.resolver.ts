import { Injectable } from '@angular/core';
import {
  Router, Resolve,
  RouterStateSnapshot,
  ActivatedRouteSnapshot
} from '@angular/router';
import {forkJoin, Observable, of} from 'rxjs';
import {JobService} from "../services/job.service";
import {JobTaskService} from "../services/job-task.service";
import {catchError} from "rxjs/operators";

@Injectable({
  providedIn: 'root'
})
export class JobDetailResolver implements Resolve<any> {
  constructor(private jobTaskService: JobTaskService, private jobService: JobService){
    console.log("resolver created");
  }
  resolve(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): Promise<any> | Observable<any> {
    console.log('Job detail resolver working');
    let a= this.jobTaskService.getAll();
    let b= this.jobService.getAll();
    // let b= observable(2);
    // let c= observable(3);
    return forkJoin(a,b).pipe(
      catchError(error => {
        return of('No data');
      }));
    // return of(true);
  }
}
