import { Injectable } from '@angular/core';
import { FormControl, NgForm } from '@angular/forms';
import { HttpErrorResponse } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class UtilsService {
  public title = "LaraTmp";
  constructor() { }


  hasInArray(str = null, arr = []) {
    return arr.find((item: String) => {
      if (item.indexOf(str) > -1) return true;
    });
  }

  setValidators(err: HttpErrorResponse, form: NgForm) {

    if (!err || !err.error || !err.error.errors) return;
    // console.log('setValidators');

    let errors = err.error.errors;
    Object.keys(errors).forEach((key1, idx1) => {
      Object.keys(errors[key1]).forEach((key2, idx2) => {
        key2 = key2.toLowerCase();
        let fC = form.controls[key1];
        // console.log(fC, key2);

        if (fC) {
          let currValue = fC.value ? (fC.value + "").toLowerCase() : "";
          fC.setValidators([fC.validator,
          (formC: FormControl) => {

            switch (key2) {
              case 'unique':
                let newValue = formC.value ? (formC.value + "").toLowerCase() : "";
                console.log(currValue, newValue);

                if (currValue == newValue) {
                  return { 'unique': 'Already exist a item with this value' };
                }
                else
                  return null;
                break;
              case 'alpha':
                if (/[^a-zA-Z]/gi.test(formC.value + ""))
                  return { 'alpha': 'Only letters' };
                else
                  return null;
                break;
              case 'alpha_dash':
                if (/[^a-zA-Z0-9_]/gi.test(formC.value + ""))
                  return { 'alpha_dash': 'Only alpha numeric and dash' };
                else
                  return null;
                break;
              case 'numeric':
                if (/[^0-9]/gi.test(formC.value + ""))
                  return { 'numeric': 'Only numbers' };
                else
                  return null;
                break;
              case 'email':
                if (/[\w\.]+@\w+(\.\w+)+/gi.test(formC.value + ""))
                  return null;
                else
                  return { 'email': 'Email format invalid' };
                break;
              case 'date':
                if (isNaN(Date.parse(formC.value)))
                  return { 'date': 'Date format invalid' };
                else
                  return null;
                break;
              default:
                return null;
                break;
            }

          }]);
          fC.updateValueAndValidity();
        }
      });
    });
  }

}
