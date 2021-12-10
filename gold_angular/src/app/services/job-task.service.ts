import {Injectable, OnDestroy} from '@angular/core';
import {GlobalVariable} from '../shared/global';
import {FormControl, FormGroup, Validators} from '@angular/forms';
import {OrderDetail} from '../models/orderDetail.model';
import {forkJoin, Observable, Subject, throwError} from 'rxjs';
import {catchError, tap} from 'rxjs/operators';
import {HttpClient, HttpErrorResponse} from '@angular/common/http';
import {JobMaster} from '../models/jobMaster.model' ;
import {JobDetail} from 'src/app/models/jobDetail.model';
import {OrderMaster} from '../models/orderMaster.model';
import {OrderResponseData} from './order.service';
import {Material} from '../models/material.model';
import {JobResponseData} from './job.service';
import {CustomValidator} from "../CustomValidator/custom-validtor";
import {JobSummarisedModel} from "../models/job-summarised.model";
import {JobBadgeModel} from "../models/job-badge.model";

@Injectable({
  providedIn: 'root'
})
export class JobTaskService implements OnDestroy{

  jobTaskForm: FormGroup;
  jobMasterForm: FormGroup;
  materialData: Material[];

  // oneJobData: JobMaster[] = [];
  oneJobData: JobMaster = null;

  savedJobsList: JobMaster[] = [];
  finishedJobsList: JobMaster[] = [];
  jobMasterData: JobMaster;
  jobDetailData: JobDetail[];
  jobReturnData: JobDetail;
  totalData: JobDetail[];
  jobTransactionData: JobDetail[];

  // btnControl: boolean;
  btnControl = false;

  // finshBadgeValue = 0;
  // goldSendBadge = 1;
  // goldSendBadge = 1;
  // goldSendBadge = 1;
  jobBadgeArray = [];


  finshBadgeValue = 0;
  goldSendBadge = 0;
  goldRetBadge = 0;
  dalSendBadge = 0;
  dalRetBadge = 0;
  panSendBadge = 0;
  panRetBadge = 0;
  bronzeSendBadge = 0;
  nitricRetBadge = 0;

  private savedJobsSub = new Subject<JobMaster[]>();
  private materialDataSub = new Subject<Material[]>();
  private getJobTaskDataSub = new Subject<JobDetail[]>();
  private jobReturnDataSub = new Subject<JobDetail>();
  private totalDataSub = new Subject<JobDetail[]>();
  private jobTransactionSub = new Subject<JobDetail[]>();
  private finishedJobsSub = new Subject<JobMaster[]>();
  private oneJobDataSub = new Subject<JobMaster[]>();
  private badgeValueSub = new Subject<any>();
  private btnControlSub: Subject<boolean> = new Subject<boolean>();

  public jobDetailSummarised: JobSummarisedModel = {goldSend:0, goldReturn:0, dalSubmit:0, dalReturn: 0, panSubmit:0, panReturn:0, nitricReturn: 0, bronzeSubmit:0, bronzeReturn:0 };
  private jobDetailSummarisedSubject = new Subject<JobSummarisedModel>();

  public jobBadges: JobBadgeModel = {finishBadge:0, goldSendBadge: 0, goldReturnBadge:0,dalSendBadge:0, dalReturnBadge:0, panSendBadge:0,panReturnBadge:0,bronzeSendBadge:0,nitricReturnBadge:0};
  private jobBadgesSubject = new Subject<JobBadgeModel>();

  getJobDetailSummarisation(){
      return {...this.jobDetailSummarised};
  }

