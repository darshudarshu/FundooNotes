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
  it('create collabarator form should be valid', async(() => {
    expect(component.mainOwner).toEqual("example@gmail.com")
    expect(component.addEmail).toEqual("example@gmail.com")
    expect(component.addEmail).toBeTruthy();
  }))
  it('create collabarator form should not be valid', async(() => {
    expect(component.mainOwner).toEqual("")
    expect(component.mainOwner).toEqual("abc")
    expect(component.addEmail).toEqual("")
    expect(component.addEmail).toEqual("abc")
    expect(component.addEmail).toBeFalsy();
  }))
  
});
