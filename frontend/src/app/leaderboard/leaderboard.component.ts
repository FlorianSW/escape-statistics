import {Component, OnInit} from '@angular/core';
import {MissionLeaderboard} from "../mission-leaderboard";
import {LeaderboardService} from "./leaderboard.service";

@Component({
  selector: 'app-leaderboard',
  templateUrl: './leaderboard.component.html',
  styleUrls: ['./leaderboard.component.scss']
})
export class LeaderboardComponent implements OnInit {
  public leaderboard: MissionLeaderboard | undefined;

  constructor(private service: LeaderboardService) {
  }

  ngOnInit() {
    this.service.missionLeaderboard().subscribe((leaderboard) => {
      this.leaderboard = leaderboard;
    });
  }

  toMinutes(playTime: number | undefined): string {
    if (playTime === undefined) {
      return "";
    }
    const minutes: number = Math.floor(playTime / 60);
    return minutes.toString().padStart(2, '0') + ':' + (playTime - minutes * 60).toString().padStart(2, '0');
  }
}