  fetchJobSummarisation(jobId:number){
    return this.http.get<any>(GlobalVariable.BASE_API_URL + '/jobSummarisation/JobMaster/'+jobId)
      .pipe(catchError(this._serverError), tap(((response: {success: number, data: any}) => {
        response.data.forEach(element => {
          if(element.job_task_id === 1){
            this.jobDetailSummarised.goldSend = element.total_material_quantity;
          }
          if(element.job_task_id === 2){
            this.jobDetailSummarised.goldReturn = element.total_material_quantity;
          }
          if(element.job_task_id === 3){
            this.jobDetailSummarised.dalSubmit = element.total_material_quantity;
          }
          if(element.job_task_id === 4){
            this.jobDetailSummarised.dalReturn = element.total_material_quantity;
          }
          if(element.job_task_id === 5){
            this.jobDetailSummarised.panSubmit = element.total_material_quantity;
          }
          if(element.job_task_id === 6){
            this.jobDetailSummarised.panReturn = element.total_material_quantity;
          }
          if(element.job_task_id === 7){
            this.jobDetailSummarised.nitricReturn = element.total_material_quantity;
          }
          if(element.job_task_id === 8){
            this.jobDetailSummarised.bronzeSubmit = element.total_material_quantity;
          }
          if(element.job_task_id === 9){
            this.jobDetailSummarised.bronzeReturn = element.total_material_quantity;
          }
        });

        this.jobDetailSummarisedSubject.next({...this.jobDetailSummarised});
    })));
  }

  getJobSummarisationUpdateListener(){
    return this.jobDetailSummarisedSubject.asObservable();
  }

  getJobBadges(){
    return {...this.jobBadges};
  }
  getJobBadgesUpdateListener(){
    return this.jobBadgesSubject.asObservable();
  }

  getSavedJobsUpdateListener(){
    return this.savedJobsSub.asObservable();
  }
  getFinishedJobsUpdateListener(){
    return this.finishedJobsSub.asObservable();
  }
  getJobTaskDataUpdateListener(){
    return this.getJobTaskDataSub.asObservable();
  }

  getTotalDataUpdateListener(){
    return this.totalDataSub.asObservable();
  }
  // getJobReturnDataUpdateListener(){
  //   return this.jobReturnDataSub.asObservable();
  // }
  getJobTransactionDataUpdateListener(){
    return this.jobTransactionSub.asObservable();
  }

  getMaterialDataUpdateListener(){
    return this.materialDataSub.asObservable();
  }

  getBadgeValue(){
    return this.badgeValueSub.asObservable();
  }
  getJobDetailsByJobAndMaterial(jobMasterId: number, materialId: number){
    return this.http.get<any>(GlobalVariable.BASE_API_URL + '/jobDetail/jobMaster/'+jobMasterId+'/material/'+materialId);
  }


