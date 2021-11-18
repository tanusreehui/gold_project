import {Component, Input, OnDestroy, OnInit} from '@angular/core';
import {AuthService} from '../../services/auth.service';
import {Observable, Subscription} from 'rxjs';
import {User} from '../../models/user.model';
import {Router} from '@angular/router';
import Swal from 'sweetalert2';
import {HttpClient, HttpHeaders, HttpParams, HttpResponse} from '@angular/common/http';
import {GlobalVariable} from "../../shared/global";
import {url} from 'inspector';
import {SncakBarComponent} from '../../common/sncak-bar/sncak-bar.component';
import {element} from 'protractor';


@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.scss']
})
export class HeaderComponent implements OnInit, OnDestroy {
  @Input() deviceXs: boolean;
  userSub: Subscription;
  isAuthenticated = false;
  isOwner = false;
  isManager = false;
  isWorker = false;
  isWorkshopManager = false;
  isSalesManager = false;
  isAccountManager = false;
  isOfficeStaff = false;
  isAgent = false;
  isDeveloper = false;
  isCustomer = false;
  isKarigarh = false;
  router: Router;
  userInfo: User;
  messages: any;
  message: any;
  showupload = false;
  file: File = null;
  imageSrc: any;
  defaultPicture: any;

  constructor(private authService: AuthService, private http: HttpClient) {
    this.defaultPicture = GlobalVariable.BASE_API_URL_profile + 'profile_pic/no_dp.png';
    if (localStorage.getItem('user')){
      const localUserID = JSON.parse(localStorage.getItem('user')).id;
      this.imageSrc = GlobalVariable.BASE_API_URL_profile + 'profile_pic/profile_pic_' + localUserID + '.jpeg';
    }
  }

  ngOnInit(): void {
    // this.authService.getChats();
    this.authService.getChats();
    this.userSub = this.authService.user.subscribe(user => {
      this.userInfo = user;

      if (user){
        this.isAuthenticated = user.isAuthenticated;
        this.isOwner = user.isOwner;
        this.isManager = user.isManager;
        this.isWorker = user.isWorker;
        this.isWorkshopManager = user.isWorkshopManager;
        this.isSalesManager = user.isSalesManager;
        this.isAccountManager = user.isAccountManager;
        this.isOfficeStaff = user.isOfficeStaff;
        this.isAgent = user.isAgent;
        this.isDeveloper = user.isDeveloper;
        this.isCustomer = user.isCustomer;
        this.isKarigarh = user.isKarigarh;

        this.imageSrc = GlobalVariable.BASE_API_URL_profile + 'profile_pic/profile_pic_' + this.userInfo.id + '.jpeg';

      }else{
        this.isAuthenticated = false;
        this.isOwner = false;
        this.isManager = false;
        this.isWorker = false;
        this.isWorkshopManager = false;
        this.isSalesManager = false;
        this.isAccountManager = false;
        this.isOfficeStaff = false;
        this.isAgent = false;
        this.isDeveloper = false;
        this.isCustomer = false;
        this.isKarigarh = false;
      }
    });
    // this.authService.getMessageSubUpdateListener().subscribe((response)=>{
    // });
    this.authService.getMessageSubUpdateListener().subscribe((response) => {
      this.messages = response;

    });

  }

  saveMessage(){

    const a = {
      customer_name : this.userInfo.userName,
      messages: this.message
    };
    this.authService.sendChats(a).subscribe((response) => {
      if (response) {
        this.message = '';
      }
    });
  }

  getChats(){
      this.authService.getMessageSubUpdateListener().subscribe((response) => {
      });
      this.authService.getChats();
  }

  ngOnDestroy(): void {
    this.userSub.unsubscribe();
  }

  logout() {
    this.authService.logout();
  }


  myStyle(){
    // return {'background-color': '#e83d44'};
    return {
      // 'background-color': 'rgba(255,0,0,' + (10 / 100) + ')',
      'background-color': 'rgba(147,112,219,.3)',
      color : 'white'
    };
  }

  onChange(event) {
    this.file = event.target.files[0];
    const reader = new FileReader();
    Swal.fire({
      title: 'Change profile ?',
      text: 'Confirmed ?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, Change it!',
      cancelButtonText: 'No, Keep it'
    }).then((result) => {
      if (result.value){
        reader.onload = e => this.imageSrc = reader.result;
        reader.readAsDataURL(this.file);
        this.authService.upload(this.file).subscribe((response) => {
          if (response.success === 100){
          }
        }
        );
      }else if (result.dismiss === Swal.DismissReason.cancel) {
      }
    });
    event.srcElement.value = null;
  }

  // onUpload(){
  //    console.log(this.file);
  //    this.authService.upload(this.file).subscribe((response) => {
  //         // if (typeof (event) === 'object') {
  //         // }
  //         console.log(response);
  //       }
  //     );
  //   }

}
