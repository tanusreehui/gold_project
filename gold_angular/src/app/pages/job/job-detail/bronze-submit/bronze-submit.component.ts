import { Component, OnInit } from '@angular/core';
import {FormGroup} from '@angular/forms';
import {JobMaster} from '../../../../models/jobMaster.model';
import {JobTaskService} from '../../../../services/job-task.service';
import {ActivatedRoute} from '@angular/router';
import {MatSnackBar} from '@angular/material/snack-bar';
import {SncakBarComponent} from '../../../../common/sncak-bar/sncak-bar.component';
import {JobDetail} from '../../../../models/jobDetail.model';
import {Material} from '../../../../models/material.model';

@Component({
  selector: 'app-bronze-submit',
  templateUrl: './bronze-submit.component.html',
  styleUrls: ['./bronze-submit.component.scss']
})
// export class BronzeSubmitComponent implements OnInit {

export class BronzeSubmitComponent implements OnInit {

  currentJob: JobMaster;
  materialData: Material[];
  bronzeSubmitList: { record: any[]; total_material: number };
  currentMaterial: Material;

  jobMasterId: number;
  jobTaskForm: FormGroup;
  savedJobsData: JobMaster[];
  oneJobData: JobMaster;
  public currentError: any;
  showJobTaskData = false;
  jobTaskData: JobDetail[];
  total: number;

  constructor(private activatedRoute: ActivatedRoute
    , private jobTaskService: JobTaskService
    , private router: ActivatedRoute
    , private _snackBar: MatSnackBar) {
    this.activatedRoute.data.subscribe((response: any) => {
      this.currentJob = response.bronzeSubmit.currentJob.data;
      this.jobMasterId = this.currentJob.id;
      // this.materialData = response.bronzeSubmit.materials.data;
      this.materialData = this.jobTaskService.getMaterials();
      // tslint:disable-next-line:no-shadowed-variable
      this.jobTaskService.getMaterialDataUpdateListener().subscribe(response => {
        this.materialData = response;
      });
      this.jobTaskForm = this.jobTaskService.jobTaskForm;
      const user = JSON.parse(localStorage.getItem('user'));

      // index of bronze in material list
      const matIndex = this.materialData.findIndex(x => x.id === 12);
      // return material name
      this.currentMaterial = this.materialData[matIndex];
      this.jobTaskForm.patchValue({
        job_Task_id: 8,
        material_id: this.currentMaterial.id,
        id: this.currentJob.id,
        employee_id: user.id
      });

    });
  } // end of constructor

  ngOnInit(): void {
    this.total = 0;
    // this.jobTaskForm = this.jobTaskService.jobTaskForm;
    // this.router.parent.params.subscribe(params => {
    //   this.jobMasterId = params.id;
    // });
    // this.savedJobsData = this.jobTaskService.getAllJobList();
    // const index = this.savedJobsData.findIndex(x => x.id == this.jobMasterId);
    // this.oneJobData = this.savedJobsData[index];
    // // this.jobTaskForm.patchValue({material_name: this.oneJobData.material_name});
    // this.jobTaskService.getJobTaskDataUpdateListener().subscribe((response) => {
    //   this.jobTaskData = response;
    // });
  }
  saveBronzeSubmit(){
    if (this.jobTaskForm.value.return_quantity === null){
      this._snackBar.openFromComponent(SncakBarComponent, {
        duration: 4000, data: {message: 'Please enter quantity before submit'}
      });
    }else {
      // making return as negative
      const bronzeSubmitWeight = parseFloat(this.jobTaskForm.value.return_quantity);
      // saving data to jobDetails
      this.jobTaskService.saveJobDetail().subscribe((response) => {
        if (response.success === 1) {
          this.jobTaskService.updateBronzeSubmit(bronzeSubmitWeight);
          // updating Badge count after saving data
          this.jobTaskService.incrementJobBadgesBronzeSendCount();
          this.jobTaskService.getJobDetailsByJobAndMaterial(this.currentJob.id, this.currentMaterial.id)
          // tslint:disable-next-line:no-shadowed-variable
            .subscribe((response: {success: number, data: {record: any[], total_material: number}}) => {
              this.bronzeSubmitList = response.data;
              this.showJobTaskData = true;
            });
          this._snackBar.openFromComponent(SncakBarComponent, {
            duration: 4000, data: {message: 'Bronze Submitted'}
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

  material_quantity_decimal(){
    const x = this.jobTaskForm.value.return_quantity.split('.');
    if (!x[1]){
      this.jobTaskForm.patchValue({return_quantity : (this.jobTaskForm.value.return_quantity / 1000)});
    }
  }

  getBronzeSubmitDetail() {
    // tslint:disable-next-line:max-line-length
    this.jobTaskService.getJobDetailsByJobAndMaterial(this.currentJob.id, this.currentMaterial.id)
      .subscribe((response: {success: number, data: {record: any[], total_material: number}}) => {
        this.bronzeSubmitList = response.data;
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
  //   // tslint:disable-next-line:max-line-length
  //   this.jobTaskForm.patchValue({ job_Task_id: 8, material_id: this.oneJobData.material_id, id: this.jobMasterId, size: this.oneJobData.size, employee_id: user.id });
  //   this.jobTaskService.jobTaskData().subscribe((response) => {
  //     this.jobTaskData = response.data;
  //     // tslint:disable-next-line:prefer-for-of
  //     for (let i = 0; i < this.jobTaskData.length; i++){
  //       this.total = this.total + this.jobTaskData[i].material_quantity;
  //     }
  //   });
  // }

}

// }