  constructor(private http: HttpClient) {
    this.btnControl = false;
    this.resolve(false);


    this.jobTaskForm = new FormGroup({
      //this is actually job_master_id
      id : new FormControl(null),
      // size : new FormControl(null, [Validators.required]),
      // price : new FormControl(null, [Validators.required]),
      return_quantity : new FormControl(null, [Validators.required, CustomValidator.numeric]),
      // material_name : new FormControl({value: null, disabled: true}, [Validators.required]),
      material_id : new FormControl(null, [Validators.required]),
      job_Task_id : new FormControl(null, [Validators.required]),
      employee_id : new FormControl(null, [Validators.required])
    });


    // ---------------------------

    this.jobMasterForm = new FormGroup({
      id : new FormControl(null),
      date : new FormControl(null, [Validators.required]),
      karigarh_id : new FormControl(null, [Validators.required]),
      gross_weight : new FormControl(null, [Validators.required]),
      order_details_id : new FormControl(null, [Validators.required]),
      model_number : new FormControl({value: null, disabled: true}, [Validators.required]),
      material_name : new FormControl({value: null, disabled: true}, [Validators.required])
    });


    // ---------------------

    // fetching the orders which are sent to job

    // this.http.get(GlobalVariable.BASE_API_URL + '/savedJobs')
    //   .subscribe((response: {success: number, data: JobMaster[]}) => {
    //     const {data} = response;
    //     this.savedJobsSub.next([...this.savedJobsList]);
    //   });
    //
    // this.http.get(GlobalVariable.BASE_API_URL + '/finishedJobs')
    //   .subscribe((response: {success: number, data: JobMaster[]}) => {
    //     const {data} = response;
    //     this.finishedJobsList = data;
    //     this.finishedJobsSub.next([...this.finishedJobsList]);
    //   });
    //
    // this.http.get(GlobalVariable.BASE_API_URL + '/materials')
    //   .subscribe((response: {success: number, data: Material[]}) => {
    //     const {data} = response;
    //     this.materialData = data;
    //     console.log('Materials: ', data);
    //     this.materialDataSub.next([...this.materialData]);
    //   });
  }
  getSavedJobList(){
    return this.http.get<any>(GlobalVariable.BASE_API_URL + '/savedJobs').pipe(catchError(this._serverError), tap(((response: any) => {
      console.log("Single call",response.data);
      this.savedJobsList = response.response.data;
    })));
  }
  fetchAllMaterials(){
    return this.http.get<any>(GlobalVariable.BASE_API_URL + '/materials')
      .pipe(catchError(this._serverError), tap(((response: any) => {
      this.materialData = response.data;
    })));
  }
  getAll(): Observable<any>{
    return forkJoin({
      savedJobs:  this.http.get<any>(GlobalVariable.BASE_API_URL + '/savedJobs'),
      finishedJobs:  this.http.get<any>(GlobalVariable.BASE_API_URL + '/finishedJobs'),
      materials:  this.http.get<any>(GlobalVariable.BASE_API_URL + '/materials'),
      // karigarhs:  this.http.get<any>(GlobalVariable.BASE_API_URL + '/karigarhs')
    }).pipe(catchError(this._serverError), tap(((response: any) => {
      this.finishedJobsList = response.finishedJobs.data;
      this.materialData = response.materials.data;
      this.savedJobsList = response.savedJobs.data;
    })));
  }
  getCurrentSavedJobByJobId(job_id: any){
    return this.http.get<any>(GlobalVariable.BASE_API_URL + '/savedJobs/'+job_id);
  }

  testObserble(){
    return this.btnControlSub.asObservable();
  }

  // testData(data) {
  //   if (data === true){
  //     this.btnControl = true;
  //   }
  //   this.resolve();
  // }

  resolve(data){
    this.btnControl = data;
    if (this.btnControl === true){
      const a = {
        finshBadgeValue : 1,
        goldSendBadge : this.goldSendBadge,
        goldRetBadge : this.goldRetBadge,
        dalSendBadge : this.dalSendBadge,
        dalRetBadge : this.dalRetBadge,
        panSendBadge : this.panSendBadge,
        panRetBadge : this.panRetBadge,
        bronzeSendBadge : this.bronzeSendBadge,
        nitricRetBadge : this.nitricRetBadge
      };
      this.badgeValueSub.next(a);
      this.btnControlSub.next(this.btnControl);
    }else{
      this.btnControl = false;
      this.btnControlSub.next(this.btnControl);
    }
  }

  getAllJobList(){
    return [...this.savedJobsList];
  }

  getFinishedJobList(){
    return [...this.finishedJobsList];
  }

  // getLatestBadgeValue(){
  //
  //   return [...this.jobBadgeArray];
  // }




  getMaterials(){
    return[...this.materialData];
  }

  ngOnDestroy(): void {
    this.getJobTaskDataSub.complete();
  }

  getUpdatedSavedJobs(){
    this.http.get(GlobalVariable.BASE_API_URL + '/savedJobs')
      .subscribe((response: {success: number, data: JobMaster[]}) => {
        const {data} = response;
        this.savedJobsList = data;
        this.savedJobsSub.next([...this.savedJobsList]);
      });

  }

  getUpdatedFinishedJobs(){
    this.http.get(GlobalVariable.BASE_API_URL + '/finishedJobs')
      .subscribe((response: {success: number, data: JobMaster[]}) => {
        const {data} = response;
        this.finishedJobsList = data;
        this.finishedJobsSub.next([...this.finishedJobsList]);
      });

  }

