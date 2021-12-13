import { Injectable } from '@angular/core';
import {
  Router, Resolve,
  RouterStateSnapshot,
  ActivatedRouteSnapshot
} from '@angular/router';
import {forkJoin, Observable, of} from 'rxjs';
import {map} from 'rxjs/operators';
import {JobTaskService} from '../../services/job-task.service';

@Injectable({
  providedIn: 'root'
})
export class DalSubmitResolver implements Resolve<boolean> {
  constructor(private jobTaskService: JobTaskService){

  }
  resolve(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<any> | boolean {
    const a = this.jobTaskService.getCurrentJobData(route.params.id);
    const b = this.jobTaskService.fetchAllMaterials();
    const join = forkJoin(a, b).pipe(map((allResponses) => {
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
