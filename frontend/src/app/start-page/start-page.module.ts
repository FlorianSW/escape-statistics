import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { StartPageComponent } from './start-page.component';
import {StatisticsModule} from "../statistics/statistics.module";
import {LeaderboardModule} from "../leaderboard/leaderboard.module";



@NgModule({
  declarations: [StartPageComponent],
  imports: [
    CommonModule,
    StatisticsModule,
    LeaderboardModule
  ]
})
export class StartPageModule { }
