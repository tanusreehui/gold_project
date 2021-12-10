import { Component, OnInit } from '@angular/core';
import {JobTaskService} from '../../../../services/job-task.service';
import {FormGroup} from '@angular/forms';
import {JobMaster} from '../../../../models/jobMaster.model';
import {ActivatedRoute} from '@angular/router';
import { MatSnackBar } from '@angular/material/snack-bar';
import {SncakBarComponent} from '../../../../common/sncak-bar/sncak-bar.component';
import {JobDetail} from '../../../../models/jobDetail.model';
import {Material} from "../../../../models/material.model";


@Component({
  selector: 'app-dal-submit',
  templateUrl: './dal-submit.component.html',
  styleUrls: ['./dal-submit.component.scss']
})
export class DalSubmitComponent implements OnInit {

  jobMasterId: number;
  currentJob: JobMaster;
  materialData: Material[];
  returnMaterial: Material;

  jobTaskForm: FormGroup;
  savedJobsData: JobMaster[];
  oneJobData: JobMaster;
  public currentError: any;
  showJobTaskData = false;
  jobTaskData: JobDetail[];
  total: number;
  dalSubmitList: { record: any[]; total_material: number };

  constructor(private activatedRoute: ActivatedRoute, private jobTaskService: JobTaskService, private router: ActivatedRoute, private _snackBar: MatSnackBar) {
    this.activatedRoute.data.subscribe((response: any) => {
      this.currentJob = response.dalSubmit.currentJob.data;
      console.log('Current Job',this.currentJob);
      this.jobMasterId = this.currentJob.id;
      this.materialData = response.dalSubmit.materials.data;
      this.jobTaskForm = this.jobTaskService.jobTaskForm;
      const user = JSON.parse(localStorage.getItem('user'));

      // index of return gold
      const matIndex = this.materialData.findIndex(x => x.id === 6);
      // return material name
      this.returnMaterial = this.materialData[matIndex];
      console.log('Return Material ', this.returnMaterial);
      // this.returnMaterialName = this.returnMaterial.material_name;

      this.jobTaskForm.patchValue({
        job_Task_id: 3,
        material_id: 6,
        id: this.jobMasterId,
        // size: this.currentJob.size,
        employee_id: user.id
      });

    });
  }

  ngOnInit(): void {
    this.total = 0;
    this.jobTaskForm = this.jobTaskService.jobTaskForm;
    this.router.parent.params.subscribe(params => {
      this.jobMasterId = parseInt(params.id);
    });
    this.savedJobsData = this.jobTaskService.getAllJobList();
    const index = this.savedJobsData.findIndex(x => x.id === this.jobMasterId);
    this.oneJobData = this.savedJobsData[index];
    // this.jobTaskForm.patchValue({material_name: this.oneJobData.material_name});
    this.jobTaskService.getJobTaskDataUpdateListener().subscribe((response) => {
      this.jobTaskData = response;
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
      let goldReturnQuantity = parseFloat(this.jobTaskForm.value.return_quantity);
      this.jobTaskForm.value.return_quantity = -this.jobTaskForm.value.return_quantity;
      // saving data to jobDetails
      this.jobTaskService.saveJobDetail().subscribe((response) => {
        if (response.success === 1) {
          this.jobTaskService.updateGoldReturn(goldReturnQuantity);
          // updating Badge count after saving data
          this.jobTaskService.incrementJobBadgesGoldReturnCount();
          this.jobTaskService.getJobDetailsByJobAndMaterial(this.currentJob.id, 6)
            // tslint:disable-next-line:no-shadowed-variable
            .subscribe((response: {success: number, data: {record: any[], total_material: number}}) => {
              this.dalSubmitList = response.data;
              this.showJobTaskData = true;
            });
          this._snackBar.openFromComponent(SncakBarComponent, {
            duration: 4000, data: {message: 'Gold Returned'}
          });
          this.total = this.total + Math.abs(parseFloat(this.jobTaskForm.value.return_quantity));
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

  // getTotal(){
  //   this.total = 0;
  //   this.showJobTaskData = true;
  //   this.router.parent.params.subscribe(params => {
  //     this.jobMasterId = params.id;
  //   });
  //   this.savedJobsData = this.jobTaskService.getAllJobList();
  //   const index = this.savedJobsData.findIndex(x => x.id === this.jobMasterId);
  //   this.oneJobData = this.savedJobsData[index];
  //   const user = JSON.parse(localStorage.getItem('user'));
  //   this.jobTaskForm.patchValue({ job_Task_id: 3, material_id: this.oneJobData.material_id, id: this.jobMasterId, size: this.oneJobData.size, employee_id: user.id });
  //   this.jobTaskService.jobTaskData().subscribe((response) => {
  //     this.jobTaskData = response.data;
  //     // tslint:disable-next-line:prefer-for-of
  //     for (let i = 0; i < this.jobTaskData.length; i++){
  //       this.total = this.total + this.jobTaskData[i].material_quantity;
  //     }
  //   });
  // }



}
