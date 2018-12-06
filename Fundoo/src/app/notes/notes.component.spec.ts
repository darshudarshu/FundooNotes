import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { NotesComponent } from './notes.component';

describe('NotesComponent', () => {
  let component: NotesComponent;
  let fixture: ComponentFixture<NotesComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ NotesComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(NotesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
  it('sign up form should be valid', async(() => {
    expect(component.model.note).toEqual("notesdata")
    expect(component.model.title).toEqual("titledata")
    expect(component.email).toEqual("example@gmail.com")
    expect(component.model).toBeTruthy();
  }))
  it('sign up form should not be valid', async(() => {
    expect(component.model.note).toEqual(null)
    expect(component.model.title).toEqual(null)
    expect(component.email).toEqual("")
    expect(component.email).toEqual("abc")
    expect(component.email).toBeFalsy();
    expect(component.model).toBeFalsy();
  }))
  
});
