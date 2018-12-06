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
  it('label component notes form should be valid', async(() => {
    expect(component.model.note).toEqual("notesdata")
    expect(component.model.title).toEqual("titledata")
    expect(component.email).toEqual("example@gmail.com")
    expect(component.model).toBeTruthy();
  }))
  it('label component notes  form should not be valid', async(() => {
    expect(component.model.note).toEqual(null)
    expect(component.model.title).toEqual(null)
    expect(component.email).toEqual("")
    expect(component.email).toEqual("abc")
    expect(component.email).toBeFalsy();
    expect(component.model).toBeFalsy();
  }))
  
});
