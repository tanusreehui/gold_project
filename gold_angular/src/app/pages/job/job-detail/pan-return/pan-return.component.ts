import { Component, OnInit } from '@angular/core';
import {JobTaskService} from '../../../../services/job-task.service';
import {FormGroup} from '@angular/forms';
import {JobMaster} from '../../../../models/jobMaster.model';
import {ActivatedRoute} from '@angular/router';
import {Material} from '../../../../models/material.model';
import { MatSnackBar } from '@angular/material/snack-bar';
import {SncakBarComponent} from '../../../../common/sncak-bar/sncak-bar.component';
import {JobDetail} from '../../../../models/jobDetail.model';

@Component({
  selector: 'app-pan-return',
  templateUrl: './pan-return.component.html',
  styleUrls: ['./pan-return.component.scss']
})
export class PanReturnComponent implements OnInit {
  currentJob: JobMaster;
  jobMasterId: number;
  jobTaskForm: FormGroup;
  savedJobsData: JobMaster[];
  oneJobData: JobMaster;
  materialList: Material[] ;
  currentMaterial: Material;
  public currentError: any;
  showJobTaskData = false;
  jobTaskData: JobDetail[];
  total: number;
  returnPanList: any;

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
    const matIndex = this.materialList.findIndex(x => x.id === 11);
    // return material name
    this.currentMaterial = this.materialList[matIndex];
    this.jobTaskForm.patchValue({
      job_Task_id: 6,
      material_id: this.currentMaterial.id,
      id: this.currentJob.id,
      // size: this.currentJob.size,
      employee_id: user.id
    });
  }



  savePanReturn(){

    if (this.jobTaskForm.value.return_quantity === null){
      this._snackBar.openFromComponent(SncakBarComponent, {
        duration: 4000, data: {message: 'Please enter quantity before submit'}
      });
    }else {
      // making return as negative
      const goldReturnQuantity = parseFloat(this.jobTaskForm.value.return_quantity);
      this.jobTaskForm.value.return_quantity = -this.jobTaskForm.value.return_quantity;
      // saving data to jobDetails
      this.jobTaskService.saveJobDetail().subscribe((response) => {
        if (response.success === 1) {
          this.jobTaskService.updatePanReturn(goldReturnQuantity);
          // updating Badge count after saving data
          this.jobTaskService.incrementJobBadgesPanReturnCount();
          this.jobTaskService.getJobDetailsByJobAndMaterial(this.currentJob.id, this.currentMaterial.id)
            // tslint:disable-next-line:no-shadowed-variable
            .subscribe((response: {success: number, data: {record: any[], total_material: number}}) => {
              this.returnPanList = response.data;
              this.showJobTaskData = true;
            });
          this._snackBar.openFromComponent(SncakBarComponent, {
            duration: 4000, data: {message: 'Pan Returned'}
          });
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

  getPanReturnDetail() {
    // tslint:disable-next-line:max-line-length
    this.jobTaskService.getJobDetailsByJobAndMaterial(this.currentJob.id, this.currentMaterial.id)
      .subscribe((response: {success: number, data: {record: any[], total_material: number}}) => {
        this.returnPanList = response.data;
        this.showJobTaskData = true;
      });
  }
}
