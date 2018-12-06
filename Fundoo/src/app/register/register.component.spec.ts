import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { RegisterComponent } from './register.component';

describe('RegisterComponent', () => {
  let component: RegisterComponent;
  let fixture: ComponentFixture<RegisterComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ RegisterComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(RegisterComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
  it('sign up form should be valid', async(() => {
    expect(component.model.email).toEqual("d@gmail.com")
    expect(component.model.pass).toEqual("abcdef")
    expect(component.model.pass).toEqual("ab22ef")
    expect(component.model.name).toEqual("darshan")
    expect(component.model.mobile).toEqual("1111111111")
    expect(component.model).toBeTruthy();
  }))
  it('sign up form should not be valid', async(() => {
    expect(component.model.email).toEqual("abc")
    expect(component.model.pass).toEqual("")
    expect(component.model.name).toEqual("")
    expect(component.model.mobile).toEqual("abcde")
    expect(component.model).toBeFalsy();
  }))
  
});
