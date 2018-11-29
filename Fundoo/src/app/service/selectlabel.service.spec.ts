import { TestBed } from '@angular/core/testing';

import { SelectlabelService } from './selectlabel.service';

describe('SelectlabelService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: SelectlabelService = TestBed.get(SelectlabelService);
    expect(service).toBeTruthy();
  });
});
