import { Component, OnInit } from '@angular/core';
import {FormControl, FormGroup} from '@angular/forms';
import {JobTaskService} from '../../../services/job-task.service';
import {SncakBarComponent} from '../../../common/sncak-bar/sncak-bar.component';
import {ConfirmationDialogService} from '../../../common/confirmation-dialog/confirmation-dialog.service';
import {MatSnackBar} from '@angular/material/snack-bar';
import { OrderDetail } from 'src/app/models/orderDetail.model';
import {JobMaster} from 'src/app/models/jobMaster.model';
import { OrderService } from 'src/app/services/order.service';
import { Material } from 'src/app/models/material.model';
import {JobDetail} from 'src/app/models/jobDetail.model';
import {Observable} from 'rxjs';
import {JobService} from '../../../services/job.service';
import {ActivatedRoute} from "@angular/router";

@Component({
  selector: 'app-job-task',
  templateUrl: './job-task.component.html',
  styleUrls: ['./job-task.component.scss']
})
export class JobTaskComponent implements OnInit {
  formTaskDiv = false;
  isShowJobMasterList = true;
  showCompleteJobs = false;
  isSendToTask = false;

  jobTaskForm: FormGroup;
  savedJobsData: JobMaster[] = [];
  finishedJobsList: JobMaster[] = [];
  materialList: Material[];


  jobNumber: string;

  public searchTerm: string;
  filter = new FormControl('');
  page: number;
  pageSize: number;
  p = 1;

  constructor(private activatedRoute: ActivatedRoute
              , private jobTaskService: JobTaskService
              // , private  jobService: JobService
              , private _snackBar: MatSnackBar
              , private confirmationDialogService: ConfirmationDialogService
              // , private orderService: OrderService
  ) {

    this.page = 1;
    this.pageSize = 15;
  }

  ngOnInit(): void {
    // active routing
    this.activatedRoute.data.subscribe((response: any) => {
      this.savedJobsData = response.jobTask.savedJobs.data;
      this.finishedJobsList = response.jobTask.finishedJobs.data;
      this.materialList = response.jobTask.materials.data;
    });

    this.showCompleteJobs = false;
    this.jobTaskForm = this.jobTaskService.jobTaskForm;
    this.jobTaskService.getSavedJobsUpdateListener().subscribe((jobData: JobMaster[]) => {
      this.savedJobsData = jobData;
    });

    this.jobTaskService.getFinishedJobsUpdateListener().subscribe((finishedJobList: JobMaster[]) => {
      this.finishedJobsList = finishedJobList;
    });
    this.jobTaskService.getMaterialDataUpdateListener().subscribe((material: Material[]) => {
        this.materialList = material;
      });

    this.savedJobsData = this.jobTaskService.getAllJobList();
    this.finishedJobsList = this.jobTaskService.getFinishedJobList();
  }

  placeDetails(data){
    this.materialList = this.jobTaskService.getMaterials();

    this.isSendToTask = true;
    this.isShowJobMasterList = false;

    const index = this.materialList.findIndex(x => x.id === data.material_id);
    // tslint:disable-next-line:max-line-length
    this.jobTaskForm.patchValue({id : data.id, material_id : data.material_id , p_loss : data.p_loss, size: data.size, price : data.price, material_name : this.materialList[index].material_name});
    this.jobNumber = data.job_number;
  }

  jobListShow(){
    this.showCompleteJobs = !this.showCompleteJobs;
  }
}
