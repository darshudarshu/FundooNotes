import { TestBed } from '@angular/core/testing';

import { LoggerserviceService } from './loggerservice.service';

describe('LoggerserviceService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: LoggerserviceService = TestBed.get(LoggerserviceService);
    expect(service).toBeTruthy();
  });
});
