import { Injectable } from '@angular/core';
import {
  HttpRequest,
  HttpHandler,
  HttpEvent,
  HttpInterceptor, HttpParams
} from '@angular/common/http';
import { Observable } from 'rxjs';
import {AuthService} from './auth.service';
import {take, exhaustMap} from 'rxjs/operators';

@Injectable()
export class AuthInterceptorInterceptor implements HttpInterceptor {
  userData: {id: number, userName: string, _authKey: string, userTypeId: number};
  constructor(private authService: AuthService) {
  }

  intercept(request: HttpRequest<unknown>, next: HttpHandler): Observable<HttpEvent<unknown>> {
    if (localStorage.getItem('user')){
      this.userData = JSON.parse(localStorage.getItem('user'));
    }else{
      this.userData = {id: 0, userName: 'No Person', _authKey: 'no key', userTypeId: 0};
    }
    return this.authService.user.pipe(take(1), exhaustMap(user => {
      // if (!user){
      //   return next.handle(request);
      // }
      // @ts-ignore
      const clonedRequest = request.clone({ headers: request.headers.set('Authorization', 'Bearer ' + this.userData._authKey) });
      return next.handle(clonedRequest);
    }));
  }
}
