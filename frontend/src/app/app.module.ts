import {NgModule} from '@angular/core';
import {BrowserModule} from '@angular/platform-browser';

import {AppComponent} from './app.component';
import {HttpClientModule} from "@angular/common/http";
import {RouterModule} from "@angular/router";
import {StatisticsResolver} from "./statistics/statistics.resolver";
import {StartPageModule} from "./start-page/start-page.module";
import {StartPageComponent} from "./start-page/start-page.component";
import {LeaderboardResolver} from "./leaderboard/leaderboard.resolver";

@NgModule({
  declarations: [
    AppComponent
  ],
  imports: [
    BrowserModule,
    HttpClientModule,
    RouterModule.forRoot([{
      path: '**',
      component: StartPageComponent,
      resolve: {
        missionStatistics: StatisticsResolver,
        missionLeaderboard: LeaderboardResolver
      }
    }]),
    StartPageModule
  ],
  bootstrap: [AppComponent]
})
export class AppModule {
}
