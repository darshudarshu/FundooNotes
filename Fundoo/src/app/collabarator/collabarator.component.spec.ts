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
  it('collabarator form should be valid', async(() => {
    expect(component.data.user.id).toEqual(1)
    expect(component.data.user.email).toEqual("example@gmail.com")
    expect(component.data.user.email).toBeTruthy();
  }))
  it('collabrator form should not be valid', async(() => {
    expect(component.data.user.id).toEqual(null)
    expect(component.data.user.email).toEqual("")
    expect(component.data.user.email).toEqual("abc")
    expect(component.data.user.email).toBeFalsy();
  }))
  
});
