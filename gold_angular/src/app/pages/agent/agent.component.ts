import { Component, OnInit } from '@angular/core';
import {AgentService} from '../../services/agent.service';
import {Agent} from '../../models/agent.model';
import {FormGroup} from '@angular/forms';
import Swal from "sweetalert2";
import {OrderDetail} from '../../models/orderDetail.model';
import {formatDate} from '@angular/common';
import {Router} from '@angular/router';
import {StorageMap} from '@ngx-pwa/local-storage';
import {Md5} from "ts-md5";

@Component({
  selector: 'app-agent',
  templateUrl: './agent.component.html',
  styleUrls: ['./agent.component.scss']
})

export class AgentComponent implements OnInit {

  agentData: Agent[];
  userTypesList: any[];
  employeeList: any[];
  agentForm: FormGroup;
  showLoginCredentials = true;



  constructor(public agentService: AgentService) { }

  ngOnInit(): void {
    this.showLoginCredentials = true;
    this.agentForm = this.agentService.agentForm;
    this.agentService.getAgentUpdateListener().subscribe((response) => {
      this.agentData = response;
    });
    this.agentData = this.agentService.getAgentList();
    this.agentService.getUserTypes().subscribe((response:{success: number , data:any[]})=>{
      this.userTypesList = response.data;
    });
  }

  onSubmit(){
    if (this.showLoginCredentials === true){
      this.agentForm.controls['email'].reset();
      this.agentForm.controls['password'].reset();
    }
    if (this.agentForm.value.password != null || this.showLoginCredentials === false){
      const md5 = new Md5();
      const passwordMd5 = md5.appendStr(this.agentForm.value.password).end();
      this.agentForm.patchValue({password: passwordMd5});
    }
    this.agentService.saveAgent().subscribe((response: {success: number, data: Agent})  => {
      if (response.data){
        // const {data} = response;
        // this.agentData.unshift(data);
        Swal.fire(
          'Done!',
          'Successfully Added',
          'success'
        );
        this.agentForm.reset();
        // this.agentService.getLatestAgent();
      }
    });
  }

  deleteAgent(item){
    Swal.fire({
      title: 'Are you sure?',
      text: 'Agent will be deleted from the list',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'No, keep it'
    }).then((result) => {
      if (result.value) {
        this.agentService.deleteAgent(item.id).subscribe((response) => {
          // @ts-ignore
          const index = this.agentData.findIndex(x => x.id === response.data.id);
          this.agentData.splice(index, 1);
          Swal.fire(
            'Done!',
            'Deleted Agent',
            'success'
          );
        });

        // For more information about handling dismissals please visit
        // https://sweetalert2.github.io/#handling-dismissals
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire(
          'Cancelled',
          'Agent not deleted :)',
          'error'
        );
      }
    });
  }

  editAgent(item){
    item.password = null;
    if(item.email != null){
      this.showLoginCredentials = false;
    }else{
      this.showLoginCredentials = true;
      this.agentForm.controls['email'].reset();
      this.agentForm.controls['password'].reset();
    }
    this.agentService.fillAgentFormForEdit(item);
  }

  showCredentials(){
    if (this.showLoginCredentials === false){
      this.showLoginCredentials = true;
      this.agentForm.controls['email'].reset();
      this.agentForm.controls['password'].reset();
    }else{
      this.showLoginCredentials = false;
      // this.agentForm.controls['email'].reset();
      // this.agentForm.controls['password'].reset();
    }
  }

  updateAgent(){
    if (this.agentForm.value.password != null) {
      const md5 = new Md5();
      const passwordMd5 = md5.appendStr(this.agentForm.value.password).end();
      this.agentForm.patchValue({password: passwordMd5});
    }
    this.agentService.updateAgent().subscribe((response: {success: number, data: Agent}) => {
      if (response.data){
        const index = this.agentData.findIndex(x => x.id === response.data.id);
        this.agentData[index] = response.data;
        Swal.fire(
          'Done!',
          'Successfully Updated :)',
          'success'
        );
        this.agentForm.reset();
      }
      else{
        Swal.fire(
          'Failed',
          'Failed to update :)',
          'error'
        );
      }
    });
  }
}
