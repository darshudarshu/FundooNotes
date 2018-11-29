import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CollabaratorComponent } from './collabarator.component';

describe('CollabaratorComponent', () => {
  let component: CollabaratorComponent;
  let fixture: ComponentFixture<CollabaratorComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CollabaratorComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CollabaratorComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
