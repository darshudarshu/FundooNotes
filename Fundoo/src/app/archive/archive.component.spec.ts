import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ArchiveComponent } from './archive.component';

describe('ArchiveComponent', () => {
  let component: ArchiveComponent;
  let fixture: ComponentFixture<ArchiveComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ArchiveComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ArchiveComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
  it('archive notes form should be valid', async(() => {
    expect(component.email).toEqual("example@gmail.com")
    expect(component.email).toBeTruthy();
  }))
  it('sign up form should not be valid', async(() => {

    expect(component.email).toEqual("")
    expect(component.email).toEqual("abc")
    expect(component.email).toBeFalsy();
  }))
  
});
