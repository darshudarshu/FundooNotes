import { TestBed } from '@angular/core/testing';

import { CollabaratorService } from './collabarator.service';

describe('CollabaratorService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: CollabaratorService = TestBed.get(CollabaratorService);
    expect(service).toBeTruthy();
  });
});
