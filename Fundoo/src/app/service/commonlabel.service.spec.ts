import { TestBed } from '@angular/core/testing';

import { CommonlabelService } from './commonlabel.service';

describe('CommonlabelService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: CommonlabelService = TestBed.get(CommonlabelService);
    expect(service).toBeTruthy();
  });
});
