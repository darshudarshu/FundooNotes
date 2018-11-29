import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { LabelcomponentComponent } from './labelcomponent.component';

describe('LabelcomponentComponent', () => {
  let component: LabelcomponentComponent;
  let fixture: ComponentFixture<LabelcomponentComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ LabelcomponentComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(LabelcomponentComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
