import {Component} from '@angular/core';
import {ActivatedRoute, Data} from "@angular/router";
import {MissionLeaderboard} from "../mission-leaderboard";

@Component({
  selector: 'app-leaderboard',
  templateUrl: './leaderboard.component.html',
  styleUrls: ['./leaderboard.component.scss']
})
export class LeaderboardComponent {
  public leaderboard: MissionLeaderboard | undefined;

  constructor(private route: ActivatedRoute) {
    route.data.subscribe((data: Data) => {
      this.leaderboard = data.missionLeaderboard;
    });
  }

  toMinutes(playTime: number): string {
    const minutes: number = Math.floor(playTime / 60);
    return minutes.toString().padStart(2, '0') + ':' + (playTime - minutes * 60).toString().padStart(2, '0');
  }
}