  saveJobDetail(){
      return this.http.post(GlobalVariable.BASE_API_URL + '/saveReturn', { data: this.jobTaskForm.value})
       .pipe(catchError(this._serverError), tap(((response: {success: number, data: JobDetail}) => {
             const {data} = response;
             this.jobReturnData = data;
             if (this.jobReturnData.job_task_id === 1){
               this.goldSendBadge = this.goldSendBadge + 1;
             }else if (this.jobReturnData.job_task_id === 2){
               this.goldRetBadge = this.goldRetBadge + 1;
             }else if (this.jobReturnData.job_task_id === 3){
               this.dalSendBadge = this.dalSendBadge + 1;
             }else if (this.jobReturnData.job_task_id === 4){
               this.dalRetBadge = this.dalRetBadge + 1;
             }else if (this.jobReturnData.job_task_id === 5){
               this.panSendBadge = this.panSendBadge + 1;
             }else if (this.jobReturnData.job_task_id === 6){
               this.panRetBadge = this.panRetBadge + 1;
             }else if (this.jobReturnData.job_task_id === 8){
               this.bronzeSendBadge = this.bronzeSendBadge + 1;
             }else if (this.jobReturnData.job_task_id === 7){
               this.nitricRetBadge = this.nitricRetBadge + 1;
             }

             const a = {
               goldSendBadge : this.goldSendBadge,
               goldRetBadge : this.goldRetBadge,
               dalSendBadge : this.dalSendBadge,
               dalRetBadge : this.dalRetBadge,
               panSendBadge : this.panSendBadge,
               panRetBadge : this.panRetBadge,
               bronzeSendBadge : this.bronzeSendBadge,
               nitricRetBadge : this.nitricRetBadge
             };
             this.badgeValueSub.next(a);

            //  this.jobReturnDataSub.next([...this.jobReturnData]);
            //  let index = this.jobBadgeArray.findIndex(x => x.id === this.jobTaskForm.value.id);
            //  if (index === -1){
            //    this.goldSendBadge = this.goldSendBadge + 1;
            //    this.jobBadgeArray.push({id: this.jobTaskForm.value.id, GS: this.goldSendBadge, GR: 0, DS: 0, DR: 0, PS: 0, PR: 0, BS: 0, NR: 0, F: 0});
            //  }
            //  else{
            //    this.jobBadgeArray[index].GS = this.jobBadgeArray[index].GS + 1;
            //  }
            //
            //  // this.jobBadgeArray.id = this.jobTaskForm.value.id;
            //  // this.jobBadgeArray.GS = this.goldSendBadge;
            //
            //  // this.badgeValueSub.next(this.jobBadgeArray);
       })));


    // this.http.post(GlobalVariable.BASE_API_URL + '/saveReturn', { data : this.jobTaskForm.value})
    //   .subscribe((response: {success: number, data: JobDetail}) => {
    //     // const {data} = response;
    //     // if (data){
    //     //   this.jobTaskForm.reset();
    //     // }
    //     // this.jobDetailData.unshift(response.data);
    //
    //   });
  }

  fetchBadges(jobId: number){
    return this.http.get<any>(GlobalVariable.BASE_API_URL + '/countTaskBadgeValue/' + jobId)
      .pipe(catchError(this._serverError), tap(((response: {success: number, data: any}) => {
        response.data.forEach(element => {
          if(element.id === 1){
            this.jobBadges.goldSendBadge = element.badgeValue;
          }
          if(element.id === 2){
            this.jobBadges.goldReturnBadge = element.badgeValue;
          }
          if(element.id === 3){
            this.jobBadges.dalSendBadge = element.badgeValue;
          }
          if(element.id === 4){
            this.jobBadges.dalReturnBadge = element.badgeValue;
          }
          if(element.id === 5){
            this.jobBadges.panSendBadge = element.badgeValue;
          }
          if(element.id === 6){
            this.jobBadges.panReturnBadge = element.badgeValue;
          }
          if(element.id === 7){
            this.jobBadges.nitricReturnBadge = element.badgeValue;
          }
          if(element.id === 8){
            this.jobBadges.bronzeSendBadge = element.badgeValue;
          }

        });
        this.jobBadgesSubject.next({...this.jobBadges});
      })));
  }

