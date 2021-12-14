import {Component, OnInit, Output} from '@angular/core';
import {FormGroup} from '@angular/forms';
import {JobTaskService} from '../../../../services/job-task.service';
import {ActivatedRoute} from '@angular/router';
import {JobMaster} from '../../../../models/jobMaster.model';
import {OrderService} from '../../../../services/order.service';
import {Material} from '../../../../models/material.model';
import {OrderMaster} from '../../../../models/orderMaster.model';
import {JobDetail} from '../../../../models/jobDetail.model';
import { MatSnackBar } from '@angular/material/snack-bar';
import {SncakBarComponent} from '../../../../common/sncak-bar/sncak-bar.component';
import { __values } from 'tslib';
import {JobDetailComponent} from '../job-detail.component';
import {AuthService} from '../../../../services/auth.service';
import {JobService} from '../../../../services/job.service';

@Component({
  selector: 'app-gold-submit',
  templateUrl: './gold-submit.component.html',
  styleUrls: ['./gold-submit.component.scss']
})
export class GoldSubmitComponent implements OnInit {
  jobMasterId: number;
  jobTaskForm: FormGroup;
  savedJobsData: JobMaster[];
  oneJobData: JobMaster;
  public currentError: any;
  showJobTaskData = false;
  jobTaskData: JobDetail[];
  total: number;
  materialName: string;

  currentJob: JobMaster;
  materialList: Material[];
  currentMaterial: Material;
  goldSubmitList: { record: any[]; total_material: number };

  constructor(private jobTaskService: JobTaskService, private router: ActivatedRoute, private _snackBar: MatSnackBar) {
    this.currentJob = this.jobTaskService.getCurrentJob();
  }

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
    const matIndex = this.materialList.findIndex(x => x.id === this.currentJob.material_id);
    // return material name
    this.currentMaterial = this.materialList[matIndex];
    this.jobTaskForm.patchValue({
      job_Task_id: 1,
      material_id: this.currentMaterial.id,
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

  saveGoldSubmit(){
    if (this.jobTaskForm.value.return_quantity === null){
      this._snackBar.openFromComponent(SncakBarComponent, {
        duration: 4000, data: {message: 'Please enter quantity before submit'}
      });
    }else {
      // making return as negative
      const goldSubmitWeight = parseFloat(this.jobTaskForm.value.return_quantity);
      // saving data to jobDetails
      this.jobTaskService.saveJobDetail().subscribe((response) => {
        if (response.success === 1) {
          this.jobTaskService.updateGoldSubmit(goldSubmitWeight);
          // updating Badge count after saving data
          this.jobTaskService.incrementJobBadgesGoldSendCount();
          this.jobTaskService.getJobDetailsByJobAndMaterial(this.currentJob.id, this.currentMaterial.id)
            // tslint:disable-next-line:no-shadowed-variable
            .subscribe((response: {success: number, data: {record: any[], total_material: number}}) => {
              this.goldSubmitList = response.data;
              this.showJobTaskData = true;
            });
          this._snackBar.openFromComponent(SncakBarComponent, {
            duration: 4000, data: {message: 'Gold Submitted'}
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
  getGoldSubmitDetail() {
    // tslint:disable-next-line:max-line-length
    this.jobTaskService.getJobDetailsByJobAndMaterial(this.currentJob.id, this.currentMaterial.id)
      .subscribe((response: {success: number, data: {record: any[], total_material: number}}) => {
        this.goldSubmitList = response.data;
        this.showJobTaskData = true;
      });
  }

}
