import {Component, OnInit} from '@angular/core';
import {MissionStatistics} from "../mission-statistics";
import {StatisticsService} from "./statistics.service";

@Component({
  selector: 'app-statistics',
  templateUrl: './statistics.component.html',
  styleUrls: ['./statistics.component.scss']
})
export class StatisticsComponent implements OnInit {
  public statistics: MissionStatistics | undefined;

  constructor(private service: StatisticsService) {
  }

  ngOnInit() {
    this.service.missionStatistics().subscribe((stats) => {
      this.statistics = stats;
    });
  }
}