  incrementJobBadgesGoldReturnCount(){
    this.jobBadges.goldReturnBadge += 1;
    this.jobBadgesSubject.next({...this.jobBadges});
  }
  incrementJobBadgesGoldSendCount(){
    this.jobBadges.goldSendBadge += 1;
    this.jobBadgesSubject.next({...this.jobBadges});
  }
  incrementJobBadgesDalSendCount(){
    this.jobBadges.dalSendBadge += 1;
    this.jobBadgesSubject.next({...this.jobBadges});
  }


  // jobTaskData(task_id) {
  //   this.http.get(GlobalVariable.BASE_API_URL + '/getJobTaskData/' + task_id)
  //     .subscribe((response: {success: number, data: JobDetail[]}) => {
  //       const {data} = response;
  //       this.jobDetailData = data;
  //       this.getJobTaskDataSub.next([...this.jobDetailData]);
  //     });
  // }

  jobTaskData() {
    return this.http.post( GlobalVariable.BASE_API_URL + '/getJobTaskData', { data : this.jobTaskForm.value})
      .pipe(catchError(this._serverError), tap(((response: {success: number, data: JobDetail[]}) => {
        const {data} = response;
        this.jobDetailData = data;
        this.getJobTaskDataSub.next([...this.jobDetailData]);
      })));
  }

  getTotal(){
    return this.http.post( GlobalVariable.BASE_API_URL + '/getTotal', { data : this.jobTaskForm.value})
      .pipe(catchError(this._serverError), tap(((response: {success: number, data: JobDetail[]}) => {
        const {data} = response;
        this.totalData = data;
        this.totalDataSub.next([...this.totalData]);
      })));
  }

  getTotalData(){
    this.http.post( GlobalVariable.BASE_API_URL + '/getTotal', { data : this.jobTaskForm.value})
      .subscribe((response: {success: number, data: JobDetail[]}) => {
        const {data} = response;
        this.totalData = data;
        this.totalDataSub.next([...this.totalData]);
      });
  }

  getAllTransactions(data) {
    return this.http.get(GlobalVariable.BASE_API_URL + '/getAllTransactions/' + data)
      .pipe(catchError(this._serverError), tap(((response: { success: number, data: JobDetail[] }) => {
        this.jobTransactionData = response.data;
        this.jobTransactionSub.next([...this.jobTransactionData]);

      })));
  }
    getCurrentJobData(data){
      return this.http.get(GlobalVariable.BASE_API_URL + '/getOneJobData/' + data )
        .pipe(catchError(this._serverError), tap(((response: { success: number, data: JobMaster}) => {
          // this.oneJobData = response.data;
        })));
    }


  // updateBadgeValue(jobTaskId){
  //   if(jobTaskId === 1){
  //     this.goldSendBadge = this.goldSendBadge + 1;
  //     this.badgeValueSub.next([...this.goldSendBadge]);
  //   }
  //   return 1;
  // }

  private _serverError(err: any) {
    if (err instanceof Response) {
      return throwError('backend server error');
      // if you're using lite-server, use the following line
      // instead of the line above:
      // return Observable.throw(err.text() || 'backend server error');
    }
    if (err.status === 0){
      // tslint:disable-next-line:label-position
      return throwError ({status: err.status, message: 'Backend Server is not Working', statusText: err.statusText});
    }
    if (err.status === 401){
      // tslint:disable-next-line:label-position
      return throwError ({status: err.status, message: 'You are not authorised', statusText: err.statusText});
    }
    return throwError(err);
  }

  updateGoldReturn(materialWeight: number) {
    this.jobDetailSummarised.goldReturn = this.jobDetailSummarised.goldReturn + materialWeight;
    this.jobDetailSummarisedSubject.next({...this.jobDetailSummarised});
  }
  updateDalSubmit(materialWeight: number) {
    this.jobDetailSummarised.dalSubmit += materialWeight;
    this.jobDetailSummarisedSubject.next({...this.jobDetailSummarised});
  }
}
