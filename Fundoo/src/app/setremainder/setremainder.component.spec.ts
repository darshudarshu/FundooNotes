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
  it('remainder notes form should be valid', async(() => {
    expect(component.model.note).toEqual("notesdata")
    expect(component.model.title).toEqual("titledata")
    expect(component.email).toEqual("example@gmail.com")
    expect(component.model).toBeTruthy();
  }))
  it('remainder notes form should not be valid', async(() => {
    expect(component.model.note).toEqual(null)
    expect(component.model.title).toEqual(null)
    expect(component.email).toEqual("")
    expect(component.email).toEqual("abc")
    expect(component.email).toBeFalsy();
    expect(component.model).toBeFalsy();
  }))
  
});
