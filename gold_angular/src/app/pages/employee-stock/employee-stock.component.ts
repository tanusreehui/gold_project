import { Component, OnInit } from '@angular/core';
import {EmployeeStockService} from '../../services/employee-stock.service';

@Component({
  selector: 'app-employee-stock',
  templateUrl: './employee-stock.component.html',
  styleUrls: ['./employee-stock.component.scss']
})
export class EmployeeStockComponent implements OnInit {

  employeeStockList: any;
  public searchTerm: any;
  constructor(public  employeeStockService: EmployeeStockService ) {
    this.employeeStockList = this.employeeStockService.getEmployeeStock();
  }

  printDivStyle = {
    table: {'border-collapse': 'collapse', 'width' : '100%' ,border: '1px  solid black'},
    label:{'width': '100%'},
    td: {border: '1px  solid black' , 'fontSize' : 'small'}
  };

  ngOnInit(): void {
     this.employeeStockService.getEmployeeStockDataUpdateListener().subscribe((response) => {
       this.employeeStockList = response;
       console.log(this.employeeStockList);
     });
  }

}
