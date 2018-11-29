import { TestBed } from '@angular/core/testing';

import { RemainderService } from './remainder.service';

describe('RemainderService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: RemainderService = TestBed.get(RemainderService);
    expect(service).toBeTruthy();
  });
});
