import { Injectable } from '@angular/core';
import {
  Router, Resolve,
  RouterStateSnapshot,
  ActivatedRouteSnapshot
} from '@angular/router';
import { Observable, of } from 'rxjs';
import {catchError} from "rxjs/operators";
import {JobTaskService} from "../services/job-task.service";
import {JobService} from "../services/job.service";

@Injectable({
  providedIn: 'root'
})
export class JobResolver implements Resolve<boolean> {
  constructor(private jobService: JobService){
    console.log("resolver created");
  }
  resolve(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): Promise<any> | Observable<any> {
    console.log('Called Get job service in jobResolver...', route);

    return this.jobService.getAll().pipe(
      catchError(error => {
        return of('No data');
      })
    );
  }
}
