import { async, ComponentFixture, TestBed } from "@angular/core/testing";

import { LoginComponent } from "./login.component";

describe("LoginComponent", () => {
  let component: LoginComponent;
  let fixture: ComponentFixture<LoginComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [LoginComponent]
    }).compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(LoginComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it("should create", () => {
    expect(component).toBeTruthy();
  });

it('sign up form should be valid', async(() => {
  expect(component.model.email).toEqual("d@gmail.com")
  expect(component.model.pass).toEqual("abcdef")
  expect(component.model).toBeTruthy();
}))
it('sign up form should not be valid', async(() => {
  expect(component.model.email).toEqual("")
  expect(component.model.pass).toEqual("")
  expect(component.model.email).toEqual("abcd")
  expect(component.model.pass).toEqual("abcde")
  expect(component.model).toBeFalsy();
}))

});
