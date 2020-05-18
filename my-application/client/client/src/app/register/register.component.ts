import { Component, OnInit, ViewChild, ElementRef, SecurityContext } from '@angular/core';
import { NgForm, NgModel, FormControl, Validators } from '@angular/forms';
import { ToastrService } from 'ngx-toastr';
import { TranslateService } from '@ngx-translate/core';
import { DomSanitizer } from '@angular/platform-browser';
import { ApiService } from '../services/api.service';
import { AuthService } from '../auth.service';
import { Router } from '@angular/router';
import { DateAdapter, MAT_DATE_FORMATS } from '@angular/material/core';
import { AppDateAdapter, APP_DATE_FORMATS } from '../shared/app-data-adapter';
import { MatDatepicker } from '@angular/material/datepicker';
import { inOut, stretch } from '../extra/animations';
import { Subject } from 'rxjs';
import { debounceTime, distinctUntilChanged } from 'rxjs/operators';
import { UtilsService } from '../services/utils.service';





@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.scss'],
  animations: [
    inOut,
    stretch
  ]
})
export class RegisterComponent implements OnInit {
  @ViewChild('tmpImage', { static: false }) tmpImage: ElementRef;
  @ViewChild('f', { static: false }) f: NgForm;

  public data = null;
  private data_ = null;
  public isLogged = false;


  public formControlValue = '';

  findChoices(searchText: string) {
    console.log(searchText);
    return ['John', 'Jane', 'Jonny'].filter(item =>
      item.toLowerCase().includes(searchText.toLowerCase())
    );
  }

  getChoiceLabel(choice: string) {


    return `@${choice} `;
  }

  constructor(
    public toastr: ToastrService,
    public translate: TranslateService,
    private _sanitizer: DomSanitizer,
    private apiService: ApiService,
    private authService: AuthService,
    private router: Router,
    private utilsService: UtilsService,

  ) {

  }

  async ngOnInit() {

    this.isLogged = this.authService.checkToken() && this.router.url !== '/register';
    // if (this.authService.checkToken() && this.router.url === '/register') {
    //   this.router.navigate(['/']);
    //   return;
    // }
    try {
      if (this.isLogged) {
        this.data_ = await this.loadData();
        this.data = Object.assign({}, this.data_);

      }

    } catch (error) {
      this.data_ = undefined
      this.data = undefined
    }
  }

  loadData() {
    this.data = null;
    return this.apiService.meGet(true, true)
      .toPromise()
      .then(res => {
        // console.log(res);
        if (res['birthdate']) {
          res['birthdate'] = new Date(res['birthdate']);
        }
        let password = this.f.controls['password'];
        if (password) {
          password.clearValidators();
          password.setValidators([
            Validators.minLength(4)]);
          password.updateValueAndValidity();
        }
        return res;
      })
      .catch(err => {
        console.log(err);
        this.data = undefined;
      });
  }

  onSubmit(f: NgForm) {
    // console.log(f.value);
    if (f.invalid) {
      let invalid = document.querySelector(':not(form).ng-invalid');
      if (invalid) invalid['focus']();
      return;
    }
    let val = f.value;
    if (val.birthdate) {
      val.birthdate = new Date(new Date(val.birthdate).getTime()).toJSON();
    }
    // console.log(val);
    // return;
    let fData = new FormData();
    Object.keys(val).forEach((key, idx) => {
      fData.append(key, val[key] || "");
    });
    if (fData.get('email')) {
      fData.set('email', fData.get('email') ? (fData.get('email') + "").toLowerCase() : fData.get('email'));
    }
    if (!this.isLogged) {
      this.apiService.userPost(fData, true, true)
        .subscribe(res => {
          this.router.navigate(['/login']);
          this.toastr.success(
            this.translate.instant('common.added', {
              name:
                this.translate.instant('common.user')
            })
          );

        }, err => {
          // console.log(err);
          this.utilsService.setValidators(err, f);
          let invalid = document.querySelector(':not(form).ng-invalid');
          if (invalid) invalid['focus']();
        });
    } else {
      this.apiService.userPut(fData, true, true)
        .subscribe(res => {
          // console.log(res);
          res['image'] = res['image'] + "?r=" + Math.round(Math.random() * 1000);
          this.authService.user = res;
          this.toastr.success(
            this.translate.instant('common.updated', {
              name:
                this.translate.instant('common.user')
            })
          );
        }, err => {

          if (err.status == 422) {
            let errors = err.error.errors;
            Object.keys(errors).forEach((key1, idx1) => {
              Object.keys(errors[key1]).forEach((key2, idx2) => {
                key2 = key2.toLowerCase();
                let fC = f.controls[key1];
                if (fC) {
                  let currValue = fC.value;
                  fC.setValidators([fC.validator,
                  (formC: FormControl) => {

                    switch (key2) {


                      case 'unique':

                        if (currValue == formC.value)
                          return { 'unique': 'Already exist a item with this value' };
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
          let invalid = document.querySelector(':not(form).ng-invalid');
          if (invalid) invalid['focus']();
        });
      // console.log(val, this.data['id']);
    }

  }

  onImageChange(e, image: NgModel = null) {
    let file: File = e.target.files[0];

    if (file) {
      if (/image/gi.test(file.type)) {
        image && image.control.setValue(file);
        let reader: FileReader = new FileReader();
        reader.readAsDataURL(file);

        reader.onload = () => {
          let res = reader.result + "";
          this.tmpImage.nativeElement.src = res;
        };
      } else {
        image && image.control.setValue(null);
        this.tmpImage.nativeElement.removeAttribute('src');
        e.target.value = null;
        this.toastr.warning(
          this.translate.instant('register.not_image')
        );
      }
    } else {
      image && image.control.setValue(null);
      this.tmpImage.nativeElement.removeAttribute('src');
      e.target.value = null;
    }

  }

  onBirthdateChange(str, e) {
    console.log(str, e);

    // let val: String = e.target.value;
    // val = val.replace(/\D/gi, '');
    // val = val.slice(0, 8);
    // if (val.length > 4) {
    //   val = val.substr(0, 4) + '/' + val.substr(4);
    // }
    // if (val.length > 2) {
    //   val = val.substr(0, 2) + '/' + val.substr(2);
    // }

    // e.target.value = val;
  }
  resetData() {
    // console.log(this.data_, this.data);
    this.data = {};
    setTimeout(() => {
      this.data = Object.assign({}, this.data_);
    }, 0);

  }
}
