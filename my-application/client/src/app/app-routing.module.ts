import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { ItemComponent } from './item/item/item.component';
import { ItemUpdateComponent } from './item/item-update/item-update.component';
import { BrandComponent } from './brand/brand.component';
import { BrandUpdateComponent } from './brand/brand-update/brand-update.component';
import { ModelComponent } from './model/model.component';
import { ModelUpdateComponent } from './model/model-update/model-update.component';
import { HomeComponent } from './home/home.component';
import { LoginComponent } from './login/login.component';
import { AuthGuardService } from './guards/auth-guard.service';
import { RegisterComponent } from './register/register.component';
import { AlreadyLoginService } from './guards/already-login.service';
import { TmpComponent } from './tmp/tmp.component';
import { PartComponent } from './part/part.component';
import { PartUpdateComponent } from './part/part-update/part-update.component';


const routes: Routes = [
  { path: 'tmp', component: TmpComponent },
  { path: 'login', canActivate: [AlreadyLoginService], component: LoginComponent },
  { path: 'register', canActivate: [AlreadyLoginService], component: RegisterComponent },
  {
    path: '', component: HomeComponent, canActivateChild: [AuthGuardService], children: [
      {
        path: 'user', children: [
          { path: 'update', component: RegisterComponent }
        ]
      },
      {
        path: 'items', children: [
          { path: '', component: ItemComponent },
          { path: 'items', component: ItemComponent },
          { path: 'update/:id', component: ItemUpdateComponent },
          { path: 'add', component: ItemUpdateComponent }
        ]
      },
      {
        path: 'brands', children: [
          { path: '', component: BrandComponent },
          { path: 'add', component: BrandUpdateComponent },
          { path: 'update/:id', component: BrandUpdateComponent },
        ]
      },
      {
        path: 'models', children: [
          { path: '', component: ModelComponent },
          { path: 'add', component: ModelUpdateComponent },
          { path: 'update/:id', component: ModelUpdateComponent },
        ]
      },
      {
        path: 'parts', children: [
          { path: '', component: PartComponent },
          { path: 'add', component: PartUpdateComponent },
          { path: 'update/:id', component: PartUpdateComponent },
        ]
      },
      { path: '**', redirectTo: '/items' }
    ]
  },

  { path: '**', redirectTo: '/login' }

];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
