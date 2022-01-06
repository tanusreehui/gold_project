import { TestBed } from '@angular/core/testing';

import { BillJobMasterResolver } from './bill-job-master.resolver';

describe('BillJobMasterResolver', () => {
  let resolver: BillJobMasterResolver;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    resolver = TestBed.inject(BillJobMasterResolver);
  });

  it('should be created', () => {
    expect(resolver).toBeTruthy();
  });
});
