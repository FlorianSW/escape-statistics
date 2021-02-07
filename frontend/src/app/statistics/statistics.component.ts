import {Component} from '@angular/core';
import {ActivatedRoute, Data} from "@angular/router";
import {MissionStatistics} from "../mission-statistics";

@Component({
  selector: 'app-statistics',
  templateUrl: './statistics.component.html',
  styleUrls: ['./statistics.component.scss']
})
export class StatisticsComponent {
  public statistics: MissionStatistics | undefined;

  constructor(route: ActivatedRoute) {
    route.data.subscribe((data: Data) => {
      this.statistics = data.missionStatistics;
    });
  }
}
