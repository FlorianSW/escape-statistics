import {ActivatedRouteSnapshot, Resolve, RouterStateSnapshot} from "@angular/router";
import {Observable} from "rxjs";
import {Injectable} from "@angular/core";
import {MissionLeaderboard} from "../mission-leaderboard";
import {LeaderboardService} from "./leaderboard.service";

@Injectable({
  providedIn: "root"
})
export class LeaderboardResolver implements Resolve<MissionLeaderboard> {
  constructor(private service: LeaderboardService) {
  }

  resolve(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<MissionLeaderboard> {
    return this.service.missionLeaderboard();
  }
}
