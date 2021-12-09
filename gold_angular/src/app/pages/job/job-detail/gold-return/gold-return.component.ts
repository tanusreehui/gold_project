import { Component, OnInit } from '@angular/core';
import {JobService} from '../../../../services/job.service';
import {FormGroup} from '@angular/forms';
import {JobTaskService} from '../../../../services/job-task.service';
import {ActivatedRoute} from '@angular/router';
import {JobMaster} from '../../../../models/jobMaster.model';
import {OrderService} from '../../../../services/order.service';
import {Material} from '../../../../models/material.model';
import { MatSnackBar } from '@angular/material/snack-bar';
import {SncakBarComponent} from '../../../../common/sncak-bar/sncak-bar.component';
import {JobDetail} from '../../../../models/jobDetail.model';


@Component({
  selector: 'app-gold-return',
  templateUrl: './gold-return.component.html',
  styleUrls: ['./gold-return.component.scss']
})
export class GoldReturnComponent implements OnInit {

  jobMasterId: number;
  jobTaskForm: FormGroup;
  savedJobsData: JobMaster[];
  currentJob: JobMaster;
  materialData: Material[];
  jobTaskData: JobDetail[];
  returnMaterialName: string;
  total: number;
  showJobTaskData = false;
  public currentError: any;
  returnMaterial: Material;
  returnGoldList: any;

  // tslint:disable-next-line:max-line-length
  constructor(private activatedRoute: ActivatedRoute , private jobTaskService: JobTaskService, private router: ActivatedRoute, private _snackBar: MatSnackBar) {
    this.activatedRoute.data.subscribe((response: any) => {
      this.currentJob = response.goldReturn.currentJob.data;
      this.jobMasterId = this.currentJob.id;
      this.materialData = response.goldReturn.materials.data;
      this.jobTaskForm = this.jobTaskService.jobTaskForm;
      const user = JSON.parse(localStorage.getItem('user'));

      // index of return gold
      const matIndex = this.materialData.findIndex(x => x.main_material_id === this.currentJob.material_id);
      // return material name
      this.returnMaterial = this.materialData[matIndex];
      this.returnMaterialName = this.returnMaterial.material_name;

      this.jobTaskForm.patchValue({
        job_Task_id: 2,
        material_id: this.returnMaterial.id,
        id: this.jobMasterId,
        // size: this.currentJob.size,
        employee_id: user.id
      });

    });
  }

  ngOnInit(): void {
    // this.materialData = this.jobTaskService.getMaterials();
    this.total = 0;
    // this.jobTaskForm = this.jobTaskService.jobTaskForm;
    // this.savedJobsData = this.jobTaskService.getAllJobList();
    // this.router.parent.params.subscribe(params => {
    //   this.jobMasterId = parseInt(params.id);
    // });
    // const index = this.savedJobsData.findIndex(x => x.id === this.jobMasterId);
    // if(index>-1) {
    //   this.currentJob = this.savedJobsData[index];
    //   console.log('Current Job', this.currentJob);
    // }

    // this.jobTaskService.getMaterialDataUpdateListener().subscribe((response) => {
    //   this.materialData = response;
    // });
    // this.jobTaskService.getJobTaskDataUpdateListener().subscribe((response) => {
    //   this.jobTaskData = response;
    // });





  }

  material_quantity_decimal(){
    const x = this.jobTaskForm.value.return_quantity.split('.');
    if (!x[1]){
      this.jobTaskForm.patchValue({return_quantity : (this.jobTaskForm.value.return_quantity / 1000)});
    }
  }

  // saving gold return
  saveGoldReturn(currentJob, returnMaterial){

    if (this.jobTaskForm.value.return_quantity === null){
      this._snackBar.openFromComponent(SncakBarComponent, {
        duration: 4000, data: {message: 'Please enter quantity before submit'}
      });
    }else {
      // this.jobMasterId = currentJob.id;
      // this.router.parent.params.subscribe(params => {
      //   this.jobMasterId = parseInt(params.id);
      // });

      // this.savedJobsData = this.jobTaskService.getAllJobList();
      // const index = this.savedJobsData.findIndex(x => x.id === this.jobMasterId);
      // this.currentJob = this.savedJobsData[index];

      // this.currentJob = currentJob;

      // this.jobTaskService.getMaterialDataUpdateListener().subscribe((response) => {
      //   this.materialData = response;
      // });
      // const matIndex = this.materialData.findIndex(x => x.main_material_id === this.currentJob.material_id);
      // const materialGold = this.materialData[matIndex];
      // console.log('Main gold: ', materialGold);

      // const user = JSON.parse(localStorage.getItem('user'));


      // making return as negative
      let goldReturnQuantity = parseFloat(this.jobTaskForm.value.return_quantity);
      this.jobTaskForm.value.return_quantity = -this.jobTaskForm.value.return_quantity;
      // saving data to jobDetails
      this.jobTaskService.saveJobDetail().subscribe((response) => {
        if (response.success === 1) {
          this.jobTaskService.updateGoldReturn(goldReturnQuantity);
          this.jobTaskService.getJobDetailsByJobAndMaterial(currentJob.id, returnMaterial.id)
          // tslint:disable-next-line:no-shadowed-variable
            .subscribe((response: {success: number, data: {record: any[], total_material: number}}) => {
            this.returnGoldList = response.data;
            this.showJobTaskData = true;
          });
          this._snackBar.openFromComponent(SncakBarComponent, {
            duration: 4000, data: {message: 'Gold Returned'}
          });
          this.total = this.total + Math.abs(parseFloat(this.jobTaskForm.value.return_quantity));
          // this.jobTaskService.getTotal().subscribe();
          // tslint:disable-next-line:no-shadowed-variable
          // this.jobTaskService.jobTaskData().subscribe((response) => {
          //   this.jobTaskData = response.data;
          // });
          this.jobTaskForm.controls.return_quantity.reset();
        }
        this.currentError = null;
      }, (error) => {
        console.log('error occured ');
        console.log(error);
        this.currentError = error;
        this._snackBar.openFromComponent(SncakBarComponent, {
          duration: 4000, data: {message: error.message}
        });
      });
    }
  }

  // getAll(){
  //   this.total = 0;
  //   this.showJobTaskData = true;
  //   // this.router.parent.params.subscribe(params => {
  //   //   this.jobMasterId = params.id;
  //   // });
  //   // this.savedJobsData = this.jobTaskService.getAllJobList();
  //   // const index = this.savedJobsData.findIndex(x => x.id === this.jobMasterId);
  //   // this.currentJob = this.savedJobsData[index];
  //   const user = JSON.parse(localStorage.getItem('user'));
  // tslint:disable-next-line:max-line-length
  //   this.jobTaskForm.patchValue({ job_Task_id: 2, material_id: this.currentJob.material_id, id: this.jobMasterId, size: this.currentJob.size, employee_id: user.id });
  //   this.jobTaskService.jobTaskData().subscribe((response) => {
  //     this.jobTaskData = response.data;
  //     // tslint:disable-next-line:prefer-for-of
  //     for (let i = 0; i < this.jobTaskData.length; i++) {
  //       this.total = this.total + this.jobTaskData[i].material_quantity;
  //     }
  //   });
  // }

  getGoldReturnDetail(currentJob: any, returnMaterial: any) {
    // tslint:disable-next-line:max-line-length
    this.jobTaskService.getJobDetailsByJobAndMaterial(currentJob.id, returnMaterial.id)
      .subscribe((response: {success: number, data: {record: any[], total_material: number}}) => {
       this.returnGoldList = response.data;
       this.showJobTaskData = true;
    });
  }
}

