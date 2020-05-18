import { TestBed } from '@angular/core/testing';

import { AlreadyLoginService } from './already-login.service';

describe('AlreadyLoginService', () => {
  let service: AlreadyLoginService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(AlreadyLoginService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
