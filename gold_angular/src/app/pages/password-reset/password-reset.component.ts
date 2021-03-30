import { Component, OnInit } from '@angular/core';
import {AgentService} from '../../services/agent.service';
import {FormGroup} from '@angular/forms';
import {Agent} from '../../models/agent.model';
import {Md5} from 'ts-md5';
import Swal from "sweetalert2";
import {SncakBarComponent} from '../../common/sncak-bar/sncak-bar.component';
import {MatSnackBar} from '@angular/material/snack-bar';

@Component({
  selector: 'app-password-reset',
  templateUrl: './password-reset.component.html',
  styleUrls: ['./password-reset.component.scss']
})
export class PasswordResetComponent implements OnInit {

  passwordResetForm: FormGroup;
  employeeList: Agent[];

  constructor(private agentService: AgentService, private _snackBar: MatSnackBar) { }

  ngOnInit(): void {
    this.passwordResetForm = this.agentService.passwordResetForm;

    this.agentService.getEmployeeDataUpdateListener().subscribe((response) => {
      this.employeeList = response;
    });
  }

  resetPassword() {

    Swal.fire({
      title: 'Are you sure to change the password ?',
      text: 'Confirm ?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'No, keep it'
    }).then((result) => {
      if (result.value) {
        if (this.passwordResetForm.value.password === this.passwordResetForm.value.confirmPassword) {
          // console.log(this.passwordResetForm.value);
          const md5 = new Md5();
          const passwordMd5 = md5.appendStr(this.passwordResetForm.value.password).end();
          this.passwordResetForm.patchValue({changedPassword: passwordMd5});
          // console.log(this.passwordResetForm.value);
          this.agentService.resetPassword().subscribe((response: { success: number, data: Agent[] }) => {
            if (response.data) {
              this.passwordResetForm.reset();
              Swal.fire(
                'Success',
                'Password reset successfully',
                'success'
              );
            }
          });
        }else{
          this._snackBar.openFromComponent(SncakBarComponent, {
            duration: 4000, data: {message: 'Password and Confirm Password did not match'}
          });
        }
      }
    });
  }

}
