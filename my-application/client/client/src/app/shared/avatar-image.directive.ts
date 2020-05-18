import { Directive, HostListener, Input, OnInit, Renderer2, ElementRef } from '@angular/core';
import { ConfigService } from '../config/config.service';
import { Subject } from 'rxjs';

@Directive({
  selector: '[avatarImage]'
})
export class AvatarImageDirective implements OnInit {
  private _avatarImage = null;
  get avatarImage() {
    return this._avatarImage;
  }

  @Input('avatarImage')
  set avatarImage(img) {
    this._avatarImage = img;
    this.handleImage();
    // console.log('avatarImage');

  }
  public attempts = 0;

  constructor(
    public render2: Renderer2,
    public el: ElementRef,
    public config: ConfigService
  ) {


  }
  ngOnInit() {

  }

  handleImage() {
    let tmpImage = this._avatarImage;
    if (tmpImage && tmpImage.indexOf('http') > -1) {

    } else {
      tmpImage = this.config.urls.urlHost + 'avatars/' + tmpImage;
    }
    this.render2.setAttribute(this.el.nativeElement, 'src', tmpImage);

  }

  @HostListener('load', ['$event']) onImageLoad(e) {
    // console.log(e);
  }
  @HostListener('error', ['$event']) onImageError(e) {
    // console.log(e);
    this.attempts += 1;
    if (this.attempts <= 3)
      this.render2.setAttribute(this.el.nativeElement, 'src', 'assets/images/avatar.svg');
    else {
      return false;
    }
  }
}
