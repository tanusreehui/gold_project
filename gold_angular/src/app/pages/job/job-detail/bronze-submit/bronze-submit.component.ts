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
  materialList: Material[];
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
  returnMaterial: Material;

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
    const matIndex = this.materialList.findIndex(x => x.id === 12);
    // return material name
    this.currentMaterial = this.materialList[matIndex];
    this.jobTaskForm.patchValue({
      job_Task_id: 8,
      material_id: 12,
      id: this.currentJob.id,
      // size: this.currentJob.size,
      employee_id: user.id
    });
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
}

// }
