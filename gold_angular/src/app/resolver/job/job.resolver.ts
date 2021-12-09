import { Injectable } from '@angular/core';
import {
  Router, Resolve,
  RouterStateSnapshot,
  ActivatedRouteSnapshot
} from '@angular/router';
import {forkJoin, Observable, of} from 'rxjs';
import {catchError, map} from 'rxjs/operators';
import {JobTaskService} from "../../services/job-task.service";
import {JobService} from "../../services/job.service";
import {ErrorService} from '../../services/error.service';

@Injectable({
  providedIn: 'root'
})
export class JobResolver implements Resolve<boolean> {
  constructor(private jobService: JobService, private errorService: ErrorService){
    console.log('resolver created for Job');
  }
  resolve(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<any> {
    console.log('Job detail resolver working');
    const a = this.jobService.getAll().pipe(
      catchError(error => {
        return of(false);
      }));
    const join = forkJoin(a).pipe(catchError(this.errorService.serverError), map((allResponses) => {
      return {
        jobServiceResponse: allResponses[0]
      };
    }));

    return join;
    // return forkJoin(a,b,c);
    // return of(true);
  }
  // resolve(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): Promise<any> | Observable<any> {
  //   console.log('Called Get job service in jobResolver...', route);
  //
  //   return this.jobService.getAll().pipe(
  //     catchError(error => {
  //       return of('No data');
  //     })
  //   );
  // }
}
