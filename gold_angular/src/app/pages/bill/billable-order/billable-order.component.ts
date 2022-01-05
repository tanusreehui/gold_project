import { Component, OnInit } from '@angular/core';
import {environment} from "../../../../environments/environment";

@Component({
  selector: 'app-billable-order',
  templateUrl: './billable-order.component.html',
  styleUrls: ['./billable-order.component.scss']
})
export class BillableOrderComponent implements OnInit {
  showDeveloperDiv = true;
  isProduction = environment.production;
  searchTerm: any;
  pageSize =15;
  page: number;
  p = 1;
  constructor() { }

  ngOnInit(): void {
  }

}
