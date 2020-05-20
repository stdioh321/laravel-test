import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { FormErrorsMessagesComponent } from './form-errors-messages.component';

describe('FormErrorsMessagesComponent', () => {
  let component: FormErrorsMessagesComponent;
  let fixture: ComponentFixture<FormErrorsMessagesComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ FormErrorsMessagesComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(FormErrorsMessagesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
