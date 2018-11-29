import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { SetremainderComponent } from './setremainder.component';

describe('SetremainderComponent', () => {
  let component: SetremainderComponent;
  let fixture: ComponentFixture<SetremainderComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ SetremainderComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(SetremainderComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
