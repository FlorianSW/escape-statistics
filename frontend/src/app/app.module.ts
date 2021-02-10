import {NgModule} from '@angular/core';
import {BrowserModule} from '@angular/platform-browser';

import {AppComponent} from './app.component';
import {HttpClientModule} from "@angular/common/http";
import {RouterModule} from "@angular/router";
import {StartPageModule} from "./start-page/start-page.module";
import {StartPageComponent} from "./start-page/start-page.component";

@NgModule({
  declarations: [
    AppComponent
  ],
  imports: [
    BrowserModule,
    HttpClientModule,
    RouterModule.forRoot([{
      path: '**',
      component: StartPageComponent
    }]),
    StartPageModule
  ],
  bootstrap: [AppComponent]
})
export class AppModule {
}
