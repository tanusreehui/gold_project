import { Injectable } from '@angular/core';
import {
  Router, Resolve,
  RouterStateSnapshot,
  ActivatedRouteSnapshot
} from '@angular/router';
import { Observable, of } from 'rxjs';
import {catchError} from "rxjs/operators";
import {JobTaskService} from "../../services/job-task.service";

@Injectable({
  providedIn: 'root'
})
export class JobTaskResolver implements Resolve<any> {
  constructor(private jobTaskService: JobTaskService){

  }
  resolve(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): Promise<any> | Observable<any> {
    return this.jobTaskService.getAll().pipe(
      catchError(error => {
        return of('No data');
      })
    );
  }
}
