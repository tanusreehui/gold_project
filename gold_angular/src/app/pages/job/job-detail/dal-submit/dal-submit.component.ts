import { Component, OnInit } from '@angular/core';
import {JobTaskService} from '../../../../services/job-task.service';
import {FormGroup} from '@angular/forms';
import {JobMaster} from '../../../../models/jobMaster.model';
import {ActivatedRoute} from '@angular/router';
import { MatSnackBar } from '@angular/material/snack-bar';
import {SncakBarComponent} from '../../../../common/sncak-bar/sncak-bar.component';
import {JobDetail} from '../../../../models/jobDetail.model';
import {Material} from '../../../../models/material.model';
import {environment} from "../../../../../environments/environment";


@Component({
  selector: 'app-dal-submit',
  templateUrl: './dal-submit.component.html',
  styleUrls: ['./dal-submit.component.scss']
})
export class DalSubmitComponent implements OnInit {
  isProduction = environment.production;
  currentJob: JobMaster;
  materialList: Material[];
  returnMaterial: Material;

  jobTaskForm: FormGroup;
  savedJobsData: JobMaster[];
  oneJobData: JobMaster;
  public currentError: any;
  showJobTaskData = false;
  jobTaskData: JobDetail[];
  total: number;
  dalSubmitList: { record: any[]; total_material: number };
  showDeveloperDiv = false;

  // tslint:disable-next-line:max-line-length
  constructor(private activatedRoute: ActivatedRoute
              , private jobTaskService: JobTaskService
              , private router: ActivatedRoute
              , private _snackBar: MatSnackBar) {
    this.currentJob = this.jobTaskService.getCurrentJob();
  } // end of constructor


  ngOnInit(): void {
    this.total = 0;

    this.materialList = this.jobTaskService.getMaterials();
    this.jobTaskService.getMaterialDataUpdateListener().subscribe(response => {
      this.materialList = response;
    });

    this.jobTaskService.getCurrentJobUpdateListener().subscribe(response => {
      this.currentJob = response;
    });

    this.jobTaskForm = this.jobTaskService.jobTaskForm;
    const user = JSON.parse(localStorage.getItem('user'));

    // index of return gold
    const matIndex = this.materialList.findIndex(x => x.id === 6);
    // return material name
    this.returnMaterial = this.materialList[matIndex];
    this.jobTaskForm.patchValue({
      job_Task_id: 3,
      material_id: 6,
      id: this.currentJob.id,
      // size: this.currentJob.size,
      employee_id: user.id
    });
  }

  material_quantity_decimal(){
    const x = this.jobTaskForm.value.return_quantity.split('.');
    if (!x[1]){
      this.jobTaskForm.patchValue({return_quantity : (this.jobTaskForm.value.return_quantity / 1000)});
    }
  }

  saveDalSubmit(){
    if (this.jobTaskForm.value.return_quantity === null){
      this._snackBar.openFromComponent(SncakBarComponent, {
        duration: 4000, data: {message: 'Please enter quantity before submit'}
      });
    }else {
      // making return as negative
      const dalSubmitWeight = parseFloat(this.jobTaskForm.value.return_quantity);
      // saving data to jobDetails
      this.jobTaskService.saveJobDetail().subscribe((response) => {
        if (response.success === 1) {
          this.jobTaskService.updateDalSubmit(dalSubmitWeight);
          // updating Badge count after saving data
          this.jobTaskService.incrementJobBadgesDalSendCount();
          this.jobTaskService.getJobDetailsByJobAndMaterial(this.currentJob.id, 6)
            // tslint:disable-next-line:no-shadowed-variable
            .subscribe((response: {success: number, data: {record: any[], total_material: number}}) => {
              this.dalSubmitList = response.data;
              this.showJobTaskData = true;
            });
          this._snackBar.openFromComponent(SncakBarComponent, {
            duration: 4000, data: {message: 'Dal Submitted'}
          });
          // this.total = this.total + Math.abs(parseFloat(this.jobTaskForm.value.return_quantity));
          this.jobTaskForm.controls.return_quantity.reset();
        }
        this.currentError = null;
      }, (error) => {
        this.currentError = error;
        this._snackBar.openFromComponent(SncakBarComponent, {
          duration: 4000, data: {message: error.message}
        });
      });
    }

  }

  getDalSubmitDetail() {
    // tslint:disable-next-line:max-line-length
    this.jobTaskService.getJobDetailsByJobAndMaterial(this.currentJob.id, this.returnMaterial.id)
      .subscribe((response: {success: number, data: {record: any[], total_material: number}}) => {
        this.dalSubmitList = response.data;
        this.showJobTaskData = true;
      });
  }
}
