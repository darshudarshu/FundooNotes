import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CreatecollabaratorComponent } from './createcollabarator.component';

describe('CreatecollabaratorComponent', () => {
  let component: CreatecollabaratorComponent;
  let fixture: ComponentFixture<CreatecollabaratorComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CreatecollabaratorComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CreatecollabaratorComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
