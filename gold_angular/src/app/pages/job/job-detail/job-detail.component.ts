import { Component, OnInit } from '@angular/core';
import {ActivatedRoute} from '@angular/router';
import {JobTaskService} from '../../../services/job-task.service';
import {AuthService} from '../../../services/auth.service';
import {JobService} from '../../../services/job.service';
import {JobMaster} from '../../../models/jobMaster.model';
import {FormGroup} from '@angular/forms';
import {OrderService} from '../../../services/order.service';
import {Material} from '../../../models/material.model';
import {Karigarh} from '../../../models/karigarh.model';
import {User} from '../../../models/user.model';
import {JobDetail} from '../../../models/jobDetail.model';
import {environment} from "../../../../environments/environment";
import {JobSummarisedModel} from "../../../models/job-summarised.model";
import {JobBadgeModel} from "../../../models/job-badge.model";

@Component({
  selector: 'app-job-detail',
  templateUrl: './job-detail.component.html',
  styleUrls: ['./job-detail.component.scss']
})
export class JobDetailComponent implements OnInit {
  showDeveloperDiv = true;
  isProduction = environment.production;
  sub: object;
  id: number;
  job_number: string;
  jobTaskForm: FormGroup;
  savedJobsData: JobMaster[];
  currentJobData: JobMaster;
  materialList: Material[];
  karigarhData: Karigarh[] = [];
  userData: User = null;
  karigarhName: string = null;
  totalData: JobDetail[];
  showTransactionDiv = false;
  jobTransactionData: JobDetail[];
  btnControl: boolean = null;
  tempTotalData = [0, 0 , 0 , 0 , 0 , 0, 0, 0];
  FGWt: number;
  selectedTask: string = null;

  // we have to change this values dynamically
  finishBadgeValue = 0;
  goldSendBadge = 0;
  goldRetBadge = 0;
  dalSendBadge = 0;
  dalRetBadge = 0;
  panSendBadge = 0;
  panRetBadge = 0;
  BronzeSendBadge = 0;
  nitricRetBadge = 0;

  public jobDetailSummarised: JobSummarisedModel;
  public jobBadges: JobBadgeModel = {finishBadge: 0
                                      , goldSendBadge: 0
                                      , goldReturnBadge: 0
                                      , dalSendBadge: 0
                                      , dalReturnBadge: 0
                                      , panSendBadge: 0
                                      , panReturnBadge: 0
                                      , bronzeSendBadge: 0
                                      , nitricReturnBadge: 0};
  // tslint:disable-next-line:max-line-length
  currentJobId: number;
  constructor(private route: ActivatedRoute
              , private  jobTaskService: JobTaskService
              , private  jobService: JobService
              , private  orderService: OrderService) {
    // this.jobDetailSummarised = this.jobTaskService.getJobDetailSummarisation();
    this.route.params.subscribe((params: any) => {
      this.currentJobId = params.id;
    });
    this.jobDetailSummarised = this.jobTaskService.getJobDetailSummarisation();
    this.jobTaskService.getJobSummarisationUpdateListener().subscribe(response => {
      this.jobDetailSummarised = response;
    });

    this.jobBadges = this.jobTaskService.getJobBadges();

    this.jobTaskService.getJobBadgesUpdateListener().subscribe(response => {
      this.jobBadges = response;
    });

    this.route.data.subscribe((response: any) => {
      this.karigarhData = response.jobDetail.karigarhs.data;
      this.materialList = response.jobDetail.materials.data;
      this.currentJobData = response.jobDetail.currentJob.data;

      this.jobTaskForm = this.jobTaskService.jobTaskForm;
      // console.log('check ', response.jobDetail.currentJob.data);
      // this.jobTaskForm.patchValue({id: this.currentJobData.id});
      this.job_number = this.currentJobData.job_number;
      const index = this.materialList.findIndex(x => x.id === this.currentJobData.material_id);
      const materialData = this.materialList[index];
      this.jobTaskForm.patchValue({id: this.currentJobData.id});
      const index1 = this.karigarhData.findIndex(x => x.id === this.currentJobData.karigarh_id);
      this.karigarhName = this.karigarhData[index1].user_name;
      this.userData = JSON.parse(localStorage.getItem('user'));

      this.jobTaskService.fetchBadges(this.currentJobData.id);
      this.showTransactionDiv = false;
      this.route.params.subscribe(params => {
        // this.jobTaskService.getTotalData();
        // this.jobTaskService.getTotal().subscribe((response) => {
        //   this.totalData = response.data;
        //   for (let i = 1; i <= 8; i ++){
        //     const index = this.totalData.findIndex(x => x.id === i);
        //     if (index >= 0)
        //     {
        //       this.tempTotalData[i - 1] = this.totalData[index].total;
        //     }
        //     else{
        //       this.tempTotalData[i - 1] = 0;
        //     }
        //   }
        // });
        // tslint:disable-next-line:no-shadowed-variable
        this.jobTaskService.getTotalDataUpdateListener().subscribe(response => {
          this.totalData = response;
          for (let i = 1; i <= 8; i ++){
            // tslint:disable-next-line:no-shadowed-variable
            const index = this.totalData.findIndex(x => x.id === i);
            if (index >= 0) {

              this.tempTotalData[i - 1] = this.totalData[index].total;
            } else {
              this.tempTotalData[i - 1] = 0;
            }
          }
        });
        this.jobTaskService.getJobTransactionDataUpdateListener().subscribe((response) => {
          this.jobTransactionData = response;
        });
        this.jobTaskService.getAllTransactions(this.id).subscribe((response) => {
          this.jobTransactionData = response.data;
        });
      });
    });
    this.FGWt = 0;
  }

  printDivStyle = {
    table: {'border-collapse': 'collapse', width : '40%', border: '1px solid black'},
    label: {width: '80%'},
    h1 : {color: 'black'},
    // h2 : {border: 'solid 1px'},
    h2 : {border: '1px solid black'},
    td: {border: '1px solid black', margin: '0px', padding: '5px', width : '30%'},
    // th: {border: '1px solid red'}
  };



  ngOnInit(): void {
    this.showTransactionDiv = true;





    // this.billService.getTotalGoldQuantityDataSubUpdateListener().subscribe((response) => {
    //   this.FGWt = response;
    // });






  }

  isSelectedTask(taskName){
    return this.selectedTask === taskName;
  }
  setSelectedTask(taskName){
    this.selectedTask = taskName;
  }

  selectedColor(taskName: string ) {
    if(this.isSelectedTask(taskName)){
      return {
        'color': 'red'
      }
    }
  }
}
