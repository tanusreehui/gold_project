import {Component, OnDestroy, OnInit, ViewChild} from '@angular/core';
import { NgbButtonsModule } from '@ng-bootstrap/ng-bootstrap';
import {NgbDateStruct} from '@ng-bootstrap/ng-bootstrap';
import { faCoffee } from '@fortawesome/free-solid-svg-icons';
import { faBaby } from '@fortawesome/free-solid-svg-icons';

import { MediaObserver, MediaChange } from '@angular/flex-layout';
import { Subscription } from 'rxjs';
import {AuthService} from './services/auth.service';
import {CommonService} from './services/common.service';
import {NavigationCancel, NavigationEnd, NavigationError, NavigationStart, Router} from "@angular/router";

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnInit, OnDestroy{
  title = 'base-project';
  active = 1;
  events: string[] = [];
  opened: boolean;
  faCoffee = faCoffee;
  faBaby = faBaby;
  mediaSub: Subscription;
  deviceXs: boolean;
  isNavigating: boolean=false;
  constructor(public router: Router ,public mediaObserver: MediaObserver, private authService: AuthService, private commonService: CommonService){
    this.router.events.subscribe(ev=>{
        if(ev instanceof NavigationStart){
          this.isNavigating=true;
        }
        if(ev instanceof NavigationEnd || ev instanceof NavigationCancel || ev instanceof NavigationError){
          this.isNavigating=false;
        }
      }
    );
  }
  ngOnInit(): void {
      this.mediaSub = this.mediaObserver.media$.subscribe(
        (result: MediaChange) => {
          console.log(result.mqAlias);
          this.deviceXs = (result.mqAlias === 'xs' ? true : false);
        }
      );

      this.authService.autoLogin();
  }
  ngOnDestroy(): void {
    this.mediaSub.unsubscribe();
  }
}
