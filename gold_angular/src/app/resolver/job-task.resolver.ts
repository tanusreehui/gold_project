import { Injectable } from '@angular/core';
import {
  Router, Resolve,
  RouterStateSnapshot,
  ActivatedRouteSnapshot
} from '@angular/router';
import { Observable, of } from 'rxjs';
import {NewJobTaskService} from "../services/new-job-task.service";
import {catchError} from "rxjs/operators";
import {JobTaskService} from "../services/job-task.service";

@Injectable({
  providedIn: 'root'
})
export class JobTaskResolver implements Resolve<any> {
  constructor(private jobTaskService: JobTaskService){
    console.log("resolver created");
  }
  resolve(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<any> {
    console.log('Called Get Product in resolver...', route);

    return this.jobTaskService.getAll().pipe(
      catchError(error => {
        return of('No data');
      })
    );
  }
}
