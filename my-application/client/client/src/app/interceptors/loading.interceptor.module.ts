import { HttpInterceptor, HttpRequest, HttpHandler, HttpEvent, HttpErrorResponse, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, throwError } from 'rxjs';
import { catchError, finalize } from 'rxjs/operators';
import { NgxSpinnerService } from 'ngx-spinner';



@Injectable()
export class LoadingInterceptorService implements HttpInterceptor {
    constructor(private spinner: NgxSpinnerService) {

    }
    intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
        // All HTTP requests are going to go through this method
        let clone = req.clone();
        let loading = clone.headers.get('loading');

        if (loading == 'true')
            this.spinner.show();
        return next.handle(clone)
            .pipe(finalize(() => {
                if (loading == 'true')
                    this.spinner.hide();
            }),
                catchError((err) => {
                    return throwError(err);
                }));
    }
}